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
 * Describes a temporal position of a visual widget inside a video.
 *
 * @property string|null $durationMs Defines the duration in milliseconds for which the promotion should be
 *     displayed. If missing, the client should use the default. A 64-bit number, as a string.
 * @property string|null $offsetMs Defines the time at which the promotion will appear. Depending on the value of
 *     type the value of the offsetMs field will represent a time offset from the start or from the end of the video,
 *     expressed in milliseconds. A 64-bit number, as a string.
 * @property string|null $type Describes a timing type. If the value is offsetFromStart, then the offsetMs field
 *     represents an offset from the start of the video. If the value is offsetFromEnd, then the offsetMs field
 *     represents an offset from the end of the video. One of the `TYPE_*` constants.
 *
 * @since 1.0.0
 */
class InvideoTiming extends Part
{
    /** A `type` of `offsetFromStart`. */
    public const TYPE_OFFSET_FROM_START = 'offsetFromStart';

    /** A `type` of `offsetFromEnd`. */
    public const TYPE_OFFSET_FROM_END = 'offsetFromEnd';
}
