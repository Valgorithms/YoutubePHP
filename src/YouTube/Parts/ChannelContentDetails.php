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
 * Details about the content of a channel.
 *
 * @property \YouTube\Parts\ChannelContentDetailsRelatedPlaylists|null $relatedPlaylists
 *
 * @since 1.0.0
 */
class ChannelContentDetails extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'relatedPlaylists' => 'ChannelContentDetailsRelatedPlaylists',
    ];
}
