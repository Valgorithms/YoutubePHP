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
 * Basic details about a channel, including title, description and thumbnails.
 *
 * @property string|null $country The country of the channel.
 * @property string|null $customUrl The custom url of the channel.
 * @property string|null $defaultLanguage The language of the channel's default title and description.
 * @property string|null $description The description of the channel.
 * @property \YouTube\Parts\ChannelLocalization|null $localized Localized title and description, read-only.
 * @property \Carbon\CarbonImmutable|null $publishedAt The date and time that the channel was created.
 * @property \YouTube\Parts\ThumbnailDetails|null $thumbnails A map of thumbnail images associated with the
 *     channel. For each object in the map, the key is the name of the thumbnail image, and the value is an object
 *     that contains other information about the thumbnail. When displaying thumbnails in your application, make sure
 *     that your code uses the image URLs exactly as they are returned in API responses. For example, your
 *     application should not use the http domain instead of the https domain in a URL returned in an API response.
 *     Beginning in July 2018, channel thumbnail URLs will only be available in the https domain, which is how the
 *     URLs appear in API responses. After that time, you might see broken images in your application if it tries to
 *     load YouTube images from the http domain. Thumbnail images might be empty for newly created channels and might
 *     take up to one day to populate.
 * @property string|null $title The channel's title.
 *
 * @since 1.0.0
 */
class ChannelSnippet extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'localized' => 'ChannelLocalization',
        'thumbnails' => 'ThumbnailDetails',
    ];

    /** @var list<string> */
    protected array $dates = [
        'publishedAt',
    ];
}
