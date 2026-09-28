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
 * Basic details about a video, including title, description, uploader, thumbnails and category.
 *
 * @property string|null $categoryId The YouTube video category associated with the video.
 * @property string|null $channelId The ID that YouTube uses to uniquely identify the channel that the video was
 *     uploaded to.
 * @property string|null $channelTitle Channel title for the channel that the video belongs to.
 * @property string|null $defaultAudioLanguage The default_audio_language property specifies the language spoken
 *     in the video's default audio track.
 * @property string|null $defaultLanguage The language of the videos's default snippet.
 * @property string|null $description The video's description. `@mutable` youtube.videos.insert
 *     youtube.videos.update
 * @property string|null $liveBroadcastContent Indicates if the video is an upcoming/active live broadcast. Or
 *     it's "none" if the video is not an upcoming/active live broadcast. One of the `LIVE_BROADCAST_CONTENT_*`
 *     constants.
 * @property \YouTube\Parts\VideoLocalization|null $localized Localized snippet selected with the hl parameter.
 *     If no such localization exists, this field is populated with the default snippet. (Read-only)
 * @property \Carbon\CarbonImmutable|null $publishedAt The date and time when the video was uploaded.
 * @property list<string>|null $tags A list of keyword tags associated with the video. Tags may contain spaces.
 * @property \YouTube\Parts\ThumbnailDetails|null $thumbnails A map of thumbnail images associated with the
 *     video. For each object in the map, the key is the name of the thumbnail image, and the value is an object that
 *     contains other information about the thumbnail.
 * @property string|null $title The video's title. `@mutable` youtube.videos.insert youtube.videos.update
 *
 * @since 1.0.0
 */
class VideoSnippet extends Part
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
        'localized' => 'VideoLocalization',
        'thumbnails' => 'ThumbnailDetails',
    ];

    /** @var list<string> */
    protected array $dates = [
        'publishedAt',
    ];
}
