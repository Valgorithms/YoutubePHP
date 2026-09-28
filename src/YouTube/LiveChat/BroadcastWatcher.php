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

use Evenement\EventEmitterInterface;
use Evenement\EventEmitterTrait;
use React\EventLoop\TimerInterface;
use React\Promise\PromiseInterface;

use function React\Promise\resolve;

use YouTube\Parts\LiveBroadcast;
use YouTube\Parts\LiveBroadcastListResponse;
use YouTube\Parts\LiveBroadcastStatus;
use YouTube\YouTube;

/**
 * Notices when the signed-in channel goes live, and when it stops.
 *
 * YouTube has no push notification for this that a bot can use, so it asks:
 * `liveBroadcasts.list` with `broadcastStatus=active`, one unit of quota a
 * check. That is every two minutes while nothing is live, about 720 units a
 * day, and every five while something is, when the chat reader usually
 * notices the end first and says so through {@see ended()}.
 *
 * Both scheduled events and the streamer's "Go live now" stream are found: the
 * check asks for `broadcastType=all`, where YouTube's default leaves the second
 * out.
 *
 * Events:
 *
 * | Event              | Arguments        | When                                                |
 * | ------------------ | ---------------- | --------------------------------------------------- |
 * | `broadcast.live`   | `LiveBroadcast`  | A broadcast went live. Its `snippet.liveChatId` is its chat. |
 * | `broadcast.ended`  | `LiveBroadcast`  | It is over: missing from two checks in a row, or {@see ended()}. |
 * | `error`            | `Throwable`      | A check failed. It changes nothing; the next one tries again. |
 *
 * A check skipped for quota leaves room in the reserve for what a person asks
 * for; see {@see \YouTube\Quota\Meter::canAfford()}.
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
final class BroadcastWatcher implements EventEmitterInterface
{
    use EventEmitterTrait;

    /** The API method each check calls. */
    public const ENDPOINT = 'liveBroadcasts.list';

    public const DEFAULTS = [
        // Seconds between checks while nothing is live.
        'interval' => 120.0,
        // Seconds between checks while something is.
        'live_interval' => 300.0,
        // Checks in a row a broadcast must be missing from before it counts as ended.
        'ended_after' => 2,
        // Also report broadcasts that are live but unlisted or private.
        'include_unlisted' => true,
    ];

    /** @var array<string, mixed> */
    private array $options;

    /** @var array<string, LiveBroadcast> The broadcasts live now, by id. */
    private array $live = [];

    /** @var array<string, int> Broadcast id => checks in a row it has been missing from. */
    private array $misses = [];

    private ?TimerInterface $timer = null;

    private bool $running = false;

    private ?PromiseInterface $checking = null;

    /**
     * @param array<string, mixed> $options See {@see DEFAULTS}.
     */
    public function __construct(private readonly YouTube $youtube, array $options = [])
    {
        $unknown = array_diff(array_keys($options), array_keys(self::DEFAULTS));
        if ($unknown !== []) {
            throw new \InvalidArgumentException('Unknown BroadcastWatcher option(s): ' . implode(', ', $unknown));
        }

        $this->options = $options + self::DEFAULTS;
    }

    /** Checks now, then keeps checking. */
    public function start(): void
    {
        if ($this->running) {
            return;
        }

        $this->running = true;
        $this->check();
    }

    /** Stops checking. What it knows is kept, for a later {@see start()}. */
    public function stop(): void
    {
        $this->running = false;

        if ($this->timer !== null) {
            $this->youtube->getLoop()->cancelTimer($this->timer);
            $this->timer = null;
        }
    }

    /**
     * One check, now.
     *
     * @return PromiseInterface<array<string, LiveBroadcast>> What is live, by id. Never rejects: a
     *                                                        failed check emits `error` and changes nothing.
     */
    public function check(): PromiseInterface
    {
        if ($this->checking !== null) {
            return $this->checking;
        }

        if ($this->timer !== null) {
            $this->youtube->getLoop()->cancelTimer($this->timer);
            $this->timer = null;
        }

        if (! $this->youtube->getMeter()->canAfford(self::ENDPOINT, keepReserve: true)) {
            $this->youtube->getLogger()->debug('skipping the live check: the quota left is the reserve');
            $this->scheduleNext();

            return resolve($this->live);
        }

        $settled = false;

        $promise = $this->youtube->liveBroadcasts->list(
            part: ['id', 'snippet', 'status'],
            broadcastStatus: 'active',
            broadcastType: 'all',
            maxResults: 50,
        )->then(
            function (LiveBroadcastListResponse $response): array {
                $this->reconcile($response);

                return $this->live;
            },
            function (\Throwable $e): array {
                $this->youtube->getLogger()->warning('could not check whether the channel is live: ' . $e->getMessage());
                $this->emit('error', [$e]);

                return $this->live;
            },
        )->finally(function () use (&$settled): void {
            $settled = true;
            $this->checking = null;
            $this->scheduleNext();
        });

        // A check YouTube answered at once is over already, and must not be
        // left looking as if it were still out.
        if (! $settled) {
            $this->checking = $promise;
        }

        return $promise;
    }

    /**
     * The broadcasts live now, by id.
     *
     * @return array<string, LiveBroadcast>
     */
    public function live(): array
    {
        return $this->live;
    }

    /**
     * A broadcast is over, as its chat reader saw: forget it now rather than
     * after two more checks.
     */
    public function ended(string $broadcastId): void
    {
        if (! isset($this->live[$broadcastId])) {
            return;
        }

        $broadcast = $this->live[$broadcastId];
        unset($this->live[$broadcastId], $this->misses[$broadcastId]);

        $this->emit('broadcast.ended', [$broadcast]);
        $this->scheduleNext();
    }

    /** The broadcast whose chat this is, if it is live. */
    public function broadcastFor(string $liveChatId): ?LiveBroadcast
    {
        foreach ($this->live as $broadcast) {
            if ($broadcast->snippet?->liveChatId === $liveChatId) {
                return $broadcast;
            }
        }

        return null;
    }

    private function reconcile(LiveBroadcastListResponse $response): void
    {
        $current = [];

        foreach ($response->items ?? [] as $broadcast) {
            if ($broadcast instanceof LiveBroadcast && $broadcast->id !== null && $this->counts($broadcast)) {
                $current[$broadcast->id] = $broadcast;
            }
        }

        foreach ($current as $id => $broadcast) {
            $known = isset($this->live[$id]);
            $this->live[$id] = $broadcast;
            unset($this->misses[$id]);

            if (! $known) {
                $this->emit('broadcast.live', [$broadcast]);
            }
        }

        foreach ($this->live as $id => $broadcast) {
            if (isset($current[$id])) {
                continue;
            }

            $this->misses[$id] = ($this->misses[$id] ?? 0) + 1;

            if ($this->misses[$id] >= $this->options['ended_after']) {
                unset($this->live[$id], $this->misses[$id]);
                $this->emit('broadcast.ended', [$broadcast]);
            }
        }
    }

    /** Whether a broadcast is one this watcher reports: actually live, and visible enough. */
    private function counts(LiveBroadcast $broadcast): bool
    {
        $status = $broadcast->status;

        if ($status !== null && $status->lifeCycleStatus !== null && $status->lifeCycleStatus !== LiveBroadcastStatus::LIFE_CYCLE_STATUS_LIVE) {
            return false;
        }

        if (! $this->options['include_unlisted'] && $status?->privacyStatus !== null && $status->privacyStatus !== LiveBroadcastStatus::PRIVACY_STATUS_PUBLIC) {
            return false;
        }

        return $broadcast->snippet?->liveChatId !== null;
    }

    private function scheduleNext(): void
    {
        if (! $this->running || $this->checking !== null) {
            return;
        }

        if ($this->timer !== null) {
            $this->youtube->getLoop()->cancelTimer($this->timer);
        }

        $delay = (float) ($this->live === [] ? $this->options['interval'] : $this->options['live_interval']);

        $this->timer = $this->youtube->getLoop()->addTimer($delay, function (): void {
            $this->timer = null;
            $this->check();
        });
    }
}
