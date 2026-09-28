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
 * Links between a channel and third-party services.
 *
 * Reach it as `$youtube->thirdPartyLinks`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @since 1.0.0
 */
final class ThirdPartyLinksApi extends AbstractApi
{
    /**
     * Deletes a resource.
     *
     * Costs 50 units of quota, by estimate: Google does not publish it, so it is counted as a write.
     *
     * @param string $linkingToken Delete the partner links with the given linking token.
     * @param string $type Type of the link to be deleted. One of `linkUnspecified`, `channelToStoreLink`,
     *     `channelToAffiliateProgramLink`.
     * @param string|null $externalChannelId Channel ID to which changes should be applied, for delegation.
     * @param list<string>|string|null $part Do not use. Required for compatibility.
     *
     * @return PromiseInterface<null>
     *
     * @since 1.0.0
     */
    public function delete(
        string $linkingToken,
        string $type,
        ?string $externalChannelId = null,
        array|string|null $part = null,
    ): PromiseInterface {
        return $this->call(
            'thirdPartyLinks.delete',
            'DELETE',
            'youtube/v3/thirdPartyLinks',
            query: [
                'linkingToken' => $linkingToken,
                'type' => $type,
                'externalChannelId' => $externalChannelId,
                'part' => $part,
            ],
        );
    }

    /**
     * Inserts a new resource into this collection.
     *
     * Costs 50 units of quota, by estimate: Google does not publish it, so it is counted as a write.
     *
     * @param list<string>|string $part The *part* parameter specifies the thirdPartyLink resource parts
     *     that the API request and response will include. Supported values are linkingToken, status, and
     *     snippet.
     * @param \YouTube\Parts\ThirdPartyLink|array<string, mixed> $body The ThirdPartyLink to send.
     * @param string|null $externalChannelId Channel ID to which changes should be applied, for delegation.
     *
     * @return PromiseInterface<\YouTube\Parts\ThirdPartyLink>
     *
     * @since 1.0.0
     */
    public function insert(
        array|string $part,
        array|\JsonSerializable $body,
        ?string $externalChannelId = null,
    ): PromiseInterface {
        return $this->call(
            'thirdPartyLinks.insert',
            'POST',
            'youtube/v3/thirdPartyLinks',
            query: [
                'part' => $part,
                'externalChannelId' => $externalChannelId,
            ],
            body: $body,
            returns: 'ThirdPartyLink',
        );
    }

    /**
     * Retrieves a list of resources, possibly filtered.
     *
     * Costs 1 unit of quota, by estimate: Google does not publish it, so it is counted as a read.
     *
     * @param list<string>|string $part The *part* parameter specifies the thirdPartyLink resource parts
     *     that the API response will include. Supported values are linkingToken, status, and snippet.
     * @param string|null $externalChannelId Channel ID to which changes should be applied, for delegation.
     * @param string|null $linkingToken Get a third party link with the given linking token.
     * @param string|null $type Get a third party link of the given type. One of `linkUnspecified`,
     *     `channelToStoreLink`, `channelToAffiliateProgramLink`.
     *
     * @return PromiseInterface<\YouTube\Parts\ThirdPartyLinkListResponse>
     *
     * @since 1.0.0
     */
    public function list(
        array|string $part,
        ?string $externalChannelId = null,
        ?string $linkingToken = null,
        ?string $type = null,
    ): PromiseInterface {
        return $this->call(
            'thirdPartyLinks.list',
            'GET',
            'youtube/v3/thirdPartyLinks',
            query: [
                'part' => $part,
                'externalChannelId' => $externalChannelId,
                'linkingToken' => $linkingToken,
                'type' => $type,
            ],
            returns: 'ThirdPartyLinkListResponse',
        );
    }

    /**
     * Updates an existing resource.
     *
     * Costs 50 units of quota, by estimate: Google does not publish it, so it is counted as a write.
     *
     * @param list<string>|string $part The *part* parameter specifies the thirdPartyLink resource parts
     *     that the API request and response will include. Supported values are linkingToken, status, and
     *     snippet.
     * @param \YouTube\Parts\ThirdPartyLink|array<string, mixed> $body The ThirdPartyLink to send.
     * @param string|null $externalChannelId Channel ID to which changes should be applied, for delegation.
     *
     * @return PromiseInterface<\YouTube\Parts\ThirdPartyLink>
     *
     * @since 1.0.0
     */
    public function update(
        array|string $part,
        array|\JsonSerializable $body,
        ?string $externalChannelId = null,
    ): PromiseInterface {
        return $this->call(
            'thirdPartyLinks.update',
            'PUT',
            'youtube/v3/thirdPartyLinks',
            query: [
                'part' => $part,
                'externalChannelId' => $externalChannelId,
            ],
            body: $body,
            returns: 'ThirdPartyLink',
        );
    }
}
