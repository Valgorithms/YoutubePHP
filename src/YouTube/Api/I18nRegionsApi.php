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
 * The content regions YouTube supports.
 *
 * Reach it as `$youtube->i18nRegions`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/i18nRegions
 *
 * @since 1.0.0
 */
final class I18nRegionsApi extends AbstractApi
{
    /**
     * Retrieves a list of resources, possibly filtered.
     *
     * Costs 1 unit of quota.
     *
     * @param list<string>|string $part The *part* parameter specifies the i18nRegion resource properties
     *     that the API response will include. Set the parameter value to snippet.
     * @param string|null $hl YouTube assumes `en_US` when it is left out.
     *
     * @return PromiseInterface<\YouTube\Parts\I18nRegionListResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/i18nRegions/list
     *
     * @since 1.0.0
     */
    public function list(
        array|string $part,
        ?string $hl = null,
    ): PromiseInterface {
        return $this->call(
            'i18nRegions.list',
            'GET',
            'youtube/v3/i18nRegions',
            query: [
                'part' => $part,
                'hl' => $hl,
            ],
            returns: 'I18nRegionListResponse',
        );
    }
}
