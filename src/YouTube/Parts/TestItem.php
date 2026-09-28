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
 * @property string|null $etag Etag for the resource. See https://en.wikipedia.org/wiki/HTTP_ETag.
 * @property bool|null $featuredPart
 * @property string|null $gaia A 64-bit number, as a string.
 * @property string|null $id
 * @property \YouTube\Parts\TestItemTestItemSnippet|null $snippet
 *
 * @since 1.0.0
 */
class TestItem extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'snippet' => 'TestItemTestItemSnippet',
    ];
}
