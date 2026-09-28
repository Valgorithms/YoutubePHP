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

/**
 * This file is generated from spec/discovery.json (YouTube Data API v3, revision 20260924) by
 * tools/generate.php. Do not edit it by hand - run `composer spec:build` instead.
 *
 * Searching for videos, channels and playlists. It has its own quota: 100 calls a day.
 *
 * Reach it as `$youtube->search`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/search
 *
 * @since 1.0.0
 */
final class SearchApi extends AbstractApi
{
    /**
     * Retrieves a list of search resources
     *
     * Costs 1 of the search quota's 100 calls a day, not the shared daily quota.
     *
     * @param list<string>|string $part The *part* parameter specifies a comma-separated list of one or
     *     more search resource properties that the API response will include. Set the parameter value to
     *     snippet.
     * @param string|null $channelId Filter on resources belonging to this channelId. (Force TAP rebuild)
     * @param string|null $channelType Add a filter on the channel search. One of `channelTypeUnspecified`,
     *     `any`, `show`.
     * @param string|null $eventType Filter on the livestream status of the videos. One of `none`,
     *     `upcoming`, `live`, `completed`.
     * @param bool|null $forContentOwner Search owned by a content owner.
     * @param bool|null $forDeveloper Restrict the search to only retrieve videos uploaded using the
     *     project id of the authenticated user.
     * @param bool|null $forMine Search for the private videos of the authenticated user.
     * @param string|null $location Filter on location of the video
     * @param string|null $locationRadius Filter on distance from the location (specified above).
     * @param int|null $maxResults The *maxResults* parameter specifies the maximum number of items that
     *     should be returned in the result set. From 0 to 50. YouTube assumes `5` when it is left out.
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The CMS account that the user authenticates with must be linked to the
     *     specified YouTube content owner.
     * @param string|null $order Sort order of the results. One of `searchSortUnspecified`, `date`,
     *     `rating`, `viewCount`, `relevance`, `title`, `videoCount`. YouTube assumes `relevance` when it is
     *     left out.
     * @param string|null $pageToken The *pageToken* parameter identifies a specific page in the result set
     *     that should be returned. In an API response, the nextPageToken and prevPageToken properties identify
     *     other pages that could be retrieved.
     * @param \DateTimeInterface|string|null $publishedAfter Filter on resources published after this date.
     * @param \DateTimeInterface|string|null $publishedBefore Filter on resources published before this
     *     date.
     * @param string|null $q Textual search terms to match.
     * @param string|null $regionCode Display the content as seen by viewers in this country.
     * @param string|null $relevanceLanguage Return results relevant to this language.
     * @param string|null $safeSearch Indicates whether the search results should include restricted
     *     content as well as standard content. One of `safeSearchSettingUnspecified`, `none`, `moderate`,
     *     `strict`. YouTube assumes `moderate` when it is left out.
     * @param string|null $topicId Restrict results to a particular topic.
     * @param list<string>|string|null $type Restrict results to a particular set of resource types from
     *     One Platform.
     * @param string|null $videoCaption Filter on the presence of captions on the videos. One of
     *     `videoCaptionUnspecified`, `any`, `closedCaption`, `none`.
     * @param string|null $videoCategoryId Filter on videos in a specific category.
     * @param string|null $videoDefinition Filter on the definition of the videos. One of `any`,
     *     `standard`, `high`.
     * @param string|null $videoDimension Filter on 3d videos. One of `any`, `2d`, `3d`.
     * @param string|null $videoDuration Filter on the duration of the videos. One of
     *     `videoDurationUnspecified`, `any`, `short`, `medium`, `long`.
     * @param string|null $videoEmbeddable Filter on embeddable videos. One of
     *     `videoEmbeddableUnspecified`, `any`, `true`.
     * @param string|null $videoLicense Filter on the license of the videos. One of `any`, `youtube`,
     *     `creativeCommon`.
     * @param string|null $videoPaidProductPlacement One of `videoPaidProductPlacementUnspecified`, `any`,
     *     `true`.
     * @param string|null $videoSyndicated Filter on syndicated videos. One of
     *     `videoSyndicatedUnspecified`, `any`, `true`.
     * @param string|null $videoType Filter on videos of a specific type. One of `videoTypeUnspecified`,
     *     `any`, `movie`, `episode`.
     *
     * @return PromiseInterface<\YouTube\Parts\SearchListResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/search/list
     *
     * @since 1.0.0
     */
    public function list(
        array|string $part,
        ?string $channelId = null,
        ?string $channelType = null,
        ?string $eventType = null,
        ?bool $forContentOwner = null,
        ?bool $forDeveloper = null,
        ?bool $forMine = null,
        ?string $location = null,
        ?string $locationRadius = null,
        ?int $maxResults = null,
        ?string $onBehalfOfContentOwner = null,
        ?string $order = null,
        ?string $pageToken = null,
        \DateTimeInterface|string|null $publishedAfter = null,
        \DateTimeInterface|string|null $publishedBefore = null,
        ?string $q = null,
        ?string $regionCode = null,
        ?string $relevanceLanguage = null,
        ?string $safeSearch = null,
        ?string $topicId = null,
        array|string|null $type = null,
        ?string $videoCaption = null,
        ?string $videoCategoryId = null,
        ?string $videoDefinition = null,
        ?string $videoDimension = null,
        ?string $videoDuration = null,
        ?string $videoEmbeddable = null,
        ?string $videoLicense = null,
        ?string $videoPaidProductPlacement = null,
        ?string $videoSyndicated = null,
        ?string $videoType = null,
    ): PromiseInterface {
        return $this->call(
            'search.list',
            'GET',
            'youtube/v3/search',
            query: [
                'part' => $part,
                'channelId' => $channelId,
                'channelType' => $channelType,
                'eventType' => $eventType,
                'forContentOwner' => $forContentOwner,
                'forDeveloper' => $forDeveloper,
                'forMine' => $forMine,
                'location' => $location,
                'locationRadius' => $locationRadius,
                'maxResults' => $maxResults,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'order' => $order,
                'pageToken' => $pageToken,
                'publishedAfter' => $publishedAfter,
                'publishedBefore' => $publishedBefore,
                'q' => $q,
                'regionCode' => $regionCode,
                'relevanceLanguage' => $relevanceLanguage,
                'safeSearch' => $safeSearch,
                'topicId' => $topicId,
                'type' => $type,
                'videoCaption' => $videoCaption,
                'videoCategoryId' => $videoCategoryId,
                'videoDefinition' => $videoDefinition,
                'videoDimension' => $videoDimension,
                'videoDuration' => $videoDuration,
                'videoEmbeddable' => $videoEmbeddable,
                'videoLicense' => $videoLicense,
                'videoPaidProductPlacement' => $videoPaidProductPlacement,
                'videoSyndicated' => $videoSyndicated,
                'videoType' => $videoType,
            ],
            returns: 'SearchListResponse',
        );
    }
}
