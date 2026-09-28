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
 * Basic broadcast information.
 *
 * @property \Carbon\CarbonImmutable|null $actualEndTime The date and time that the broadcast actually ended.
 *     This information is only available once the broadcast's state is complete.
 * @property \Carbon\CarbonImmutable|null $actualStartTime The date and time that the broadcast actually started.
 *     This information is only available once the broadcast's state is live.
 * @property string|null $categoryId The YouTube video category associated with the video broadcast.
 * @property string|null $channelId The ID that YouTube uses to uniquely identify the channel that is publishing
 *     the broadcast.
 * @property string|null $description The broadcast's description. As with the title, you can set this field by
 *     modifying the broadcast resource or by setting the description field of the corresponding video resource.
 * @property bool|null $isDefaultBroadcast Indicates whether this broadcast is the default broadcast. Internal
 *     only.
 * @property string|null $liveChatId The id of the live chat for this broadcast.
 * @property \Carbon\CarbonImmutable|null $publishedAt The date and time that the broadcast was added to
 *     YouTube's live broadcast schedule.
 * @property \Carbon\CarbonImmutable|null $scheduledEndTime The date and time that the broadcast is scheduled to
 *     end.
 * @property \Carbon\CarbonImmutable|null $scheduledStartTime The date and time that the broadcast is scheduled
 *     to start.
 * @property \YouTube\Parts\ThumbnailDetails|null $thumbnails A map of thumbnail images associated with the
 *     broadcast. For each nested object in this object, the key is the name of the thumbnail image, and the value is
 *     an object that contains other information about the thumbnail.
 * @property string|null $title The broadcast's title. Note that the broadcast represents exactly one YouTube
 *     video. You can set this field by modifying the broadcast resource or by setting the title field of the
 *     corresponding video resource.
 *
 * @since 1.0.0
 */
class LiveBroadcastSnippet extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'thumbnails' => 'ThumbnailDetails',
    ];

    /** @var list<string> */
    protected array $dates = [
        'actualEndTime',
        'actualStartTime',
        'publishedAt',
        'scheduledEndTime',
        'scheduledStartTime',
    ];
}
