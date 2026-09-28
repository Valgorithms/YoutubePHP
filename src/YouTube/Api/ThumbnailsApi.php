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
 * Setting a video's custom thumbnail.
 *
 * Reach it as `$youtube->thumbnails`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/thumbnails
 *
 * @since 1.0.0
 */
final class ThumbnailsApi extends AbstractApi
{
    /**
     * As this is not an insert in a strict sense (it supports uploading/setting of a thumbnail for
     * multiple videos, which doesn't result in creation of a single resource), I use a custom verb here.
     *
     * Costs 50 units of quota.
     *
     * @param string $videoId Returns the Thumbnail with the given video IDs for Stubby or Apiary.
     * @param Media|null $media The file to upload: image/jpeg, image/png, application/octet-stream, up to
     *     50 MB. Sent in the same request as the metadata.
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The actual CMS account that the user authenticates with must be linked to
     *     the specified YouTube content owner.
     *
     * @return PromiseInterface<\YouTube\Parts\ThumbnailSetResponse>
     *
     * @link https://developers.google.com/youtube/v3/docs/thumbnails/set
     *
     * @since 1.0.0
     */
    public function set(
        string $videoId,
        ?Media $media = null,
        ?string $onBehalfOfContentOwner = null,
    ): PromiseInterface {
        return $this->call(
            'thumbnails.set',
            'POST',
            'youtube/v3/thumbnails/set',
            query: [
                'videoId' => $videoId,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
            ],
            returns: 'ThumbnailSetResponse',
            media: $media,
            uploadPath: '/upload/youtube/v3/thumbnails/set',
        );
    }
}
