<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Parts;

/**
 * This file is generated from spec/discovery.json (YouTube Data API v3, revision 20260924) by
 * tools/generate.php. Do not edit it by hand - run `composer spec:build` instead.
 *
 * Represents a time interval, encoded as a Timestamp start (inclusive) and a Timestamp end
 * (exclusive). The start must be less than or equal to the end. When the start equals the end, the
 * interval is empty (matches no time). When both start and end are unspecified, the interval matches
 * any time.
 *
 * @property \Carbon\CarbonImmutable|null $endTime Optional. Exclusive end of the interval. If specified, a
 *     Timestamp matching this interval will have to be before the end.
 * @property \Carbon\CarbonImmutable|null $startTime Optional. Inclusive start of the interval. If specified, a
 *     Timestamp matching this interval will have to be the same or after the start.
 *
 * @since 1.0.0
 */
class Interval extends Part
{
    /** @var list<string> */
    protected array $dates = [
        'endTime',
        'startTime',
    ];
}
