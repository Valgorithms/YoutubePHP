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
 * A `__superChatEvent__` resource represents a Super Chat purchase on a YouTube channel.
 *
 * @property string|null $etag Etag of this resource.
 * @property string|null $id The ID that YouTube assigns to uniquely identify the Super Chat event.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     `"youtube#superChatEvent"`.
 * @property \YouTube\Parts\SuperChatEventSnippet|null $snippet The `snippet` object contains basic details about
 *     the Super Chat event.
 *
 * @link https://developers.google.com/youtube/v3/live/docs/superChatEvents
 *
 * @since 1.0.0
 */
class SuperChatEvent extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'snippet' => 'SuperChatEventSnippet',
    ];
}
