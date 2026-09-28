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

use React\EventLoop\LoopInterface;
use React\EventLoop\Timer\Timer;
use React\EventLoop\TimerInterface;

/**
 * A loop for tests that records the delay of every one-off timer, and then
 * either runs it at once or holds it until the test says time has passed:
 * the timing a test asserts on, without the waiting. Everything else is the
 * wrapped loop's.
 */
final class FastLoop implements LoopInterface
{
    /** @var list<float> The delay every one-off timer asked for. */
    public array $delays = [];

    /** @var array<int, TimerInterface> Timers held back, by object id, when not firing. */
    private array $held = [];

    /**
     * @param bool $fire Run each timer at once; false holds it for {@see advance()}.
     */
    public function __construct(
        private readonly LoopInterface $loop,
        private readonly bool $fire = true,
    ) {
    }

    public function addTimer($interval, $callback): TimerInterface
    {
        $this->delays[] = (float) $interval;

        if ($this->fire) {
            return $this->loop->addTimer(0, $callback);
        }

        $timer = new Timer((float) $interval, $callback, false);
        $this->held[spl_object_id($timer)] = $timer;

        return $timer;
    }

    /**
     * Runs every held timer due within this many seconds, in the order they
     * were set. Timers they set in turn wait for the next call.
     *
     * @return int How many ran.
     */
    public function advance(float $seconds = 0.0): int
    {
        // A Timer never reports less than a microsecond, even when asked for 0.
        $due = array_filter($this->held, static fn (TimerInterface $timer): bool => $timer->getInterval() <= $seconds + 0.00001);

        foreach (array_keys($due) as $id) {
            unset($this->held[$id]);
        }

        foreach ($due as $timer) {
            ($timer->getCallback())($timer);
        }

        return count($due);
    }

    /** @return list<float> The delays of the timers still held. */
    public function pending(): array
    {
        return array_values(array_map(static fn (TimerInterface $timer): float => $timer->getInterval(), $this->held));
    }

    public function addPeriodicTimer($interval, $callback): TimerInterface
    {
        return $this->loop->addPeriodicTimer($interval, $callback);
    }

    public function cancelTimer(TimerInterface $timer): void
    {
        if (isset($this->held[spl_object_id($timer)])) {
            unset($this->held[spl_object_id($timer)]);

            return;
        }

        $this->loop->cancelTimer($timer);
    }

    public function futureTick($listener): void
    {
        $this->loop->futureTick($listener);
    }

    public function addReadStream($stream, $listener): void
    {
        $this->loop->addReadStream($stream, $listener);
    }

    public function addWriteStream($stream, $listener): void
    {
        $this->loop->addWriteStream($stream, $listener);
    }

    public function removeReadStream($stream): void
    {
        $this->loop->removeReadStream($stream);
    }

    public function removeWriteStream($stream): void
    {
        $this->loop->removeWriteStream($stream);
    }

    public function addSignal($signal, $listener): void
    {
        $this->loop->addSignal($signal, $listener);
    }

    public function removeSignal($signal, $listener): void
    {
        $this->loop->removeSignal($signal, $listener);
    }

    public function run(): void
    {
        $this->loop->run();
    }

    public function stop(): void
    {
        $this->loop->stop();
    }
}
