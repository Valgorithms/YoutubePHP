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
 * Comments written in (direct or indirect) reply to the top level comment.
 *
 * @property \Discord\Helpers\Collection<\YouTube\Parts\Comment>|null $comments A limited number of replies.
 *     Unless the number of replies returned equals total_reply_count in the snippet the returned replies are only a
 *     subset of the total number of replies.
 *
 * @since 1.0.0
 */
class CommentThreadReplies extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'comments' => 'Array of Comment',
    ];
}
