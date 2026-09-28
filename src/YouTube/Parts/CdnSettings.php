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
 * Brief description of the live stream cdn settings.
 *
 * @property string|null $format Deprecated. The format of the video stream that you are sending to Youtube.
 * @property string|null $frameRate The frame rate of the inbound video data. One of the `FRAME_RATE_*`
 *     constants.
 * @property \YouTube\Parts\IngestionInfo|null $ingestionInfo The ingestionInfo object contains information that
 *     YouTube provides that you need to transmit your RTMP or HTTP stream to YouTube.
 * @property string|null $ingestionType The method or protocol used to transmit the video stream. One of the
 *     `INGESTION_TYPE_*` constants.
 * @property string|null $resolution The resolution of the inbound video data. One of the `RESOLUTION_*`
 *     constants.
 *
 * @since 1.0.0
 */
class CdnSettings extends Part
{
    /** A `frameRate` of `30fps`. */
    public const FRAME_RATE_30FPS = '30fps';

    /** A `frameRate` of `60fps`. */
    public const FRAME_RATE_60FPS = '60fps';

    /** A `frameRate` of `variable`. */
    public const FRAME_RATE_VARIABLE = 'variable';

    /** A `ingestionType` of `rtmp`. */
    public const INGESTION_TYPE_RTMP = 'rtmp';

    /** A `ingestionType` of `dash`. */
    public const INGESTION_TYPE_DASH = 'dash';

    /** A `ingestionType` of `webrtc`. */
    public const INGESTION_TYPE_WEBRTC = 'webrtc';

    /** A `ingestionType` of `hls`. */
    public const INGESTION_TYPE_HLS = 'hls';

    /** A `resolution` of `240p`. */
    public const RESOLUTION_240P = '240p';

    /** A `resolution` of `360p`. */
    public const RESOLUTION_360P = '360p';

    /** A `resolution` of `480p`. */
    public const RESOLUTION_480P = '480p';

    /** A `resolution` of `720p`. */
    public const RESOLUTION_720P = '720p';

    /** A `resolution` of `1080p`. */
    public const RESOLUTION_1080P = '1080p';

    /** A `resolution` of `1440p`. */
    public const RESOLUTION_1440P = '1440p';

    /** A `resolution` of `2160p`. */
    public const RESOLUTION_2160P = '2160p';

    /** A `resolution` of `variable`. */
    public const RESOLUTION_VARIABLE = 'variable';

    /** @var array<string, string> */
    protected array $casts = [
        'ingestionInfo' => 'IngestionInfo',
    ];
}
