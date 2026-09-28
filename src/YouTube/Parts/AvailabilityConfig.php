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
 * Common proto for Live and VOD geo-restrictions
 *
 * @property \YouTube\Parts\AvailabilityConfigGlobalConfig|null $globalConfig Video is available in all regions
 *     except the ones specified in the config.
 * @property \YouTube\Parts\AvailabilityConfigRegionsConfig|null $regionsConfig Video is available in the
 *     specified regions only.
 *
 * @since 1.0.0
 */
class AvailabilityConfig extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'globalConfig' => 'AvailabilityConfigGlobalConfig',
        'regionsConfig' => 'AvailabilityConfigRegionsConfig',
    ];
}
