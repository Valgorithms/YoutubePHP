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
use YouTube\Quota\Cost;
use YouTube\Quota\Meter;

/**
 * The quota count: what things cost, which bucket pays, the reserve, and the
 * day turning over at midnight in California rather than here.
 */
final class MeterTest extends TestCase
{
    private float $now;

    private string $dir;

    protected function setUp(): void
    {
        // 23:00 on 27 September 2026, Pacific daylight time.
        $this->now = (float) (new \DateTimeImmutable('2026-09-27 23:00:00', new \DateTimeZone('America/Los_Angeles')))->getTimestamp();
        $this->dir = sys_get_temp_dir() . '/youtubephp-meter-' . bin2hex(random_bytes(6));
    }

    protected function tearDown(): void
    {
        @unlink($this->dir . '/quota.json');
        @rmdir($this->dir);
    }

    private function meter(array $limits = [], int $reserve = 0, ?string $path = null): Meter
    {
        return new Meter($limits, $reserve, $path, fn (): float => $this->now);
    }

    public function testCallsAreChargedWhatTheyCost(): void
    {
        $meter = $this->meter();

        $meter->spend('liveChatMessages.list', 3);
        $meter->spend('liveChatMessages.insert');

        $this->assertSame(53, $meter->used());
        $this->assertSame(9947, $meter->remaining());
    }

    public function testSearchHasABucketOfItsOwn(): void
    {
        $meter = $this->meter();

        $meter->spend('search.list');

        $this->assertSame('search', $meter->bucket('search.list'));
        $this->assertSame(1, $meter->used('search'));
        $this->assertSame(99, $meter->remaining('search'));
        $this->assertSame(0, $meter->used(), 'the shared bucket is untouched');
    }

    public function testTheReserveIsLeftForWhatAPersonAsksFor(): void
    {
        $meter = $this->meter(['default' => 1000], 500);
        $meter->spend('liveChatMessages.list', 499);

        $this->assertTrue($meter->canAfford('liveChatMessages.list', keepReserve: true));

        $meter->spend('liveChatMessages.list');

        $this->assertFalse($meter->canAfford('liveChatMessages.list', keepReserve: true), 'background work stops at the reserve');
        $this->assertTrue($meter->canAfford('liveChatMessages.insert'), 'a person may still spend it');
    }

    public function testNothingIsAffordableOnceTheDayIsSpent(): void
    {
        $meter = $this->meter(['default' => 100]);
        $meter->spend('liveChatMessages.insert', 2);

        $this->assertFalse($meter->canAfford('liveChatMessages.list'));
        $this->assertSame(0, $meter->remaining());
    }

    public function testQuotaFromGoogleSpendsTheBucket(): void
    {
        $meter = $this->meter();

        $meter->exhaust('liveChatMessages.list');

        $this->assertSame(0, $meter->remaining());
        $this->assertSame(100, $meter->remaining('search'), 'only the bucket that ran out');
    }

    public function testTheDayTurnsOverAtMidnightPacific(): void
    {
        $meter = $this->meter();
        $meter->spend('liveChatMessages.insert');

        $this->assertSame('2026-09-27', $meter->day());
        $this->assertSame('2026-09-28T00:00:00-07:00', $meter->resetsAt()->toIso8601String());

        $this->now += 3599;
        $this->assertSame(50, $meter->used(), 'one second to midnight');

        $this->now += 1;
        $this->assertSame('2026-09-28', $meter->day());
        $this->assertSame(0, $meter->used());
    }

    public function testTheResetFollowsDaylightSaving(): void
    {
        // The night the clocks go back: 1 November 2026 is 25 hours long.
        $this->now = (float) (new \DateTimeImmutable('2026-11-01 12:00:00', new \DateTimeZone('America/Los_Angeles')))->getTimestamp();

        $this->assertSame('2026-11-02T00:00:00-08:00', $this->meter()->resetsAt()->toIso8601String());
    }

    public function testTheCountSurvivesARestart(): void
    {
        $path = $this->dir . '/quota.json';

        $this->meter(path: $path)->spend('liveChatMessages.insert');
        $this->assertFileExists($path);

        $this->assertSame(50, $this->meter(path: $path)->used());
    }

    public function testYesterdaysCountIsNotCarriedOver(): void
    {
        $path = $this->dir . '/quota.json';
        $this->meter(path: $path)->spend('liveChatMessages.insert');

        $this->now += 3600;

        $this->assertSame(0, $this->meter(path: $path)->used());
    }

    public function testADamagedFileIsOnlyACount(): void
    {
        @mkdir($this->dir, 0o777, true);
        file_put_contents($this->dir . '/quota.json', '{"day": "2026-09-27", "used": ');

        $this->assertSame(0, $this->meter(path: $this->dir . '/quota.json')->used());
    }

    public function testAMethodThisBuildDoesNotKnowCountsAsARead(): void
    {
        $this->assertSame(1, Cost::of('somethingNew.list'));
        $this->assertSame(Meter::DEFAULT_BUCKET, Cost::bucketOf('somethingNew.list'));
    }

    public function testTheSnapshotReportsEveryBucket(): void
    {
        $meter = $this->meter(reserve: 500);
        $meter->spend('liveChatMessages.list', 10);

        $snapshot = $meter->snapshot();

        $this->assertSame('2026-09-27', $snapshot['day']);
        $this->assertSame(500, $snapshot['reserve']);
        $this->assertSame(['used' => 10, 'limit' => 10000, 'remaining' => 9990], $snapshot['buckets']['default']);
        $this->assertSame(['default', 'search', 'uploads'], array_keys($snapshot['buckets']));
    }
}
