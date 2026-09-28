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
 * Note that there may be a 5-second end-point resolution issue. For instance, if a cuepoint comes in
 * for 22:03:27, we may stuff the cuepoint into 22:03:25 or 22:03:30, depending. This is an artifact of
 * HLS.
 *
 * @property string|null $cueType One of the `CUE_TYPE_*` constants.
 * @property int|null $durationSecs The duration of this cuepoint.
 * @property string|null $etag
 * @property string|null $id The identifier for cuepoint resource.
 * @property string|null $insertionOffsetTimeMs The time when the cuepoint should be inserted by offset to the
 *     broadcast actual start time. A 64-bit number, as a string.
 * @property string|null $walltimeMs The wall clock time at which the cuepoint should be inserted. Only one of
 *     insertion_offset_time_ms and walltime_ms may be set at a time. A 64-bit number, as a string.
 *
 * @since 1.0.0
 */
class Cuepoint extends Part
{
    /** A `cueType` of `cueTypeUnspecified`. */
    public const CUE_TYPE_CUE_TYPE_UNSPECIFIED = 'cueTypeUnspecified';

    /** A `cueType` of `cueTypeAd`. */
    public const CUE_TYPE_CUE_TYPE_AD = 'cueTypeAd';
}
