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
 * An internal method Google uses to test the API.
 *
 * Reach it as `$youtube->tests`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @since 1.0.0
 */
final class TestsApi extends AbstractApi
{
    /**
     * POST method.
     *
     * Costs 50 units of quota, by estimate: Google does not publish it, so it is counted as a write.
     *
     * @param list<string>|string $part
     * @param \YouTube\Parts\TestItem|array<string, mixed> $body The TestItem to send.
     * @param string|null $externalChannelId
     * @param string|null $onBehalfOfContentOwnerChannel
     *
     * @return PromiseInterface<\YouTube\Parts\TestItem>
     *
     * @since 1.0.0
     */
    public function insert(
        array|string $part,
        array|\JsonSerializable $body,
        ?string $externalChannelId = null,
        ?string $onBehalfOfContentOwnerChannel = null,
    ): PromiseInterface {
        return $this->call(
            'tests.insert',
            'POST',
            'youtube/v3/tests',
            query: [
                'part' => $part,
                'externalChannelId' => $externalChannelId,
                'onBehalfOfContentOwnerChannel' => $onBehalfOfContentOwnerChannel,
            ],
            body: $body,
            returns: 'TestItem',
        );
    }
}
