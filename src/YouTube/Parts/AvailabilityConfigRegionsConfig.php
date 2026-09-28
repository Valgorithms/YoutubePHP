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
 * Video is available in the specified regions only.
 *
 * @property \Discord\Helpers\Collection<\YouTube\Parts\AvailabilityConfigRegionsConfigRegionInterval>|null
 *     $regionIntervals Required. List of regions and time windows where video is available. If a region is specified
 *     multiple times, the union of all intervals is used.
 *
 * @since 1.0.0
 */
class AvailabilityConfigRegionsConfig extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'regionIntervals' => 'Array of AvailabilityConfigRegionsConfigRegionInterval',
    ];
}
