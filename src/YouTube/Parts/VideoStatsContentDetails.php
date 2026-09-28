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
 * Details about the content of a YouTube Video. This is a subset of the information in
 * VideoContentDetails specifically for the Videos.stats API.
 *
 * @property string|null $duration Output only. The length of the video. The property value is a
 *     [`google.protobuf.Duration`](https://developers.google.com/protocol-buffers/docs/reference/google.protobuf#duration)
 *     object. Read-only.
 *
 * @since 1.0.0
 */
class VideoStatsContentDetails extends Part
{
}
