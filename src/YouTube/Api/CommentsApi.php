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
 * Single comments and replies, and moderating them.
 *
 * Reach it as `$youtube->comments`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/comments
 *
 * @since 1.0.0
 */
final class CommentsApi extends AbstractApi
{
    /**
     * Deletes a resource.
     *
     * Costs 50 units of quota.
     *
     * @param string $id
     *
     * @return PromiseInterface<null>
     *
     * @link https://developers.google.com/youtube/v3/docs/comments/delete
     *
     * @since 1.0.0
     */
    public function delete(
        string $id,
    ): PromiseInterface {
        return $this->call(
            'comments.delete',
            'DELETE',
            'youtube/v3/comments',
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
     * @param list<string>|string $part The *part* parameter identifies the properties that the API
     *     response will include. Set the parameter value to snippet. The snippet part has a quota cost of 2
     *     units.
     * @param \YouTube\Parts\Comment|array<string, mixed> $body The Comment to send.
     *
     * @return PromiseInterface<\YouTube\Parts\Comment>
     *
     * @link https://developers.google.com/youtube/v3/docs/comments/insert
     *
     * @since 1.0.0
     */
    public function insert(
        array|string $part,
        array|\JsonSerializable $body,
    ): PromiseInterface {
        return $this->call(
            'comments.insert',
            'POST',
            'youtube/v3/comments',
            query: [
                'part' => $part,
            ],
            body: $body,
            returns: 'Comment',
        );
    }

    /**
     * Retrieves a list of resources, possibly filtered.
     *
     * Costs 1 unit of quota.
     *
     * @param list<string>|string $part The *part* parameter specifies a comma-separated list of one or
     *     more comment resource properties that the API response will include.
     * @param list<string>|string|null $id Returns the comments with the given IDs for One Platform.
     * @param int|null $maxResults The *maxResults* parameter specifies the maximum number of items that
     *     should be returned in the result set. From 1 to 100. YouTube assumes `20` when it is left out.
     * @param string|null $pageToken The *pageToken* parameter identifies a specific page in the result set
     *     that should be returned. In an API response, the nextPageToken and prevPageToken properties identify
     *     other pages that could be retrieved.
     * @param string|null $parentId Returns replies to the specified comment. Note, currently YouTube
     *     features only one level of replies (ie replies to top level comments). However replies to replies
     *     may be supported in the future.
     * @param string|null $textFormat The requested text format for the returned comments. One of
     *     `textFormatUnspecified`, `html`, `plainText`. YouTube assumes `html` when it is left out.
     *
     * @return PromiseInterface<\YouTube\Parts\CommentListResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/comments/list
     *
     * @since 1.0.0
     */
    public function list(
        array|string $part,
        array|string|null $id = null,
        ?int $maxResults = null,
        ?string $pageToken = null,
        ?string $parentId = null,
        ?string $textFormat = null,
    ): PromiseInterface {
        return $this->call(
            'comments.list',
            'GET',
            'youtube/v3/comments',
            query: [
                'part' => $part,
                'id' => $id,
                'maxResults' => $maxResults,
                'pageToken' => $pageToken,
                'parentId' => $parentId,
                'textFormat' => $textFormat,
            ],
            returns: 'CommentListResponse',
        );
    }

    /**
     * Expresses the caller's opinion that one or more comments should be flagged as spam.
     *
     * Costs 50 units of quota, by estimate: Google does not publish it, so it is counted as a write.
     *
     * @param list<string>|string $id Flags the comments with the given IDs as spam in the caller's
     *     opinion.
     *
     * @return PromiseInterface<null>
     *
     * @link https://developers.google.com/youtube/v3/docs/comments/markAsSpam
     *
     * @since 1.0.0
     */
    public function markAsSpam(
        array|string $id,
    ): PromiseInterface {
        return $this->call(
            'comments.markAsSpam',
            'POST',
            'youtube/v3/comments/markAsSpam',
            query: [
                'id' => $id,
            ],
        );
    }

    /**
     * Sets the moderation status of one or more comments.
     *
     * Costs 50 units of quota.
     *
     * @param list<string>|string $id Modifies the moderation status of the comments with the given IDs
     * @param string $moderationStatus Specifies the requested moderation status. Note, comments can be in
     *     statuses, which are not available through this call. For example, this call does not allow to mark a
     *     comment as 'likely spam'. Valid values: 'heldForReview', 'published' or 'rejected'. One of
     *     `published`, `heldForReview`, `likelySpam`, `rejected`.
     * @param bool|null $banAuthor If set to true the author of the comment gets added to the ban list.
     *     This means all future comments of the author will autmomatically be rejected. Only valid in
     *     combination with STATUS_REJECTED. YouTube assumes `false` when it is left out.
     *
     * @return PromiseInterface<null>
     *
     * @link https://developers.google.com/youtube/v3/docs/comments/setModerationStatus
     *
     * @since 1.0.0
     */
    public function setModerationStatus(
        array|string $id,
        string $moderationStatus,
        ?bool $banAuthor = null,
    ): PromiseInterface {
        return $this->call(
            'comments.setModerationStatus',
            'POST',
            'youtube/v3/comments/setModerationStatus',
            query: [
                'id' => $id,
                'moderationStatus' => $moderationStatus,
                'banAuthor' => $banAuthor,
            ],
        );
    }

    /**
     * Updates an existing resource.
     *
     * Costs 50 units of quota.
     *
     * @param list<string>|string $part The *part* parameter identifies the properties that the API
     *     response will include. You must at least include the snippet part in the parameter value since that
     *     part contains all of the properties that the API request can update.
     * @param \YouTube\Parts\Comment|array<string, mixed> $body The Comment to send.
     *
     * @return PromiseInterface<\YouTube\Parts\Comment>
     *
     * @link https://developers.google.com/youtube/v3/docs/comments/update
     *
     * @since 1.0.0
     */
    public function update(
        array|string $part,
        array|\JsonSerializable $body,
    ): PromiseInterface {
        return $this->call(
            'comments.update',
            'PUT',
            'youtube/v3/comments',
            query: [
                'part' => $part,
            ],
            body: $body,
            returns: 'Comment',
        );
    }
}
