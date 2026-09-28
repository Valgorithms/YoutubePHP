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
 * Schedule to insert cuepoints into a broadcast by ads automator.
 *
 * @property bool|null $enabled This field is semantically required. If it is set false or not set, other fields
 *     in this message will be ignored.
 * @property string|null $pauseAdsUntil If set, automatic cuepoint insertion is paused until this timestamp ("No
 *     Ad Zone"). The value is specified in ISO 8601 format.
 * @property int|null $repeatIntervalSecs Deprecated. Interval frequency in seconds that api uses to insert
 *     cuepoints automatically.
 * @property string|null $scheduleStrategy Deprecated. The strategy to use when scheduling cuepoints. One of the
 *     `SCHEDULE_STRATEGY_*` constants.
 *
 * @since 1.0.0
 */
class CuepointSchedule extends Part
{
    /** A `scheduleStrategy` of `scheduleStrategyUnspecified`. */
    public const SCHEDULE_STRATEGY_SCHEDULE_STRATEGY_UNSPECIFIED = 'scheduleStrategyUnspecified';

    /** Strategy to schedule cuepoints at one time for all viewers. */
    public const SCHEDULE_STRATEGY_CONCURRENT = 'concurrent';

    /**
     * Strategy to schedule cuepoints at an increased rate to allow viewers to receive cuepoints when
     * eligible. See go/lcr-non-concurrent-ads for more details.
     */
    public const SCHEDULE_STRATEGY_NON_CONCURRENT = 'nonConcurrent';
}
