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
 * @property string|null $amountMicros The purchase amount, in micros of the purchase currency. e.g., 1 is
 *     represented as 1000000. A 64-bit number, as a string.
 * @property string|null $channelId Channel id where the event occurred.
 * @property string|null $commentText The text contents of the comment left by the user.
 * @property \Carbon\CarbonImmutable|null $createdAt The date and time when the event occurred.
 * @property string|null $currency The currency in which the purchase was made. ISO 4217.
 * @property string|null $displayString A rendered string that displays the purchase amount and currency (e.g.,
 *     "$1.00"). The string is rendered for the given language.
 * @property bool|null $isSuperStickerEvent True if this event is a Super Sticker event.
 * @property int|null $messageType The tier for the paid message, which is based on the amount of money spent to
 *     purchase the message.
 * @property \YouTube\Parts\SuperStickerMetadata|null $superStickerMetadata If this event is a Super Sticker
 *     event, this field will contain metadata about the Super Sticker.
 * @property \YouTube\Parts\ChannelProfileDetails|null $supporterDetails Details about the supporter.
 *
 * @since 1.0.0
 */
class SuperChatEventSnippet extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'superStickerMetadata' => 'SuperStickerMetadata',
        'supporterDetails' => 'ChannelProfileDetails',
    ];

    /** @var list<string> */
    protected array $dates = [
        'createdAt',
    ];
}
