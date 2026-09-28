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
 * Basic details about a video category, such as its localized title.
 *
 * @property string|null $label The localized label belonging to this abuse report reason.
 * @property \Discord\Helpers\Collection<\YouTube\Parts\VideoAbuseReportSecondaryReason>|null $secondaryReasons
 *     The secondary reasons associated with this reason, if any are available. (There might be 0 or more.)
 *
 * @since 1.0.0
 */
class VideoAbuseReportReasonSnippet extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'secondaryReasons' => 'Array of VideoAbuseReportSecondaryReason',
    ];
}
