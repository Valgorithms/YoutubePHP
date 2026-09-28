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
 * Live broadcasts: scheduling one, binding it to a stream, going live and ending it.
 *
 * Reach it as `$youtube->liveBroadcasts`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/live/docs/liveBroadcasts
 *
 * @since 1.0.0
 */
final class LiveBroadcastsApi extends AbstractApi
{
    /**
     * Bind a broadcast to a stream.
     *
     * Costs 50 units of quota.
     *
     * @param string $id Broadcast to bind to the stream
     * @param list<string>|string $part The *part* parameter specifies a comma-separated list of one or
     *     more liveBroadcast resource properties that the API response will include. The part names that you
     *     can include in the parameter value are id, snippet, contentDetails, and status.
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
     * @param string|null $streamId Stream to bind, if not set unbind the current one.
     *
     * @return PromiseInterface<\YouTube\Parts\LiveBroadcast>
     *
     * @link https://developers.google.com/youtube/v3/live/docs/liveBroadcasts/bind
     *
     * @since 1.0.0
     */
    public function bind(
        string $id,
        array|string $part,
        ?string $onBehalfOfContentOwner = null,
        ?string $onBehalfOfContentOwnerChannel = null,
        ?string $streamId = null,
    ): PromiseInterface {
        return $this->call(
            'liveBroadcasts.bind',
            'POST',
            'youtube/v3/liveBroadcasts/bind',
            query: [
                'id' => $id,
                'part' => $part,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'onBehalfOfContentOwnerChannel' => $onBehalfOfContentOwnerChannel,
                'streamId' => $streamId,
            ],
            returns: 'LiveBroadcast',
        );
    }

    /**
     * Delete a given broadcast.
     *
     * Costs 50 units of quota.
     *
     * @param string $id Broadcast to delete.
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
     * @return PromiseInterface<null>
     *
     * @link https://developers.google.com/youtube/v3/live/docs/liveBroadcasts/delete
     *
     * @since 1.0.0
     */
    public function delete(
        string $id,
        ?string $onBehalfOfContentOwner = null,
        ?string $onBehalfOfContentOwnerChannel = null,
    ): PromiseInterface {
        return $this->call(
            'liveBroadcasts.delete',
            'DELETE',
            'youtube/v3/liveBroadcasts',
            query: [
                'id' => $id,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'onBehalfOfContentOwnerChannel' => $onBehalfOfContentOwnerChannel,
            ],
        );
    }

    /**
     * Inserts a new stream for the authenticated user.
     *
     * Costs 50 units of quota.
     *
     * @param list<string>|string $part The *part* parameter serves two purposes in this operation. It
     *     identifies the properties that the write operation will set as well as the properties that the API
     *     response will include. The part properties that you can include in the parameter value are id,
     *     snippet, contentDetails, and status.
     * @param \YouTube\Parts\LiveBroadcast|array<string, mixed> $body The LiveBroadcast to send.
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
     * @return PromiseInterface<\YouTube\Parts\LiveBroadcast>
     *
     * @link https://developers.google.com/youtube/v3/live/docs/liveBroadcasts/insert
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
            'liveBroadcasts.insert',
            'POST',
            'youtube/v3/liveBroadcasts',
            query: [
                'part' => $part,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'onBehalfOfContentOwnerChannel' => $onBehalfOfContentOwnerChannel,
            ],
            body: $body,
            returns: 'LiveBroadcast',
        );
    }

    /**
     * Insert cuepoints in a broadcast
     *
     * Costs 50 units of quota.
     *
     * @param \YouTube\Parts\Cuepoint|array<string, mixed> $body The Cuepoint to send.
     * @param string|null $id Broadcast to insert ads to, or equivalently `external_video_id` for internal
     *     use.
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
     * @param list<string>|string|null $part The *part* parameter specifies a comma-separated list of one
     *     or more liveBroadcast resource properties that the API response will include. The part names that
     *     you can include in the parameter value are id, snippet, contentDetails, and status.
     *
     * @return PromiseInterface<\YouTube\Parts\Cuepoint>
     *
     * @since 1.0.0
     */
    public function insertCuepoint(
        array|\JsonSerializable $body,
        ?string $id = null,
        ?string $onBehalfOfContentOwner = null,
        ?string $onBehalfOfContentOwnerChannel = null,
        array|string|null $part = null,
    ): PromiseInterface {
        return $this->call(
            'liveBroadcasts.insertCuepoint',
            'POST',
            'youtube/v3/liveBroadcasts/cuepoint',
            query: [
                'id' => $id,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'onBehalfOfContentOwnerChannel' => $onBehalfOfContentOwnerChannel,
                'part' => $part,
            ],
            body: $body,
            returns: 'Cuepoint',
        );
    }

