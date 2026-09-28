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
 * @property string|null $channelId The ID that YouTube uses to uniquely identify the channel that is
 *     transmitting the stream.
 * @property string|null $description The stream's description. The value cannot be longer than 10000 characters.
 * @property bool|null $isDefaultStream
 * @property \Carbon\CarbonImmutable|null $publishedAt The date and time that the stream was created.
 * @property string|null $title The stream's title. The value must be between 1 and 128 characters long.
 *
 * @since 1.0.0
 */
class LiveStreamSnippet extends Part
{
    /** @var list<string> */
    protected array $dates = [
        'publishedAt',
    ];
}
