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
 * @property bool|null $alcoholContent Indicates whether or not the video has alcoholic beverage content. Only
 *     users of legal purchasing age in a particular country, as identified by ICAP, can view the content.
 * @property bool|null $restricted Age-restricted trailers. For redband trailers and adult-rated video-games.
 *     Only users aged 18+ can view the content. The the field is true the content is restricted to viewers aged 18+.
 *     Otherwise The field won't be present.
 * @property string|null $videoGameRating Video game rating, if any. One of the `VIDEO_GAME_RATING_*` constants.
 *
 * @since 1.0.0
 */
class VideoAgeGating extends Part
{
    /** A `videoGameRating` of `anyone`. */
    public const VIDEO_GAME_RATING_ANYONE = 'anyone';

    /** A `videoGameRating` of `m15Plus`. */
    public const VIDEO_GAME_RATING_M15_PLUS = 'm15Plus';

    /** A `videoGameRating` of `m16Plus`. */
    public const VIDEO_GAME_RATING_M16_PLUS = 'm16Plus';

    /** A `videoGameRating` of `m17Plus`. */
    public const VIDEO_GAME_RATING_M17_PLUS = 'm17Plus';
}
