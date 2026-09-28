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
 * Basic details about a comment thread.
 *
 * @property bool|null $canReply Whether the current viewer of the thread can reply to it. This is viewer
 *     specific - other viewers may see a different value for this field.
 * @property string|null $channelId The YouTube channel the comments in the thread refer to or the channel with
 *     the video the comments refer to. If neither video_id nor post_id is set the comments refer to the channel
 *     itself.
 * @property bool|null $isPublic Whether the thread (and therefore all its comments) is visible to all YouTube
 *     users.
 * @property \YouTube\Parts\Comment|null $topLevelComment The top level comment of this thread.
 * @property int|null $totalReplyCount The total number of replies (not including the top level comment).
 * @property string|null $videoId The ID of the video the comments refer to, if any.
 *
 * @since 1.0.0
 */
class CommentThreadSnippet extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'topLevelComment' => 'Comment',
    ];
}
