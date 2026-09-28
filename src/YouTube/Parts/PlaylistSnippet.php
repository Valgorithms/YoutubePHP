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
 * Basic details about a playlist, including title, description and thumbnails.
 *
 * @property string|null $channelId The ID that YouTube uses to uniquely identify the channel that published the
 *     playlist.
 * @property string|null $channelTitle The channel title of the channel that the video belongs to.
 * @property string|null $defaultLanguage The language of the playlist's default title and description.
 * @property string|null $description The playlist's description.
 * @property \YouTube\Parts\PlaylistLocalization|null $localized Localized title and description, read-only.
 * @property \Carbon\CarbonImmutable|null $publishedAt The date and time that the playlist was created.
 * @property list<string>|null $tags Deprecated. Keyword tags associated with the playlist.
 * @property string|null $thumbnailVideoId Note: if the playlist has a custom thumbnail, this field will not be
 *     populated. The video id selected by the user that will be used as the thumbnail of this playlist. This field
 *     defaults to the first publicly viewable video in the playlist, if: 1. The user has never selected a video to
 *     be the thumbnail of the playlist. 2. The user selects a video to be the thumbnail, and then removes that video
 *     from the playlist. 3. The user selects a non-owned video to be the thumbnail, but that video becomes private,
 *     or gets deleted.
 * @property \YouTube\Parts\ThumbnailDetails|null $thumbnails A map of thumbnail images associated with the
 *     playlist. For each object in the map, the key is the name of the thumbnail image, and the value is an object
 *     that contains other information about the thumbnail.
 * @property string|null $title The playlist's title.
 *
 * @since 1.0.0
 */
class PlaylistSnippet extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'localized' => 'PlaylistLocalization',
        'thumbnails' => 'ThumbnailDetails',
    ];

    /** @var list<string> */
    protected array $dates = [
        'publishedAt',
    ];
}
