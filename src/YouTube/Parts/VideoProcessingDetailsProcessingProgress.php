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
 * Video processing progress and completion time estimate.
 *
 * @property string|null $partsProcessed The number of parts of the video that YouTube has already processed. You
 *     can estimate the percentage of the video that YouTube has already processed by calculating: 100 *
 *     parts_processed / parts_total Note that since the estimated number of parts could increase without a
 *     corresponding increase in the number of parts that have already been processed, it is possible that the
 *     calculated progress could periodically decrease while YouTube processes a video. A 64-bit number, as a string.
 * @property string|null $partsTotal An estimate of the total number of parts that need to be processed for the
 *     video. The number may be updated with more precise estimates while YouTube processes the video. A 64-bit
 *     number, as a string.
 * @property string|null $timeLeftMs An estimate of the amount of time, in millseconds, that YouTube needs to
 *     finish processing the video. A 64-bit number, as a string.
 *
 * @since 1.0.0
 */
class VideoProcessingDetailsProcessingProgress extends Part
{
}
