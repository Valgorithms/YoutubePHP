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
use YouTube\LiveChat\BroadcastWatcher;
use YouTube\Parts\LiveBroadcast;
use YouTube\YouTube;

/**
 * Noticing the channel go live and stop, without announcing a blip, and
 * without spending the reserve on it.
 */
final class BroadcastWatcherTest extends TestCase
{
    private ScriptedDriver $driver;

    private FastLoop $loop;

    private YouTube $youtube;

    /** @var list<string> */
    private array $events = [];

    protected function setUp(): void
    {
        $this->driver = new ScriptedDriver();
        $this->loop = new FastLoop(Loop::get(), fire: false);
        $this->youtube = new YouTube(['token' => 'token', 'driver' => $this->driver, 'loop' => $this->loop]);
    }

    /** @param array<string, mixed> $options */
    private function watcher(array $options = []): BroadcastWatcher
    {
        $watcher = new BroadcastWatcher($this->youtube, $options);

        $watcher->on('broadcast.live', function (LiveBroadcast $broadcast): void {
            $this->events[] = 'live ' . $broadcast->id;
        });
        $watcher->on('broadcast.ended', function (LiveBroadcast $broadcast): void {
            $this->events[] = 'ended ' . $broadcast->id;
        });
        $watcher->on('error', function (\Throwable $e): void {
            $this->events[] = 'error';
        });

        return $watcher;
    }

    /** @param list<array<string, mixed>> $broadcasts */
    private function answer(array $broadcasts): void
    {
        $this->driver->respond(200, ['kind' => 'youtube#liveBroadcastListResponse', 'items' => $broadcasts]);
    }

    private static function broadcast(string $id, string $lifeCycle = 'live', string $privacy = 'public'): array
    {
        return [
            'kind' => 'youtube#liveBroadcast',
            'id' => $id,
            'snippet' => ['title' => 'Stream ' . $id, 'liveChatId' => 'chat-' . $id, 'actualStartTime' => '2026-09-27T19:00:00Z'],
            'status' => ['lifeCycleStatus' => $lifeCycle, 'privacyStatus' => $privacy],
        ];
    }

    public function testTheCheckAsksForEveryKindOfActiveBroadcast(): void
    {
        $this->answer([]);

        $this->watcher()->check();

        $pairs = ScriptedDriver::queryPairs($this->driver->last());
        $this->assertContains(['broadcastStatus', 'active'], $pairs);
        $this->assertContains(['broadcastType', 'all'], $pairs, "YouTube's default leaves out the Go-live-now stream");
        $this->assertNotContains('mine', array_column($pairs, 0), 'mine and broadcastStatus cannot be combined');
    }

    public function testGoingLiveIsReportedOnce(): void
    {
        $watcher = $this->watcher();
        $this->answer([self::broadcast('b1')]);
        $this->answer([self::broadcast('b1')]);

        $watcher->check();
        $watcher->check();

        $this->assertSame(['live b1'], $this->events);
        $this->assertSame('chat-b1', $watcher->live()['b1']->snippet->liveChatId);
        $this->assertSame('b1', $watcher->broadcastFor('chat-b1')?->id);
    }

    public function testAnEndTakesTwoChecksWithoutIt(): void
    {
        $watcher = $this->watcher();
        $this->answer([self::broadcast('b1')]);
        $this->answer([]);
        $this->answer([]);

        $watcher->check();
        $watcher->check();
        $this->assertSame(['live b1'], $this->events, 'one empty answer could be a blip');

        $watcher->check();
        $this->assertSame(['live b1', 'ended b1'], $this->events);
        $this->assertSame([], $watcher->live());
    }

    public function testTheChatSayingItEndedIsBelievedAtOnce(): void
    {
        $watcher = $this->watcher();
        $this->answer([self::broadcast('b1')]);
        $this->answer([]);

        $watcher->check();
        $watcher->ended('b1');
        $watcher->check();

        $this->assertSame(['live b1', 'ended b1'], $this->events);
    }

    public function testOnlyABroadcastThatIsActuallyLiveCounts(): void
    {
        $this->answer([self::broadcast('b1', 'testing'), self::broadcast('b2', 'complete'), self::broadcast('b3')]);

        $this->watcher()->check();

        $this->assertSame(['live b3'], $this->events);
    }

    public function testUnlistedBroadcastsCanBeLeftOut(): void
    {
        $this->answer([self::broadcast('b1', privacy: 'unlisted'), self::broadcast('b2')]);

        $this->watcher(['include_unlisted' => false])->check();

        $this->assertSame(['live b2'], $this->events);
    }

    public function testAFailedCheckChangesNothing(): void
    {
        $watcher = $this->watcher();
        $this->answer([self::broadcast('b1')]);
        $this->driver->error(500, 'backendError');

        $watcher->check();
        // The client retries a 500 on a GET, so script the retries' failures too.
        foreach (range(2, 4) as $attempt) {
            $this->driver->error(500, 'backendError');
        }
        $watcher->check();
        // Each retry sets the timer for the next when it fails.
        while ($this->loop->advance(10.0) > 0) {
        }

        $this->assertSame(['live b1', 'error'], $this->events);
        $this->assertArrayHasKey('b1', $watcher->live());
    }

    public function testChecksComeMoreSlowlyWhileLive(): void
    {
        $watcher = $this->watcher();
        $this->answer([]);
        $this->answer([self::broadcast('b1')]);

        $watcher->start();
        $this->assertSame([120.0], $this->loop->pending());

        $this->loop->advance(120.0);
        $this->assertSame([300.0], $this->loop->pending(), 'the chat reader notices the end sooner');

        $watcher->stop();
        $this->assertSame([], $this->loop->pending());
    }

    public function testTheReserveIsNotSpentOnChecking(): void
    {
        $this->youtube = new YouTube(['token' => 'token', 'driver' => $this->driver, 'loop' => $this->loop, 'quota' => ['daily' => 1000, 'reserve' => 1000]]);

        $this->watcher()->start();

        $this->assertSame([], $this->driver->requests);
        $this->assertSame([120.0], $this->loop->pending(), 'it tries again later');
    }
}
