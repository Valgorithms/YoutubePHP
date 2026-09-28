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
 * @property string|null $memberLevelName The name of the Level at which the viever is a member. The Level names
 *     are defined by the YouTube channel offering the Membership. In some situations this field isn't filled.
 * @property int|null $memberMonth The total amount of months (rounded up) the viewer has been a member that
 *     granted them this Member Milestone Chat. This is the same number of months as is being displayed to YouTube
 *     users.
 * @property string|null $userComment The comment added by the member to this Member Milestone Chat. This field
 *     is empty for messages without a comment from the member.
 *
 * @since 1.0.0
 */
class LiveChatMemberMilestoneChatDetails extends Part
{
}
