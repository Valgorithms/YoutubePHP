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
 * A channel's watermark image.
 *
 * Reach it as `$youtube->watermarks`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/watermarks
 *
 * @since 1.0.0
 */
final class WatermarksApi extends AbstractApi
{
    /**
     * Allows upload of watermark image and setting it for a channel.
     *
     * Costs 50 units of quota.
     *
     * @param string $channelId
     * @param \YouTube\Parts\InvideoBranding|array<string, mixed> $body The InvideoBranding to send.
     * @param Media|null $media The file to upload: image/jpeg, image/png, application/octet-stream, up to
     *     10 MB. Sent in the same request as the metadata.
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
     * @link https://developers.google.com/youtube/v3/docs/watermarks/set
     *
     * @since 1.0.0
     */
    public function set(
        string $channelId,
        array|\JsonSerializable $body,
        ?Media $media = null,
        ?string $onBehalfOfContentOwner = null,
    ): PromiseInterface {
        return $this->call(
            'watermarks.set',
            'POST',
            'youtube/v3/watermarks/set',
            query: [
                'channelId' => $channelId,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
            ],
            body: $body,
            media: $media,
            uploadPath: '/upload/youtube/v3/watermarks/set',
        );
    }

    /**
     * Allows removal of channel watermark.
     *
     * Costs 50 units of quota.
     *
     * @param string $channelId
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
     * @link https://developers.google.com/youtube/v3/docs/watermarks/unset
     *
     * @since 1.0.0
     */
    public function unset(
        string $channelId,
        ?string $onBehalfOfContentOwner = null,
    ): PromiseInterface {
        return $this->call(
            'watermarks.unset',
            'POST',
            'youtube/v3/watermarks/unset',
            query: [
                'channelId' => $channelId,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
            ],
        );
    }
}
