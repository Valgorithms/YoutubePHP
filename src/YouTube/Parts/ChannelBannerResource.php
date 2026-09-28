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
 * A channel banner returned as the response to a channel_banner.insert call.
 *
 * @property string|null $etag
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#channelBannerResource".
 * @property string|null $url The URL of this banner image.
 *
 * @since 1.0.0
 */
class ChannelBannerResource extends Part
{
}
