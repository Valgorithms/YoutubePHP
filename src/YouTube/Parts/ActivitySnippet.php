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
 * Basic details about an activity, including title, description, thumbnails, activity type and group.
 * Next ID: 12
 *
 * @property string|null $channelId The ID that YouTube uses to uniquely identify the channel associated with the
 *     activity.
 * @property string|null $channelTitle Channel title for the channel responsible for this activity
 * @property string|null $description The description of the resource primarily associated with the activity.
 *     `@mutable` youtube.activities.insert
 * @property string|null $groupId The group ID associated with the activity. A group ID identifies user events
 *     that are associated with the same user and resource. For example, if a user uploads a video and watches the
 *     same video, the entries for those events would have the same group ID in the user's activity feed. In your
 *     user interface, you can avoid repetition by grouping events with the same `groupId` value.
 * @property \Carbon\CarbonImmutable|null $publishedAt The date and time that the video was uploaded.
 * @property \YouTube\Parts\ThumbnailDetails|null $thumbnails A map of thumbnail images associated with the
 *     resource that is primarily associated with the activity. For each object in the map, the key is the name of
 *     the thumbnail image, and the value is an object that contains other information about the thumbnail.
 * @property string|null $title The title of the resource primarily associated with the activity.
 * @property string|null $type The type of activity that the resource describes. One of the `TYPE_*` constants.
 *
 * @since 1.0.0
 */
class ActivitySnippet extends Part
{
    /** A `type` of `typeUnspecified`. */
    public const TYPE_TYPE_UNSPECIFIED = 'typeUnspecified';

    /** A `type` of `upload`. */
    public const TYPE_UPLOAD = 'upload';

    /** A `type` of `comment`. */
    public const TYPE_COMMENT = 'comment';

    /** A `type` of `subscription`. */
    public const TYPE_SUBSCRIPTION = 'subscription';

    /** A `type` of `playlistItem`. */
    public const TYPE_PLAYLIST_ITEM = 'playlistItem';

    /** A `type` of `recommendation`. */
    public const TYPE_RECOMMENDATION = 'recommendation';

    /** A `type` of `bulletin`. */
    public const TYPE_BULLETIN = 'bulletin';

    /** A `type` of `social`. */
    public const TYPE_SOCIAL = 'social';

    /** A `type` of `channelItem`. */
    public const TYPE_CHANNEL_ITEM = 'channelItem';

    /** A `type` of `promotedItem`. */
    public const TYPE_PROMOTED_ITEM = 'promotedItem';

    /** @var array<string, string> */
    protected array $casts = [
        'thumbnails' => 'ThumbnailDetails',
    ];

    /** @var list<string> */
    protected array $dates = [
        'publishedAt',
    ];
}
