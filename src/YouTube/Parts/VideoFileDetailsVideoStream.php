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
 * Information about a video stream.
 *
 * @property float|null $aspectRatio The video content's display aspect ratio, which specifies the aspect ratio
 *     in which the video should be displayed.
 * @property string|null $bitrateBps The video stream's bitrate, in bits per second. A 64-bit number, as a
 *     string.
 * @property string|null $codec The video codec that the stream uses.
 * @property float|null $frameRateFps The video stream's frame rate, in frames per second.
 * @property int|null $heightPixels The encoded video content's height in pixels.
 * @property string|null $rotation The amount that YouTube needs to rotate the original source content to
 *     properly display the video. One of the `ROTATION_*` constants.
 * @property string|null $vendor A value that uniquely identifies a video vendor. Typically, the value is a
 *     four-letter vendor code.
 * @property int|null $widthPixels The encoded video content's width in pixels. You can calculate the video's
 *     encoding aspect ratio as width_pixels / height_pixels.
 *
 * @since 1.0.0
 */
class VideoFileDetailsVideoStream extends Part
{
    /** A `rotation` of `none`. */
    public const ROTATION_NONE = 'none';

    /** A `rotation` of `clockwise`. */
    public const ROTATION_CLOCKWISE = 'clockwise';

    /** A `rotation` of `upsideDown`. */
    public const ROTATION_UPSIDE_DOWN = 'upsideDown';

    /** A `rotation` of `counterClockwise`. */
    public const ROTATION_COUNTER_CLOCKWISE = 'counterClockwise';

    /** A `rotation` of `other`. */
    public const ROTATION_OTHER = 'other';
}
