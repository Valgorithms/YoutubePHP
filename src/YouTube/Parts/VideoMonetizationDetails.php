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
 * Details about monetization of a YouTube Video.
 *
 * @property \YouTube\Parts\AccessPolicy|null $access The value of access indicates whether the video can be
 *     monetized or not.
 *
 * @since 1.0.0
 */
class VideoMonetizationDetails extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'access' => 'AccessPolicy',
    ];
}
