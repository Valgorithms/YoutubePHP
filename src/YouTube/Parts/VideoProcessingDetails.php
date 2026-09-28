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
 * Describes processing status and progress and availability of some other Video resource parts.
 *
 * @property string|null $editorSuggestionsAvailability This value indicates whether video editing suggestions,
 *     which might improve video quality or the playback experience, are available for the video. You can retrieve
 *     these suggestions by requesting the suggestions part in your videos.list() request.
 * @property string|null $fileDetailsAvailability This value indicates whether file details are available for the
 *     uploaded video. You can retrieve a video's file details by requesting the fileDetails part in your
 *     videos.list() request.
 * @property string|null $processingFailureReason The reason that YouTube failed to process the video. This
 *     property will only have a value if the processingStatus property's value is failed. One of the
 *     `PROCESSING_FAILURE_REASON_*` constants.
 * @property string|null $processingIssuesAvailability This value indicates whether the video processing engine
 *     has generated suggestions that might improve YouTube's ability to process the the video, warnings that explain
 *     video processing problems, or errors that cause video processing problems. You can retrieve these suggestions
 *     by requesting the suggestions part in your videos.list() request.
 * @property \YouTube\Parts\VideoProcessingDetailsProcessingProgress|null $processingProgress The
 *     processingProgress object contains information about the progress YouTube has made in processing the video.
 *     The values are really only relevant if the video's processing status is processing.
 * @property string|null $processingStatus The video's processing status. This value indicates whether YouTube
 *     was able to process the video or if the video is still being processed. One of the `PROCESSING_STATUS_*`
 *     constants.
 * @property string|null $tagSuggestionsAvailability This value indicates whether keyword (tag) suggestions are
 *     available for the video. Tags can be added to a video's metadata to make it easier for other users to find the
 *     video. You can retrieve these suggestions by requesting the suggestions part in your videos.list() request.
 * @property string|null $thumbnailsAvailability This value indicates whether thumbnail images have been
 *     generated for the video.
 *
 * @since 1.0.0
 */
class VideoProcessingDetails extends Part
{
    /** A `processingFailureReason` of `uploadFailed`. */
    public const PROCESSING_FAILURE_REASON_UPLOAD_FAILED = 'uploadFailed';

    /** A `processingFailureReason` of `transcodeFailed`. */
    public const PROCESSING_FAILURE_REASON_TRANSCODE_FAILED = 'transcodeFailed';

    /** A `processingFailureReason` of `streamingFailed`. */
    public const PROCESSING_FAILURE_REASON_STREAMING_FAILED = 'streamingFailed';

    /** A `processingFailureReason` of `other`. */
    public const PROCESSING_FAILURE_REASON_OTHER = 'other';

    /** A `processingStatus` of `processing`. */
    public const PROCESSING_STATUS_PROCESSING = 'processing';

    /** A `processingStatus` of `succeeded`. */
    public const PROCESSING_STATUS_SUCCEEDED = 'succeeded';

    /** A `processingStatus` of `failed`. */
    public const PROCESSING_STATUS_FAILED = 'failed';

    /** A `processingStatus` of `terminated`. */
    public const PROCESSING_STATUS_TERMINATED = 'terminated';

    /** @var array<string, string> */
    protected array $casts = [
        'processingProgress' => 'VideoProcessingDetailsProcessingProgress',
    ];
}
