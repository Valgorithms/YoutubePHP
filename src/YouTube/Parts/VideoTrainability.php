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
 * Specifies who is allowed to train on the video.
 *
 * @property string|null $etag Etag of this resource.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#videoTrainability".
 * @property list<string>|null $permitted Specifies who is allowed to train on the video. Valid values are: - a
 *     single string "all" - a single string "none" - a list of allowed parties
 * @property string|null $videoId The ID of the video.
 *
 * @since 1.0.0
 */
class VideoTrainability extends Part
{
}
