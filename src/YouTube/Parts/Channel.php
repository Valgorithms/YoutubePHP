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
 * A *channel* resource contains information about a YouTube channel.
 *
 * @property \YouTube\Parts\ChannelAuditDetails|null $auditDetails The auditionDetails object encapsulates
 *     channel data that is relevant for YouTube Partners during the audition process.
 * @property \YouTube\Parts\ChannelBrandingSettings|null $brandingSettings The brandingSettings object
 *     encapsulates information about the branding of the channel.
 * @property \YouTube\Parts\ChannelContentDetails|null $contentDetails The contentDetails object encapsulates
 *     information about the channel's content.
 * @property \YouTube\Parts\ChannelContentOwnerDetails|null $contentOwnerDetails The contentOwnerDetails object
 *     encapsulates channel data that is relevant for YouTube Partners linked with the channel.
 * @property \YouTube\Parts\ChannelConversionPings|null $conversionPings Deprecated. The conversionPings object
 *     encapsulates information about conversion pings that need to be respected by the channel.
 * @property string|null $etag Etag of this resource.
 * @property string|null $id The ID that YouTube uses to uniquely identify the channel.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#channel".
 * @property array<string, \YouTube\Parts\ChannelLocalization>|null $localizations Localizations for different
 *     languages
 * @property \YouTube\Parts\ChannelSnippet|null $snippet The snippet object contains basic details about the
 *     channel, such as its title, description, and thumbnail images.
 * @property \YouTube\Parts\ChannelStatistics|null $statistics The statistics object encapsulates statistics for
 *     the channel.
 * @property \YouTube\Parts\ChannelStatus|null $status The status object encapsulates information about the
 *     privacy status of the channel.
 * @property \YouTube\Parts\ChannelTopicDetails|null $topicDetails The topicDetails object encapsulates
 *     information about Freebase topics associated with the channel.
 *
 * @link https://developers.google.com/youtube/v3/docs/channels
 *
 * @since 1.0.0
 */
class Channel extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'auditDetails' => 'ChannelAuditDetails',
        'brandingSettings' => 'ChannelBrandingSettings',
        'contentDetails' => 'ChannelContentDetails',
        'contentOwnerDetails' => 'ChannelContentOwnerDetails',
        'conversionPings' => 'ChannelConversionPings',
        'localizations' => 'Map of ChannelLocalization',
        'snippet' => 'ChannelSnippet',
        'statistics' => 'ChannelStatistics',
        'status' => 'ChannelStatus',
        'topicDetails' => 'ChannelTopicDetails',
    ];
}
