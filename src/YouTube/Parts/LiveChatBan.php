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
 * A `__liveChatBan__` resource represents a ban for a YouTube live chat.
 *
 * @property string|null $etag Etag of this resource.
 * @property string|null $id The ID that YouTube assigns to uniquely identify the ban.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     `"youtube#liveChatBan"`.
 * @property \YouTube\Parts\LiveChatBanSnippet|null $snippet The `snippet` object contains basic details about
 *     the ban.
 *
 * @link https://developers.google.com/youtube/v3/live/docs/liveChatBans
 *
 * @since 1.0.0
 */
class LiveChatBan extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'snippet' => 'LiveChatBanSnippet',
    ];
}
