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
 * Information specific to billing.
 *
 * @property string|null $billingStatus The current billing profile status. One of the `BILLING_STATUS_*`
 *     constants.
 *
 * @since 1.0.0
 */
class ChannelToStoreLinkDetailsBillingDetails extends Part
{
    /** A `billingStatus` of `billingStatusUnspecified`. */
    public const BILLING_STATUS_BILLING_STATUS_UNSPECIFIED = 'billingStatusUnspecified';

    /** A `billingStatus` of `billingStatusPending`. */
    public const BILLING_STATUS_BILLING_STATUS_PENDING = 'billingStatusPending';

    /** A `billingStatus` of `billingStatusActive`. */
    public const BILLING_STATUS_BILLING_STATUS_ACTIVE = 'billingStatusActive';

    /** A `billingStatus` of `billingStatusInactive`. */
    public const BILLING_STATUS_BILLING_STATUS_INACTIVE = 'billingStatusInactive';
}
