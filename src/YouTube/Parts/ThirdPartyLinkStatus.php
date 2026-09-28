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
 * The third-party link status object contains information about the status of the link.
 *
 * @property string|null $linkStatus One of the `LINK_STATUS_*` constants.
 *
 * @since 1.0.0
 */
class ThirdPartyLinkStatus extends Part
{
    /** A `linkStatus` of `unknown`. */
    public const LINK_STATUS_UNKNOWN = 'unknown';

    /** A `linkStatus` of `failed`. */
    public const LINK_STATUS_FAILED = 'failed';

    /** A `linkStatus` of `pending`. */
    public const LINK_STATUS_PENDING = 'pending';

    /** A `linkStatus` of `linked`. */
    public const LINK_STATUS_LINKED = 'linked';
}
