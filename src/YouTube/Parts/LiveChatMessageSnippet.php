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
 * @property string|null $authorChannelId The ID of the user that authored this message, this field is not always
 *     filled. textMessageEvent - the user that wrote the message fanFundingEvent - the user that funded the
 *     broadcast newSponsorEvent - the user that just became a sponsor memberMilestoneChatEvent - the member that
 *     sent the message membershipGiftingEvent - the user that made the purchase giftMembershipReceivedEvent - the
 *     user that received the gift membership messageDeletedEvent - the moderator that took the action. Unused.
 *     messageRetractedEvent - the author that retracted their message. Unused. userBannedEvent - the moderator that
 *     took the action superChatEvent - the user that made the purchase superStickerEvent - the user that made the
 *     purchase pollEvent - the user that created the poll
 * @property string|null $displayMessage Contains a string that can be displayed to the user. If this field is
 *     not present the message is silent, at the moment only messages of type TOMBSTONE and CHAT_ENDED_EVENT are
 *     silent.
 * @property \YouTube\Parts\LiveChatFanFundingEventDetails|null $fanFundingEventDetails Deprecated. Details about
 *     the funding event, this is only set if the type is 'fanFundingEvent'.
 * @property \YouTube\Parts\LiveChatGiftDetails|null $giftDetails Details about the gift event, this is only set
 *     if the type is 'giftEvent'.
 * @property \YouTube\Parts\LiveChatGiftMembershipReceivedDetails|null $giftMembershipReceivedDetails Details
 *     about the Gift Membership Received event, this is only set if the type is 'giftMembershipReceivedEvent'.
 * @property bool|null $hasDisplayContent Whether the message has display content that should be displayed to
 *     users.
 * @property string|null $liveChatId
 * @property \YouTube\Parts\LiveChatMemberMilestoneChatDetails|null $memberMilestoneChatDetails Details about the
 *     Member Milestone Chat event, this is only set if the type is 'memberMilestoneChatEvent'.
 * @property \YouTube\Parts\LiveChatMembershipGiftingDetails|null $membershipGiftingDetails Details about the
 *     Membership Gifting event, this is only set if the type is 'membershipGiftingEvent'.
 * @property \YouTube\Parts\LiveChatMessageDeletedDetails|null $messageDeletedDetails Deprecated.
 * @property \YouTube\Parts\LiveChatMessageRetractedDetails|null $messageRetractedDetails Deprecated.
 * @property \YouTube\Parts\LiveChatNewSponsorDetails|null $newSponsorDetails Details about the New Member
 *     Announcement event, this is only set if the type is 'newSponsorEvent'. Please note that "member" is the new
 *     term for "sponsor".
 * @property \YouTube\Parts\LiveChatPollDetails|null $pollDetails Details about the poll event, this is only set
 *     if the type is 'pollEvent'.
 * @property \Carbon\CarbonImmutable|null $publishedAt The date and time when the message was orignally
 *     published.
 * @property \YouTube\Parts\LiveChatSuperChatDetails|null $superChatDetails Details about the Super Chat event,
 *     this is only set if the type is 'superChatEvent'.
 * @property \YouTube\Parts\LiveChatSuperStickerDetails|null $superStickerDetails Details about the Super Sticker
 *     event, this is only set if the type is 'superStickerEvent'.
 * @property \YouTube\Parts\LiveChatTextMessageDetails|null $textMessageDetails Details about the text message,
 *     this is only set if the type is 'textMessageEvent'.
 * @property string|null $type The type of message, this will always be present, it determines the contents of
 *     the message as well as which fields will be present. One of the `TYPE_*` constants.
 * @property \YouTube\Parts\LiveChatUserBannedMessageDetails|null $userBannedDetails
 *
 * @since 1.0.0
 */
class LiveChatMessageSnippet extends Part
{
    /** A `type` of `invalidType`. */
    public const TYPE_INVALID_TYPE = 'invalidType';

