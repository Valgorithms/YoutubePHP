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
 * Region and time window where video is available for the region.
 *
 * @property \YouTube\Parts\Interval|null $interval Time window where video is available for the region. Not
 *     supported for upcoming / active live broadcasts. If start time is unspecified, video is already available If
 *     end time is unspecified, video is available forever Specified start and end times cannot be more than five
 *     years in the future.
 * @property string|null $regionCode Required. Region where video is available
 *
 * @since 1.0.0
 */
class AvailabilityConfigRegionsConfigRegionInterval extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'interval' => 'Interval',
    ];
}
