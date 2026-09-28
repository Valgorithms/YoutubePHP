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
 * Basic information about a third party account link, including its type and type-specific
 * information.
 *
 * @property \YouTube\Parts\ChannelToAffiliateProgramLinkDetails|null $channelToAffiliateProgramLink Information
 *     specific to a link between a channel and an affiliate program of a partner.
 * @property \YouTube\Parts\ChannelToStoreLinkDetails|null $channelToStoreLink Information specific to a link
 *     between a channel and a store on a merchandising platform.
 * @property string|null $type Type of the link named after the entities that are being linked. One of the
 *     `TYPE_*` constants.
 *
 * @since 1.0.0
 */
class ThirdPartyLinkSnippet extends Part
{
    /** A `type` of `linkUnspecified`. */
    public const TYPE_LINK_UNSPECIFIED = 'linkUnspecified';

    /**
     * A link that is connecting (or about to connect) a channel with a store on a merchandising platform
     * in order to enable retail commerce capabilities for that channel on YouTube.
     */
    public const TYPE_CHANNEL_TO_STORE_LINK = 'channelToStoreLink';

    /**
     * A link that is connecting (or about to connect) a channel with an affiliate program of a partner to
     * enable that channel to earn commissions from that partner through affiliate links.
     */
    public const TYPE_CHANNEL_TO_AFFILIATE_PROGRAM_LINK = 'channelToAffiliateProgramLink';

    /** @var array<string, string> */
    protected array $casts = [
        'channelToAffiliateProgramLink' => 'ChannelToAffiliateProgramLinkDetails',
        'channelToStoreLink' => 'ChannelToStoreLinkDetails',
    ];
}
