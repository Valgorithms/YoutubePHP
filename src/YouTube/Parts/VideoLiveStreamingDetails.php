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
 * Details about the live streaming metadata.
 *
 * @property string|null $activeLiveChatId The ID of the currently active live chat attached to this video. This
 *     field is filled only if the video is a currently live broadcast that has live chat. Once the broadcast
 *     transitions to complete this field will be removed and the live chat closed down. For persistent broadcasts
 *     that live chat id will no longer be tied to this video but rather to the new video being displayed at the
 *     persistent page.
 * @property \Carbon\CarbonImmutable|null $actualEndTime The time that the broadcast actually ended. This value
 *     will not be available until the broadcast is over.
 * @property \Carbon\CarbonImmutable|null $actualStartTime The time that the broadcast actually started. This
 *     value will not be available until the broadcast begins.
 * @property string|null $concurrentViewers The number of viewers currently watching the broadcast. The property
 *     and its value will be present if the broadcast has current viewers and the broadcast owner has not hidden the
 *     viewcount for the video. Note that YouTube stops tracking the number of concurrent viewers for a broadcast
 *     when the broadcast ends. So, this property would not identify the number of viewers watching an archived video
 *     of a live broadcast that already ended. A 64-bit number, as a string.
 * @property \Carbon\CarbonImmutable|null $scheduledEndTime The time that the broadcast is scheduled to end. If
 *     the value is empty or the property is not present, then the broadcast is scheduled to continue indefinitely.
 * @property \Carbon\CarbonImmutable|null $scheduledStartTime The time that the broadcast is scheduled to begin.
 *
 * @since 1.0.0
 */
class VideoLiveStreamingDetails extends Part
{
    /** @var list<string> */
    protected array $dates = [
        'actualEndTime',
        'actualStartTime',
        'scheduledEndTime',
        'scheduledStartTime',
    ];
}
