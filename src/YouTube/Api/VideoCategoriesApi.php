<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Api;

use React\Promise\PromiseInterface;

/**
 * This file is generated from spec/discovery.json (YouTube Data API v3, revision 20260924) by
 * tools/generate.php. Do not edit it by hand - run `composer spec:build` instead.
 *
 * The categories a video can be filed under.
 *
 * Reach it as `$youtube->videoCategories`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/videoCategories
 *
 * @since 1.0.0
 */
final class VideoCategoriesApi extends AbstractApi
{
    /**
     * Retrieves a list of resources, possibly filtered.
     *
     * Costs 1 unit of quota.
     *
     * @param list<string>|string $part The *part* parameter specifies the videoCategory resource
     *     properties that the API response will include. Set the parameter value to snippet.
     * @param string|null $hl YouTube assumes `en-US` when it is left out.
     * @param list<string>|string|null $id Returns the video categories with the given IDs for Stubby or
     *     Apiary.
     * @param string|null $regionCode
     *
     * @return PromiseInterface<\YouTube\Parts\VideoCategoryListResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/videoCategories/list
     *
     * @since 1.0.0
     */
    public function list(
        array|string $part,
        ?string $hl = null,
        array|string|null $id = null,
        ?string $regionCode = null,
    ): PromiseInterface {
        return $this->call(
            'videoCategories.list',
            'GET',
            'youtube/v3/videoCategories',
            query: [
                'part' => $part,
                'hl' => $hl,
                'id' => $id,
                'regionCode' => $regionCode,
            ],
            returns: 'VideoCategoryListResponse',
        );
    }
}
