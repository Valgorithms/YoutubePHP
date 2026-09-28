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
 * Information that identifies the recommended resource.
 *
 * @property string|null $reason The reason that the resource is recommended to the user. One of the `REASON_*`
 *     constants.
 * @property \YouTube\Parts\ResourceId|null $resourceId The `resourceId` object contains information that
 *     identifies the recommended resource.
 * @property \YouTube\Parts\ResourceId|null $seedResourceId The `seedResourceId` object contains information
 *     about the resource that caused the recommendation.
 *
 * @since 1.0.0
 */
class ActivityContentDetailsRecommendation extends Part
{
    /** A `reason` of `reasonUnspecified`. */
    public const REASON_REASON_UNSPECIFIED = 'reasonUnspecified';

    /** A `reason` of `videoWatched`. */
    public const REASON_VIDEO_WATCHED = 'videoWatched';

    /** @var array<string, string> */
    protected array $casts = [
        'resourceId' => 'ResourceId',
        'seedResourceId' => 'ResourceId',
    ];
}
