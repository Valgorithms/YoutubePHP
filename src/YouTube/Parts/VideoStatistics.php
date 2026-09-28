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
 * Statistics about the video, such as the number of times the video was viewed or liked.
 *
 * @property string|null $commentCount The number of comments for the video. A 64-bit number, as a string.
 * @property string|null $dislikeCount The number of users who have indicated that they disliked the video by
 *     giving it a negative rating. A 64-bit number, as a string.
 * @property string|null $favoriteCount Deprecated. The number of users who currently have the video marked as a
 *     favorite video. A 64-bit number, as a string.
 * @property string|null $likeCount The number of users who have indicated that they liked the video by giving it
 *     a positive rating. A 64-bit number, as a string.
 * @property string|null $viewCount The number of times the video has been viewed. A 64-bit number, as a string.
 *
 * @since 1.0.0
 */
class VideoStatistics extends Part
{
}
