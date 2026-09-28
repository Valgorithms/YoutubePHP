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
 * The reasons a video can be reported for.
 *
 * Reach it as `$youtube->videoAbuseReportReasons`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/videoAbuseReportReasons
 *
 * @since 1.0.0
 */
final class VideoAbuseReportReasonsApi extends AbstractApi
{
    /**
     * Retrieves a list of resources, possibly filtered.
     *
     * Costs 1 unit of quota.
     *
     * @param list<string>|string $part The *part* parameter specifies the videoCategory resource parts
     *     that the API response will include. Supported values are id and snippet.
     * @param string|null $hl YouTube assumes `en-US` when it is left out.
     *
     * @return PromiseInterface<\YouTube\Parts\VideoAbuseReportReasonListResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/videoAbuseReportReasons/list
     *
     * @since 1.0.0
     */
    public function list(
        array|string $part,
        ?string $hl = null,
    ): PromiseInterface {
        return $this->call(
            'videoAbuseReportReasons.list',
            'GET',
            'youtube/v3/videoAbuseReportReasons',
            query: [
                'part' => $part,
                'hl' => $hl,
            ],
            returns: 'VideoAbuseReportReasonListResponse',
        );
    }
}
