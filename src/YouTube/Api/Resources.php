<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Api;

/**
 * This file is generated from spec/discovery.json (YouTube Data API v3, revision 20260924) by
 * tools/generate.php. Do not edit it by hand - run `composer spec:build` instead.
 *
 * One API object per resource, as properties of {@see \YouTube\YouTube}:
 * `$youtube->liveChatMessages->list(...)`.
 *
 * @since 1.0.0
 */
trait Resources
{
    /** Reports of abuse. */
    public readonly AbuseReportsApi $abuseReports;

    /** What a channel has been doing: uploads, likes, playlist changes and the rest of its feed. */
    public readonly ActivitiesApi $activities;

    /** The caption tracks of videos. */
    public readonly CaptionsApi $captions;

    /** Uploading a channel's banner image. */
    public readonly ChannelBannersApi $channelBanners;

    /** The shelves on a channel's page. */
    public readonly ChannelSectionsApi $channelSections;

    /** Channels, the signed-in account's own included. */
    public readonly ChannelsApi $channels;

    /** Top-level comments, with their replies. */
    public readonly CommentThreadsApi $commentThreads;

    /** Single comments and replies, and moderating them. */
    public readonly CommentsApi $comments;

    /** The interface languages YouTube supports. */
    public readonly I18nLanguagesApi $i18nLanguages;

    /** The content regions YouTube supports. */
    public readonly I18nRegionsApi $i18nRegions;

    /** Live broadcasts: scheduling one, binding it to a stream, going live and ending it. */
    public readonly LiveBroadcastsApi $liveBroadcasts;

    /** Banning people from a live chat, and lifting bans. */
    public readonly LiveChatBansApi $liveChatBans;

    /** Live chat: reading it, posting to it, and deleting from it. */
    public readonly LiveChatMessagesApi $liveChatMessages;

    /** A live chat's moderators. */
    public readonly LiveChatModeratorsApi $liveChatModerators;

    /** The video streams that live broadcasts are fed from. */
    public readonly LiveStreamsApi $liveStreams;

    /** A channel's members, which the API also calls sponsors. */
    public readonly MembersApi $members;

    /** A channel's membership levels. */
    public readonly MembershipsLevelsApi $membershipsLevels;

    /** Playlists' cover images. */
    public readonly PlaylistImagesApi $playlistImages;

    /** The videos in playlists. */
    public readonly PlaylistItemsApi $playlistItems;

    /** Playlists. */
    public readonly PlaylistsApi $playlists;

    /** Searching for videos, channels and playlists. It has its own quota: 100 calls a day. */
    public readonly SearchApi $search;

    /** Subscriptions between channels. */
    public readonly SubscriptionsApi $subscriptions;

    /** The Super Chats and Super Stickers bought on the signed-in channel. */
    public readonly SuperChatEventsApi $superChatEvents;

    /** An internal method Google uses to test the API. */
    public readonly TestsApi $tests;

    /** Links between a channel and third-party services. */
    public readonly ThirdPartyLinksApi $thirdPartyLinks;

    /** Setting a video's custom thumbnail. */
    public readonly ThumbnailsApi $thumbnails;

    /** The reasons a video can be reported for. */
    public readonly VideoAbuseReportReasonsApi $videoAbuseReportReasons;

    /** The categories a video can be filed under. */
    public readonly VideoCategoriesApi $videoCategories;

    /** Whether a video may be used to train AI models. */
    public readonly VideoTrainabilityApi $videoTrainability;

    /** Videos: listing, uploading, updating, rating and reporting them. */
    public readonly VideosApi $videos;

    /** A channel's watermark image. */
    public readonly WatermarksApi $watermarks;

    /** Builds every resource API against this client. */
    private function bootResources(): void
    {
        $this->abuseReports = new AbuseReportsApi($this);
        $this->activities = new ActivitiesApi($this);
        $this->captions = new CaptionsApi($this);
        $this->channelBanners = new ChannelBannersApi($this);
        $this->channelSections = new ChannelSectionsApi($this);
        $this->channels = new ChannelsApi($this);
        $this->commentThreads = new CommentThreadsApi($this);
        $this->comments = new CommentsApi($this);
        $this->i18nLanguages = new I18nLanguagesApi($this);
        $this->i18nRegions = new I18nRegionsApi($this);
        $this->liveBroadcasts = new LiveBroadcastsApi($this);
        $this->liveChatBans = new LiveChatBansApi($this);
        $this->liveChatMessages = new LiveChatMessagesApi($this);
        $this->liveChatModerators = new LiveChatModeratorsApi($this);
        $this->liveStreams = new LiveStreamsApi($this);
        $this->members = new MembersApi($this);
        $this->membershipsLevels = new MembershipsLevelsApi($this);
        $this->playlistImages = new PlaylistImagesApi($this);
        $this->playlistItems = new PlaylistItemsApi($this);
        $this->playlists = new PlaylistsApi($this);
        $this->search = new SearchApi($this);
        $this->subscriptions = new SubscriptionsApi($this);
        $this->superChatEvents = new SuperChatEventsApi($this);
        $this->tests = new TestsApi($this);
        $this->thirdPartyLinks = new ThirdPartyLinksApi($this);
        $this->thumbnails = new ThumbnailsApi($this);
        $this->videoAbuseReportReasons = new VideoAbuseReportReasonsApi($this);
        $this->videoCategories = new VideoCategoriesApi($this);
        $this->videoTrainability = new VideoTrainabilityApi($this);
        $this->videos = new VideosApi($this);
        $this->watermarks = new WatermarksApi($this);
    }
}
