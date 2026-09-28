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
 * @property \YouTube\Parts\ChannelSectionContentDetails|null $contentDetails The contentDetails object contains
 *     details about the channel section content, such as a list of playlists or channels featured in the section.
 * @property string|null $etag Etag of this resource.
 * @property string|null $id The ID that YouTube uses to uniquely identify the channel section.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#channelSection".
 * @property array<string, \YouTube\Parts\ChannelSectionLocalization>|null $localizations Deprecated.
 *     Localizations for different languages
 * @property \YouTube\Parts\ChannelSectionSnippet|null $snippet The snippet object contains basic details about
 *     the channel section, such as its type, style and title.
 * @property \YouTube\Parts\ChannelSectionTargeting|null $targeting Deprecated. The targeting object contains
 *     basic targeting settings about the channel section.
 *
 * @link https://developers.google.com/youtube/v3/docs/channelSections
 *
 * @since 1.0.0
 */
class ChannelSection extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'contentDetails' => 'ChannelSectionContentDetails',
        'localizations' => 'Map of ChannelSectionLocalization',
        'snippet' => 'ChannelSectionSnippet',
        'targeting' => 'ChannelSectionTargeting',
    ];
}
