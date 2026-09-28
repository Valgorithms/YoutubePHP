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
 * @property string|null $memberSince The date and time when the user became a continuous member across all
 *     levels.
 * @property int|null $memberTotalDurationMonths The cumulative time the user has been a member across all levels
 *     in complete months (the time is rounded down to the nearest integer).
 *
 * @since 1.0.0
 */
class MembershipsDuration extends Part
{
}
