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

use React\Promise\PromiseInterface;
use YouTube\Http\Media;

/**
 * This file is generated from spec/discovery.json (YouTube Data API v3, revision 20260924) by
 * tools/generate.php. Do not edit it by hand - run `composer spec:build` instead.
 *
 * Videos: listing, uploading, updating, rating and reporting them.
 *
 * Reach it as `$youtube->videos`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/videos
 *
 * @since 1.0.0
 */
final class VideosApi extends AbstractApi
{
    /**
     * Retrieves a batch of VideoStat resources, possibly filtered. BatchGetStats is intentionally not
     * atomic to provide a better user experience.
     *
     * Costs 1 unit of quota.
     *
     * @param list<string>|string|null $id Required. Return videos with the given ids. The number of IDs
     *     specified cannot exceed 50.
     * @param string|null $onBehalfOfContentOwner Optional. **Note:** This parameter is intended
     *     exclusively for YouTube content partners. The `onBehalfOfContentOwner` parameter indicates that the
     *     request's authorization credentials identify a YouTube CMS user who is acting on behalf of the
     *     content owner specified in the parameter value. This parameter is intended for YouTube content
     *     partners that own and manage many different YouTube channels. It allows content owners to
     *     authenticate once and get access to all their video and channel data, without having to provide
     *     authentication credentials for each individual channel. The CMS account that the user authenticates
     *     with must be linked to the specified YouTube content owner.
     * @param list<string>|string|null $part Required. The `**part**` parameter specifies a comma-separated
     *     list of one or more `videoStat` resource properties that the API response will include. If the
     *     parameter identifies a property that contains child properties, the child properties will be
     *     included in the response. For example, in a `videoStat` resource, the `statistics` property contains
     *     `view_count` and `like_count`. As such, if you set `**part=snippet**`, the API response will contain
     *     all of those properties.
     *
     * @return PromiseInterface<\YouTube\Parts\BatchGetStatsResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/videos/batchGetStats
     *
     * @since 1.0.0
     */
    public function batchGetStats(
        array|string|null $id = null,
        ?string $onBehalfOfContentOwner = null,
        array|string|null $part = null,
    ): PromiseInterface {
        return $this->call(
            'videos.batchGetStats',
            'GET',
            'youtube/v3/videos:batchGetStats',
            query: [
                'id' => $id,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'part' => $part,
            ],
            returns: 'BatchGetStatsResponse',
        );
    }

    /**
     * Deletes a resource.
     *
     * Costs 50 units of quota.
     *
     * @param string $id
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The actual CMS account that the user authenticates with must be linked to
     *     the specified YouTube content owner.
     *
     * @return PromiseInterface<null>
     *
     * @link https://developers.google.com/youtube/v3/docs/videos/delete
     *
     * @since 1.0.0
     */
    public function delete(
        string $id,
        ?string $onBehalfOfContentOwner = null,
    ): PromiseInterface {
        return $this->call(
            'videos.delete',
            'DELETE',
            'youtube/v3/videos',
            query: [
                'id' => $id,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
            ],
        );
    }

    /**
     * Retrieves the ratings that the authorized user gave to a list of specified videos.
     *
     * Costs 1 unit of quota.
     *
     * @param list<string>|string $id
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The CMS account that the user authenticates with must be linked to the
     *     specified YouTube content owner.
     *
     * @return PromiseInterface<\YouTube\Parts\VideoGetRatingResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/videos/getRating
     *
     * @since 1.0.0
     */
    public function getRating(
        array|string $id,
        ?string $onBehalfOfContentOwner = null,
    ): PromiseInterface {
        return $this->call(
            'videos.getRating',
            'GET',
            'youtube/v3/videos/getRating',
            query: [
                'id' => $id,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
            ],
            returns: 'VideoGetRatingResponse',
        );
    }

