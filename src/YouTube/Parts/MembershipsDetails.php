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
 * @property list<string>|null $accessibleLevels Ids of all levels that the user has access to. This includes the
 *     currently active level and all other levels that are included because of a higher purchase.
 * @property string|null $highestAccessibleLevel Id of the highest level that the user has access to at the
 *     moment.
 * @property string|null $highestAccessibleLevelDisplayName Display name for the highest level that the user has
 *     access to at the moment.
 * @property \YouTube\Parts\MembershipsDuration|null $membershipsDuration Data about memberships duration without
 *     taking into consideration pricing levels.
 * @property \Discord\Helpers\Collection<\YouTube\Parts\MembershipsDurationAtLevel>|null
 *     $membershipsDurationAtLevels Data about memberships duration on particular pricing levels.
 *
 * @since 1.0.0
 */
class MembershipsDetails extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'membershipsDuration' => 'MembershipsDuration',
        'membershipsDurationAtLevels' => 'Array of MembershipsDurationAtLevel',
    ];
}
