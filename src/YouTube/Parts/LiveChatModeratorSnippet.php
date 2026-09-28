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
 * @property string|null $liveChatId The ID of the live chat this moderator can act on.
 * @property \YouTube\Parts\ChannelProfileDetails|null $moderatorDetails Details about the moderator.
 *
 * @since 1.0.0
 */
class LiveChatModeratorSnippet extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'moderatorDetails' => 'ChannelProfileDetails',
    ];
}
