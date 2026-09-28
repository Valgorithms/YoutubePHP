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
 * A *playlistItem* resource identifies another resource, such as a video, that is included in a
 * playlist. In addition, the playlistItem resource contains details about the included resource that
 * pertain specifically to how that resource is used in that playlist. YouTube uses playlists to
 * identify special collections of videos for a channel, such as: - uploaded videos - favorite videos -
 * positively rated (liked) videos - watch history - watch later To be more specific, these lists are
 * associated with a channel, which is a collection of a person, group, or company's videos, playlists,
 * and other YouTube information. You can retrieve the playlist IDs for each of these lists from the
 * channel resource for a given channel. You can then use the playlistItems.list method to retrieve any
 * of those lists. You can also add or remove items from those lists by calling the
 * playlistItems.insert and playlistItems.delete methods. For example, if a user gives a positive
 * rating to a video, you would insert that video into the liked videos playlist for that user's
 * channel.
 *
 * @property \YouTube\Parts\PlaylistItemContentDetails|null $contentDetails The contentDetails object is included
 *     in the resource if the included item is a YouTube video. The object contains additional information about the
 *     video.
 * @property string|null $etag Etag of this resource.
 * @property string|null $id The ID that YouTube uses to uniquely identify the playlist item.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#playlistItem".
 * @property \YouTube\Parts\PlaylistItemSnippet|null $snippet The snippet object contains basic details about the
 *     playlist item, such as its title and position in the playlist.
 * @property \YouTube\Parts\PlaylistItemStatus|null $status The status object contains information about the
 *     playlist item's privacy status.
 *
 * @link https://developers.google.com/youtube/v3/docs/playlistItems
 *
 * @since 1.0.0
 */
class PlaylistItem extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'contentDetails' => 'PlaylistItemContentDetails',
        'snippet' => 'PlaylistItemSnippet',
        'status' => 'PlaylistItemStatus',
    ];
}
