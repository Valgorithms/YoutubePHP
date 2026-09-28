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
 * What a channel has been doing: uploads, likes, playlist changes and the rest of its feed.
 *
 * Reach it as `$youtube->activities`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/activities
 *
 * @since 1.0.0
 */
final class ActivitiesApi extends AbstractApi
{
    /**
     * Retrieves a list of resources, possibly filtered.
     *
     * Costs 1 unit of quota.
     *
     * @param list<string>|string $part The *part* parameter specifies a comma-separated list of one or
     *     more activity resource properties that the API response will include. If the parameter identifies a
     *     property that contains child properties, the child properties will be included in the response. For
     *     example, in an activity resource, the snippet property contains other properties that identify the
     *     type of activity, a display title for the activity, and so forth. If you set *part=snippet*, the API
     *     response will also contain all of those nested properties.
     * @param string|null $channelId
     * @param bool|null $home Deprecated.
     * @param int|null $maxResults The *maxResults* parameter specifies the maximum number of items that
     *     should be returned in the result set. From 0 to 50. YouTube assumes `5` when it is left out.
     * @param bool|null $mine
     * @param string|null $pageToken The *pageToken* parameter identifies a specific page in the result set
     *     that should be returned. In an API response, the nextPageToken and prevPageToken properties identify
     *     other pages that could be retrieved.
     * @param \DateTimeInterface|string|null $publishedAfter
     * @param \DateTimeInterface|string|null $publishedBefore
     * @param string|null $regionCode
     *
     * @return PromiseInterface<\YouTube\Parts\ActivityListResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/activities/list
     *
     * @since 1.0.0
     */
    public function list(
        array|string $part,
        ?string $channelId = null,
        ?bool $home = null,
        ?int $maxResults = null,
        ?bool $mine = null,
        ?string $pageToken = null,
        \DateTimeInterface|string|null $publishedAfter = null,
        \DateTimeInterface|string|null $publishedBefore = null,
        ?string $regionCode = null,
    ): PromiseInterface {
        return $this->call(
            'activities.list',
            'GET',
            'youtube/v3/activities',
            query: [
                'part' => $part,
                'channelId' => $channelId,
                'home' => $home,
                'maxResults' => $maxResults,
                'mine' => $mine,
                'pageToken' => $pageToken,
                'publishedAfter' => $publishedAfter,
                'publishedBefore' => $publishedBefore,
                'regionCode' => $regionCode,
            ],
            returns: 'ActivityListResponse',
        );
    }
}
