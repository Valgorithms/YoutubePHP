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
 * A *liveBroadcast* resource represents an event that will be streamed, via live video, on YouTube.
 *
 * @property \YouTube\Parts\LiveBroadcastContentDetails|null $contentDetails The contentDetails object contains
 *     information about the event's video content, such as whether the content can be shown in an embedded video
 *     player or if it will be archived and therefore available for viewing after the event has concluded.
 * @property string|null $etag Etag of this resource.
 * @property string|null $id The ID that YouTube assigns to uniquely identify the broadcast.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#liveBroadcast".
 * @property \YouTube\Parts\LiveBroadcastMonetizationDetails|null $monetizationDetails The monetizationDetails
 *     object contains information about the event's monetization details.
 * @property \YouTube\Parts\LiveBroadcastSnippet|null $snippet The snippet object contains basic details about
 *     the event, including its title, description, start time, and end time.
 * @property \YouTube\Parts\LiveBroadcastStatistics|null $statistics The statistics object contains info about
 *     the event's current stats. These include concurrent viewers and total chat count. Statistics can change (in
 *     either direction) during the lifetime of an event. Statistics are only returned while the event is live.
 * @property \YouTube\Parts\LiveBroadcastStatus|null $status The status object contains information about the
 *     event's status.
 *
 * @link https://developers.google.com/youtube/v3/live/docs/liveBroadcasts
 *
 * @since 1.0.0
 */
class LiveBroadcast extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'contentDetails' => 'LiveBroadcastContentDetails',
        'monetizationDetails' => 'LiveBroadcastMonetizationDetails',
        'snippet' => 'LiveBroadcastSnippet',
        'statistics' => 'LiveBroadcastStatistics',
        'status' => 'LiveBroadcastStatus',
    ];
}