    /**
     * Retrieve the list of broadcasts associated with the given channel.
     *
     * Costs 1 unit of quota.
     *
     * @param list<string>|string $part The *part* parameter specifies a comma-separated list of one or
     *     more liveBroadcast resource properties that the API response will include. The part names that you
     *     can include in the parameter value are id, snippet, contentDetails, status and statistics.
     * @param string|null $broadcastStatus Return broadcasts with a certain status, e.g. active broadcasts.
     *     One of `broadcastStatusFilterUnspecified`, `all`, `active`, `upcoming`, `completed`.
     * @param string|null $broadcastType Return only broadcasts with the selected type. One of
     *     `broadcastTypeFilterUnspecified`, `all`, `event`, `persistent`. YouTube assumes `event` when it is
     *     left out.
     * @param list<string>|string|null $id Return broadcasts with the given ids from Stubby or Apiary.
     * @param int|null $maxResults The *maxResults* parameter specifies the maximum number of items that
     *     should be returned in the result set. From 0 to 50. YouTube assumes `5` when it is left out.
     * @param bool|null $mine
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
     * @param string|null $pageToken The *pageToken* parameter identifies a specific page in the result set
     *     that should be returned. In an API response, the nextPageToken and prevPageToken properties identify
     *     other pages that could be retrieved.
     *
     * @return PromiseInterface<\YouTube\Parts\LiveBroadcastListResponse>
     *
     * @link https://developers.google.com/youtube/v3/live/docs/liveBroadcasts/list
     *
     * @since 1.0.0
     */
    public function list(
        array|string $part,
        ?string $broadcastStatus = null,
        ?string $broadcastType = null,
        array|string|null $id = null,
        ?int $maxResults = null,
        ?bool $mine = null,
        ?string $onBehalfOfContentOwner = null,
        ?string $onBehalfOfContentOwnerChannel = null,
        ?string $pageToken = null,
    ): PromiseInterface {
        return $this->call(
            'liveBroadcasts.list',
            'GET',
            'youtube/v3/liveBroadcasts',
            query: [
                'part' => $part,
                'broadcastStatus' => $broadcastStatus,
                'broadcastType' => $broadcastType,
                'id' => $id,
                'maxResults' => $maxResults,
                'mine' => $mine,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'onBehalfOfContentOwnerChannel' => $onBehalfOfContentOwnerChannel,
                'pageToken' => $pageToken,
            ],
            returns: 'LiveBroadcastListResponse',
        );
    }

    /**
     * Transition a broadcast to a given status.
     *
     * Costs 50 units of quota.
     *
     * @param string $broadcastStatus The status to which the broadcast is going to transition. One of
     *     `statusUnspecified`, `testing`, `live`, `complete`.
     * @param string $id Broadcast to transition.
     * @param list<string>|string $part The *part* parameter specifies a comma-separated list of one or
     *     more liveBroadcast resource properties that the API response will include. The part names that you
     *     can include in the parameter value are id, snippet, contentDetails, and status.
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
     * @return PromiseInterface<\YouTube\Parts\LiveBroadcast>
     *
     * @link https://developers.google.com/youtube/v3/live/docs/liveBroadcasts/transition
     *
     * @since 1.0.0
     */
    public function transition(
        string $broadcastStatus,
        string $id,
        array|string $part,
        ?string $onBehalfOfContentOwner = null,
        ?string $onBehalfOfContentOwnerChannel = null,
    ): PromiseInterface {
        return $this->call(
            'liveBroadcasts.transition',
            'POST',
            'youtube/v3/liveBroadcasts/transition',
            query: [
                'broadcastStatus' => $broadcastStatus,
                'id' => $id,
                'part' => $part,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'onBehalfOfContentOwnerChannel' => $onBehalfOfContentOwnerChannel,
            ],
            returns: 'LiveBroadcast',
        );
    }

    /**
     * Updates an existing broadcast for the authenticated user.
     *
     * Costs 50 units of quota.
     *
     * @param list<string>|string $part The *part* parameter serves two purposes in this operation. It
     *     identifies the properties that the write operation will set as well as the properties that the API
     *     response will include. The part properties that you can include in the parameter value are id,
     *     snippet, contentDetails, and status. Note that this method will override the existing values for all
     *     of the mutable properties that are contained in any parts that the parameter value specifies. For
     *     example, a broadcast's privacy status is defined in the status part. As such, if your request is
     *     updating a private or unlisted broadcast, and the request's part parameter value includes the status
     *     part, the broadcast's privacy setting will be updated to whatever value the request body specifies.
     *     If the request body does not specify a value, the existing privacy setting will be removed and the
     *     broadcast will revert to the default privacy setting.
     * @param \YouTube\Parts\LiveBroadcast|array<string, mixed> $body The LiveBroadcast to send.
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
     * @return PromiseInterface<\YouTube\Parts\LiveBroadcast>
     *
     * @link https://developers.google.com/youtube/v3/live/docs/liveBroadcasts/update
     *
     * @since 1.0.0
     */
    public function update(
        array|string $part,
        array|\JsonSerializable $body,
        ?string $onBehalfOfContentOwner = null,
        ?string $onBehalfOfContentOwnerChannel = null,
    ): PromiseInterface {
        return $this->call(
            'liveBroadcasts.update',
            'PUT',
            'youtube/v3/liveBroadcasts',
            query: [
                'part' => $part,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'onBehalfOfContentOwnerChannel' => $onBehalfOfContentOwnerChannel,
            ],
            body: $body,
            returns: 'LiveBroadcast',
        );
    }
}
