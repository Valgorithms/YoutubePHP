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
 * A search result contains information about a YouTube video, channel, or playlist that matches the
 * search parameters specified in an API request. While a search result points to a uniquely
 * identifiable resource, like a video, it does not have its own persistent data.
 *
 * @property string|null $etag Etag of this resource.
 * @property \YouTube\Parts\ResourceId|null $id The id object contains information that can be used to uniquely
 *     identify the resource that matches the search request.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#searchResult".
 * @property \YouTube\Parts\SearchResultSnippet|null $snippet The snippet object contains basic details about a
 *     search result, such as its title or description. For example, if the search result is a video, then the title
 *     will be the video's title and the description will be the video's description.
 *
 * @since 1.0.0
 */
class SearchResult extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'id' => 'ResourceId',
        'snippet' => 'SearchResultSnippet',
    ];
}
