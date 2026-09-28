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
 * Channels, the signed-in account's own included.
 *
 * Reach it as `$youtube->channels`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/channels
 *
 * @since 1.0.0
 */
final class ChannelsApi extends AbstractApi
{
    /**
     * Retrieves a list of resources, possibly filtered.
     *
     * Costs 1 unit of quota.
     *
     * @param list<string>|string $part The *part* parameter specifies a comma-separated list of one or
     *     more channel resource properties that the API response will include. If the parameter identifies a
     *     property that contains child properties, the child properties will be included in the response. For
     *     example, in a channel resource, the contentDetails property contains other properties, such as the
     *     uploads properties. As such, if you set *part=contentDetails*, the API response will also contain
     *     all of those nested properties.
     * @param string|null $categoryId Return the channels within the specified guide category ID.
     * @param string|null $forHandle Return the channel associated with a YouTube handle.
     * @param string|null $forUsername Return the channel associated with a YouTube username.
     * @param string|null $hl Stands for "host language". Specifies the localization language of the
     *     metadata to be filled into snippet.localized. The field is filled with the default metadata if there
     *     is no localization in the specified language. The parameter value must be a language code included
     *     in the list returned by the i18nLanguages.list method (e.g. en_US, es_MX).
     * @param list<string>|string|null $id Return the channels with the specified IDs.
     * @param bool|null $managedByMe Return the channels managed by the authenticated user.
     * @param int|null $maxResults The *maxResults* parameter specifies the maximum number of items that
     *     should be returned in the result set. From 0 to 50. YouTube assumes `5` when it is left out.
     * @param bool|null $mine Return the ids of channels owned by the authenticated user.
     * @param bool|null $mySubscribers Return the channels subscribed to the authenticated user
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The CMS account that the user authenticates with must be linked to the
     *     specified YouTube content owner.
     * @param string|null $pageToken The *pageToken* parameter identifies a specific page in the result set
     *     that should be returned. In an API response, the nextPageToken and prevPageToken properties identify
     *     other pages that could be retrieved.
     *
     * @return PromiseInterface<\YouTube\Parts\ChannelListResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/channels/list
     *
     * @since 1.0.0
     */
    public function list(
        array|string $part,
        ?string $categoryId = null,
        ?string $forHandle = null,
        ?string $forUsername = null,
        ?string $hl = null,
        array|string|null $id = null,
        ?bool $managedByMe = null,
        ?int $maxResults = null,
        ?bool $mine = null,
        ?bool $mySubscribers = null,
        ?string $onBehalfOfContentOwner = null,
        ?string $pageToken = null,
    ): PromiseInterface {
        return $this->call(
            'channels.list',
            'GET',
            'youtube/v3/channels',
            query: [
                'part' => $part,
                'categoryId' => $categoryId,
                'forHandle' => $forHandle,
                'forUsername' => $forUsername,
                'hl' => $hl,
                'id' => $id,
                'managedByMe' => $managedByMe,
                'maxResults' => $maxResults,
                'mine' => $mine,
                'mySubscribers' => $mySubscribers,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'pageToken' => $pageToken,
            ],
            returns: 'ChannelListResponse',
        );
    }

    /**
     * Updates an existing resource.
     *
     * Costs 50 units of quota.
     *
     * @param list<string>|string $part The *part* parameter serves two purposes in this operation. It
     *     identifies the properties that the write operation will set as well as the properties that the API
     *     response will include. The API currently only allows the parameter value to be set to either
     *     brandingSettings or invideoPromotion. (You cannot update both of those parts with a single request.)
     *     Note that this method overrides the existing values for all of the mutable properties that are
     *     contained in any parts that the parameter value specifies.
     * @param \YouTube\Parts\Channel|array<string, mixed> $body The Channel to send.
     * @param string|null $onBehalfOfContentOwner The *onBehalfOfContentOwner* parameter indicates that the
     *     authenticated user is acting on behalf of the content owner specified in the parameter value. This
     *     parameter is intended for YouTube content partners that own and manage many different YouTube
     *     channels. It allows content owners to authenticate once and get access to all their video and
     *     channel data, without having to provide authentication credentials for each individual channel. The
     *     actual CMS account that the user authenticates with needs to be linked to the specified YouTube
     *     content owner. This parameter must be provided if the request is authenticated with credentials for
     *     a CMS content owner user acting on a managed channel. If omitted, the request executes under the
     *     authenticated user's direct context and returns an HTTP 403 Forbidden error.
     *
     * @return PromiseInterface<\YouTube\Parts\Channel>
     *
     * @link https://developers.google.com/youtube/v3/docs/channels/update
     *
     * @since 1.0.0
     */
    public function update(
        array|string $part,
        array|\JsonSerializable $body,
        ?string $onBehalfOfContentOwner = null,
    ): PromiseInterface {
        return $this->call(
            'channels.update',
            'PUT',
            'youtube/v3/channels',
            query: [
                'part' => $part,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
            ],
            body: $body,
            returns: 'Channel',
        );
    }
}
