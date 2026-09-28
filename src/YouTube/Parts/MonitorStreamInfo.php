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
 * Settings and Info of the monitor stream
 *
 * @property int|null $broadcastStreamDelayMs If you have set the enableMonitorStream property to true, then this
 *     property determines the length of the live broadcast delay.
 * @property string|null $embedHtml HTML code that embeds a player that plays the monitor stream.
 * @property bool|null $enableMonitorStream This value determines whether the monitor stream is enabled for the
 *     broadcast. If the monitor stream is enabled, then YouTube will broadcast the event content on a special stream
 *     intended only for the broadcaster's consumption. The broadcaster can use the stream to review the event
 *     content and also to identify the optimal times to insert cuepoints. You need to set this value to true if you
 *     intend to have a broadcast delay for your event. *Note:* This property cannot be updated once the broadcast is
 *     in the testing or live state.
 *
 * @since 1.0.0
 */
class MonitorStreamInfo extends Part
{
}
