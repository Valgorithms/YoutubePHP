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
 * Describes the spatial position of a visual widget inside a video. It is a union of various position
 * types, out of which only will be set one.
 *
 * @property string|null $cornerPosition Describes in which corner of the video the visual widget will appear.
 *     One of the `CORNER_POSITION_*` constants.
 * @property string|null $type Defines the position type. One of the `TYPE_*` constants.
 *
 * @since 1.0.0
 */
class InvideoPosition extends Part
{
    /**
     * A `cornerPosition` of `topLeft`.
     *
     * @deprecated
     */
    public const CORNER_POSITION_TOP_LEFT = 'topLeft';

    /** A `cornerPosition` of `topRight`. */
    public const CORNER_POSITION_TOP_RIGHT = 'topRight';

    /**
     * A `cornerPosition` of `bottomLeft`.
     *
     * @deprecated
     */
    public const CORNER_POSITION_BOTTOM_LEFT = 'bottomLeft';

    /**
     * A `cornerPosition` of `bottomRight`.
     *
     * @deprecated
     */
    public const CORNER_POSITION_BOTTOM_RIGHT = 'bottomRight';

    /** A `type` of `corner`. */
    public const TYPE_CORNER = 'corner';
}
