<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Tests;

use PHPUnit\Framework\TestCase;
use React\EventLoop\Loop;
use React\Stream\ThroughStream;
use YouTube\LiveChat\ChatReader;
use YouTube\Parts\LiveChatMessage;
use YouTube\YouTube;

/**
 * Reading a live chat: streamed or polled, history left out, each kind of
 * message to its event, and every way the connection can go wrong.
 */
final class ChatReaderTest extends TestCase
{
    private ScriptedDriver $driver;

    private FastLoop $loop;

    private YouTube $youtube;

    private float $now;

    /** @var list<string> */
    private array $events = [];

    protected function setUp(): void
    {
        // Noon Pacific, so the quota day has twelve hours left.
        $this->now = (float) (new \DateTimeImmutable('2026-09-27 12:00:00', new \DateTimeZone('America/Los_Angeles')))->getTimestamp();
        $this->driver = new ScriptedDriver();
        $this->loop = new FastLoop(Loop::get(), fire: false);
        $this->youtube = $this->client();
    }

    /** @param array<string, mixed> $quota */
    private function client(array $quota = []): YouTube
    {
        return new YouTube([
            'token' => 'token',
            'driver' => $this->driver,
            'loop' => $this->loop,
            'clock' => fn (): float => $this->now,
            'quota' => $quota,
        ]);
    }

    /** @param array<string, mixed> $options */
    private function reader(array $options = []): ChatReader
    {
        $reader = new ChatReader($this->youtube, 'chat', $options + ['jitter' => 0.0, 'clock' => fn (): float => $this->now]);

        foreach (['chat.message', 'chat.superchat', 'chat.member', 'chat.gift', 'chat.poll', 'chat.banned'] as $event) {
            $reader->on($event, function (LiveChatMessage $message) use ($event): void {
                $this->events[] = $event . ' ' . $message->id;
            });
        }
        $reader->on('chat.deleted', function (string $id): void {
            $this->events[] = 'chat.deleted ' . $id;
        });
        $reader->on('chat.ended', function (): void {
            $this->events[] = 'chat.ended';
        });
        $reader->on('chat.offline', function (): void {
            $this->events[] = 'chat.offline';
        });
        foreach (['chat.connected', 'chat.resumed'] as $event) {
            $reader->on($event, function () use ($event): void {
                $this->events[] = $event;
            });
        }
        $reader->on('chat.disconnected', function (int $status): void {
            $this->events[] = 'chat.disconnected';
        });
        $reader->on('chat.reconnecting', function (int $attempt, float $delay): void {
            $this->events[] = "chat.reconnecting {$attempt} {$delay}";
        });
        $reader->on('chat.reconnect_failed', function (int $attempts): void {
            $this->events[] = "chat.reconnect_failed {$attempts}";
        });
        $reader->on('chat.paused', function (): void {
            $this->events[] = 'chat.paused';
        });
        $reader->on('chat.slowed', function (float $interval): void {
            $this->events[] = "chat.slowed {$interval}";
        });
        $reader->on('chat.mode', function (string $mode): void {
            $this->events[] = "chat.mode {$mode}";
        });

        return $reader;
    }

    /**
     * One chat item, as YouTube sends it.
     *
     * @param array<string, mixed> $snippet
     *
     * @return array<string, mixed>
     */
    private function item(string $id, string $type = 'textMessageEvent', float $age = 0.0, array $snippet = []): array
    {
        return [
            'kind' => 'youtube#liveChatMessage',
            'id' => $id,
            'snippet' => $snippet + [
                'type' => $type,
                'liveChatId' => 'chat',
                'publishedAt' => gmdate('Y-m-d\TH:i:s', (int) ($this->now - $age)) . '.000Z',
                'displayMessage' => 'says ' . $id,
            ],
            'authorDetails' => ['channelId' => 'UCviewer', 'displayName' => 'Viewer'],
        ];
    }

    /** @param list<array<string, mixed>> $items */
    private static function page(array $items, string $token = 'next', array $extra = []): string
    {
        return json_encode(['kind' => 'youtube#liveChatMessageListResponse', 'nextPageToken' => $token, 'items' => $items] + $extra, JSON_THROW_ON_ERROR);
    }

    /** Opens a stream the test writes pages into. */
    private function stream(): ThroughStream
    {
        $body = new ThroughStream();
        $this->driver->respond(200, $body);

        return $body;
    }

    public function testMessagesStreamInAndTheHistoryIsLeftOut(): void
    {
        $body = $this->stream();
        $reader = $this->reader();

        $reader->start();
        $this->loop->advance();
        $this->assertTrue($this->driver->streaming[0]);
        $this->assertSame(['chat.connected'], $this->events);

        $this->now += 1;
        $body->write('[' . self::page([$this->item('old', age: 120), $this->item('new')], 't1'));

        $this->assertSame(['chat.connected', 'chat.message new'], $this->events);
        $this->assertSame('t1', $reader->getPageToken());
    }

