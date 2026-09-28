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
 * @property string|null $associatedMembershipGiftingMessageId The ID of the membership gifting message that is
 *     related to this gift membership. This ID will always refer to a message whose type is
 *     'membershipGiftingEvent'.
 * @property string|null $gifterChannelId The ID of the user that made the membership gifting purchase. This
 *     matches the `snippet.authorChannelId` of the associated membership gifting message.
 * @property string|null $memberLevelName The name of the Level at which the viewer is a member. This matches the
 *     `snippet.membershipGiftingDetails.giftMembershipsLevelName` of the associated membership gifting message. The
 *     Level names are defined by the YouTube channel offering the Membership. In some situations this field isn't
 *     filled.
 *
 * @since 1.0.0
 */
class LiveChatGiftMembershipReceivedDetails extends Part
{
}
