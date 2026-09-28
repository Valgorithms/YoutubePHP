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
 * The conversionPings object encapsulates information about conversion pings that need to be respected
 * by the channel.
 *
 * @property \Discord\Helpers\Collection<\YouTube\Parts\ChannelConversionPing>|null $pings Pings that the app
 *     shall fire (authenticated by biscotti cookie). Each ping has a context, in which the app must fire the ping,
 *     and a url identifying the ping.
 *
 * @since 1.0.0
 */
class ChannelConversionPings extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'pings' => 'Array of ChannelConversionPing',
    ];
}
