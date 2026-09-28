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
 * Describes an invideo branding.
 *
 * @property string|null $imageBytes The bytes the uploaded image. Only used in api to youtube communication.
 * @property string|null $imageUrl The url of the uploaded image. Only used in apiary to api communication.
 * @property \YouTube\Parts\InvideoPosition|null $position Deprecated. The spatial position within the video
 *     where the branding watermark will be displayed.
 * @property string|null $targetChannelId The channel to which this branding links. If not present it defaults to
 *     the current channel.
 * @property \YouTube\Parts\InvideoTiming|null $timing The temporal position within the video where watermark
 *     will be displayed.
 *
 * @since 1.0.0
 */
class InvideoBranding extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'position' => 'InvideoPosition',
        'timing' => 'InvideoTiming',
    ];
}
