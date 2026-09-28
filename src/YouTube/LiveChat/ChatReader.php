<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\LiveChat;

use Carbon\CarbonImmutable;
use Evenement\EventEmitterInterface;
use Evenement\EventEmitterTrait;
use React\EventLoop\TimerInterface;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;

use function React\Promise\reject;
use function React\Promise\resolve;

use YouTube\Http\Exceptions\HttpException;
use YouTube\Http\Exceptions\LiveChatDisabledException;
use YouTube\Http\Exceptions\LiveChatEndedException;
use YouTube\Http\Exceptions\LiveChatNotFoundException;
use YouTube\Http\Exceptions\NotFoundException;
use YouTube\Http\Exceptions\QuotaExceededException;
use YouTube\Http\ResponseStream;
use YouTube\Parts\LiveChatMessage;
use YouTube\Parts\LiveChatMessageListResponse;
use YouTube\Parts\LiveChatMessageSnippet as Snippet;
use YouTube\YouTube;

/**
 * Reads one live chat as it happens, and keeps reading through whatever the
 * network does.
 *
 * - **Streaming:** by default it holds `liveChatMessages.stream` open, and
 *   YouTube pushes each message as it is posted. A stream the server closes is
 *   reopened where it left off, with the last `nextPageToken`, and one that
 *   has been silent for five minutes is reopened too, because a connection the
 *   network dropped looks exactly like a quiet chat.
 * - **Polling:** `liveChatMessages.list` at the interval YouTube asks for.
 *   It is what the reader falls back to if the stream is refused as
 *   unsupported, and it can be chosen outright with `mode`.
 * - **History:** joining a chat sends its recent history first. Messages
 *   posted before the reader joined are not emitted, so a restart does not
 *   replay the last few minutes into wherever they are relayed.
 * - **Quota:** before each request it checks the day's quota, reserve kept
 *   back. When polling, it slows down when the pace YouTube asks for would run
 *   the quota out within `budget_hours`. When nothing is left but the reserve,
 *   it pauses until the reset at midnight Pacific.
 * - **Dropped connections:** it retries with the same back-off as TwitchPHP's
 *   chat client, a second to a minute over about five minutes, then every five
 *   minutes. {@see reconnect()} tries again at once.
 *
 * Events:
 *
 * | Event                  | Arguments                 | When                                          |
 * | ---------------------- | ------------------------- | --------------------------------------------- |
 * | `chat.item`            | `LiveChatMessage`         | Anything new in the chat, whatever its type.  |
 * | `chat.message`         | `LiveChatMessage`         | A text message.                               |
 * | `chat.superchat`       | `LiveChatMessage`         | A Super Chat or Super Sticker.                |
 * | `chat.member`          | `LiveChatMessage`         | A new member, a milestone, or gifted memberships. |
 * | `chat.gift`            | `LiveChatMessage`         | A virtual gift.                               |
 * | `chat.poll`            | `LiveChatMessage`         | A poll, or a change to one.                   |
 * | `chat.banned`          | `LiveChatMessage`         | A moderator banned someone.                   |
 * | `chat.deleted`         | `string` message id, `LiveChatMessage` | A tombstone: a message that has been deleted. |
 * | `chat.offline`         | `CarbonImmutable`         | The stream went offline. The chat may stay open a while. |
 * | `chat.ended`           | `string` why              | The chat is over. The reader stops.           |
 * | `chat.connected`       |                           | Reading, at first and after every recovery.   |
 * | `chat.disconnected`    | `int` status, `string` why | Reading stopped.                             |
 * | `chat.reconnecting`    | `int` attempt, `float` delay | Another attempt is coming.                 |
 * | `chat.reconnect_failed`| `int` attempts            | The quick retries are spent. Once an outage.  |
 * | `chat.paused`          | `CarbonImmutable` resumes | Only the quota reserve is left. Once a pause. |
 * | `chat.resumed`         |                           | The quota reset.                              |
 * | `chat.slowed`          | `float` seconds           | Polling slowed to spread the quota over the day. |
 * | `chat.mode`            | `string` mode             | Streaming was refused, so it polls instead.   |
 *
 * YouTube stopped reporting deleted messages as they happen: a deletion shows
 * up only as a tombstone in a later listing, and a moderator's ban arrives as
 * `chat.banned`.
 *
 * @link https://developers.google.com/youtube/v3/live/docs/liveChatMessages/streamList
 * @link https://developers.google.com/youtube/v3/live/docs/liveChatMessages/list
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
final class ChatReader implements EventEmitterInterface
{
    use EventEmitterTrait;

    public const MODE_STREAM = 'stream';

    public const MODE_POLL = 'poll';

    /** Seconds before each quick retry. After the last, every `keep_trying_every`. */
    public const RETRY_DELAYS = [1, 2, 5, 10, 20, 30, 60, 60, 60, 60];

    public const DEFAULTS = [
        // `stream`, or `poll` to never try streaming.
        'mode' => self::MODE_STREAM,
        // The parts of each message to ask for.
        'part' => ['id', 'snippet', 'authorDetails'],
        // The language of system messages and currency strings, e.g. `en`.
        'hl' => null,
        // The size, in pixels, of the avatars in `authorDetails`.
        'profile_image_size' => null,
        // Leave out what was posted before the reader joined.
        'skip_history' => true,
        // Seconds before joining that still count as new: clocks disagree a little.
        'history_grace' => 10.0,
        // Seconds between attempts once the quick retries are spent.
        'keep_trying_every' => 300.0,
        // Up to this fraction added to each retry delay, so bots do not retry in step.
        'jitter' => 0.2,
        // Seconds of silence after which a stream is reopened.
        'stream_idle' => 300.0,
        // The slowest the quota may make polling.
        'max_poll_interval' => 60.0,
        // Hours of polling the quota left should last: at the pace YouTube asks
        // for until the rest would not, then slower. A stream rarely runs until
        // midnight Pacific, so spreading the quota that far would slow every
        // stream from its first minute.
        'budget_hours' => 6.0,
        // Message ids remembered, so a reconnect does not repeat one.
        'remember' => 2000,
        // The time, as a Unix timestamp, for tests.
        'clock' => null,
    ];

    /** Message types, and the event each is emitted as besides `chat.item`. */
    private const EVENTS = [
        Snippet::TYPE_TEXT_MESSAGE_EVENT => 'chat.message',
        Snippet::TYPE_SUPER_CHAT_EVENT => 'chat.superchat',
        Snippet::TYPE_SUPER_STICKER_EVENT => 'chat.superchat',
        Snippet::TYPE_NEW_SPONSOR_EVENT => 'chat.member',
        Snippet::TYPE_MEMBER_MILESTONE_CHAT_EVENT => 'chat.member',
        Snippet::TYPE_MEMBERSHIP_GIFTING_EVENT => 'chat.member',
        Snippet::TYPE_GIFT_MEMBERSHIP_RECEIVED_EVENT => 'chat.member',
        Snippet::TYPE_GIFT_EVENT => 'chat.gift',
        Snippet::TYPE_POLL_EVENT => 'chat.poll',
        Snippet::TYPE_USER_BANNED_EVENT => 'chat.banned',
    ];

    /** @var array<string, mixed> */
    private array $options;

    private string $mode;

    private bool $running = false;

    private bool $ended = false;

    private bool $connected = false;

    /** Where to carry on from, once there is somewhere. */
    private ?string $pageToken = null;

    /** Messages posted before this Unix time are history. Null once past it. */
    private ?float $historyBefore = null;

    /** Failed attempts in a row. */
    private int $failures = 0;

    private bool $failureAnnounced = false;

    private bool $paused = false;

    private bool $slowed = false;

    private bool $offline = false;

    /** Bumped for every attempt, so the callbacks of an abandoned one do nothing. */
    private int $generation = 0;

    private ?TimerInterface $timer = null;

    private ?TimerInterface $idleTimer = null;

    private ?ResponseStream $stream = null;

    /** When the open stream was opened, and whether it has sent anything. */
    private float $streamOpenedAt = 0.0;

    private bool $streamHeard = false;

    /** Callers of {@see reconnect()} waiting for it. */
    private ?Deferred $reconnecting = null;

    /** @var array<string, true> Recent message ids, oldest first. */
    private array $seen = [];

    /**
     * @param array<string, mixed> $options See {@see DEFAULTS}.
     */
    public function __construct(
        private readonly YouTube $youtube,
        private readonly string $liveChatId,
        array $options = [],
    ) {
        $unknown = array_diff(array_keys($options), array_keys(self::DEFAULTS));
        if ($unknown !== []) {
            throw new \InvalidArgumentException('Unknown ChatReader option(s): ' . implode(', ', $unknown));
        }

        $this->options = $options + self::DEFAULTS;
        $this->mode = $this->options['mode'] === self::MODE_POLL ? self::MODE_POLL : self::MODE_STREAM;
    }

    /** Joins the chat and starts reading. */
    public function start(): void
    {
        if ($this->running || $this->ended) {
            return;
        }

        $this->running = true;

        if ($this->pageToken === null && $this->options['skip_history']) {
            $this->historyBefore = $this->now() - (float) $this->options['history_grace'];
        }

        $this->next(0.0);
    }

    /** Stops reading. {@see start()} carries on from where it stopped. */
    public function stop(): void
    {
        if (! $this->running) {
            return;
        }

        $this->running = false;
        $this->abandon();

        if ($this->connected) {
            $this->connected = false;
            $this->emit('chat.disconnected', [1000, 'stopped']);
        }

        $this->settleReconnect(new \RuntimeException('The chat reader was stopped'));
    }

    /**
     * Tries again now, rather than when the next retry is due. Resolves when
     * that attempt works, at once if reading never stopped, and rejects with
     * the reason when it fails. The quota reserve may be spent on it: a person
     * asked. Retrying carries on either way.
     *
     * @return PromiseInterface<null>
     */
    public function reconnect(): PromiseInterface
    {
        if ($this->ended) {
            return reject(new \RuntimeException('The chat has ended; there is nothing to reconnect to'));
        }

        if ($this->connected && $this->running) {
            return resolve(null);
        }

        $this->reconnecting ??= new Deferred();
        $promise = $this->reconnecting->promise();

        if (! $this->running) {
            $this->start();
        } else {
            $this->abandon();
            $this->next(0.0, force: true);
        }

        return $promise;
    }

    public function isConnected(): bool
    {
        return $this->connected;
    }

    public function hasEnded(): bool
    {
        return $this->ended;
    }

    public function getLiveChatId(): string
    {
        return $this->liveChatId;
    }

    /** `stream`, or `poll` when it was chosen or streaming was refused. */
    public function getMode(): string
    {
        return $this->mode;
    }

    /** Where the next request carries on from. */
    public function getPageToken(): ?string
    {
        return $this->pageToken;
    }

    // -- Requests -----------------------------------------------------------------

    /** Schedules the next request. */
    private function next(float $delay, bool $force = false): void
    {
        $this->cancelTimer();

        $this->timer = $this->youtube->getLoop()->addTimer(max(0.0, $delay), function () use ($force): void {
            $this->timer = null;
            $this->fetch($force);
        });
    }

    /** @param bool $force Spend the reserve too: a person asked for this. */
    private function fetch(bool $force = false): void
    {
        if (! $this->running) {
            return;
        }

        $endpoint = $this->mode === self::MODE_STREAM ? 'liveChatMessages.stream' : 'liveChatMessages.list';

        if (! $this->youtube->getMeter()->canAfford($endpoint, keepReserve: ! $force)) {
            $this->settleReconnect(new \RuntimeException('The YouTube quota is spent until it resets'));
            $this->pause();

            return;
        }

        $this->mode === self::MODE_STREAM ? $this->openStream() : $this->poll();
    }

    private function openStream(): void
    {
        $generation = ++$this->generation;

        $this->youtube->liveChatMessages->stream(
            liveChatId: $this->liveChatId,
            part: $this->options['part'],
            hl: $this->options['hl'],
            pageToken: $this->pageToken,
            profileImageSize: $this->options['profile_image_size'],
        )->then(
            function (ResponseStream $stream) use ($generation): void {
                if ($generation !== $this->generation || ! $this->running) {
                    $stream->close();

                    return;
                }

                $this->stream = $stream;
                $this->streamOpenedAt = $this->now();
                $this->streamHeard = false;
                $this->succeeded();
                $this->armIdle($generation);

                $stream->on('data', function (LiveChatMessageListResponse $page) use ($generation): void {
                    if ($generation === $this->generation) {
                        $this->streamHeard = true;
                        $this->armIdle($generation);
                        $this->page($page);
                    }
                });
                $stream->on('error', function (\Throwable $e) use ($generation): void {
                    if ($generation === $this->generation) {
                        $this->streamClosed(true);
                        $this->failed($e);
                    }
                });
                $stream->on('close', function () use ($generation): void {
                    if ($generation === $this->generation && $this->stream !== null) {
                        $this->streamClosed(false);
                    }
                });
            },
            function (\Throwable $e) use ($generation): void {
                if ($generation === $this->generation) {
                    $this->failed($e);
                }
            },
        );
    }

    /**
     * The open stream closed: by the server's choice, which is carried on from
     * at once, or with an error, which {@see failed()} deals with.
     */
    private function streamClosed(bool $withError): void
    {
        $this->stream = null;
        $this->cancelIdle();

        if ($withError || ! $this->running || $this->ended) {
            return;
        }

        // A stream that closes as soon as it opens, having said nothing, is
        // failing, however politely: back off rather than spin.
        if (! $this->streamHeard && $this->now() - $this->streamOpenedAt < 5.0) {
            $this->failed(new HttpException('liveChatMessages.stream: the server closed the stream at once', 0, null, null, [], null, 'liveChatMessages.stream'));

            return;
        }

        $this->next(0.0);
    }

    private function poll(): void
    {
        $generation = ++$this->generation;

        $this->youtube->liveChatMessages->list(
            liveChatId: $this->liveChatId,
            part: $this->options['part'],
            hl: $this->options['hl'],
            pageToken: $this->pageToken,
            profileImageSize: $this->options['profile_image_size'],
        )->then(
            function (LiveChatMessageListResponse $page) use ($generation): void {
                if ($generation !== $this->generation || ! $this->running) {
                    return;
                }

                $this->succeeded();
                $this->page($page);

                if ($this->running) {
                    $this->next($this->pollInterval($page));
                }
            },
            function (\Throwable $e) use ($generation): void {
                if ($generation === $this->generation) {
                    $this->failed($e);
                }
            },
        );
    }

    /**
     * How long to wait before the next poll: what YouTube asks for, or longer
     * if that pace would spend the quota within `budget_hours`, or before it
     * resets if that comes first.
     */
    private function pollInterval(LiveChatMessageListResponse $page): float
    {
        $asked = max(0.0, (float) ($page->pollingIntervalMillis ?? 5000) / 1000);

        $meter = $this->youtube->getMeter();
        $calls = intdiv(max(0, $meter->remaining() - $meter->reserve()), max(1, $meter->cost('liveChatMessages.list')));
        $window = min(
            max(1.0, $meter->resetsAt()->getTimestamp() - $this->now()),
            (float) $this->options['budget_hours'] * 3600,
        );
        $spread = $calls > 0 ? $window / $calls : INF;

        $interval = max($asked, min($spread, (float) $this->options['max_poll_interval']));
        $slowed = $interval > $asked;

        if ($slowed && ! $this->slowed) {
            $this->youtube->getLogger()->info(sprintf('polling live chat every %.1fs rather than %.1fs, to last the quota until it resets', $interval, $asked));
            $this->emit('chat.slowed', [$interval]);
        }
        $this->slowed = $slowed;

        return $interval;
    }

    // -- What arrives -------------------------------------------------------------

    private function page(LiveChatMessageListResponse $page): void
    {
        if (is_string($page->nextPageToken) && $page->nextPageToken !== '') {
            $this->pageToken = $page->nextPageToken;
        }

        foreach ($page->items ?? [] as $message) {
            if (! $this->running) {
                return;
            }

            if ($message instanceof LiveChatMessage) {
                $this->message($message);
            }
        }

        $offlineAt = $page->getRawAttribute('offlineAt');
        if (! $this->offline && is_string($offlineAt) && $offlineAt !== '') {
            $this->offline = true;
            $this->emit('chat.offline', [CarbonImmutable::parse($offlineAt)]);
        }
    }

    private function message(LiveChatMessage $message): void
    {
        $snippet = $message->snippet;
        $type = $snippet?->type;
        $id = is_string($message->id) ? $message->id : null;

        // A tombstone reuses the id of the message it replaced, which is
        // exactly the one already seen.
        if ($type === Snippet::TYPE_TOMBSTONE) {
            if ($id !== null && ! $this->isHistory($message)) {
                $this->emit('chat.item', [$message]);
                $this->emit('chat.deleted', [$id, $message]);
            }

            return;
        }

        if ($id !== null) {
            if (isset($this->seen[$id])) {
                return;
            }

            $this->remember($id);
        }

        if ($type === Snippet::TYPE_CHAT_ENDED_EVENT) {
            $this->end('the chat ended');

            return;
        }

        if ($this->isHistory($message)) {
            return;
        }

        $this->emit('chat.item', [$message]);

        if ($type === Snippet::TYPE_MESSAGE_DELETED_EVENT) {
            $deleted = $snippet?->messageDeletedDetails?->deletedMessageId;
            if (is_string($deleted)) {
                $this->emit('chat.deleted', [$deleted, $message]);
            }

            return;
        }

        if (isset(self::EVENTS[$type])) {
            $this->emit(self::EVENTS[$type], [$message]);
        }
    }

    /** Whether a message was posted before the reader joined. */
    private function isHistory(LiveChatMessage $message): bool
    {
        if ($this->historyBefore === null) {
            return false;
        }

        $published = $message->snippet?->getRawAttribute('publishedAt');

        if (! is_string($published) || $published === '') {
            return false;
        }

        try {
            return (float) CarbonImmutable::parse($published)->format('U.u') < $this->historyBefore;
        } catch (\Throwable) {
            return false;
        }
    }

    private function remember(string $id): void
    {
        $this->seen[$id] = true;

        if (count($this->seen) > (int) $this->options['remember']) {
            unset($this->seen[array_key_first($this->seen)]);
        }
    }

    // -- Connection state ------------------------------------------------------

    private function succeeded(): void
    {
        $this->failures = 0;
        $this->failureAnnounced = false;

        if ($this->paused) {
            $this->paused = false;
            $this->emit('chat.resumed');
        }

        if (! $this->connected) {
            $this->connected = true;
            $this->emit('chat.connected');
        }

        $this->settleReconnect();
    }

    private function failed(\Throwable $e): void
    {
        if (! $this->running) {
            return;
        }

        if ($e instanceof LiveChatEndedException || $e instanceof LiveChatNotFoundException || $e instanceof LiveChatDisabledException) {
            $this->end($e->getMessage());

            return;
        }

        if ($e instanceof QuotaExceededException) {
            $this->lost($e);
            $this->settleReconnect($e);
            $this->pause();

            return;
        }

        if ($this->mode === self::MODE_STREAM && $this->streamingRefused($e)) {
            $this->youtube->getLogger()->warning('YouTube refused to stream live chat (' . $e->getMessage() . ') - polling it instead');
            $this->mode = self::MODE_POLL;
            $this->emit('chat.mode', [self::MODE_POLL]);
            $this->next(0.0);

            return;
        }

        $this->lost($e);
        // Whoever asked to reconnect hears how this attempt went, not the next.
        $this->settleReconnect($e);
        $this->scheduleRetry();
    }

    /** Whether a failure says the stream itself is unavailable, not that the chat is. */
    private function streamingRefused(\Throwable $e): bool
    {
        if (! $e instanceof HttpException) {
            return false;
        }

        return ($e instanceof NotFoundException && ! $e instanceof LiveChatNotFoundException)
            || in_array($e->getStatus(), [405, 501], true)
            || str_contains($e->getMessage(), 'not a JSON array');
    }

    private function lost(\Throwable $e): void
    {
        $this->youtube->getLogger()->warning('lost the YouTube live chat: ' . $e->getMessage());

        if ($this->connected) {
            $this->connected = false;
            $this->emit('chat.disconnected', [$e instanceof HttpException ? $e->getStatus() : 0, $e->getMessage()]);
        }
    }

    private function scheduleRetry(): void
    {
        ++$this->failures;
        $quick = count(self::RETRY_DELAYS);

        if ($this->failures <= $quick) {
            $delay = (float) self::RETRY_DELAYS[$this->failures - 1];
        } else {
            if (! $this->failureAnnounced) {
                $this->failureAnnounced = true;
                $this->emit('chat.reconnect_failed', [$quick]);
            }

            $delay = (float) $this->options['keep_trying_every'];
        }

        $delay *= 1 + (float) $this->options['jitter'] * (mt_rand() / mt_getrandmax());

        $this->emit('chat.reconnecting', [$this->failures, $delay]);
        $this->next($delay);
    }

    /** Only the reserve is left: wait for midnight Pacific. */
    private function pause(): void
    {
        $this->cancelTimer();
        $resumes = $this->youtube->getMeter()->resetsAt();

        if (! $this->paused) {
            $this->paused = true;
            $this->youtube->getLogger()->warning('pausing YouTube live chat until the quota resets at ' . $resumes->toIso8601String());
            $this->emit('chat.paused', [$resumes]);
        }

        $this->timer = $this->youtube->getLoop()->addTimer(max(1.0, $resumes->getTimestamp() - $this->now() + 5.0), function (): void {
            $this->timer = null;

            if ($this->paused) {
                $this->paused = false;
                $this->emit('chat.resumed');
            }

            $this->fetch();
        });
    }

    /** The chat is over: nothing more will come. */
    private function end(string $why): void
    {
        if ($this->ended) {
            return;
        }

        $this->ended = true;
        $this->running = false;
        $this->abandon();
        $this->connected = false;

        $this->youtube->getLogger()->info("the YouTube live chat {$this->liveChatId} ended: {$why}");
        $this->emit('chat.ended', [$why]);
        $this->settleReconnect(new \RuntimeException('The chat has ended'));
    }

    /** Drops whatever is in flight, so its callbacks do nothing. */
    private function abandon(): void
    {
        ++$this->generation;
        $this->cancelTimer();
        $this->cancelIdle();

        $stream = $this->stream;
        $this->stream = null;
        $stream?->close();
    }

    private function armIdle(int $generation): void
    {
        $this->cancelIdle();

        $this->idleTimer = $this->youtube->getLoop()->addTimer((float) $this->options['stream_idle'], function () use ($generation): void {
            $this->idleTimer = null;

            if ($generation !== $this->generation || ! $this->running) {
                return;
            }

            // Quiet, or dead: the difference cannot be seen from here, and a
            // fresh stream picks up where this one left off either way.
            $this->youtube->getLogger()->debug('the live chat stream has been silent a while - reopening it');
            $this->abandon();
            $this->next(0.0);
        });
    }

    private function cancelTimer(): void
    {
        if ($this->timer !== null) {
            $this->youtube->getLoop()->cancelTimer($this->timer);
            $this->timer = null;
        }
    }

    private function cancelIdle(): void
    {
        if ($this->idleTimer !== null) {
            $this->youtube->getLoop()->cancelTimer($this->idleTimer);
            $this->idleTimer = null;
        }
    }

    private function settleReconnect(?\Throwable $failure = null): void
    {
        if ($this->reconnecting === null) {
            return;
        }

        $deferred = $this->reconnecting;
        $this->reconnecting = null;

        $failure === null ? $deferred->resolve(null) : $deferred->reject($failure);
    }

    private function now(): float
    {
        return $this->options['clock'] !== null ? (float) ($this->options['clock'])() : microtime(true);
    }
}
