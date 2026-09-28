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
 * @property string|null $channelId The YouTube channel ID.
 * @property string|null $channelUrl The channel's URL.
 * @property string|null $displayName The channel's display name.
 * @property bool|null $isChatModerator Whether the author is a moderator of the live chat.
 * @property bool|null $isChatOwner Whether the author is the owner of the live chat.
 * @property bool|null $isChatSponsor Whether the author is a sponsor of the live chat.
 * @property bool|null $isVerified Whether the author's identity has been verified by YouTube.
 * @property string|null $profileImageUrl The channels's avatar URL.
 *
 * @since 1.0.0
 */
class LiveChatMessageAuthorDetails extends Part
{
}
