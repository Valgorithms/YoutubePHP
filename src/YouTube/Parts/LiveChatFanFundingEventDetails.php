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
 * @property string|null $amountMicros The amount of the fund. A 64-bit number, as a string.
 * @property string|null $currency The currency in which the fund was made.
 * @property string|null $userComment The comment added by the user to this fan funding event.
 *
 * @since 1.0.0
 */
class LiveChatFanFundingEventDetails extends Part
{
}
