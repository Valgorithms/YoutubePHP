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
 * The contentOwnerDetails object encapsulates channel data that is relevant for YouTube Partners
 * linked with the channel.
 *
 * @property string|null $contentOwner The ID of the content owner linked to the channel.
 * @property \Carbon\CarbonImmutable|null $timeLinked The date and time when the channel was linked to the
 *     content owner.
 *
 * @since 1.0.0
 */
class ChannelContentOwnerDetails extends Part
{
    /** @var list<string> */
    protected array $dates = [
        'timeLinked',
    ];
}
