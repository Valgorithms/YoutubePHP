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
 * The Super Chats and Super Stickers bought on the signed-in channel.
 *
 * Reach it as `$youtube->superChatEvents`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/live/docs/superChatEvents
 *
 * @since 1.0.0
 */
final class SuperChatEventsApi extends AbstractApi
{
    /**
     * Retrieves a list of resources, possibly filtered.
     *
     * Costs 1 unit of quota.
     *
     * @param list<string>|string $part The *part* parameter specifies the superChatEvent resource parts
     *     that the API response will include. This parameter is currently not supported.
     * @param string|null $hl Return rendered funding amounts in specified language.
     * @param int|null $maxResults The *maxResults* parameter specifies the maximum number of items that
     *     should be returned in the result set. From 1 to 50. YouTube assumes `5` when it is left out.
     * @param string|null $pageToken The *pageToken* parameter identifies a specific page in the result set
     *     that should be returned. In an API response, the nextPageToken and prevPageToken properties identify
     *     other pages that could be retrieved.
     *
     * @return PromiseInterface<\YouTube\Parts\SuperChatEventListResponse>
     *
     * @link https://developers.google.com/youtube/v3/live/docs/superChatEvents/list
     *
     * @since 1.0.0
     */
    public function list(
        array|string $part,
        ?string $hl = null,
        ?int $maxResults = null,
        ?string $pageToken = null,
    ): PromiseInterface {
        return $this->call(
            'superChatEvents.list',
            'GET',
            'youtube/v3/superChatEvents',
            query: [
                'part' => $part,
                'hl' => $hl,
                'maxResults' => $maxResults,
                'pageToken' => $pageToken,
            ],
            returns: 'SuperChatEventListResponse',
        );
    }
}