    /**
     * Inserts a new resource into this collection.
     *
     * Costs 1 of the uploads quota's 100 calls a day, not the shared daily quota.
     *
     * @param list<string>|string $part The *part* parameter serves two purposes in this operation. It
     *     identifies the properties that the write operation will set as well as the properties that the API
     *     response will include. Note that not all parts contain properties that can be set when inserting or
     *     updating a video. For example, the statistics object encapsulates statistics that YouTube calculates
     *     for a video and does not contain values that you can set or modify. If the parameter value specifies
     *     a part that does not contain mutable values, that part will still be included in the API response.
     * @param \YouTube\Parts\Video|array<string, mixed> $body The Video to send.
     * @param Media|null $media The file to upload: video/*, application/octet-stream, up to 256 GB. Sent
     *     in the same request as the metadata.
     * @param bool|null $autoLevels Should auto-levels be applied to the upload.
     * @param bool|null $notifySubscribers Notify the channel subscribers about the new video. As default,
     *     the notification is enabled. YouTube assumes `true` when it is left out.
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The CMS account that the user authenticates with must be linked to the
     *     specified YouTube content owner.
     * @param string|null $onBehalfOfContentOwnerChannel This parameter can only be used in a properly
     *     authorized request. *Note:* This parameter is intended exclusively for YouTube content partners. The
     *     *onBehalfOfContentOwnerChannel* parameter specifies the YouTube channel ID of the channel to which a
     *     video is being added. This parameter is required when a request specifies a value for the
     *     onBehalfOfContentOwner parameter, and it can only be used in conjunction with that parameter. In
     *     addition, the request must be authorized using a CMS account that is linked to the content owner
     *     that the onBehalfOfContentOwner parameter specifies. Finally, the channel that the
     *     onBehalfOfContentOwnerChannel parameter value specifies must be linked to the content owner that the
     *     onBehalfOfContentOwner parameter specifies. This parameter is intended for YouTube content partners
     *     that own and manage many different YouTube channels. It allows content owners to authenticate once
     *     and perform actions on behalf of the channel specified in the parameter value, without having to
     *     provide authentication credentials for each separate channel.
     * @param bool|null $stabilize Should stabilize be applied to the upload.
     *
     * @return PromiseInterface<\YouTube\Parts\Video>
     *
     * @link https://developers.google.com/youtube/v3/docs/videos/insert
     *
     * @since 1.0.0
     */
    public function insert(
        array|string $part,
        array|\JsonSerializable $body,
        ?Media $media = null,
        ?bool $autoLevels = null,
        ?bool $notifySubscribers = null,
        ?string $onBehalfOfContentOwner = null,
        ?string $onBehalfOfContentOwnerChannel = null,
        ?bool $stabilize = null,
    ): PromiseInterface {
        return $this->call(
            'videos.insert',
            'POST',
            'youtube/v3/videos',
            query: [
                'part' => $part,
                'autoLevels' => $autoLevels,
                'notifySubscribers' => $notifySubscribers,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'onBehalfOfContentOwnerChannel' => $onBehalfOfContentOwnerChannel,
                'stabilize' => $stabilize,
            ],
            body: $body,
            returns: 'Video',
            media: $media,
            uploadPath: '/upload/youtube/v3/videos',
        );
    }

    /**
     * Retrieves a list of resources, possibly filtered.
     *
     * Costs 1 unit of quota.
     *
     * @param list<string>|string $part The *part* parameter specifies a comma-separated list of one or
     *     more video resource properties that the API response will include. If the parameter identifies a
     *     property that contains child properties, the child properties will be included in the response. For
     *     example, in a video resource, the snippet property contains the channelId, title, description, tags,
     *     and categoryId properties. As such, if you set *part=snippet*, the API response will contain all of
     *     those properties.
     * @param string|null $chart Return the videos that are in the specified chart. One of
     *     `chartUnspecified`, `mostPopular`.
     * @param string|null $hl Stands for "host language". Specifies the localization language of the
     *     metadata to be filled into snippet.localized. The field is filled with the default metadata if there
     *     is no localization in the specified language. The parameter value must be a language code included
     *     in the list returned by the i18nLanguages.list method (e.g. en_US, es_MX).
     * @param list<string>|string|null $id Return videos with the given ids.
     * @param string|null $locale Deprecated.
     * @param int|null $maxHeight From 72 to 8192.
     * @param int|null $maxResults The *maxResults* parameter specifies the maximum number of items that
     *     should be returned in the result set. *Note:* This parameter is supported for use in conjunction
     *     with the myRating and chart parameters, but it is not supported for use in conjunction with the id
     *     parameter. From 1 to 50. YouTube assumes `5` when it is left out.
     * @param int|null $maxWidth Return the player with maximum height specified in From 72 to 8192.
     * @param string|null $myRating Return videos liked/disliked by the authenticated user. Does not
     *     support RateType.RATED_TYPE_NONE. One of `none`, `like`, `dislike`.
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The CMS account that the user authenticates with must be linked to the
     *     specified YouTube content owner.
     * @param string|null $pageToken The *pageToken* parameter identifies a specific page in the result set
     *     that should be returned. In an API response, the nextPageToken and prevPageToken properties identify
     *     other pages that could be retrieved. *Note:* This parameter is supported for use in conjunction with
     *     the myRating and chart parameters, but it is not supported for use in conjunction with the id
     *     parameter.
     * @param string|null $regionCode Use a chart that is specific to the specified region
     * @param string|null $videoCategoryId Use chart that is specific to the specified video category
     *     YouTube assumes `0` when it is left out.
     *
     * @return PromiseInterface<\YouTube\Parts\VideoListResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/videos/list
     *
     * @since 1.0.0
     */
    public function list(
        array|string $part,
        ?string $chart = null,
        ?string $hl = null,
        array|string|null $id = null,
        ?string $locale = null,
        ?int $maxHeight = null,
        ?int $maxResults = null,
        ?int $maxWidth = null,
        ?string $myRating = null,
        ?string $onBehalfOfContentOwner = null,
        ?string $pageToken = null,
        ?string $regionCode = null,
        ?string $videoCategoryId = null,
    ): PromiseInterface {
        return $this->call(
            'videos.list',
            'GET',
            'youtube/v3/videos',
            query: [
                'part' => $part,
                'chart' => $chart,
                'hl' => $hl,
                'id' => $id,
                'locale' => $locale,
                'maxHeight' => $maxHeight,
                'maxResults' => $maxResults,
                'maxWidth' => $maxWidth,
                'myRating' => $myRating,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'pageToken' => $pageToken,
                'regionCode' => $regionCode,
                'videoCategoryId' => $videoCategoryId,
            ],
            returns: 'VideoListResponse',
        );
    }

