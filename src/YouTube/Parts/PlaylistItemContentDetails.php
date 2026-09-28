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
 * @property string|null $endAt Deprecated. The time, measured in seconds from the start of the video, when the
 *     video should stop playing. (The playlist owner can specify the times when the video should start and stop
 *     playing when the video is played in the context of the playlist.) By default, assume that the video.endTime is
 *     the end of the video.
 * @property string|null $note A user-generated note for this item.
 * @property string|null $startAt Deprecated. The time, measured in seconds from the start of the video, when the
 *     video should start playing. (The playlist owner can specify the times when the video should start and stop
 *     playing when the video is played in the context of the playlist.) The default value is 0.
 * @property string|null $videoId The ID that YouTube uses to uniquely identify a video. To retrieve the video
 *     resource, set the id query parameter to this value in your API request.
 * @property \Carbon\CarbonImmutable|null $videoPublishedAt The date and time that the video was published to
 *     YouTube.
 *
 * @since 1.0.0
 */
class PlaylistItemContentDetails extends Part
{
    /** @var list<string> */
    protected array $dates = [
        'videoPublishedAt',
    ];
}
