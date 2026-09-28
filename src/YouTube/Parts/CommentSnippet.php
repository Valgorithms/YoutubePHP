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
 * Basic details about a comment, such as its author and text.
 *
 * @property \YouTube\Parts\CommentSnippetAuthorChannelId|null $authorChannelId
 * @property string|null $authorChannelUrl Link to the author's YouTube channel, if any.
 * @property string|null $authorDisplayName The name of the user who posted the comment.
 * @property string|null $authorProfileImageUrl The URL for the avatar of the user who posted the comment.
 * @property bool|null $canRate Whether the current viewer can rate this comment.
 * @property string|null $channelId The id of the corresponding YouTube channel. In case of a channel comment
 *     this is the channel the comment refers to. In case of a video or post comment it's the video/post's channel.
 * @property int|null $likeCount The total number of likes this comment has received.
 * @property string|null $moderationStatus The comment's moderation status. Will not be set if the comments were
 *     requested through the id filter. One of the `MODERATION_STATUS_*` constants.
 * @property string|null $parentId The unique id of the top-level comment, only set for replies.
 * @property \Carbon\CarbonImmutable|null $publishedAt The date and time when the comment was originally
 *     published.
 * @property string|null $textDisplay The comment's text. The format is either plain text or HTML dependent on
 *     what has been requested. Even the plain text representation may differ from the text originally posted in that
 *     it may replace video links with video titles etc.
 * @property string|null $textOriginal The comment's original raw text as initially posted or last updated. The
 *     original text will only be returned if it is accessible to the viewer, which is only guaranteed if the viewer
 *     is the comment's author.
 * @property \Carbon\CarbonImmutable|null $updatedAt The date and time when the comment was last updated.
 * @property string|null $videoId The ID of the video the comment refers to, if any.
 * @property string|null $viewerRating The rating the viewer has given to this comment. For the time being this
 *     will never return RATE_TYPE_DISLIKE and instead return RATE_TYPE_NONE. This may change in the future. One of
 *     the `VIEWER_RATING_*` constants.
 *
 * @since 1.0.0
 */
class CommentSnippet extends Part
{
    /** The comment is available for public display. */
    public const MODERATION_STATUS_PUBLISHED = 'published';

    /** The comment is awaiting review by a moderator. */
    public const MODERATION_STATUS_HELD_FOR_REVIEW = 'heldForReview';

    /** A `moderationStatus` of `likelySpam`. */
    public const MODERATION_STATUS_LIKELY_SPAM = 'likelySpam';

    /** The comment is unfit for display. */
    public const MODERATION_STATUS_REJECTED = 'rejected';

    /** The entity has not been rated. */
    public const VIEWER_RATING_NONE = 'none';

    /** The entity is liked. */
    public const VIEWER_RATING_LIKE = 'like';

    /** The entity is disliked. */
    public const VIEWER_RATING_DISLIKE = 'dislike';

    /** @var array<string, string> */
    protected array $casts = [
        'authorChannelId' => 'CommentSnippetAuthorChannelId',
    ];

    /** @var list<string> */
    protected array $dates = [
        'publishedAt',
        'updatedAt',
    ];
}
