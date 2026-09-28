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
 * A *subscription* resource contains information about a YouTube user subscription. A subscription
 * notifies a user when new videos are added to a channel or when another user takes one of several
 * actions on YouTube, such as uploading a video, rating a video, or commenting on a video.
 *
 * @property \YouTube\Parts\SubscriptionContentDetails|null $contentDetails The contentDetails object contains
 *     basic statistics about the subscription.
 * @property string|null $etag Etag of this resource.
 * @property string|null $id The ID that YouTube uses to uniquely identify the subscription.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#subscription".
 * @property \YouTube\Parts\SubscriptionSnippet|null $snippet The snippet object contains basic details about the
 *     subscription, including its title and the channel that the user subscribed to.
 * @property \YouTube\Parts\SubscriptionSubscriberSnippet|null $subscriberSnippet The subscriberSnippet object
 *     contains basic details about the subscriber.
 *
 * @link https://developers.google.com/youtube/v3/docs/subscriptions
 *
 * @since 1.0.0
 */
class Subscription extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'contentDetails' => 'SubscriptionContentDetails',
        'snippet' => 'SubscriptionSnippet',
        'subscriberSnippet' => 'SubscriptionSubscriberSnippet',
    ];
}
