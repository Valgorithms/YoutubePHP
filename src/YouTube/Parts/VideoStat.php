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
 * A *VideoStat* resource represents a YouTube video's stats.
 *
 * @property \YouTube\Parts\VideoStatsContentDetails|null $contentDetails Output only. The
 *     VideoStatsContentDetails object contains information about the video content, including the length of the
 *     video. Read-only.
 * @property string|null $etag Output only. Etag of this resource. Read-only.
 * @property string|null $id Output only. The ID that YouTube uses to uniquely identify the video. Read-only.
 * @property string|null $kind Output only. Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#videoStats". Read-only.
 * @property \YouTube\Parts\VideoStatsSnippet|null $snippet Output only. The VideoStatsSnippet object contains
 *     basic details about the video, such publish time. Read-only.
 * @property \YouTube\Parts\VideoStatsStatistics|null $statistics Output only. The VideoStatsStatistics object
 *     contains statistics about the video. Read-only.
 *
 * @since 1.0.0
 */
class VideoStat extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'contentDetails' => 'VideoStatsContentDetails',
        'snippet' => 'VideoStatsSnippet',
        'statistics' => 'VideoStatsStatistics',
    ];
}
