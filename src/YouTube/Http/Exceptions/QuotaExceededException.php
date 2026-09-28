<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Http\Exceptions;

use Carbon\CarbonImmutable;
use YouTube\Quota\Meter;

/**
 * The day's quota is spent: Google said `quotaExceeded`, or the
 * {@see Meter} refused the call before it was sent because it could not pay for
 * it.
 *
 * Quota resets at midnight Pacific time, which {@see getResetsAt()} gives when
 * the meter knows it. A refusal made locally has status 0: YouTube never saw
 * the request, and it cost nothing.
 *
 * @link https://developers.google.com/youtube/v3/determine_quota_cost
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
class QuotaExceededException extends HttpException
{
    private ?CarbonImmutable $resetsAt = null;

    /** Refused before sending: the meter could not pay for the call. */
    public static function local(string $endpoint, Meter $meter): self
    {
        $bucket = $meter->bucket($endpoint);
        $exception = new self(sprintf(
            '%s: costs %d, and %d of today\'s %d remain in the %s quota. It resets %s.',
            $endpoint,
            $meter->cost($endpoint),
            $meter->remaining($bucket),
            $meter->limit($bucket),
            $bucket,
            $meter->resetsAt()->diffForHumans(),
        ), 0, 'quotaExceeded', 'youtubephp.meter', [], null, $endpoint);
        $exception->resetsAt = $meter->resetsAt();

        return $exception;
    }

    /** True when the meter refused it and YouTube never saw the request. */
    public function isLocal(): bool
    {
        return $this->getStatus() === 0;
    }

    /** When the quota comes back, if the meter knows. */
    public function getResetsAt(): ?CarbonImmutable
    {
        return $this->resetsAt;
    }

    /** @internal Set by the client, which knows the meter. */
    public function setResetsAt(CarbonImmutable $resetsAt): void
    {
        $this->resetsAt = $resetsAt;
    }
}
