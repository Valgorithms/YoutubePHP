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
 * Specifies suggestions on how to improve video content, including encoding hints, tag suggestions,
 * and editor suggestions.
 *
 * @property list<string>|null $editorSuggestions A list of video editing operations that might improve the video
 *     quality or playback experience of the uploaded video.
 * @property list<string>|null $processingErrors A list of errors that will prevent YouTube from successfully
 *     processing the uploaded video video. These errors indicate that, regardless of the video's current processing
 *     status, eventually, that status will almost certainly be failed.
 * @property list<string>|null $processingHints A list of suggestions that may improve YouTube's ability to
 *     process the video.
 * @property list<string>|null $processingWarnings A list of reasons why YouTube may have difficulty transcoding
 *     the uploaded video or that might result in an erroneous transcoding. These warnings are generated before
 *     YouTube actually processes the uploaded video file. In addition, they identify issues that are unlikely to
 *     cause the video processing to fail but that might cause problems such as sync issues, video artifacts, or a
 *     missing audio track.
 * @property \Discord\Helpers\Collection<\YouTube\Parts\VideoSuggestionsTagSuggestion>|null $tagSuggestions A
 *     list of keyword tags that could be added to the video's metadata to increase the likelihood that users will
 *     locate your video when searching or browsing on YouTube.
 *
 * @since 1.0.0
 */
class VideoSuggestions extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'tagSuggestions' => 'Array of VideoSuggestionsTagSuggestion',
    ];
}
