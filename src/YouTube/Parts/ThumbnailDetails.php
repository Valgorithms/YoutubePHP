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
 * Internal representation of thumbnails for a YouTube resource.
 *
 * @property \YouTube\Parts\Thumbnail|null $default The default image for this resource.
 * @property \YouTube\Parts\Thumbnail|null $fhd The full high definition (1080p) quality image for this resource.
 * @property \YouTube\Parts\Thumbnail|null $high The high quality image for this resource.
 * @property \YouTube\Parts\Thumbnail|null $maxres The maximum resolution quality image for this resource.
 * @property \YouTube\Parts\Thumbnail|null $medium The medium quality image for this resource.
 * @property \YouTube\Parts\Thumbnail|null $qhd The quad high definition (1440p / 2K) quality image for this
 *     resource.
 * @property \YouTube\Parts\Thumbnail|null $standard The standard quality image for this resource.
 * @property \YouTube\Parts\Thumbnail|null $uhd The ultra-high resolution (4K) quality image for this resource.
 *
 * @since 1.0.0
 */
class ThumbnailDetails extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'default' => 'Thumbnail',
        'fhd' => 'Thumbnail',
        'high' => 'Thumbnail',
        'maxres' => 'Thumbnail',
        'medium' => 'Thumbnail',
        'qhd' => 'Thumbnail',
        'standard' => 'Thumbnail',
        'uhd' => 'Thumbnail',
    ];
}
