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
 * Response for the Videos.stats API. Returns VideoStat information about a batch of videos. VideoStat
 * contains a subset of the information in Video that is relevant to statistics and content details.
 * BatchGetStats is intentionally not atomic to provide a better user experience. BatchGetStatsResponse
 * returns a summary to help users understand the outcome of the operation.
 *
 * @property string|null $etag Etag of this resource.
 * @property \Discord\Helpers\Collection<\YouTube\Parts\VideoStat>|null $items The videos' stats information.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#batchGetStatsResponse".
 *
 * @since 1.0.0
 */
class BatchGetStatsResponse extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'items' => 'Array of VideoStat',
    ];
}
