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
 * DEPRECATED Region restriction of the video.
 *
 * @property list<string>|null $allowed A list of region codes that identify countries where the video is
 *     viewable. If this property is present and a country is not listed in its value, then the video is blocked from
 *     appearing in that country. If this property is present and contains an empty list, the video is blocked in all
 *     countries.
 * @property list<string>|null $blocked A list of region codes that identify countries where the video is
 *     blocked. If this property is present and a country is not listed in its value, then the video is viewable in
 *     that country. If this property is present and contains an empty list, the video is viewable in all countries.
 *
 * @since 1.0.0
 */
class VideoContentDetailsRegionRestriction extends Part
{
}
