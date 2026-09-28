<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Quota;

/**
 * This file is generated from spec/quota.json by tools/generate.php. Do not edit
 * it by hand - edit spec/quota.json and run `composer spec:generate` instead.
 *
 * What each method costs against the daily quota, as Google publishes it. Most
 * methods share one bucket of 10,000 units a day; `search.list` and
 * `videos.insert` have buckets of their own, counted in calls.
 *
 * @link https://developers.google.com/youtube/v3/determine_quota_cost
 *
 * @since 1.0.0
 */
final class Cost
{
    /** @var array<string, int> Method => what one call costs, in its bucket's units. */
    public const METHODS = [
        'abuseReports.insert' => 50,
        'activities.list' => 1,
        'captions.delete' => 50,
        'captions.download' => 200,
        'captions.insert' => 400,
        'captions.list' => 50,
        'captions.update' => 450,
        'channelBanners.insert' => 50,
        'channelSections.delete' => 50,
        'channelSections.insert' => 50,
        'channelSections.list' => 1,
        'channelSections.update' => 50,
        'channels.list' => 1,
        'channels.update' => 50,
        'commentThreads.insert' => 50,
        'commentThreads.list' => 1,
        'comments.delete' => 50,
        'comments.insert' => 50,
        'comments.list' => 1,
        'comments.markAsSpam' => 50,
        'comments.setModerationStatus' => 50,
        'comments.update' => 50,
        'i18nLanguages.list' => 1,
        'i18nRegions.list' => 1,
        'liveBroadcasts.bind' => 50,
        'liveBroadcasts.delete' => 50,
        'liveBroadcasts.insert' => 50,
        'liveBroadcasts.insertCuepoint' => 50,
        'liveBroadcasts.list' => 1,
        'liveBroadcasts.transition' => 50,
        'liveBroadcasts.update' => 50,
        'liveChatBans.delete' => 50,
        'liveChatBans.insert' => 50,
        'liveChatMessages.delete' => 50,
        'liveChatMessages.insert' => 50,
        'liveChatMessages.list' => 1,
        'liveChatMessages.stream' => 1,
        'liveChatMessages.transition' => 50,
        'liveChatModerators.delete' => 50,
        'liveChatModerators.insert' => 50,
        'liveChatModerators.list' => 1,
        'liveStreams.delete' => 50,
        'liveStreams.insert' => 50,
        'liveStreams.list' => 1,
        'liveStreams.update' => 50,
        'members.list' => 2,
        'membershipsLevels.list' => 1,
        'playlistImages.delete' => 50,
        'playlistImages.insert' => 50,
        'playlistImages.list' => 1,
        'playlistImages.update' => 50,
        'playlistItems.delete' => 50,
        'playlistItems.insert' => 50,
        'playlistItems.list' => 1,
        'playlistItems.update' => 50,
        'playlists.delete' => 50,
        'playlists.insert' => 50,
        'playlists.list' => 1,
        'playlists.update' => 50,
        'search.list' => 1,
        'subscriptions.delete' => 50,
        'subscriptions.insert' => 50,
        'subscriptions.list' => 1,
        'superChatEvents.list' => 1,
        'tests.insert' => 50,
        'thirdPartyLinks.delete' => 50,
        'thirdPartyLinks.insert' => 50,
        'thirdPartyLinks.list' => 1,
        'thirdPartyLinks.update' => 50,
        'thumbnails.set' => 50,
        'videoAbuseReportReasons.list' => 1,
        'videoCategories.list' => 1,
        'videoTrainability.get' => 1,
        'videos.batchGetStats' => 1,
        'videos.delete' => 50,
        'videos.getRating' => 1,
        'videos.insert' => 1,
        'videos.list' => 1,
        'videos.rate' => 50,
        'videos.reportAbuse' => 50,
        'videos.update' => 50,
        'watermarks.set' => 50,
        'watermarks.unset' => 50,
    ];

    /** @var array<string, string> Method => its bucket, for the methods outside the default one. */
    public const BUCKETS = [
        'search.list' => 'search',
        'videos.insert' => 'uploads',
    ];

    /** @var array<string, int> Bucket => Google's default daily allowance. */
    public const DAILY = [
        'default' => 10000,
        'search' => 100,
        'uploads' => 100,
    ];

    /** @var list<string> Methods whose cost Google does not publish, and is estimated. */
    public const ESTIMATED = [
        'abuseReports.insert',
        'comments.markAsSpam',
        'liveChatMessages.stream',
        'members.list',
        'tests.insert',
        'thirdPartyLinks.delete',
        'thirdPartyLinks.insert',
        'thirdPartyLinks.list',
        'thirdPartyLinks.update',
        'videoTrainability.get',
    ];

    /** What one call to a method costs. A method this build does not know counts as a read. */
    public static function of(string $endpoint): int
    {
        return self::METHODS[$endpoint] ?? 1;
    }

    /** The bucket a method draws from. */
    public static function bucketOf(string $endpoint): string
    {
        return self::BUCKETS[$endpoint] ?? Meter::DEFAULT_BUCKET;
    }
}
