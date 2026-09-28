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
 * Basic details about a video. This is a subset of the information in VideoSnippet specifically for
 * the Videos.stats API.
 *
 * @property \Carbon\CarbonImmutable|null $publishTime Output only. The date and time that the video was
 *     uploaded. The property value is a
 *     [`google.protobuf.Timestamp`](https://developers.google.com/protocol-buffers/docs/reference/google.protobuf#timestamp)
 *     object. Read-only.
 *
 * @since 1.0.0
 */
class VideoStatsSnippet extends Part
{
    /** @var list<string> */
    protected array $dates = [
        'publishTime',
    ];
}
