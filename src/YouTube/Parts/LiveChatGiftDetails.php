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
 * Details about the gift event, this is only set if the type is 'giftEvent'.
 *
 * @property string|null $altText The alternative text to be used for accessibility.
 * @property int|null $comboCount The number of times the gift has been sent in a row.
 * @property string|null $giftDuration The duration of the gift.
 * @property string|null $giftName The name of the gift.
 * @property string|null $giftUrl The URL of the gift image.
 * @property bool|null $hasVisualEffect Whether the gift involves a visual effect.
 * @property int|null $jewelsAmount The value of the gift in jewels.
 * @property string|null $language The BCP-47 language code of the gift.
 *
 * @since 1.0.0
 */
class LiveChatGiftDetails extends Part
{
}
