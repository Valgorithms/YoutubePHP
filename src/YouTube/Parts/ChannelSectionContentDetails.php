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
 * Details about a channelsection, including playlists and channels.
 *
 * @property list<string>|null $channels The channel ids for type multiple_channels.
 * @property list<string>|null $playlists The playlist ids for type single_playlist and multiple_playlists. For
 *     singlePlaylist, only one playlistId is allowed.
 *
 * @since 1.0.0
 */
class ChannelSectionContentDetails extends Part
{
}
