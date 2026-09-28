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
 * Basic details about a playlist, including title, description and thumbnails. Basic details of a
 * YouTube Playlist item provided by the author. Next ID: 15
 *
 * @property string|null $channelId The ID that YouTube uses to uniquely identify the user that added the item to
 *     the playlist.
 * @property string|null $channelTitle Channel title for the channel that the playlist item belongs to.
 * @property string|null $description The item's description.
 * @property string|null $playlistId The ID that YouTube uses to uniquely identify thGe playlist that the
 *     playlist item is in.
 * @property int|null $position The order in which the item appears in the playlist. The value uses a zero-based
 *     index, so the first item has a position of 0, the second item has a position of 1, and so forth.
 * @property \Carbon\CarbonImmutable|null $publishedAt The date and time that the item was added to the playlist.
 * @property \YouTube\Parts\ResourceId|null $resourceId The id object contains information that can be used to
 *     uniquely identify the resource that is included in the playlist as the playlist item.
 * @property \YouTube\Parts\ThumbnailDetails|null $thumbnails A map of thumbnail images associated with the
 *     playlist item. For each object in the map, the key is the name of the thumbnail image, and the value is an
 *     object that contains other information about the thumbnail.
 * @property string|null $title The item's title.
 * @property string|null $videoOwnerChannelId Channel id for the channel this video belongs to.
 * @property string|null $videoOwnerChannelTitle Channel title for the channel this video belongs to.
 *
 * @since 1.0.0
 */
class PlaylistItemSnippet extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'resourceId' => 'ResourceId',
        'thumbnails' => 'ThumbnailDetails',
    ];

    /** @var list<string> */
    protected array $dates = [
        'publishedAt',
    ];
}
