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
 * The `relatedPlaylists` object of a ChannelContentDetails.
 *
 * @property string|null $favorites Deprecated. The ID of the playlist that contains the channel"s favorite
 *     videos. Use the playlistItems.insert and playlistItems.delete to add or remove items from that list.
 * @property string|null $likes The ID of the playlist that contains the channel"s liked videos. Use the
 *     playlistItems.insert and playlistItems.delete to add or remove items from that list.
 * @property string|null $uploads The ID of the playlist that contains the channel"s uploaded videos. Use the
 *     videos.insert method to upload new videos and the videos.delete method to delete previously uploaded videos.
 * @property string|null $watchHistory Deprecated. The ID of the playlist that contains the channel"s watch
 *     history. Use the playlistItems.insert and playlistItems.delete to add or remove items from that list.
 * @property string|null $watchLater Deprecated. The ID of the playlist that contains the channel"s watch later
 *     playlist. Use the playlistItems.insert and playlistItems.delete to add or remove items from that list.
 *
 * @since 1.0.0
 */
class ChannelContentDetailsRelatedPlaylists extends Part
{
}
