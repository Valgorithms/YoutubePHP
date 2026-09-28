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
 * A *liveChatModerator* resource represents a moderator for a YouTube live chat. A chat moderator has
 * the ability to ban/unban users from a chat, remove message, etc.
 *
 * @property string|null $etag Etag of this resource.
 * @property string|null $id The ID that YouTube assigns to uniquely identify the moderator.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#liveChatModerator".
 * @property \YouTube\Parts\LiveChatModeratorSnippet|null $snippet The snippet object contains basic details
 *     about the moderator.
 *
 * @link https://developers.google.com/youtube/v3/live/docs/liveChatModerators
 *
 * @since 1.0.0
 */
class LiveChatModerator extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'snippet' => 'LiveChatModeratorSnippet',
    ];
}
