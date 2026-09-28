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
 * The caption tracks of videos.
 *
 * Reach it as `$youtube->captions`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/captions
 *
 * @since 1.0.0
 */
final class CaptionsApi extends AbstractApi
{
    /**
     * Deletes a resource.
     *
     * Costs 50 units of quota.
     *
     * @param string $id
     * @param string|null $onBehalfOf ID of the Google+ Page for the channel that the request is be on
     *     behalf of
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The actual CMS account that the user authenticates with must be linked to
     *     the specified YouTube content owner.
     *
     * @return PromiseInterface<null>
     *
     * @link https://developers.google.com/youtube/v3/docs/captions/delete
     *
     * @since 1.0.0
     */
    public function delete(
        string $id,
        ?string $onBehalfOf = null,
        ?string $onBehalfOfContentOwner = null,
    ): PromiseInterface {
        return $this->call(
            'captions.delete',
            'DELETE',
            'youtube/v3/captions',
            query: [
                'id' => $id,
                'onBehalfOf' => $onBehalfOf,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
            ],
        );
    }

    /**
     * Downloads a caption track.
     *
     * Costs 200 units of quota.
     *
     * @param string $id The ID of the caption track to download, required for One Platform.
     * @param string|null $onBehalfOf ID of the Google+ Page for the channel that the request is be on
     *     behalf of
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The actual CMS account that the user authenticates with must be linked to
     *     the specified YouTube content owner.
     * @param string|null $tfmt Convert the captions into this format. Supported options are sbv, srt, and
     *     vtt.
     * @param string|null $tlang tlang is the language code; machine translate the captions into this
     *     language.
     *
     * @return PromiseInterface<string> The file.
     *
     * @link https://developers.google.com/youtube/v3/docs/captions/download
     *
     * @since 1.0.0
     */
    public function download(
        string $id,
        ?string $onBehalfOf = null,
        ?string $onBehalfOfContentOwner = null,
        ?string $tfmt = null,
        ?string $tlang = null,
    ): PromiseInterface {
        return $this->call(
            'captions.download',
            'GET',
            'youtube/v3/captions/' . rawurlencode($id),
            query: [
                'onBehalfOf' => $onBehalfOf,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'tfmt' => $tfmt,
                'tlang' => $tlang,
            ],
            download: true,
        );
    }

    /**
     * Inserts a new resource into this collection.
     *
     * Costs 400 units of quota.
     *
     * @param list<string>|string $part The *part* parameter specifies the caption resource parts that the
     *     API response will include. Set the parameter value to snippet.
     * @param \YouTube\Parts\Caption|array<string, mixed> $body The Caption to send.
     * @param Media|null $media The file to upload: text/xml, application/octet-stream, *\/*, up to 100 MB.
     *     Sent in the same request as the metadata.
     * @param string|null $onBehalfOf ID of the Google+ Page for the channel that the request is be on
     *     behalf of
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The actual CMS account that the user authenticates with must be linked to
     *     the specified YouTube content owner.
     * @param bool|null $sync Extra parameter to allow automatically syncing the uploaded
     *     caption/transcript with the audio.
     *
     * @return PromiseInterface<\YouTube\Parts\Caption>
     *
     * @link https://developers.google.com/youtube/v3/docs/captions/insert
     *
     * @since 1.0.0
     */
    public function insert(
        array|string $part,
        array|\JsonSerializable $body,
        ?Media $media = null,
        ?string $onBehalfOf = null,
        ?string $onBehalfOfContentOwner = null,
        ?bool $sync = null,
    ): PromiseInterface {
        return $this->call(
            'captions.insert',
            'POST',
            'youtube/v3/captions',
            query: [
                'part' => $part,
                'onBehalfOf' => $onBehalfOf,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'sync' => $sync,
            ],
            body: $body,
            returns: 'Caption',
            media: $media,
            uploadPath: '/upload/youtube/v3/captions',
        );
    }

    /**
     * Retrieves a list of resources, possibly filtered.
     *
     * Costs 50 units of quota.
     *
     * @param list<string>|string $part The *part* parameter specifies a comma-separated list of one or
     *     more caption resource parts that the API response will include. The part names that you can include
     *     in the parameter value are id and snippet.
     * @param string $videoId Returns the captions for the specified video.
     * @param list<string>|string|null $id Returns the captions with the given IDs for Stubby or Apiary.
     * @param string|null $onBehalfOf ID of the Google+ Page for the channel that the request is on behalf
     *     of.
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The actual CMS account that the user authenticates with must be linked to
     *     the specified YouTube content owner.
     *
     * @return PromiseInterface<\YouTube\Parts\CaptionListResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/captions/list
     *
     * @since 1.0.0
     */
    public function list(
        array|string $part,
        string $videoId,
        array|string|null $id = null,
        ?string $onBehalfOf = null,
        ?string $onBehalfOfContentOwner = null,
    ): PromiseInterface {
        return $this->call(
            'captions.list',
            'GET',
            'youtube/v3/captions',
            query: [
                'part' => $part,
                'videoId' => $videoId,
                'id' => $id,
                'onBehalfOf' => $onBehalfOf,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
            ],
            returns: 'CaptionListResponse',
        );
    }

    /**
     * Updates an existing resource.
     *
     * Costs 450 units of quota.
     *
     * @param list<string>|string $part The *part* parameter specifies a comma-separated list of one or
     *     more caption resource parts that the API response will include. The part names that you can include
     *     in the parameter value are id and snippet.
     * @param \YouTube\Parts\Caption|array<string, mixed> $body The Caption to send.
     * @param Media|null $media The file to upload: text/xml, application/octet-stream, *\/*, up to 100 MB.
     *     Sent in the same request as the metadata.
     * @param string|null $onBehalfOf ID of the Google+ Page for the channel that the request is on behalf
     *     of.
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The actual CMS account that the user authenticates with must be linked to
     *     the specified YouTube content owner.
     * @param bool|null $sync Extra parameter to allow automatically syncing the uploaded
     *     caption/transcript with the audio.
     *
     * @return PromiseInterface<\YouTube\Parts\Caption>
     *
     * @link https://developers.google.com/youtube/v3/docs/captions/update
     *
     * @since 1.0.0
     */
    public function update(
        array|string $part,
        array|\JsonSerializable $body,
        ?Media $media = null,
        ?string $onBehalfOf = null,
        ?string $onBehalfOfContentOwner = null,
        ?bool $sync = null,
    ): PromiseInterface {
        return $this->call(
            'captions.update',
            'PUT',
            'youtube/v3/captions',
            query: [
                'part' => $part,
                'onBehalfOf' => $onBehalfOf,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'sync' => $sync,
            ],
            body: $body,
            returns: 'Caption',
            media: $media,
            uploadPath: '/upload/youtube/v3/captions',
        );
    }
}
