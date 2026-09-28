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
 * Details about the content to witch a subscription refers.
 *
 * @property string|null $activityType The type of activity this subscription is for (only uploads, everything).
 *     One of the `ACTIVITY_TYPE_*` constants.
 * @property int|null $newItemCount The number of new items in the subscription since its content was last read.
 * @property int|null $totalItemCount The approximate number of items that the subscription points to.
 *
 * @since 1.0.0
 */
class SubscriptionContentDetails extends Part
{
    /** A `activityType` of `subscriptionActivityTypeUnspecified`. */
    public const ACTIVITY_TYPE_SUBSCRIPTION_ACTIVITY_TYPE_UNSPECIFIED = 'subscriptionActivityTypeUnspecified';

    /** A `activityType` of `all`. */
    public const ACTIVITY_TYPE_ALL = 'all';

    /** A `activityType` of `uploads`. */
    public const ACTIVITY_TYPE_UPLOADS = 'uploads';
}
