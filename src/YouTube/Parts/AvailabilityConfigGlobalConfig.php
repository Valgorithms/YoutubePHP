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
 * Video is available in all regions except the ones specified in the excluded_region_codes list.
 *
 * @property list<string>|null $excludedRegionCodes Optional. Regions where video is blocked
 * @property \YouTube\Parts\Interval|null $interval Default time window where video is available for all
 *     non-blocked regions Not supported for upcoming / active live broadcasts. If start time is unspecified, video
 *     is already available If end time is unspecified, video is available forever Specified start and end times
 *     cannot be more than five years in the future.
 *
 * @since 1.0.0
 */
class AvailabilityConfigGlobalConfig extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'interval' => 'Interval',
    ];
}