    /**
     * Adds a like or dislike rating to a video or removes a rating from a video.
     *
     * Costs 50 units of quota.
     *
     * @param string $id
     * @param string $rating One of `none`, `like`, `dislike`.
     *
     * @return PromiseInterface<null>
     *
     * @link https://developers.google.com/youtube/v3/docs/videos/rate
     *
     * @since 1.0.0
     */
    public function rate(
        string $id,
        string $rating,
    ): PromiseInterface {
        return $this->call(
            'videos.rate',
            'POST',
            'youtube/v3/videos/rate',
            query: [
                'id' => $id,
                'rating' => $rating,
            ],
        );
    }

    /**
     * Report abuse for a video.
     *
     * Costs 50 units of quota.
     *
     * @param \YouTube\Parts\VideoAbuseReport|array<string, mixed> $body The VideoAbuseReport to send.
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The CMS account that the user authenticates with must be linked to the
     *     specified YouTube content owner.
     *
     * @return PromiseInterface<null>
     *
     * @link https://developers.google.com/youtube/v3/docs/videos/reportAbuse
     *
     * @since 1.0.0
     */
    public function reportAbuse(
        array|\JsonSerializable $body,
        ?string $onBehalfOfContentOwner = null,
    ): PromiseInterface {
        return $this->call(
            'videos.reportAbuse',
            'POST',
            'youtube/v3/videos/reportAbuse',
            query: [
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
            ],
            body: $body,
        );
    }

    /**
     * Updates an existing resource.
     *
     * Costs 50 units of quota.
     *
     * @param list<string>|string $part The *part* parameter serves two purposes in this operation. It
     *     identifies the properties that the write operation will set as well as the properties that the API
     *     response will include. Note that this method will override the existing values for all of the
     *     mutable properties that are contained in any parts that the parameter value specifies. For example,
     *     a video's privacy setting is contained in the status part. As such, if your request is updating a
     *     private video, and the request's part parameter value includes the status part, the video's privacy
     *     setting will be updated to whatever value the request body specifies. If the request body does not
     *     specify a value, the existing privacy setting will be removed and the video will revert to the
     *     default privacy setting. In addition, not all parts contain properties that can be set when
     *     inserting or updating a video. For example, the statistics object encapsulates statistics that
     *     YouTube calculates for a video and does not contain values that you can set or modify. If the
     *     parameter value specifies a part that does not contain mutable values, that part will still be
     *     included in the API response.
     * @param \YouTube\Parts\Video|array<string, mixed> $body The Video to send.
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The actual CMS account that the user authenticates with must be linked to
     *     the specified YouTube content owner.
     *
     * @return PromiseInterface<\YouTube\Parts\Video>
     *
     * @link https://developers.google.com/youtube/v3/docs/videos/update
     *
     * @since 1.0.0
     */
    public function update(
        array|string $part,
        array|\JsonSerializable $body,
        ?string $onBehalfOfContentOwner = null,
    ): PromiseInterface {
        return $this->call(
            'videos.update',
            'PUT',
            'youtube/v3/videos',
            query: [
                'part' => $part,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
            ],
            body: $body,
            returns: 'Video',
        );
    }
}
