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
use YouTube\Http\ResponseStream;

/**
 * This file is generated from spec/discovery.json (YouTube Data API v3, revision 20260924) by
 * tools/generate.php. Do not edit it by hand - run `composer spec:build` instead.
 *
 * Live chat: reading it, posting to it, and deleting from it.
 *
 * Reach it as `$youtube->liveChatMessages`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/live/docs/liveChatMessages
 *
 * @since 1.0.0
 */
final class LiveChatMessagesApi extends AbstractApi
{
    /**
     * Deletes a chat message.
     *
     * Costs 50 units of quota.
     *
     * @param string $id
     *
     * @return PromiseInterface<null>
     *
     * @link https://developers.google.com/youtube/v3/live/docs/liveChatMessages/delete
     *
     * @since 1.0.0
     */
    public function delete(
        string $id,
    ): PromiseInterface {
        return $this->call(
            'liveChatMessages.delete',
            'DELETE',
            'youtube/v3/liveChat/messages',
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
     * @param list<string>|string $part The *part* parameter serves two purposes. It identifies the
     *     properties that the write operation will set as well as the properties that the API response will
     *     include. Set the parameter value to snippet.
     * @param \YouTube\Parts\LiveChatMessage|array<string, mixed> $body The LiveChatMessage to send.
     *
     * @return PromiseInterface<\YouTube\Parts\LiveChatMessage>
     *
     * @link https://developers.google.com/youtube/v3/live/docs/liveChatMessages/insert
     *
     * @since 1.0.0
     */
    public function insert(
        array|string $part,
        array|\JsonSerializable $body,
    ): PromiseInterface {
        return $this->call(
            'liveChatMessages.insert',
            'POST',
            'youtube/v3/liveChat/messages',
            query: [
                'part' => $part,
            ],
            body: $body,
            returns: 'LiveChatMessage',
        );
    }

    /**
     * Retrieves a list of resources, possibly filtered.
     *
     * Costs 1 unit of quota.
     *
     * @param string $liveChatId The id of the live chat for which comments should be returned.
     * @param list<string>|string $part The *part* parameter specifies the liveChatComment resource parts
     *     that the API response will include. Supported values are id, snippet, and authorDetails.
     * @param string|null $hl Specifies the localization language in which the system messages should be
     *     returned.
     * @param int|null $maxResults The *maxResults* parameter specifies the maximum number of items that
     *     should be returned in the result set. Not used in the streaming RPC. From 200 to 2000. YouTube
     *     assumes `500` when it is left out.
     * @param string|null $pageToken The *pageToken* parameter identifies a specific page in the result set
     *     that should be returned. In an API response, the nextPageToken property identify other pages that
     *     could be retrieved.
     * @param int|null $profileImageSize Specifies the size of the profile image that should be returned
     *     for each user. From 16 to 720.
     *
     * @return PromiseInterface<\YouTube\Parts\LiveChatMessageListResponse>
     *
     * @link https://developers.google.com/youtube/v3/live/docs/liveChatMessages/list
     *
     * @since 1.0.0
     */
    public function list(
        string $liveChatId,
        array|string $part,
        ?string $hl = null,
        ?int $maxResults = null,
        ?string $pageToken = null,
        ?int $profileImageSize = null,
    ): PromiseInterface {
        return $this->call(
            'liveChatMessages.list',
            'GET',
            'youtube/v3/liveChat/messages',
            query: [
                'liveChatId' => $liveChatId,
                'part' => $part,
                'hl' => $hl,
                'maxResults' => $maxResults,
                'pageToken' => $pageToken,
                'profileImageSize' => $profileImageSize,
            ],
            returns: 'LiveChatMessageListResponse',
        );
    }

    /**
     * Allows a user to load live chat through a server-streamed RPC.
     *
     * Costs 1 unit of quota, by estimate: Google does not publish it, so each connection is counted as one
     * list call.
     *
     * The response keeps arriving for as long as the server has more to send, as a stream of
     * LiveChatMessageListResponse parts. The stream ends when the server closes it; open another with the
     * last `nextPageToken` to carry on.
     *
     * @param string $liveChatId The id of the live chat for which comments should be returned.
     * @param list<string>|string $part The *part* parameter specifies the liveChatComment resource parts
     *     that the API response will include. Supported values are id, snippet, and authorDetails.
     * @param string|null $hl Specifies the localization language in which the system messages should be
     *     returned.
     * @param int|null $maxResults The *maxResults* parameter specifies the maximum number of items that
     *     should be returned in the result set. Not used in the streaming RPC. From 200 to 2000. YouTube
     *     assumes `500` when it is left out.
     * @param string|null $pageToken The *pageToken* parameter identifies a specific page in the result set
     *     that should be returned. In an API response, the nextPageToken property identify other pages that
     *     could be retrieved.
     * @param int|null $profileImageSize Specifies the size of the profile image that should be returned
     *     for each user. From 16 to 720.
     *
     * @return PromiseInterface<ResponseStream>
     *
     * @link https://developers.google.com/youtube/v3/live/docs/liveChatMessages/streamList
     *
     * @since 1.0.0
     */
    public function stream(
        string $liveChatId,
        array|string $part,
        ?string $hl = null,
        ?int $maxResults = null,
        ?string $pageToken = null,
        ?int $profileImageSize = null,
    ): PromiseInterface {
        return $this->streamed(
            'liveChatMessages.stream',
            'youtube/v3/liveChat/messages/stream',
            [
                'liveChatId' => $liveChatId,
                'part' => $part,
                'hl' => $hl,
                'maxResults' => $maxResults,
                'pageToken' => $pageToken,
                'profileImageSize' => $profileImageSize,
            ],
            'LiveChatMessageListResponse',
        );
    }

    /**
     * Transition a durable chat event.
     *
     * Costs 50 units of quota.
     *
     * @param string|null $id The ID that uniquely identify the chat message event to transition.
     * @param string|null $status The status to which the chat event is going to transition. One of
     *     `statusUnspecified`, `closed`.
     *
     * @return PromiseInterface<\YouTube\Parts\LiveChatMessage>
     *
     * @link https://developers.google.com/youtube/v3/live/docs/liveChatMessages/transition
     *
     * @since 1.0.0
     */
    public function transition(
        ?string $id = null,
        ?string $status = null,
    ): PromiseInterface {
        return $this->call(
            'liveChatMessages.transition',
            'POST',
            'youtube/v3/liveChat/messages/transition',
            query: [
                'id' => $id,
                'status' => $status,
            ],
            returns: 'LiveChatMessage',
        );
    }
}
