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
 * @property string|null $banDurationSeconds The duration of the ban. This property is only present if the
 *     banType is temporary. A 64-bit number, as a string.
 * @property string|null $banType The type of ban. One of the `BAN_TYPE_*` constants.
 * @property \YouTube\Parts\ChannelProfileDetails|null $bannedUserDetails The details of the user that was
 *     banned.
 *
 * @since 1.0.0
 */
class LiveChatUserBannedMessageDetails extends Part
{
    /** A `banType` of `permanent`. */
    public const BAN_TYPE_PERMANENT = 'permanent';

    /** A `banType` of `temporary`. */
    public const BAN_TYPE_TEMPORARY = 'temporary';

    /** @var array<string, string> */
    protected array $casts = [
        'bannedUserDetails' => 'ChannelProfileDetails',
    ];
}
