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
 * Information specific to merchant affiliate program.
 *
 * @property string|null $status The current merchant affiliate program status. One of the `STATUS_*` constants.
 *
 * @since 1.0.0
 */
class ChannelToStoreLinkDetailsMerchantAffiliateProgramDetails extends Part
{
    /** Unspecified status. */
    public const STATUS_MERCHANT_AFFILIATE_PROGRAM_STATUS_UNSPECIFIED = 'merchantAffiliateProgramStatusUnspecified';

    /** Merchant is eligible for the merchant affiliate program. */
    public const STATUS_MERCHANT_AFFILIATE_PROGRAM_STATUS_ELIGIBLE = 'merchantAffiliateProgramStatusEligible';

    /** Merchant affiliate program is active. */
    public const STATUS_MERCHANT_AFFILIATE_PROGRAM_STATUS_ACTIVE = 'merchantAffiliateProgramStatusActive';

    /** Merchant affiliate program is paused. */
    public const STATUS_MERCHANT_AFFILIATE_PROGRAM_STATUS_PAUSED = 'merchantAffiliateProgramStatusPaused';
}
