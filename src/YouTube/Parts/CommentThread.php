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
 * A *comment thread* represents information that applies to a top level comment and all its replies.
 * It can also include the top level comment itself and some of the replies.
 *
 * @property string|null $etag Etag of this resource.
 * @property string|null $id The ID that YouTube uses to uniquely identify the comment thread.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#commentThread".
 * @property \YouTube\Parts\CommentThreadReplies|null $replies The replies object contains a limited number of
 *     replies (if any) to the top level comment found in the snippet.
 * @property \YouTube\Parts\CommentThreadSnippet|null $snippet The snippet object contains basic details about
 *     the comment thread and also the top level comment.
 *
 * @link https://developers.google.com/youtube/v3/docs/commentThreads
 *
 * @since 1.0.0
 */
class CommentThread extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'replies' => 'CommentThreadReplies',
        'snippet' => 'CommentThreadSnippet',
    ];
}
