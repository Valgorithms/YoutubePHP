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
 * A channel's members, which the API also calls sponsors.
 *
 * Reach it as `$youtube->members`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/members
 *
 * @since 1.0.0
 */
final class MembersApi extends AbstractApi
{
    /**
     * Retrieves a list of members that match the request criteria for a channel.
     *
     * Costs 2 units of quota, by estimate: the quota calculator says 1 and the method's own page says 2.
     *
     * @param list<string>|string $part The *part* parameter specifies the member resource parts that the
     *     API response will include. Set the parameter value to snippet.
     * @param string|null $filterByMemberChannelId Comma separated list of channel IDs. Only data about
     *     members that are part of this list will be included in the response.
     * @param string|null $hasAccessToLevel Filter members in the results set to the ones that have access
     *     to a level.
     * @param int|null $maxResults The *maxResults* parameter specifies the maximum number of items that
     *     should be returned in the result set. From 0 to 1000. YouTube assumes `5` when it is left out.
     * @param string|null $mode Parameter that specifies which channel members to return. One of
     *     `listMembersModeUnknown`, `updates`, `all_current`. YouTube assumes `all_current` when it is left
     *     out.
     * @param string|null $pageToken The *pageToken* parameter identifies a specific page in the result set
     *     that should be returned. In an API response, the nextPageToken and prevPageToken properties identify
     *     other pages that could be retrieved.
     *
     * @return PromiseInterface<\YouTube\Parts\MemberListResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/members/list
     *
     * @since 1.0.0
     */
    public function list(
        array|string $part,
        ?string $filterByMemberChannelId = null,
        ?string $hasAccessToLevel = null,
        ?int $maxResults = null,
        ?string $mode = null,
        ?string $pageToken = null,
    ): PromiseInterface {
        return $this->call(
            'members.list',
            'GET',
            'youtube/v3/members',
            query: [
                'part' => $part,
                'filterByMemberChannelId' => $filterByMemberChannelId,
                'hasAccessToLevel' => $hasAccessToLevel,
                'maxResults' => $maxResults,
                'mode' => $mode,
                'pageToken' => $pageToken,
            ],
            returns: 'MemberListResponse',
        );
    }
}
