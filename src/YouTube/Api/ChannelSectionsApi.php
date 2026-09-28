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
 * The shelves on a channel's page.
 *
 * Reach it as `$youtube->channelSections`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/channelSections
 *
 * @since 1.0.0
 */
final class ChannelSectionsApi extends AbstractApi
{
    /**
     * Deletes a resource.
     *
     * Costs 50 units of quota.
     *
     * @param string $id
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The CMS account that the user authenticates with must be linked to the
     *     specified YouTube content owner.
     *
     * @return PromiseInterface<null>
     *
     * @link https://developers.google.com/youtube/v3/docs/channelSections/delete
     *
     * @since 1.0.0
     */
    public function delete(
        string $id,
        ?string $onBehalfOfContentOwner = null,
    ): PromiseInterface {
        return $this->call(
            'channelSections.delete',
            'DELETE',
            'youtube/v3/channelSections',
            query: [
                'id' => $id,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
            ],
        );
    }

    /**
     * Inserts a new resource into this collection.
     *
     * Costs 50 units of quota.
     *
     * @param list<string>|string $part The *part* parameter serves two purposes in this operation. It
     *     identifies the properties that the write operation will set as well as the properties that the API
     *     response will include. The part names that you can include in the parameter value are snippet and
     *     contentDetails.
     * @param \YouTube\Parts\ChannelSection|array<string, mixed> $body The ChannelSection to send.
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The CMS account that the user authenticates with must be linked to the
     *     specified YouTube content owner.
     * @param string|null $onBehalfOfContentOwnerChannel This parameter can only be used in a properly
     *     authorized request. *Note:* This parameter is intended exclusively for YouTube content partners. The
     *     *onBehalfOfContentOwnerChannel* parameter specifies the YouTube channel ID of the channel to which a
     *     video is being added. This parameter is required when a request specifies a value for the
     *     onBehalfOfContentOwner parameter, and it can only be used in conjunction with that parameter. In
     *     addition, the request must be authorized using a CMS account that is linked to the content owner
     *     that the onBehalfOfContentOwner parameter specifies. Finally, the channel that the
     *     onBehalfOfContentOwnerChannel parameter value specifies must be linked to the content owner that the
     *     onBehalfOfContentOwner parameter specifies. This parameter is intended for YouTube content partners
     *     that own and manage many different YouTube channels. It allows content owners to authenticate once
     *     and perform actions on behalf of the channel specified in the parameter value, without having to
     *     provide authentication credentials for each separate channel.
     *
     * @return PromiseInterface<\YouTube\Parts\ChannelSection>
     *
     * @link https://developers.google.com/youtube/v3/docs/channelSections/insert
     *
     * @since 1.0.0
     */
    public function insert(
        array|string $part,
        array|\JsonSerializable $body,
        ?string $onBehalfOfContentOwner = null,
        ?string $onBehalfOfContentOwnerChannel = null,
    ): PromiseInterface {
        return $this->call(
            'channelSections.insert',
            'POST',
            'youtube/v3/channelSections',
            query: [
                'part' => $part,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'onBehalfOfContentOwnerChannel' => $onBehalfOfContentOwnerChannel,
            ],
            body: $body,
            returns: 'ChannelSection',
        );
    }

    /**
     * Retrieves a list of resources, possibly filtered.
     *
     * Costs 1 unit of quota.
     *
     * @param list<string>|string $part The *part* parameter specifies a comma-separated list of one or
     *     more channelSection resource properties that the API response will include. The part names that you
     *     can include in the parameter value are id, snippet, and contentDetails. If the parameter identifies
     *     a property that contains child properties, the child properties will be included in the response.
     *     For example, in a channelSection resource, the snippet property contains other properties, such as a
     *     display title for the channelSection. If you set *part=snippet*, the API response will also contain
     *     all of those nested properties.
     * @param string|null $channelId Return the ChannelSections owned by the specified channel ID.
     * @param string|null $hl Deprecated. Return content in specified language
     * @param list<string>|string|null $id Return the ChannelSections with the given IDs for Stubby or
     *     Apiary.
     * @param bool|null $mine Return the ChannelSections owned by the authenticated user.
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The CMS account that the user authenticates with must be linked to the
     *     specified YouTube content owner.
     *
     * @return PromiseInterface<\YouTube\Parts\ChannelSectionListResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/channelSections/list
     *
     * @since 1.0.0
     */
    public function list(
        array|string $part,
        ?string $channelId = null,
        ?string $hl = null,
        array|string|null $id = null,
        ?bool $mine = null,
        ?string $onBehalfOfContentOwner = null,
    ): PromiseInterface {
        return $this->call(
            'channelSections.list',
            'GET',
            'youtube/v3/channelSections',
            query: [
                'part' => $part,
                'channelId' => $channelId,
                'hl' => $hl,
                'id' => $id,
                'mine' => $mine,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
            ],
            returns: 'ChannelSectionListResponse',
        );
    }

    /**
     * Updates an existing resource.
     *
     * Costs 50 units of quota.
     *
     * @param list<string>|string $part The *part* parameter serves two purposes in this operation. It
     *     identifies the properties that the write operation will set as well as the properties that the API
     *     response will include. The part names that you can include in the parameter value are snippet and
     *     contentDetails.
     * @param \YouTube\Parts\ChannelSection|array<string, mixed> $body The ChannelSection to send.
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The CMS account that the user authenticates with must be linked to the
     *     specified YouTube content owner.
     *
     * @return PromiseInterface<\YouTube\Parts\ChannelSection>
     *
     * @link https://developers.google.com/youtube/v3/docs/channelSections/update
     *
     * @since 1.0.0
     */
    public function update(
        array|string $part,
        array|\JsonSerializable $body,
        ?string $onBehalfOfContentOwner = null,
    ): PromiseInterface {
        return $this->call(
            'channelSections.update',
            'PUT',
            'youtube/v3/channelSections',
            query: [
                'part' => $part,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
            ],
            body: $body,
            returns: 'ChannelSection',
        );
    }
}
