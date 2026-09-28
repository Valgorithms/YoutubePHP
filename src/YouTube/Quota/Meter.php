<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Quota;

use Carbon\CarbonImmutable;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Counts what today's requests have cost against the project's daily quota.
 *
 * YouTube gives each Google Cloud project a daily allowance, reset at midnight
 * Pacific time: 10,000 units shared by most methods, plus separate buckets of
 * 100 calls for `search.list` and for `videos.insert`. Every request costs,
 * including ones that fail, and a project that runs out gets `quotaExceeded`
 * for everything until the reset. {@see Cost} lists what each method costs.
 *
 * The meter is an estimate kept on this side: it cannot see requests other
 * programs make with the same project, and a few costs are unpublished. When
 * Google says the quota is spent, {@see exhaust()} brings the count into line.
 *
 * - **Refusing:** {@see \YouTube\Http\Http} charges every attempt it sends and
 *   refuses a call the day's remaining quota cannot pay for, before sending it.
 * - **Reserve:** some units can be kept back. {@see canAfford()} leaves them
 *   out when asked to, so a background job such as reading chat stops short of
 *   the limit and leaves room for what a person asks for.
 * - **Restarts:** with a path, the count is written to a JSON file on every
 *   charge and read back at start, so a restart does not forget the day.
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
final class Meter
{
    /** The quota day runs midnight to midnight here. */
    public const TIMEZONE = 'America/Los_Angeles';

    /** The bucket most methods draw from. */
    public const DEFAULT_BUCKET = 'default';

    /** @var array<string, int> Bucket => its daily allowance. */
    private array $limits;

    /** @var array<string, int> Bucket => what today has used. */
    private array $used = [];

    /** The quota day the counts belong to, as `Y-m-d` in Pacific time. */
    private string $day;

    private LoggerInterface $logger;

    /**
     * @param array<string, int>     $limits  Bucket => daily allowance, for any that differ from
     *                                        {@see Cost::DAILY} - a project granted more quota.
     * @param int                    $reserve Units of the default bucket to keep back, see {@see canAfford()}.
     * @param string|null            $path    A JSON file to keep the count in across restarts.
     * @param (\Closure(): float)|null $clock The time as a Unix timestamp, for tests.
     */
    public function __construct(
        array $limits = [],
        private readonly int $reserve = 0,
        private readonly ?string $path = null,
        private readonly ?\Closure $clock = null,
        ?LoggerInterface $logger = null,
    ) {
        $this->limits = array_map('intval', $limits) + Cost::DAILY;
        $this->logger = $logger ?? new NullLogger();
        $this->day = $this->today();
        $this->load();
    }

    /** What one call to a method costs, in its bucket's units. */
    public function cost(string $endpoint): int
    {
        return Cost::of($endpoint);
    }

    /** The bucket a method draws from. */
    public function bucket(string $endpoint): string
    {
        return Cost::bucketOf($endpoint);
    }

    /** Charges for calls to a method. */
    public function spend(string $endpoint, int $times = 1): void
    {
        $this->roll();

        $bucket = $this->bucket($endpoint);
        $this->used[$bucket] = ($this->used[$bucket] ?? 0) + $this->cost($endpoint) * $times;

        $this->save();
    }

    /**
     * Whether today's quota can pay for calls to a method.
     *
     * @param bool $keepReserve Leave the reserve out of what is available. A
     *                          job that runs by itself should, so it does not
     *                          spend what a person may need later in the day.
     */
    public function canAfford(string $endpoint, bool $keepReserve = false, int $times = 1): bool
    {
        $bucket = $this->bucket($endpoint);
        $available = $this->remaining($bucket);

        if ($keepReserve && $bucket === self::DEFAULT_BUCKET) {
            $available -= $this->reserve;
        }

        return $this->cost($endpoint) * $times <= $available;
    }

    /**
     * Google said the quota is spent, so the rest of the day is: whatever this
     * count thought, other programs using the project got there first.
     */
    public function exhaust(string $endpoint): void
    {
        $this->roll();

        $bucket = $this->bucket($endpoint);
        $this->used[$bucket] = max($this->used[$bucket] ?? 0, $this->limit($bucket));

        $this->save();
    }

    /** What today has used of a bucket. */
    public function used(string $bucket = self::DEFAULT_BUCKET): int
    {
        $this->roll();

        return $this->used[$bucket] ?? 0;
    }

    /** A bucket's daily allowance. */
    public function limit(string $bucket = self::DEFAULT_BUCKET): int
    {
        return $this->limits[$bucket] ?? 0;
    }

    /** What is left of a bucket today, reserve included. */
    public function remaining(string $bucket = self::DEFAULT_BUCKET): int
    {
        return max(0, $this->limit($bucket) - $this->used($bucket));
    }

    /** Units of the default bucket kept back from background work. */
    public function reserve(): int
    {
        return $this->reserve;
    }

    /** The quota day, as `Y-m-d` in Pacific time. */
    public function day(): string
    {
        $this->roll();

        return $this->day;
    }

    /** When the quota next resets: the coming midnight, Pacific time. */
    public function resetsAt(): CarbonImmutable
    {
        return $this->now()->startOfDay()->addDay();
    }

    /**
     * Today's count, for a status command.
     *
     * @return array{day: string, resets_at: CarbonImmutable, reserve: int, buckets: array<string, array{used: int, limit: int, remaining: int}>}
     */
    public function snapshot(): array
    {
        $buckets = [];
        foreach (array_keys($this->limits) as $bucket) {
            $buckets[$bucket] = [
                'used' => $this->used($bucket),
                'limit' => $this->limit($bucket),
                'remaining' => $this->remaining($bucket),
            ];
        }

        return [
            'day' => $this->day(),
            'resets_at' => $this->resetsAt(),
            'reserve' => $this->reserve,
            'buckets' => $buckets,
        ];
    }

    /** Starts a fresh count once midnight Pacific has passed. */
    private function roll(): void
    {
        $today = $this->today();

        if ($today !== $this->day) {
            $this->day = $today;
            $this->used = [];
        }
    }

    private function now(): CarbonImmutable
    {
        $timestamp = $this->clock !== null ? ($this->clock)() : microtime(true);

        return CarbonImmutable::createFromTimestamp($timestamp, self::TIMEZONE);
    }

    private function today(): string
    {
        return $this->now()->format('Y-m-d');
    }

    private function load(): void
    {
        if ($this->path === null || ! is_file($this->path)) {
            return;
        }

        $saved = json_decode((string) @file_get_contents($this->path), true);

        // Another day's count is no use, and a damaged file is only a count.
        if (! is_array($saved) || ($saved['day'] ?? null) !== $this->day || ! is_array($saved['used'] ?? null)) {
            return;
        }

        foreach ($saved['used'] as $bucket => $used) {
            if (is_string($bucket) && is_int($used) && $used >= 0) {
                $this->used[$bucket] = $used;
            }
        }
    }

    private function save(): void
    {
        if ($this->path === null) {
            return;
        }

        $directory = dirname($this->path);
        if (! is_dir($directory)) {
            @mkdir($directory, 0o777, true);
        }

        $json = json_encode(['day' => $this->day, 'used' => $this->used], JSON_PRETTY_PRINT) . "\n";

        // In place rather than through a rename: a count torn by a crash costs
        // at most the day's figure, and Windows can refuse a rename while a
        // virus scanner has the file open.
        if (@file_put_contents($this->path, $json, LOCK_EX) === false) {
            $this->logger->debug("could not write the quota count to {$this->path}");
        }
    }
}
