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
 * @property string|null $banDurationSeconds The duration of a ban, only filled if the ban has type TEMPORARY. A
 *     64-bit number, as a string.
 * @property \YouTube\Parts\ChannelProfileDetails|null $bannedUserDetails
 * @property string|null $liveChatId The chat this ban is pertinent to.
 * @property string|null $type The type of ban. One of the `TYPE_*` constants.
 *
 * @since 1.0.0
 */
class LiveChatBanSnippet extends Part
{
    /** An invalid ban type. */
    public const TYPE_LIVE_CHAT_BAN_TYPE_UNSPECIFIED = 'liveChatBanTypeUnspecified';

    /** A permanent ban. */
    public const TYPE_PERMANENT = 'permanent';

    /** A temporary ban. */
    public const TYPE_TEMPORARY = 'temporary';

    /** @var array<string, string> */
    protected array $casts = [
        'bannedUserDetails' => 'ChannelProfileDetails',
    ];
}
