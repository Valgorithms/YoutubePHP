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
 * @property \YouTube\Parts\LiveChatPollDetailsPollMetadata|null $metadata
 * @property string|null $status One of the `STATUS_*` constants.
 *
 * @since 1.0.0
 */
class LiveChatPollDetails extends Part
{
    /** A `status` of `unknown`. */
    public const STATUS_UNKNOWN = 'unknown';

    /** A `status` of `active`. */
    public const STATUS_ACTIVE = 'active';

    /** A `status` of `closed`. */
    public const STATUS_CLOSED = 'closed';

    /** @var array<string, string> */
    protected array $casts = [
        'metadata' => 'LiveChatPollDetailsPollMetadata',
    ];
}
