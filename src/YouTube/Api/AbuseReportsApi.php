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
 * Reports of abuse.
 *
 * Reach it as `$youtube->abuseReports`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @since 1.0.0
 */
final class AbuseReportsApi extends AbstractApi
{
    /**
     * Inserts a new resource into this collection.
     *
     * Costs 50 units of quota, by estimate: Google does not publish it, so it is counted as a write.
     *
     * @param list<string>|string $part The *part* parameter serves two purposes in this operation. It
     *     identifies the properties that the write operation will set as well as the properties that the API
     *     response will include.
     * @param \YouTube\Parts\AbuseReport|array<string, mixed> $body The AbuseReport to send.
     *
     * @return PromiseInterface<\YouTube\Parts\AbuseReport>
     *
     * @since 1.0.0
     */
    public function insert(
        array|string $part,
        array|\JsonSerializable $body,
    ): PromiseInterface {
        return $this->call(
            'abuseReports.insert',
            'POST',
            'youtube/v3/abuseReports',
            query: [
                'part' => $part,
            ],
            body: $body,
            returns: 'AbuseReport',
        );
    }
}
