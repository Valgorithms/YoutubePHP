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
 * A live chat's moderators.
 *
 * Reach it as `$youtube->liveChatModerators`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/live/docs/liveChatModerators
 *
 * @since 1.0.0
 */
final class LiveChatModeratorsApi extends AbstractApi
{
    /**
     * Deletes a chat moderator.
     *
     * Costs 50 units of quota.
     *
     * @param string $id
     *
     * @return PromiseInterface<null>
     *
     * @link https://developers.google.com/youtube/v3/live/docs/liveChatModerators/delete
     *
     * @since 1.0.0
     */
    public function delete(
        string $id,
    ): PromiseInterface {
        return $this->call(
            'liveChatModerators.delete',
            'DELETE',
            'youtube/v3/liveChat/moderators',
            query: [
                'id' => $id,
            ],
        );
    }

    /**
     * Inserts a new resource into this collection.
     *
     * Costs 50 units of quota.
     *
     * @param list<string>|string $part The *part* parameter serves two purposes in this operation. It
     *     identifies the properties that the write operation will set as well as the properties that the API
     *     response returns. Set the parameter value to snippet.
     * @param \YouTube\Parts\LiveChatModerator|array<string, mixed> $body The LiveChatModerator to send.
     *
     * @return PromiseInterface<\YouTube\Parts\LiveChatModerator>
     *
     * @link https://developers.google.com/youtube/v3/live/docs/liveChatModerators/insert
     *
     * @since 1.0.0
     */
    public function insert(
        array|string $part,
        array|\JsonSerializable $body,
    ): PromiseInterface {
        return $this->call(
            'liveChatModerators.insert',
            'POST',
            'youtube/v3/liveChat/moderators',
            query: [
                'part' => $part,
            ],
            body: $body,
            returns: 'LiveChatModerator',
        );
    }

    /**
     * Retrieves a list of resources, possibly filtered.
     *
     * Costs 1 unit of quota.
     *
     * @param string $liveChatId The id of the live chat for which moderators should be returned.
     * @param list<string>|string $part The *part* parameter specifies the liveChatModerator resource parts
     *     that the API response will include. Supported values are id and snippet.
     * @param int|null $maxResults The *maxResults* parameter specifies the maximum number of items that
     *     should be returned in the result set. From 0 to 50. YouTube assumes `5` when it is left out.
     * @param string|null $pageToken The *pageToken* parameter identifies a specific page in the result set
     *     that should be returned. In an API response, the nextPageToken and prevPageToken properties identify
     *     other pages that could be retrieved.
     *
     * @return PromiseInterface<\YouTube\Parts\LiveChatModeratorListResponse>
     *
     * @link https://developers.google.com/youtube/v3/live/docs/liveChatModerators/list
     *
     * @since 1.0.0
     */
    public function list(
        string $liveChatId,
        array|string $part,
        ?int $maxResults = null,
        ?string $pageToken = null,
    ): PromiseInterface {
        return $this->call(
            'liveChatModerators.list',
            'GET',
            'youtube/v3/liveChat/moderators',
            query: [
                'liveChatId' => $liveChatId,
                'part' => $part,
                'maxResults' => $maxResults,
                'pageToken' => $pageToken,
            ],
            returns: 'LiveChatModeratorListResponse',
        );
    }
}
