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
 * Information specific to a creator in an affiliate program linked to a YouTube channel.
 *
 * @property string|null $merchantId Required. Google Merchant Center ID of the partner. A 64-bit number, as a
 *     string.
 * @property string|null $programStatus Required. Affiliate program status. One of the `PROGRAM_STATUS_*`
 *     constants.
 * @property string|null $statusUpdateReason Optional. Reason for the last update of the affiliate program
 *     status.
 * @property \Carbon\CarbonImmutable|null $statusUpdateTime Optional. Timestamp when the affiliate program status
 *     was last updated.
 *
 * @since 1.0.0
 */
class ChannelToAffiliateProgramLinkDetails extends Part
{
    /** Unspecified status. */
    public const PROGRAM_STATUS_AFFILIATE_PROGRAM_STATUS_UNSPECIFIED = 'affiliateProgramStatusUnspecified';

    /** Channel is active in the affiliate program. */
    public const PROGRAM_STATUS_ACTIVE = 'active';

    /** Channel is inactive in the affiliate program. */
    public const PROGRAM_STATUS_INACTIVE = 'inactive';

    /** @var list<string> */
    protected array $dates = [
        'statusUpdateTime',
    ];
}
