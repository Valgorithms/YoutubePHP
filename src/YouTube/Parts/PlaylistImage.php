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
 * @property string|null $id Identifies this resource (playlist id and image type).
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#playlistImages".
 * @property \YouTube\Parts\PlaylistImageSnippet|null $snippet
 *
 * @link https://developers.google.com/youtube/v3/docs/playlistImages
 *
 * @since 1.0.0
 */
class PlaylistImage extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'snippet' => 'PlaylistImageSnippet',
    ];
}
