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
 * @property string|null $comments Additional comments regarding the abuse report.
 * @property string|null $language The language that the content was viewed in.
 * @property string|null $reasonId The high-level, or primary, reason that the content is abusive. The value is
 *     an abuse report reason ID.
 * @property string|null $secondaryReasonId The specific, or secondary, reason that this content is abusive (if
 *     available). The value is an abuse report reason ID that is a valid secondary reason for the primary reason.
 * @property string|null $videoId The ID that YouTube uses to uniquely identify the video.
 *
 * @since 1.0.0
 */
class VideoAbuseReport extends Part
{
}
