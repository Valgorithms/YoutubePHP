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
 * The auditDetails object encapsulates channel data that is relevant for YouTube Partners during the
 * audit process.
 *
 * @property bool|null $communityGuidelinesGoodStanding Whether or not the channel respects the community
 *     guidelines.
 * @property bool|null $contentIdClaimsGoodStanding Whether or not the channel has any unresolved claims.
 * @property bool|null $copyrightStrikesGoodStanding Whether or not the channel has any copyright strikes.
 *
 * @since 1.0.0
 */
class ChannelAuditDetails extends Part
{
}
