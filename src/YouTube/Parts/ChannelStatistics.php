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
 * Statistics about a channel: number of subscribers, number of videos in the channel, etc.
 *
 * @property string|null $commentCount The number of comments for the channel. A 64-bit number, as a string.
 * @property bool|null $hiddenSubscriberCount Whether or not the number of subscribers is shown for this user.
 * @property string|null $subscriberCount The number of subscribers that the channel has. A 64-bit number, as a
 *     string.
 * @property string|null $videoCount The number of videos uploaded to the channel. A 64-bit number, as a string.
 * @property string|null $viewCount The number of times the channel has been viewed. A 64-bit number, as a
 *     string.
 *
 * @since 1.0.0
 */
class ChannelStatistics extends Part
{
}
