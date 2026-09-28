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
 * Basic details about a search result, including title, description and thumbnails of the item
 * referenced by the search result.
 *
 * @property string|null $channelId The value that YouTube uses to uniquely identify the channel that published
 *     the resource that the search result identifies.
 * @property string|null $channelTitle The title of the channel that published the resource that the search
 *     result identifies.
 * @property string|null $description A description of the search result.
 * @property string|null $liveBroadcastContent It indicates if the resource (video or channel) has
 *     upcoming/active live broadcast content. Or it's "none" if there is not any upcoming/active live broadcasts.
 *     One of the `LIVE_BROADCAST_CONTENT_*` constants.
 * @property \Carbon\CarbonImmutable|null $publishedAt The creation date and time of the resource that the search
 *     result identifies.
 * @property \YouTube\Parts\ThumbnailDetails|null $thumbnails A map of thumbnail images associated with the
 *     search result. For each object in the map, the key is the name of the thumbnail image, and the value is an
 *     object that contains other information about the thumbnail.
 * @property string|null $title The title of the search result.
 *
 * @since 1.0.0
 */
class SearchResultSnippet extends Part
{
    /** The resource does not have live broadcast content. */
    public const LIVE_BROADCAST_CONTENT_NONE = 'none';

    /** The live broadcast is upcoming. */
    public const LIVE_BROADCAST_CONTENT_UPCOMING = 'upcoming';

    /** The live broadcast is active. */
    public const LIVE_BROADCAST_CONTENT_LIVE = 'live';

    /** The live broadcast has been completed. */
    public const LIVE_BROADCAST_CONTENT_COMPLETED = 'completed';

    /** @var array<string, string> */
    protected array $casts = [
        'thumbnails' => 'ThumbnailDetails',
    ];

    /** @var list<string> */
    protected array $dates = [
        'publishedAt',
    ];
}
