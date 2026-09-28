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
 * A live stream describes a live ingestion point.
 *
 * @property \YouTube\Parts\CdnSettings|null $cdn The cdn object defines the live stream's content delivery
 *     network (CDN) settings. These settings provide details about the manner in which you stream your content to
 *     YouTube.
 * @property \YouTube\Parts\LiveStreamContentDetails|null $contentDetails The content_details object contains
 *     information about the stream, including the closed captions ingestion URL.
 * @property string|null $etag Etag of this resource.
 * @property string|null $id The ID that YouTube assigns to uniquely identify the stream.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#liveStream".
 * @property \YouTube\Parts\LiveStreamSnippet|null $snippet The snippet object contains basic details about the
 *     stream, including its channel, title, and description.
 * @property \YouTube\Parts\LiveStreamStatus|null $status The status object contains information about live
 *     stream's status.
 *
 * @link https://developers.google.com/youtube/v3/live/docs/liveStreams
 *
 * @since 1.0.0
 */
class LiveStream extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'cdn' => 'CdnSettings',
        'contentDetails' => 'LiveStreamContentDetails',
        'snippet' => 'LiveStreamSnippet',
        'status' => 'LiveStreamStatus',
    ];
}
