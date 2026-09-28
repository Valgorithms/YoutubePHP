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
 * Basic details about a subscription's subscriber including title, description, channel ID and
 * thumbnails.
 *
 * @property string|null $channelId The channel ID of the subscriber.
 * @property string|null $description The description of the subscriber.
 * @property \YouTube\Parts\ThumbnailDetails|null $thumbnails Thumbnails for this subscriber.
 * @property string|null $title The title of the subscriber.
 *
 * @since 1.0.0
 */
class SubscriptionSubscriberSnippet extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'thumbnails' => 'ThumbnailDetails',
    ];
}
