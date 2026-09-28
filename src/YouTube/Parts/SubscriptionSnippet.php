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
 * Basic details about a subscription, including title, description and thumbnails of the subscribed
 * item.
 *
 * @property string|null $channelId The ID that YouTube uses to uniquely identify the subscriber's channel.
 * @property string|null $description The subscription's details.
 * @property \Carbon\CarbonImmutable|null $publishedAt The date and time that the subscription was created.
 * @property \YouTube\Parts\ResourceId|null $resourceId The id object contains information about the channel that
 *     the user subscribed to.
 * @property \YouTube\Parts\ThumbnailDetails|null $thumbnails A map of thumbnail images associated with the
 *     video. For each object in the map, the key is the name of the thumbnail image, and the value is an object that
 *     contains other information about the thumbnail.
 * @property string|null $title The subscription's title.
 *
 * @since 1.0.0
 */
class SubscriptionSnippet extends Part
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
