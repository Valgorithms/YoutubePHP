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
 * Details about the content of a YouTube Video.
 *
 * @property string|null $caption The value of captions indicates whether the video has captions or not. One of
 *     the `CAPTION_*` constants.
 * @property \YouTube\Parts\ContentRating|null $contentRating Specifies the ratings that the video received under
 *     various rating schemes.
 * @property \YouTube\Parts\AccessPolicy|null $countryRestriction The countryRestriction object contains
 *     information about the countries where a video is (or is not) viewable.
 * @property string|null $definition The value of definition indicates whether the video is available in high
 *     definition or only in standard definition. One of the `DEFINITION_*` constants.
 * @property string|null $dimension The value of dimension indicates whether the video is available in 3D or in
 *     2D.
 * @property string|null $duration The length of the video. The tag value is an ISO 8601 duration in the format
 *     PT#M#S, in which the letters PT indicate that the value specifies a period of time, and the letters M and S
 *     refer to length in minutes and seconds, respectively. The # characters preceding the M and S letters are both
 *     integers that specify the number of minutes (or seconds) of the video. For example, a value of PT15M51S
 *     indicates that the video is 15 minutes and 51 seconds long.
 * @property bool|null $hasCustomThumbnail Indicates whether the video uploader has provided a custom thumbnail
 *     image for the video. This property is only visible to the video uploader.
 * @property bool|null $licensedContent The value of is_license_content indicates whether the video is licensed
 *     content.
 * @property string|null $projection Specifies the projection format of the video. One of the `PROJECTION_*`
 *     constants.
 * @property \YouTube\Parts\VideoContentDetailsRegionRestriction|null $regionRestriction Deprecated. The
 *     regionRestriction object contains information about the countries where a video is (or is not) viewable. The
 *     object will contain either the contentDetails.regionRestriction.allowed property or the
 *     contentDetails.regionRestriction.blocked property.
 *
 * @since 1.0.0
 */
class VideoContentDetails extends Part
{
    /** A `caption` of `true`. */
    public const CAPTION_TRUE = 'true';

    /** A `caption` of `false`. */
    public const CAPTION_FALSE = 'false';

    /** sd */
    public const DEFINITION_SD = 'sd';

    /** hd */
    public const DEFINITION_HD = 'hd';

    /** A `projection` of `rectangular`. */
    public const PROJECTION_RECTANGULAR = 'rectangular';

    /** A `projection` of `360`. */
    public const PROJECTION_360 = '360';

    /** @var array<string, string> */
    protected array $casts = [
        'contentRating' => 'ContentRating',
        'countryRestriction' => 'AccessPolicy',
        'regionRestriction' => 'VideoContentDetailsRegionRestriction',
    ];
}
