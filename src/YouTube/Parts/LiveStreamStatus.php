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
 * Brief description of the live stream status.
 *
 * @property \YouTube\Parts\LiveStreamHealthStatus|null $healthStatus The health status of the stream.
 * @property string|null $streamStatus One of the `STREAM_STATUS_*` constants.
 *
 * @since 1.0.0
 */
class LiveStreamStatus extends Part
{
    /** A `streamStatus` of `created`. */
    public const STREAM_STATUS_CREATED = 'created';

    /** A `streamStatus` of `ready`. */
    public const STREAM_STATUS_READY = 'ready';

    /** A `streamStatus` of `active`. */
    public const STREAM_STATUS_ACTIVE = 'active';

    /** A `streamStatus` of `inactive`. */
    public const STREAM_STATUS_INACTIVE = 'inactive';

    /** A `streamStatus` of `error`. */
    public const STREAM_STATUS_ERROR = 'error';

    /** @var array<string, string> */
    protected array $casts = [
        'healthStatus' => 'LiveStreamHealthStatus',
    ];
}
