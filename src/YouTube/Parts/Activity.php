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
 * An `activity` resource contains information about an action that a particular channel, or user, has
 * taken on YouTube. The actions reported in activity feeds include sharing a video, uploading a video,
 * and so forth. Each `activity` resource identifies the type of action, the channel associated with
 * the action, and the resource(s) associated with the action, such as the video that was rated or
 * uploaded.
 *
 * @property \YouTube\Parts\ActivityContentDetails|null $contentDetails The `contentDetails` object contains
 *     information about the content associated with the activity. For example, if the `snippet.type` value is
 *     `videoRated`, then the `contentDetails` object's content identifies the rated video.
 * @property string|null $etag Etag of this resource
 * @property string|null $id The ID that YouTube uses to uniquely identify the activity.
 * @property string|null $kind Identifies what kind of resource this is. Value: The fixed string
 *     `"youtube#activity"`.
 * @property \YouTube\Parts\ActivitySnippet|null $snippet The `snippet` object contains basic details about the
 *     activity, including the activity's type and group ID.
 *
 * @link https://developers.google.com/youtube/v3/docs/activities
 *
 * @since 1.0.0
 */
class Activity extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'contentDetails' => 'ActivityContentDetails',
        'snippet' => 'ActivitySnippet',
    ];
}
