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
 * Subscriptions between channels.
 *
 * Reach it as `$youtube->subscriptions`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/subscriptions
 *
 * @since 1.0.0
 */
final class SubscriptionsApi extends AbstractApi
{
    /**
     * Deletes a resource.
     *
     * Costs 50 units of quota.
     *
     * @param string $id
     *
     * @return PromiseInterface<null>
     *
     * @link https://developers.google.com/youtube/v3/docs/subscriptions/delete
     *
     * @since 1.0.0
     */
    public function delete(
        string $id,
    ): PromiseInterface {
        return $this->call(
            'subscriptions.delete',
            'DELETE',
            'youtube/v3/subscriptions',
            query: [
                'id' => $id,
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
     *     response will include.
     * @param \YouTube\Parts\Subscription|array<string, mixed> $body The Subscription to send.
     *
     * @return PromiseInterface<\YouTube\Parts\Subscription>
     *
     * @link https://developers.google.com/youtube/v3/docs/subscriptions/insert
     *
     * @since 1.0.0
     */
    public function insert(
        array|string $part,
        array|\JsonSerializable $body,
    ): PromiseInterface {
        return $this->call(
            'subscriptions.insert',
            'POST',
            'youtube/v3/subscriptions',
            query: [
                'part' => $part,
            ],
            body: $body,
            returns: 'Subscription',
        );
    }

    /**
     * Retrieves a list of resources, possibly filtered.
     *
     * Costs 1 unit of quota.
     *
     * @param list<string>|string $part The *part* parameter specifies a comma-separated list of one or
     *     more subscription resource properties that the API response will include. If the parameter
     *     identifies a property that contains child properties, the child properties will be included in the
     *     response. For example, in a subscription resource, the snippet property contains other properties,
     *     such as a display title for the subscription. If you set *part=snippet*, the API response will also
     *     contain all of those nested properties.
     * @param string|null $channelId Return the subscriptions of the given channel owner.
     * @param string|null $forChannelId Return the subscriptions to the subset of these channels that the
     *     authenticated user is subscribed to.
     * @param list<string>|string|null $id Return the subscriptions with the given IDs for Stubby or
     *     Apiary.
     * @param int|null $maxResults The *maxResults* parameter specifies the maximum number of items that
     *     should be returned in the result set. From 0 to 50. YouTube assumes `5` when it is left out.
     * @param bool|null $mine Flag for returning the subscriptions of the authenticated user.
     * @param bool|null $myRecentSubscribers
     * @param bool|null $mySubscribers Return the subscribers of the given channel owner.
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
     * @param string|null $order The order of the returned subscriptions One of
     *     `subscriptionOrderUnspecified`, `relevance`, `unread`, `alphabetical`. YouTube assumes `relevance`
     *     when it is left out.
     * @param string|null $pageToken The *pageToken* parameter identifies a specific page in the result set
     *     that should be returned. In an API response, the nextPageToken and prevPageToken properties identify
     *     other pages that could be retrieved.
     *
     * @return PromiseInterface<\YouTube\Parts\SubscriptionListResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/subscriptions/list
     *
     * @since 1.0.0
     */
    public function list(
        array|string $part,
        ?string $channelId = null,
        ?string $forChannelId = null,
        array|string|null $id = null,
        ?int $maxResults = null,
        ?bool $mine = null,
        ?bool $myRecentSubscribers = null,
        ?bool $mySubscribers = null,
        ?string $onBehalfOfContentOwner = null,
        ?string $onBehalfOfContentOwnerChannel = null,
        ?string $order = null,
        ?string $pageToken = null,
    ): PromiseInterface {
        return $this->call(
            'subscriptions.list',
            'GET',
            'youtube/v3/subscriptions',
            query: [
                'part' => $part,
                'channelId' => $channelId,
                'forChannelId' => $forChannelId,
                'id' => $id,
                'maxResults' => $maxResults,
                'mine' => $mine,
                'myRecentSubscribers' => $myRecentSubscribers,
                'mySubscribers' => $mySubscribers,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'onBehalfOfContentOwnerChannel' => $onBehalfOfContentOwnerChannel,
                'order' => $order,
                'pageToken' => $pageToken,
            ],
            returns: 'SubscriptionListResponse',
        );
    }
}
