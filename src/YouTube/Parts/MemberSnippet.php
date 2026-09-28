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
 * @property string|null $creatorChannelId The id of the channel that's offering memberships.
 * @property \YouTube\Parts\ChannelProfileDetails|null $memberDetails Details about the member.
 * @property \YouTube\Parts\MembershipsDetails|null $membershipsDetails Details about the user's membership.
 *
 * @since 1.0.0
 */
class MemberSnippet extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'memberDetails' => 'ChannelProfileDetails',
        'membershipsDetails' => 'MembershipsDetails',
    ];
}
