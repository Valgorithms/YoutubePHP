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
 * @property \Discord\Helpers\Collection<\YouTube\Parts\LiveStreamConfigurationIssue>|null $configurationIssues
 *     The configurations issues on this stream
 * @property string|null $lastUpdateTimeSeconds The last time this status was updated (in seconds) A 64-bit
 *     number, as a string.
 * @property string|null $status The status code of this stream One of the `STATUS_*` constants.
 *
 * @since 1.0.0
 */
class LiveStreamHealthStatus extends Part
{
    /** A `status` of `good`. */
    public const STATUS_GOOD = 'good';

    /** A `status` of `ok`. */
    public const STATUS_OK = 'ok';

    /** A `status` of `bad`. */
    public const STATUS_BAD = 'bad';

    /** A `status` of `noData`. */
    public const STATUS_NO_DATA = 'noData';

    /** A `status` of `revoked`. */
    public const STATUS_REVOKED = 'revoked';

    /** @var array<string, string> */
    protected array $casts = [
        'configurationIssues' => 'Array of LiveStreamConfigurationIssue',
    ];
}
