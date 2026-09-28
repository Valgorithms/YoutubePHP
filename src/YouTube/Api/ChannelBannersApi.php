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
 * Uploading a channel's banner image.
 *
 * Reach it as `$youtube->channelBanners`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/docs/channelBanners
 *
 * @since 1.0.0
 */
final class ChannelBannersApi extends AbstractApi
{
    /**
     * Inserts a new resource into this collection.
     *
     * Costs 50 units of quota.
     *
     * @param \YouTube\Parts\ChannelBannerResource|array<string, mixed> $body The ChannelBannerResource to
     *     send.
     * @param Media|null $media The file to upload: image/jpeg, image/png, application/octet-stream, up to
     *     6 MB. Sent in the same request as the metadata.
     * @param string|null $channelId Unused, channel_id is currently derived from the security context of
     *     the requestor.
     * @param string|null $onBehalfOfContentOwner *Note:* This parameter is intended exclusively for
     *     YouTube content partners. The *onBehalfOfContentOwner* parameter indicates that the request's
     *     authorization credentials identify a YouTube CMS user who is acting on behalf of the content owner
     *     specified in the parameter value. This parameter is intended for YouTube content partners that own
     *     and manage many different YouTube channels. It allows content owners to authenticate once and get
     *     access to all their video and channel data, without having to provide authentication credentials for
     *     each individual channel. The actual CMS account that the user authenticates with must be linked to
     *     the specified YouTube content owner.
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
     * @return PromiseInterface<\YouTube\Parts\ChannelBannerResource>
     *
     * @link https://developers.google.com/youtube/v3/docs/channelBanners/insert
     *
     * @since 1.0.0
     */
    public function insert(
        array|\JsonSerializable $body,
        ?Media $media = null,
        ?string $channelId = null,
        ?string $onBehalfOfContentOwner = null,
        ?string $onBehalfOfContentOwnerChannel = null,
    ): PromiseInterface {
        return $this->call(
            'channelBanners.insert',
            'POST',
            'youtube/v3/channelBanners/insert',
            query: [
                'channelId' => $channelId,
                'onBehalfOfContentOwner' => $onBehalfOfContentOwner,
                'onBehalfOfContentOwnerChannel' => $onBehalfOfContentOwnerChannel,
            ],
            body: $body,
            returns: 'ChannelBannerResource',
            media: $media,
            uploadPath: '/upload/youtube/v3/channelBanners/insert',
        );
    }
}
