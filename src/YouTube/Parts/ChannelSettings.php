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
 * Branding properties for the channel view.
 *
 * @property string|null $country The country of the channel.
 * @property string|null $defaultLanguage
 * @property string|null $defaultTab Deprecated. Which content tab users should see when viewing the channel.
 * @property string|null $description Specifies the channel description.
 * @property string|null $featuredChannelsTitle Deprecated. Title for the featured channels tab.
 * @property list<string>|null $featuredChannelsUrls Deprecated. The list of featured channels.
 * @property string|null $keywords Lists keywords associated with the channel, comma-separated.
 * @property bool|null $moderateComments Deprecated. Whether user-submitted comments left on the channel page
 *     need to be approved by the channel owner to be publicly visible.
 * @property string|null $profileColor Deprecated. A prominent color that can be rendered on this channel page.
 * @property bool|null $showBrowseView Deprecated. Whether the tab to browse the videos should be displayed.
 * @property bool|null $showRelatedChannels Deprecated. Whether related channels should be proposed.
 * @property string|null $title Specifies the channel title.
 * @property string|null $trackingAnalyticsAccountId The ID for a Google Analytics account to track and measure
 *     traffic to the channels.
 * @property string|null $unsubscribedTrailer The trailer of the channel, for users that are not subscribers.
 *
 * @since 1.0.0
 */
class ChannelSettings extends Part
{
}