    public function testEachKindOfItemHasItsEvent(): void
    {
        $body = $this->stream();
        $reader = $this->reader();
        $reader->start();
        $this->loop->advance();

        $body->write('[' . self::page([
            $this->item('sc', 'superChatEvent'),
            $this->item('ss', 'superStickerEvent'),
            $this->item('mb', 'newSponsorEvent'),
            $this->item('ms', 'memberMilestoneChatEvent'),
            $this->item('gm', 'membershipGiftingEvent'),
            $this->item('gf', 'giftEvent'),
            $this->item('pl', 'pollEvent'),
            $this->item('bn', 'userBannedEvent'),
            $this->item('tx', 'textMessageEvent'),
            $this->item('tx', 'tombstone'),
        ]));

        $this->assertSame([
            'chat.connected',
            'chat.superchat sc',
            'chat.superchat ss',
            'chat.member mb',
            'chat.member ms',
            'chat.member gm',
            'chat.gift gf',
            'chat.poll pl',
            'chat.banned bn',
            'chat.message tx',
            'chat.deleted tx',
        ], $this->events);
    }

    public function testAMessageSeenTwiceIsEmittedOnce(): void
    {
        $body = $this->stream();
        $this->reader()->start();
        $this->loop->advance();

        $body->write('[' . self::page([$this->item('m1')]));
        $body->write(',' . self::page([$this->item('m1'), $this->item('m2')]));

        $this->assertSame(['chat.connected', 'chat.message m1', 'chat.message m2'], $this->events);
    }

    public function testAStreamTheServerClosesIsCarriedOnFromItsLastPage(): void
    {
        $first = $this->stream();
        $reader = $this->reader();
        $reader->start();
        $this->loop->advance();

        $first->write('[' . self::page([$this->item('m1')], 't1'));
        $this->now += 30;
        $second = $this->stream();
        $first->end(']');
        $this->loop->advance();

        $this->assertCount(2, $this->driver->requests);
        $this->assertContains(['pageToken', 't1'], ScriptedDriver::queryPairs($this->driver->last()));
        $this->assertNotContains('chat.disconnected', $this->events, 'a routine reopen is not an outage');
        $this->assertTrue($second->isReadable());
    }

    public function testAStreamThatClosesAsSoonAsItOpensIsBackedOffFrom(): void
    {
        $body = $this->stream();
        $this->reader()->start();
        $this->loop->advance();

        $body->end();

        $this->assertSame(['chat.connected', 'chat.disconnected', 'chat.reconnecting 1 1'], $this->events);
        $this->assertSame([1.0], $this->loop->pending());
    }

    public function testTheChatEndingStopsTheReader(): void
    {
        $body = $this->stream();
        $reader = $this->reader();
        $reader->start();
        $this->loop->advance();

        $body->write('[' . self::page([$this->item('m1'), $this->item('end', 'chatEndedEvent')]));

        $this->assertSame(['chat.connected', 'chat.message m1', 'chat.ended'], $this->events);
        $this->assertTrue($reader->hasEnded());
        $this->assertFalse($body->isReadable(), 'the stream is closed');
        $this->assertSame([], $this->loop->pending(), 'nothing more is asked for');
    }

    public function testAChatYouTubeSaysHasEndedStopsTheReader(): void
    {
        $this->driver->error(403, 'liveChatEnded', 'The live chat is no longer live.');
        $reader = $this->reader();

        $reader->start();
        $this->loop->advance();

        $this->assertSame(['chat.ended'], $this->events);
        $this->assertTrue($reader->hasEnded());
    }

    public function testTheStreamGoingOfflineIsSaidOnce(): void
    {
        $body = $this->stream();
        $this->reader()->start();
        $this->loop->advance();

        $body->write('[' . self::page([], 't1', ['offlineAt' => '2026-09-27T19:00:00Z']));
        $body->write(',' . self::page([], 't2', ['offlineAt' => '2026-09-27T19:00:00Z']));

        $this->assertSame(['chat.connected', 'chat.offline'], $this->events);
    }

    public function testStreamingRefusedFallsBackToPolling(): void
    {
        $this->driver->respond(404, '');
        $this->driver->respond(200, self::page([$this->item('m1')], 't1', ['pollingIntervalMillis' => 3000]));
        $reader = $this->reader();

        $reader->start();
        $this->loop->advance();
        $this->loop->advance();

        $this->assertSame('poll', $reader->getMode());
        $this->assertSame('youtube/v3/liveChat/messages', ScriptedDriver::path($this->driver->last()));
        $this->assertFalse($this->driver->streaming[1]);
        $this->assertSame(['chat.mode poll', 'chat.connected', 'chat.message m1'], $this->events);
        $this->assertSame([3.0], $this->loop->pending(), 'the interval YouTube asked for');
    }

