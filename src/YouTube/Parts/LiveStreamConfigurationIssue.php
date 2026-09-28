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
 * @property string|null $description The long-form description of the issue and how to resolve it.
 * @property string|null $reason The short-form reason for this issue.
 * @property string|null $severity How severe this issue is to the stream. One of the `SEVERITY_*` constants.
 * @property string|null $type The kind of error happening. One of the `TYPE_*` constants.
 *
 * @since 1.0.0
 */
class LiveStreamConfigurationIssue extends Part
{
    /** A `severity` of `info`. */
    public const SEVERITY_INFO = 'info';

    /** A `severity` of `warning`. */
    public const SEVERITY_WARNING = 'warning';

    /** A `severity` of `error`. */
    public const SEVERITY_ERROR = 'error';

    /** A `type` of `gopSizeOver`. */
    public const TYPE_GOP_SIZE_OVER = 'gopSizeOver';

    /** A `type` of `gopSizeLong`. */
    public const TYPE_GOP_SIZE_LONG = 'gopSizeLong';

    /** A `type` of `gopSizeShort`. */
    public const TYPE_GOP_SIZE_SHORT = 'gopSizeShort';

    /** A `type` of `openGop`. */
    public const TYPE_OPEN_GOP = 'openGop';

    /** A `type` of `badContainer`. */
    public const TYPE_BAD_CONTAINER = 'badContainer';

    /** A `type` of `audioBitrateHigh`. */
    public const TYPE_AUDIO_BITRATE_HIGH = 'audioBitrateHigh';

    /** A `type` of `audioBitrateLow`. */
    public const TYPE_AUDIO_BITRATE_LOW = 'audioBitrateLow';

    /** A `type` of `audioSampleRate`. */
    public const TYPE_AUDIO_SAMPLE_RATE = 'audioSampleRate';

    /** A `type` of `bitrateHigh`. */
    public const TYPE_BITRATE_HIGH = 'bitrateHigh';

    /** A `type` of `bitrateLow`. */
    public const TYPE_BITRATE_LOW = 'bitrateLow';

    /** A `type` of `audioCodec`. */
    public const TYPE_AUDIO_CODEC = 'audioCodec';

    /** A `type` of `videoCodec`. */
    public const TYPE_VIDEO_CODEC = 'videoCodec';

    /** A `type` of `noAudioStream`. */
    public const TYPE_NO_AUDIO_STREAM = 'noAudioStream';

    /** A `type` of `noVideoStream`. */
    public const TYPE_NO_VIDEO_STREAM = 'noVideoStream';

    /** A `type` of `multipleVideoStreams`. */
    public const TYPE_MULTIPLE_VIDEO_STREAMS = 'multipleVideoStreams';

    /** A `type` of `multipleAudioStreams`. */
    public const TYPE_MULTIPLE_AUDIO_STREAMS = 'multipleAudioStreams';

    /** A `type` of `audioTooManyChannels`. */
    public const TYPE_AUDIO_TOO_MANY_CHANNELS = 'audioTooManyChannels';

    /** A `type` of `interlacedVideo`. */
    public const TYPE_INTERLACED_VIDEO = 'interlacedVideo';

    /** A `type` of `frameRateHigh`. */
    public const TYPE_FRAME_RATE_HIGH = 'frameRateHigh';

    /** A `type` of `resolutionMismatch`. */
    public const TYPE_RESOLUTION_MISMATCH = 'resolutionMismatch';

    /** A `type` of `videoCodecMismatch`. */
    public const TYPE_VIDEO_CODEC_MISMATCH = 'videoCodecMismatch';

    /** A `type` of `videoInterlaceMismatch`. */
    public const TYPE_VIDEO_INTERLACE_MISMATCH = 'videoInterlaceMismatch';

    /** A `type` of `videoProfileMismatch`. */
    public const TYPE_VIDEO_PROFILE_MISMATCH = 'videoProfileMismatch';

    /** A `type` of `videoBitrateMismatch`. */
    public const TYPE_VIDEO_BITRATE_MISMATCH = 'videoBitrateMismatch';

    /** A `type` of `framerateMismatch`. */
    public const TYPE_FRAMERATE_MISMATCH = 'framerateMismatch';

    /** A `type` of `gopMismatch`. */
    public const TYPE_GOP_MISMATCH = 'gopMismatch';

    /** A `type` of `audioSampleRateMismatch`. */
    public const TYPE_AUDIO_SAMPLE_RATE_MISMATCH = 'audioSampleRateMismatch';

    /** A `type` of `audioStereoMismatch`. */
    public const TYPE_AUDIO_STEREO_MISMATCH = 'audioStereoMismatch';

    /** A `type` of `audioCodecMismatch`. */
    public const TYPE_AUDIO_CODEC_MISMATCH = 'audioCodecMismatch';

    /** A `type` of `audioBitrateMismatch`. */
    public const TYPE_AUDIO_BITRATE_MISMATCH = 'audioBitrateMismatch';

    /** A `type` of `videoResolutionSuboptimal`. */
    public const TYPE_VIDEO_RESOLUTION_SUBOPTIMAL = 'videoResolutionSuboptimal';

    /** A `type` of `videoResolutionUnsupported`. */
    public const TYPE_VIDEO_RESOLUTION_UNSUPPORTED = 'videoResolutionUnsupported';

    /** A `type` of `videoIngestionStarved`. */
    public const TYPE_VIDEO_INGESTION_STARVED = 'videoIngestionStarved';

    /** A `type` of `videoIngestionFasterThanRealtime`. */
    public const TYPE_VIDEO_INGESTION_FASTER_THAN_REALTIME = 'videoIngestionFasterThanRealtime';
}
