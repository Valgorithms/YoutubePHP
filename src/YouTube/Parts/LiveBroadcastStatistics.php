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
 * Statistics about the live broadcast. These represent a snapshot of the values at the time of the
 * request. Statistics are only returned for live broadcasts.
 *
 * @property string|null $concurrentViewers The number of viewers currently watching the broadcast. The property
 *     and its value will be present if the broadcast has current viewers and the broadcast owner has not hidden the
 *     viewcount for the video. Note that YouTube stops tracking the number of concurrent viewers for a broadcast
 *     when the broadcast ends. So, this property would not identify the number of viewers watching an archived video
 *     of a live broadcast that already ended. A 64-bit number, as a string.
 *
 * @since 1.0.0
 */
class LiveBroadcastStatistics extends Part
{
}
