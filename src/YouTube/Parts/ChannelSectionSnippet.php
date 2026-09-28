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
 * Basic details about a channel section, including title, style and position.
 *
 * @property string|null $channelId The ID that YouTube uses to uniquely identify the channel that published the
 *     channel section.
 * @property string|null $defaultLanguage Deprecated. The language of the channel section's default title and
 *     description.
 * @property \YouTube\Parts\ChannelSectionLocalization|null $localized Deprecated. Localized title, read-only.
 * @property int|null $position The position of the channel section in the channel.
 * @property string|null $style Deprecated. The style of the channel section. One of the `STYLE_*` constants.
 * @property string|null $title The channel section's title for multiple_playlists and multiple_channels.
 * @property string|null $type The type of the channel section. One of the `TYPE_*` constants.
 *
 * @since 1.0.0
 */
class ChannelSectionSnippet extends Part
{
    /** A `style` of `channelsectionStyleUnspecified`. */
    public const STYLE_CHANNELSECTION_STYLE_UNSPECIFIED = 'channelsectionStyleUnspecified';

    /** A `style` of `horizontalRow`. */
    public const STYLE_HORIZONTAL_ROW = 'horizontalRow';

    /** A `style` of `verticalList`. */
    public const STYLE_VERTICAL_LIST = 'verticalList';

    /** A `type` of `channelsectionTypeUndefined`. */
    public const TYPE_CHANNELSECTION_TYPE_UNDEFINED = 'channelsectionTypeUndefined';

    /** A `type` of `singlePlaylist`. */
    public const TYPE_SINGLE_PLAYLIST = 'singlePlaylist';

    /** A `type` of `multiplePlaylists`. */
    public const TYPE_MULTIPLE_PLAYLISTS = 'multiplePlaylists';

    /** A `type` of `popularUploads`. */
    public const TYPE_POPULAR_UPLOADS = 'popularUploads';

    /** A `type` of `recentUploads`. */
    public const TYPE_RECENT_UPLOADS = 'recentUploads';

    /**
     * A `type` of `likes`.
     *
     * @deprecated
     */
    public const TYPE_LIKES = 'likes';

    /** A `type` of `allPlaylists`. */
    public const TYPE_ALL_PLAYLISTS = 'allPlaylists';

    /**
     * A `type` of `likedPlaylists`.
     *
     * @deprecated
     */
    public const TYPE_LIKED_PLAYLISTS = 'likedPlaylists';

    /**
     * A `type` of `recentPosts`.
     *
     * @deprecated
     */
    public const TYPE_RECENT_POSTS = 'recentPosts';

    /**
     * A `type` of `recentActivity`.
     *
     * @deprecated
     */
    public const TYPE_RECENT_ACTIVITY = 'recentActivity';

    /** A `type` of `liveEvents`. */
    public const TYPE_LIVE_EVENTS = 'liveEvents';

    /** A `type` of `upcomingEvents`. */
    public const TYPE_UPCOMING_EVENTS = 'upcomingEvents';

    /** A `type` of `completedEvents`. */
    public const TYPE_COMPLETED_EVENTS = 'completedEvents';

    /** A `type` of `multipleChannels`. */
    public const TYPE_MULTIPLE_CHANNELS = 'multipleChannels';

    /**
     * A `type` of `postedVideos`.
     *
     * @deprecated
     */
    public const TYPE_POSTED_VIDEOS = 'postedVideos';

    /**
     * A `type` of `postedPlaylists`.
     *
     * @deprecated
     */
    public const TYPE_POSTED_PLAYLISTS = 'postedPlaylists';

    /** A `type` of `subscriptions`. */
    public const TYPE_SUBSCRIPTIONS = 'subscriptions';

    /** @var array<string, string> */
    protected array $casts = [
        'localized' => 'ChannelSectionLocalization',
    ];
}