    public function testPollingCarriesOnFromEachPage(): void
    {
        $this->driver->respond(200, self::page([], 't1', ['pollingIntervalMillis' => 5000]));
        $this->driver->respond(200, self::page([$this->item('m1')], 't2', ['pollingIntervalMillis' => 5000]));
        $reader = $this->reader(['mode' => ChatReader::MODE_POLL]);

        $reader->start();
        $this->loop->advance();
        $this->assertSame([5.0], $this->loop->pending());
        $this->loop->advance(5.0);

        $this->assertContains(['pageToken', 't1'], ScriptedDriver::queryPairs($this->driver->last()));
        $this->assertSame(['chat.connected', 'chat.message m1'], $this->events);
        $this->assertSame('t2', $reader->getPageToken());
    }

    public function testPollingSlowsDownToMakeTheQuotaLast(): void
    {
        // 100 polls left to last six hours: every 216s would do it, and 60s is the slowest allowed.
        $this->youtube = $this->client(['daily' => 101]);
        $this->driver->respond(200, self::page([], 't1', ['pollingIntervalMillis' => 2000]));
        $reader = $this->reader(['mode' => ChatReader::MODE_POLL]);

        $reader->start();
        $this->loop->advance();

        $this->assertSame(['chat.connected', 'chat.slowed 60'], $this->events);
        $this->assertSame([60.0], $this->loop->pending());
    }

    public function testTheReserveIsLeftForPeople(): void
    {
        $this->youtube = $this->client(['daily' => 1000, 'reserve' => 1000]);
        $reader = $this->reader();

        $reader->start();
        $this->loop->advance();

        $this->assertSame([], $this->driver->requests);
        $this->assertSame(['chat.paused'], $this->events);
        // Twelve hours to midnight Pacific, and five seconds to be sure.
        $this->assertSame([12 * 3600 + 5.0], $this->loop->pending());
    }

    public function testTheQuickRetriesRunOutAndThenItKeepsTrying(): void
    {
        $reader = $this->reader();
        foreach (range(1, 12) as $attempt) {
            $this->driver->fail(new \RuntimeException('Network is unreachable'));
        }

        $reader->start();
        $this->loop->advance();
        foreach (ChatReader::RETRY_DELAYS as $delay) {
            $this->loop->advance((float) $delay);
        }
        $this->loop->advance(300.0);

        $this->assertSame([
            'chat.reconnecting 1 1',
            'chat.reconnecting 2 2',
            'chat.reconnecting 3 5',
            'chat.reconnecting 4 10',
            'chat.reconnecting 5 20',
            'chat.reconnecting 6 30',
            'chat.reconnecting 7 60',
            'chat.reconnecting 8 60',
            'chat.reconnecting 9 60',
            'chat.reconnecting 10 60',
            'chat.reconnect_failed 10',
            'chat.reconnecting 11 300',
            'chat.reconnecting 12 300',
        ], $this->events);
    }

    public function testReconnectingNowSettlesWithThatAttempt(): void
    {
        $reader = $this->reader();
        $this->driver->fail(new \RuntimeException('Network is unreachable'));
        $this->driver->fail(new \RuntimeException('Still unreachable'));
        $body = $this->stream();

        $reader->start();
        $this->loop->advance();

        $outcomes = [];
        $reader->reconnect()->then(
            static function () use (&$outcomes): void {
                $outcomes[] = 'resolved';
            },
            static function (\Throwable $e) use (&$outcomes): void {
                $outcomes[] = 'rejected: ' . $e->getMessage();
            },
        );
        $this->loop->advance();
        $this->assertSame(['rejected: liveChatMessages.stream: transport error: Still unreachable'], $outcomes);

        $reader->reconnect()->then(static function () use (&$outcomes): void {
            $outcomes[] = 'resolved';
        });
        $this->loop->advance();

        $this->assertSame('resolved', $outcomes[1] ?? null);
        $this->assertTrue($reader->isConnected());
        $this->assertTrue($body->isReadable());
    }

    public function testAQuietStreamIsReopenedWhereItLeftOff(): void
    {
        $first = $this->stream();
        $reader = $this->reader();
        $reader->start();
        $this->loop->advance();
        $first->write('[' . self::page([], 't1'));

        $this->stream();
        $this->loop->advance(300.0);
        $this->loop->advance();

        $this->assertFalse($first->isReadable(), 'the old connection is let go');
        $this->assertContains(['pageToken', 't1'], ScriptedDriver::queryPairs($this->driver->last()));
        $this->assertNotContains('chat.disconnected', $this->events);
    }

    public function testStoppingLetsGoOfTheConnection(): void
    {
        $body = $this->stream();
        $reader = $this->reader();
        $reader->start();
        $this->loop->advance();

        $reader->stop();

        $this->assertFalse($body->isReadable());
        $this->assertSame(['chat.connected', 'chat.disconnected'], $this->events);
        $this->assertSame([], $this->loop->pending());
    }
}
