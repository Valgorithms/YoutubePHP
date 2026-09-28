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
 * A single tag suggestion with its relevance information.
 *
 * @property list<string>|null $categoryRestricts A set of video categories for which the tag is relevant. You
 *     can use this information to display appropriate tag suggestions based on the video category that the video
 *     uploader associates with the video. By default, tag suggestions are relevant for all categories if there are
 *     no restricts defined for the keyword.
 * @property string|null $tag The keyword tag suggested for the video.
 *
 * @since 1.0.0
 */
class VideoSuggestionsTagSuggestion extends Part
{
}
