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
 * Recording information associated with the video.
 *
 * @property \YouTube\Parts\GeoPoint|null $location The geolocation information associated with the video.
 * @property string|null $locationDescription The text description of the location where the video was recorded.
 * @property \Carbon\CarbonImmutable|null $recordingDate The date and time when the video was recorded.
 *
 * @since 1.0.0
 */
class VideoRecordingDetails extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'location' => 'GeoPoint',
    ];

    /** @var list<string> */
    protected array $dates = [
        'recordingDate',
    ];
}
