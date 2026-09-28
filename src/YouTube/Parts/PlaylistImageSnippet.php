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
 * A *playlistImage* resource identifies another resource, such as a image, that is associated with a
 * playlist. In addition, the playlistImage resource contains details about the included resource that
 * pertain specifically to how that resource is used in that playlist. YouTube uses playlists to
 * identify special collections of videos for a channel, such as: - uploaded videos - favorite videos -
 * positively rated (liked) videos - watch history To be more specific, these lists are associated with
 * a channel, which is a collection of a person, group, or company's videos, playlists, and other
 * YouTube information. You can retrieve the playlist IDs for each of these lists from the channel
 * resource for a given channel. You can then use the playlistImages.list method to retrieve image data
 * for any of those playlists. You can also add or remove images from those lists by calling the
 * playlistImages.insert and playlistImages.delete methods.
 *
 * @property int|null $height The image height.
 * @property string|null $playlistId The Playlist ID of the playlist this image is associated with.
 * @property string|null $type The image type. One of the `TYPE_*` constants.
 * @property int|null $width The image width.
 *
 * @since 1.0.0
 */
class PlaylistImageSnippet extends Part
{
    /** The main image that will be used for this playlist. */
    public const TYPE_HERO = 'hero';
}
