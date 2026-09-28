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
 * Top-level comments, with their replies.
 *
 * Reach it as `$youtube->commentThreads`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/commentThreads
 *
 * @since 1.0.0
 */
final class CommentThreadsApi extends AbstractApi
{
    /**
     * Inserts a new resource into this collection.
     *
     * Costs 50 units of quota.
     *
     * @param list<string>|string $part The *part* parameter identifies the properties that the API
     *     response will include. Set the parameter value to snippet. The snippet part has a quota cost of 2
     *     units.
     * @param \YouTube\Parts\CommentThread|array<string, mixed> $body The CommentThread to send.
     *
     * @return PromiseInterface<\YouTube\Parts\CommentThread>
     *
     * @link https://developers.google.com/youtube/v3/docs/commentThreads/insert
     *
     * @since 1.0.0
     */
    public function insert(
        array|string $part,
        array|\JsonSerializable $body,
    ): PromiseInterface {
        return $this->call(
            'commentThreads.insert',
            'POST',
            'youtube/v3/commentThreads',
            query: [
                'part' => $part,
            ],
            body: $body,
            returns: 'CommentThread',
        );
    }

    /**
     * Retrieves a list of resources, possibly filtered.
     *
     * Costs 1 unit of quota.
     *
     * @param list<string>|string $part The *part* parameter specifies a comma-separated list of one or
     *     more commentThread resource properties that the API response will include.
     * @param string|null $allThreadsRelatedToChannelId Returns the comment threads of all videos of the
     *     channel and the channel comments as well.
     * @param string|null $channelId Returns the comment threads for all the channel comments (ie does not
     *     include comments left on videos).
     * @param list<string>|string|null $id Returns the comment threads with the given IDs for Stubby or
     *     Apiary.
     * @param int|null $maxResults The *maxResults* parameter specifies the maximum number of items that
     *     should be returned in the result set. From 1 to 100. YouTube assumes `20` when it is left out.
     * @param string|null $moderationStatus Limits the returned comment threads to those with the specified
     *     moderation status. Not compatible with the 'id' filter. Valid values: published, heldForReview,
     *     likelySpam. One of `published`, `heldForReview`, `likelySpam`, `rejected`. YouTube assumes
     *     `published` when it is left out.
     * @param string|null $order One of `orderUnspecified`, `time`, `relevance`. YouTube assumes `time`
     *     when it is left out.
     * @param string|null $pageToken The *pageToken* parameter identifies a specific page in the result set
     *     that should be returned. In an API response, the nextPageToken and prevPageToken properties identify
     *     other pages that could be retrieved.
     * @param string|null $searchTerms Limits the returned comment threads to those matching the specified
     *     key words. Not compatible with the 'id' filter.
     * @param string|null $textFormat The requested text format for the returned comments. One of
     *     `textFormatUnspecified`, `html`, `plainText`. YouTube assumes `html` when it is left out.
     * @param string|null $videoId Returns the comment threads of the specified video.
     *
     * @return PromiseInterface<\YouTube\Parts\CommentThreadListResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/commentThreads/list
     *
     * @since 1.0.0
     */
    public function list(
        array|string $part,
        ?string $allThreadsRelatedToChannelId = null,
        ?string $channelId = null,
        array|string|null $id = null,
        ?int $maxResults = null,
        ?string $moderationStatus = null,
        ?string $order = null,
        ?string $pageToken = null,
        ?string $searchTerms = null,
        ?string $textFormat = null,
        ?string $videoId = null,
    ): PromiseInterface {
        return $this->call(
            'commentThreads.list',
            'GET',
            'youtube/v3/commentThreads',
            query: [
                'part' => $part,
                'allThreadsRelatedToChannelId' => $allThreadsRelatedToChannelId,
                'channelId' => $channelId,
                'id' => $id,
                'maxResults' => $maxResults,
                'moderationStatus' => $moderationStatus,
                'order' => $order,
                'pageToken' => $pageToken,
                'searchTerms' => $searchTerms,
                'textFormat' => $textFormat,
                'videoId' => $videoId,
            ],
            returns: 'CommentThreadListResponse',
        );
    }
}
