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
 * The videos in playlists.
 *
 * Reach it as `$youtube->playlistItems`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/playlistItems
 *
 * @since 1.0.0
 */
final class PlaylistItemsApi extends AbstractApi
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
     * @link https://developers.google.com/youtube/v3/docs/playlistItems/delete
     *
     * @since 1.0.0
     */
    public function delete(
        string $id,
        ?string $onBehalfOfContentOwner = null,
    ): PromiseInterface {
        return $this->call(
            'playlistItems.delete',
            'DELETE',
            'youtube/v3/playlistItems',
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
     *     response will include.
     * @param \YouTube\Parts\PlaylistItem|array<string, mixed> $body The PlaylistItem to send.
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The CMS account that the user authenticates with must be linked to the
     *     specified YouTube content owner.
     *
     * @return PromiseInterface<\YouTube\Parts\PlaylistItem>
     *
     * @link https://developers.google.com/youtube/v3/docs/playlistItems/insert
     *
     * @since 1.0.0
     */
    public function insert(
        array|string $part,
        array|\JsonSerializable $body,
        ?string $onBehalfOfContentOwner = null,
    ): PromiseInterface {
        return $this->call(
            'playlistItems.insert',
            'POST',
            'youtube/v3/playlistItems',
            query: [
                'part' => $part,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
            ],
            body: $body,
            returns: 'PlaylistItem',
        );
    }

    /**
     * Retrieves a list of resources, possibly filtered.
     *
     * Costs 1 unit of quota.
     *
     * @param list<string>|string $part The *part* parameter specifies a comma-separated list of one or
     *     more playlistItem resource properties that the API response will include. If the parameter
     *     identifies a property that contains child properties, the child properties will be included in the
     *     response. For example, in a playlistItem resource, the snippet property contains numerous fields,
     *     including the title, description, position, and resourceId properties. As such, if you set
     *     *part=snippet*, the API response will contain all of those properties.
     * @param list<string>|string|null $id
     * @param int|null $maxResults The *maxResults* parameter specifies the maximum number of items that
     *     should be returned in the result set. From 0 to 50. YouTube assumes `5` when it is left out.
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
     * @param string|null $playlistId Return the playlist items within the given playlist.
     * @param string|null $videoId Return the playlist items associated with the given video ID.
     *
     * @return PromiseInterface<\YouTube\Parts\PlaylistItemListResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/playlistItems/list
     *
     * @since 1.0.0
     */
    public function list(
        array|string $part,
        array|string|null $id = null,
        ?int $maxResults = null,
        ?string $onBehalfOfContentOwner = null,
        ?string $pageToken = null,
        ?string $playlistId = null,
        ?string $videoId = null,
    ): PromiseInterface {
        return $this->call(
            'playlistItems.list',
            'GET',
            'youtube/v3/playlistItems',
            query: [
                'part' => $part,
                'id' => $id,
                'maxResults' => $maxResults,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'pageToken' => $pageToken,
                'playlistId' => $playlistId,
                'videoId' => $videoId,
            ],
            returns: 'PlaylistItemListResponse',
        );
    }

    /**
     * Updates an existing resource.
     *
     * Costs 50 units of quota.
     *
     * @param list<string>|string $part The *part* parameter serves two purposes in this operation. It
     *     identifies the properties that the write operation will set as well as the properties that the API
     *     response will include. Note that this method will override the existing values for all of the
     *     mutable properties that are contained in any parts that the parameter value specifies. For example,
     *     a playlist item can specify a start time and end time, which identify the times portion of the video
     *     that should play when users watch the video in the playlist. If your request is updating a playlist
     *     item that sets these values, and the request's part parameter value includes the contentDetails
     *     part, the playlist item's start and end times will be updated to whatever value the request body
     *     specifies. If the request body does not specify values, the existing start and end times will be
     *     removed and replaced with the default settings.
     * @param \YouTube\Parts\PlaylistItem|array<string, mixed> $body The PlaylistItem to send.
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The CMS account that the user authenticates with must be linked to the
     *     specified YouTube content owner.
     *
     * @return PromiseInterface<\YouTube\Parts\PlaylistItem>
     *
     * @link https://developers.google.com/youtube/v3/docs/playlistItems/update
     *
     * @since 1.0.0
     */
    public function update(
        array|string $part,
        array|\JsonSerializable $body,
        ?string $onBehalfOfContentOwner = null,
    ): PromiseInterface {
        return $this->call(
            'playlistItems.update',
            'PUT',
            'youtube/v3/playlistItems',
            query: [
                'part' => $part,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
            ],
            body: $body,
            returns: 'PlaylistItem',
        );
    }
}
