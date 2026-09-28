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
 * Information about an audio stream.
 *
 * @property string|null $bitrateBps The audio stream's bitrate, in bits per second. A 64-bit number, as a
 *     string.
 * @property int|null $channelCount The number of audio channels that the stream contains.
 * @property string|null $codec The audio codec that the stream uses.
 * @property string|null $vendor A value that uniquely identifies a video vendor. Typically, the value is a
 *     four-letter vendor code.
 *
 * @since 1.0.0
 */
class VideoFileDetailsAudioStream extends Part
{
}
