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
 * A channel's membership levels.
 *
 * Reach it as `$youtube->membershipsLevels`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/membershipsLevels
 *
 * @since 1.0.0
 */
final class MembershipsLevelsApi extends AbstractApi
{
    /**
     * Retrieves a list of all pricing levels offered by a creator to the fans.
     *
     * Costs 1 unit of quota.
     *
     * @param list<string>|string $part The *part* parameter specifies the membershipsLevel resource parts
     *     that the API response will include. Supported values are id and snippet.
     *
     * @return PromiseInterface<\YouTube\Parts\MembershipsLevelListResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/membershipsLevels/list
     *
     * @since 1.0.0
     */
    public function list(
        array|string $part,
    ): PromiseInterface {
        return $this->call(
            'membershipsLevels.list',
            'GET',
            'youtube/v3/membershipsLevels',
            query: [
                'part' => $part,
            ],
            returns: 'MembershipsLevelListResponse',
        );
    }
}
