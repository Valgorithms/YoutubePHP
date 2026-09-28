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
 * Information specific to a store on a merchandising platform linked to a YouTube channel.
 *
 * @property \YouTube\Parts\ChannelToStoreLinkDetailsBillingDetails|null $billingDetails Information specific to
 *     billing (read-only).
 * @property \YouTube\Parts\ChannelToStoreLinkDetailsMerchantAffiliateProgramDetails|null
 *     $merchantAffiliateProgramDetails Information specific to merchant affiliate program (read-only).
 * @property string|null $merchantId Google Merchant Center id of the store. A 64-bit number, as a string.
 * @property string|null $storeName Name of the store.
 * @property string|null $storeUrl Landing page of the store.
 *
 * @since 1.0.0
 */
class ChannelToStoreLinkDetails extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'billingDetails' => 'ChannelToStoreLinkDetailsBillingDetails',
        'merchantAffiliateProgramDetails' => 'ChannelToStoreLinkDetailsMerchantAffiliateProgramDetails',
    ];
}
