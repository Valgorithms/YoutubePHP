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
 * Details about the content of an activity: the video that was shared, the channel that was subscribed
 * to, etc.
 *
 * @property \YouTube\Parts\ActivityContentDetailsBulletin|null $bulletin The `bulletin` object contains details
 *     about a channel bulletin post. This object is only present if the `snippet.type` is `bulletin`.
 * @property \YouTube\Parts\ActivityContentDetailsChannelItem|null $channelItem The `channelItem` object contains
 *     details about a resource which was added to a channel. This property is only present if the `snippet.type` is
 *     `channelItem`.
 * @property \YouTube\Parts\ActivityContentDetailsComment|null $comment The `comment` object contains information
 *     about a resource that received a comment. This property is only present if the `snippet.type` is `comment`.
 * @property \YouTube\Parts\ActivityContentDetailsPlaylistItem|null $playlistItem The `playlistItem` object
 *     contains information about a new playlist item. This property is only present if the `snippet.type` is
 *     `playlistItem`.
 * @property \YouTube\Parts\ActivityContentDetailsPromotedItem|null $promotedItem The `promotedItem` object
 *     contains details about a resource which is being promoted. This property is only present if the `snippet.type`
 *     is `promotedItem`.
 * @property \YouTube\Parts\ActivityContentDetailsRecommendation|null $recommendation The `recommendation` object
 *     contains information about a recommended resource. This property is only present if the `snippet.type` is
 *     `recommendation`.
 * @property \YouTube\Parts\ActivityContentDetailsSocial|null $social The `social` object contains details about
 *     a social network post. This property is only present if the `snippet.type` is `social`.
 * @property \YouTube\Parts\ActivityContentDetailsSubscription|null $subscription The `subscription` object
 *     contains information about a channel that a user subscribed to. This property is only present if the
 *     `snippet.type` is `subscription`.
 * @property \YouTube\Parts\ActivityContentDetailsUpload|null $upload The `upload` object contains information
 *     about the uploaded video. This property is only present if the `snippet.type` is `upload`.
 *
 * @since 1.0.0
 */
class ActivityContentDetails extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'bulletin' => 'ActivityContentDetailsBulletin',
        'channelItem' => 'ActivityContentDetailsChannelItem',
        'comment' => 'ActivityContentDetailsComment',
        'playlistItem' => 'ActivityContentDetailsPlaylistItem',
        'promotedItem' => 'ActivityContentDetailsPromotedItem',
        'recommendation' => 'ActivityContentDetailsRecommendation',
        'social' => 'ActivityContentDetailsSocial',
        'subscription' => 'ActivityContentDetailsSubscription',
        'upload' => 'ActivityContentDetailsUpload',
    ];
}
