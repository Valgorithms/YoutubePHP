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
use YouTube\Http\Media;

/**
 * This file is generated from spec/discovery.json (YouTube Data API v3, revision 20260924) by
 * tools/generate.php. Do not edit it by hand - run `composer spec:build` instead.
 *
 * Playlists' cover images.
 *
 * Reach it as `$youtube->playlistImages`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/playlistImages
 *
 * @since 1.0.0
 */
final class PlaylistImagesApi extends AbstractApi
{
    /**
     * Deletes a resource.
     *
     * Costs 50 units of quota.
     *
     * @param string|null $id Id to identify this image. This is returned from by the List method.
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
     * @link https://developers.google.com/youtube/v3/docs/playlistImages/delete
     *
     * @since 1.0.0
     */
    public function delete(
        ?string $id = null,
        ?string $onBehalfOfContentOwner = null,
    ): PromiseInterface {
        return $this->call(
            'playlistImages.delete',
            'DELETE',
            'youtube/v3/playlistImages',
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
     * @param \YouTube\Parts\PlaylistImage|array<string, mixed> $body The PlaylistImage to send.
     * @param Media|null $media The file to upload: image/jpeg, image/png, application/octet-stream, up to
     *     50 MB. Sent in the same request as the metadata.
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
     * @param list<string>|string|null $part The *part* parameter specifies the properties that the API
     *     response will include.
     *
     * @return PromiseInterface<\YouTube\Parts\PlaylistImage>
     *
     * @link https://developers.google.com/youtube/v3/docs/playlistImages/insert
     *
     * @since 1.0.0
     */
    public function insert(
        array|\JsonSerializable $body,
        ?Media $media = null,
        ?string $onBehalfOfContentOwner = null,
        ?string $onBehalfOfContentOwnerChannel = null,
        array|string|null $part = null,
    ): PromiseInterface {
        return $this->call(
            'playlistImages.insert',
            'POST',
            'youtube/v3/playlistImages',
            query: [
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'onBehalfOfContentOwnerChannel' => $onBehalfOfContentOwnerChannel,
                'part' => $part,
            ],
            body: $body,
            returns: 'PlaylistImage',
            media: $media,
            uploadPath: '/upload/youtube/v3/playlistImages',
        );
    }

    /**
     * Retrieves a list of resources, possibly filtered.
     *
     * Costs 1 unit of quota.
     *
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
     * @param string|null $parent Return PlaylistImages for this playlist id.
     * @param list<string>|string|null $part The *part* parameter specifies a comma-separated list of one
     *     or more playlistImage resource properties that the API response will include. If the parameter
     *     identifies a property that contains child properties, the child properties will be included in the
     *     response.
     *
     * @return PromiseInterface<\YouTube\Parts\PlaylistImageListResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/playlistImages/list
     *
     * @since 1.0.0
     */
    public function list(
        ?int $maxResults = null,
        ?string $onBehalfOfContentOwner = null,
        ?string $onBehalfOfContentOwnerChannel = null,
        ?string $pageToken = null,
        ?string $parent = null,
        array|string|null $part = null,
    ): PromiseInterface {
        return $this->call(
            'playlistImages.list',
            'GET',
            'youtube/v3/playlistImages',
            query: [
                'maxResults' => $maxResults,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'onBehalfOfContentOwnerChannel' => $onBehalfOfContentOwnerChannel,
                'pageToken' => $pageToken,
                'parent' => $parent,
                'part' => $part,
            ],
            returns: 'PlaylistImageListResponse',
        );
    }

    /**
     * Updates an existing resource.
     *
     * Costs 50 units of quota.
     *
     * @param \YouTube\Parts\PlaylistImage|array<string, mixed> $body The PlaylistImage to send.
     * @param Media|null $media The file to upload: image/jpeg, image/png, application/octet-stream, up to
     *     50 MB. Sent in the same request as the metadata.
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The CMS account that the user authenticates with must be linked to the
     *     specified YouTube content owner.
     * @param list<string>|string|null $part The *part* parameter specifies the properties that the API
     *     response will include.
     *
     * @return PromiseInterface<\YouTube\Parts\PlaylistImage>
     *
     * @link https://developers.google.com/youtube/v3/docs/playlistImages/update
     *
     * @since 1.0.0
     */
    public function update(
        array|\JsonSerializable $body,
        ?Media $media = null,
        ?string $onBehalfOfContentOwner = null,
        array|string|null $part = null,
    ): PromiseInterface {
        return $this->call(
            'playlistImages.update',
            'PUT',
            'youtube/v3/playlistImages',
            query: [
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'part' => $part,
            ],
            body: $body,
            returns: 'PlaylistImage',
            media: $media,
            uploadPath: '/upload/youtube/v3/playlistImages',
        );
    }
}
