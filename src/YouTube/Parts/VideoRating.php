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
 * Basic details about rating of a video.
 *
 * @property string|null $rating Rating of a video. One of the `RATING_*` constants.
 * @property string|null $videoId The ID that YouTube uses to uniquely identify the video.
 *
 * @since 1.0.0
 */
class VideoRating extends Part
{
    /** The entity has not been rated. */
    public const RATING_NONE = 'none';

    /** The entity is liked. */
    public const RATING_LIKE = 'like';

    /** The entity is disliked. */
    public const RATING_DISLIKE = 'dislike';
}
