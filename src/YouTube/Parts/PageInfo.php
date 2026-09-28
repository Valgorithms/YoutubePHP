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
 * Paging details for lists of resources, including total number of items available and number of
 * resources returned in a single page.
 *
 * @property int|null $resultsPerPage The number of results included in the API response.
 * @property int|null $totalResults The total number of results in the result set.
 *
 * @since 1.0.0
 */
class PageInfo extends Part
{
}
