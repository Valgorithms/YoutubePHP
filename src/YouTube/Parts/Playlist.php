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
 * A *playlist* resource represents a YouTube playlist. A playlist is a collection of videos that can
 * be viewed sequentially and shared with other users. A playlist can contain up to 200 videos, and
 * YouTube does not limit the number of playlists that each user creates. By default, playlists are
 * publicly visible to other users, but playlists can be public or private. YouTube also uses playlists
 * to identify special collections of videos for a channel, such as: - uploaded videos - favorite
 * videos - positively rated (liked) videos - watch history - watch later To be more specific, these
 * lists are associated with a channel, which is a collection of a person, group, or company's videos,
 * playlists, and other YouTube information. You can retrieve the playlist IDs for each of these lists
 * from the channel resource for a given channel. You can then use the playlistItems.list method to
 * retrieve any of those lists. You can also add or remove items from those lists by calling the
 * playlistItems.insert and playlistItems.delete methods.
 *
 * @property \YouTube\Parts\PlaylistContentDetails|null $contentDetails The contentDetails object contains
 *     information like video count.
 * @property string|null $etag Etag of this resource.
 * @property string|null $id The ID that YouTube uses to uniquely identify the playlist.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#playlist".
 * @property array<string, \YouTube\Parts\PlaylistLocalization>|null $localizations Localizations for different
 *     languages
 * @property \YouTube\Parts\PlaylistPlayer|null $player The player object contains information that you would use
 *     to play the playlist in an embedded player.
 * @property \YouTube\Parts\PlaylistSnippet|null $snippet The snippet object contains basic details about the
 *     playlist, such as its title and description.
 * @property \YouTube\Parts\PlaylistStatus|null $status The status object contains status information for the
 *     playlist.
 *
 * @link https://developers.google.com/youtube/v3/docs/playlists
 *
 * @since 1.0.0
 */
class Playlist extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'contentDetails' => 'PlaylistContentDetails',
        'localizations' => 'Map of PlaylistLocalization',
        'player' => 'PlaylistPlayer',
        'snippet' => 'PlaylistSnippet',
        'status' => 'PlaylistStatus',
    ];
}
