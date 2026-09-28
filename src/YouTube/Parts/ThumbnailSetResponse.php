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
 * @property string|null $etag Etag of this resource.
 * @property string|null $eventId Deprecated. Serialized EventId of the request which produced this response.
 * @property \Discord\Helpers\Collection<\YouTube\Parts\ThumbnailDetails>|null $items A list of thumbnails.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#thumbnailSetResponse".
 * @property string|null $visitorId Deprecated. The visitorId identifies the visitor.
 *
 * @since 1.0.0
 */
class ThumbnailSetResponse extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'items' => 'Array of ThumbnailDetails',
    ];
}
