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
 * A `__videoAbuseReportReason__` resource identifies a reason that a video could be reported as
 * abusive. Video abuse report reasons are used with `video.ReportAbuse`.
 *
 * @property string|null $etag Etag of this resource.
 * @property string|null $id The ID of this abuse report reason.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     `"youtube#videoAbuseReportReason"`.
 * @property \YouTube\Parts\VideoAbuseReportReasonSnippet|null $snippet The `snippet` object contains basic
 *     details about the abuse report reason.
 *
 * @link https://developers.google.com/youtube/v3/docs/videoAbuseReportReasons
 *
 * @since 1.0.0
 */
class VideoAbuseReportReason extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'snippet' => 'VideoAbuseReportReasonSnippet',
    ];
}
