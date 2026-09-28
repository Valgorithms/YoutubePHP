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
 * @property string|null $amountDisplayString A rendered string that displays the fund amount and currency to the
 *     user.
 * @property string|null $amountMicros The amount purchased by the user, in micros (1,750,000 micros = 1.75). A
 *     64-bit number, as a string.
 * @property string|null $currency The currency in which the purchase was made.
 * @property \YouTube\Parts\SuperStickerMetadata|null $superStickerMetadata Information about the Super Sticker.
 * @property int|null $tier The tier in which the amount belongs. Lower amounts belong to lower tiers. The lowest
 *     tier is 1.
 *
 * @since 1.0.0
 */
class LiveChatSuperStickerDetails extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'superStickerMetadata' => 'SuperStickerMetadata',
    ];
}
