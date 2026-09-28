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
 * Details about paid content, such as paid product placement, sponsorships or endorsement, contained
 * in a YouTube video and a method to inform viewers of paid promotion. This data can only be retrieved
 * by the video owner.
 *
 * @property bool|null $hasPaidProductPlacement This boolean represents whether the video contains Paid Product
 *     Placement, Studio equivalent: https://screenshot.googleplex.com/4Me79DE6AfT2ktp.png
 *
 * @since 1.0.0
 */
class VideoPaidProductPlacementDetails extends Part
{
}
