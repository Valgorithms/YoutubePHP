<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Parts;

/**
 * This file is generated from spec/discovery.json (YouTube Data API v3, revision 20260924) by
 * tools/generate.php. Do not edit it by hand - run `composer spec:build` instead.
 *
 * A resource id is a generic reference that points to another YouTube resource.
 *
 * @property string|null $channelId The ID that YouTube uses to uniquely identify the referred resource, if that
 *     resource is a channel. This property is only present if the resourceId.kind value is youtube#channel.
 * @property string|null $kind The type of the API resource.
 * @property string|null $playlistId The ID that YouTube uses to uniquely identify the referred resource, if that
 *     resource is a playlist. This property is only present if the resourceId.kind value is youtube#playlist.
 * @property string|null $videoId The ID that YouTube uses to uniquely identify the referred resource, if that
 *     resource is a video. This property is only present if the resourceId.kind value is youtube#video.
 *
 * @since 1.0.0
 */
class ResourceId extends Part
{
}
