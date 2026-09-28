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
 * Branding properties of a YouTube channel.
 *
 * @property \YouTube\Parts\ChannelSettings|null $channel Branding properties for the channel view.
 * @property \Discord\Helpers\Collection<\YouTube\Parts\PropertyValue>|null $hints Deprecated. Additional
 *     experimental branding properties.
 * @property \YouTube\Parts\ImageSettings|null $image Branding properties for branding images.
 * @property \YouTube\Parts\WatchSettings|null $watch Deprecated. Branding properties for the watch page.
 *
 * @since 1.0.0
 */
class ChannelBrandingSettings extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'channel' => 'ChannelSettings',
        'hints' => 'Array of PropertyValue',
        'image' => 'ImageSettings',
        'watch' => 'WatchSettings',
    ];
}