    /** A `type` of `textMessageEvent`. */
    public const TYPE_TEXT_MESSAGE_EVENT = 'textMessageEvent';

    /** A `type` of `tombstone`. */
    public const TYPE_TOMBSTONE = 'tombstone';

    /** A `type` of `fanFundingEvent`. */
    public const TYPE_FAN_FUNDING_EVENT = 'fanFundingEvent';

    /** A `type` of `chatEndedEvent`. */
    public const TYPE_CHAT_ENDED_EVENT = 'chatEndedEvent';

    /** A `type` of `sponsorOnlyModeStartedEvent`. */
    public const TYPE_SPONSOR_ONLY_MODE_STARTED_EVENT = 'sponsorOnlyModeStartedEvent';

    /** A `type` of `sponsorOnlyModeEndedEvent`. */
    public const TYPE_SPONSOR_ONLY_MODE_ENDED_EVENT = 'sponsorOnlyModeEndedEvent';

    /** A `type` of `newSponsorEvent`. */
    public const TYPE_NEW_SPONSOR_EVENT = 'newSponsorEvent';

    /** A `type` of `memberMilestoneChatEvent`. */
    public const TYPE_MEMBER_MILESTONE_CHAT_EVENT = 'memberMilestoneChatEvent';

    /** A `type` of `membershipGiftingEvent`. */
    public const TYPE_MEMBERSHIP_GIFTING_EVENT = 'membershipGiftingEvent';

    /** A `type` of `giftMembershipReceivedEvent`. */
    public const TYPE_GIFT_MEMBERSHIP_RECEIVED_EVENT = 'giftMembershipReceivedEvent';

    /**
     * A `type` of `messageDeletedEvent`.
     *
     * @deprecated
     */
    public const TYPE_MESSAGE_DELETED_EVENT = 'messageDeletedEvent';

    /**
     * A `type` of `messageRetractedEvent`.
     *
     * @deprecated
     */
    public const TYPE_MESSAGE_RETRACTED_EVENT = 'messageRetractedEvent';

    /** A `type` of `userBannedEvent`. */
    public const TYPE_USER_BANNED_EVENT = 'userBannedEvent';

    /** A `type` of `superChatEvent`. */
    public const TYPE_SUPER_CHAT_EVENT = 'superChatEvent';

    /** A `type` of `superStickerEvent`. */
    public const TYPE_SUPER_STICKER_EVENT = 'superStickerEvent';

    /** A `type` of `pollEvent`. */
    public const TYPE_POLL_EVENT = 'pollEvent';

    /** A virtual gift sent by a viewer to support a creator. */
    public const TYPE_GIFT_EVENT = 'giftEvent';

    /** @var array<string, string> */
    protected array $casts = [
        'fanFundingEventDetails' => 'LiveChatFanFundingEventDetails',
        'giftDetails' => 'LiveChatGiftDetails',
        'giftMembershipReceivedDetails' => 'LiveChatGiftMembershipReceivedDetails',
        'memberMilestoneChatDetails' => 'LiveChatMemberMilestoneChatDetails',
        'membershipGiftingDetails' => 'LiveChatMembershipGiftingDetails',
        'messageDeletedDetails' => 'LiveChatMessageDeletedDetails',
        'messageRetractedDetails' => 'LiveChatMessageRetractedDetails',
        'newSponsorDetails' => 'LiveChatNewSponsorDetails',
        'pollDetails' => 'LiveChatPollDetails',
        'superChatDetails' => 'LiveChatSuperChatDetails',
        'superStickerDetails' => 'LiveChatSuperStickerDetails',
        'textMessageDetails' => 'LiveChatTextMessageDetails',
        'userBannedDetails' => 'LiveChatUserBannedMessageDetails',
    ];

    /** @var list<string> */
    protected array $dates = [
        'publishedAt',
    ];
}
