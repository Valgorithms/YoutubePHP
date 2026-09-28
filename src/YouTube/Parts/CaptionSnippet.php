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
 * Basic details about a caption track, such as its language and name.
 *
 * @property string|null $audioTrackType The type of audio track associated with the caption track. One of the
 *     `AUDIO_TRACK_TYPE_*` constants.
 * @property string|null $failureReason The reason that YouTube failed to process the caption track. This
 *     property is only present if the state property's value is failed. One of the `FAILURE_REASON_*` constants.
 * @property bool|null $isAutoSynced Indicates whether YouTube synchronized the caption track to the audio track
 *     in the video. The value will be true if a sync was explicitly requested when the caption track was uploaded.
 *     For example, when calling the captions.insert or captions.update methods, you can set the sync parameter to
 *     true to instruct YouTube to sync the uploaded track to the video. If the value is false, YouTube uses the time
 *     codes in the uploaded caption track to determine when to display captions.
 * @property bool|null $isCC Indicates whether the track contains closed captions for the deaf and hard of
 *     hearing. The default value is false.
 * @property bool|null $isDraft Indicates whether the caption track is a draft. If the value is true, then the
 *     track is not publicly visible. The default value is false. `@mutable` youtube.captions.insert
 *     youtube.captions.update
 * @property bool|null $isEasyReader Indicates whether caption track is formatted for "easy reader," meaning it
 *     is at a third-grade level for language learners. The default value is false.
 * @property bool|null $isLarge Indicates whether the caption track uses large text for the vision-impaired. The
 *     default value is false.
 * @property string|null $language The language of the caption track. The property value is a BCP-47 language
 *     tag.
 * @property \Carbon\CarbonImmutable|null $lastUpdated The date and time when the caption track was last updated.
 * @property string|null $name The name of the caption track. The name is intended to be visible to the user as
 *     an option during playback.
 * @property string|null $status The caption track's status. One of the `STATUS_*` constants.
 * @property string|null $trackKind The caption track's type. One of the `TRACK_KIND_*` constants.
 * @property string|null $videoId The ID that YouTube uses to uniquely identify the video associated with the
 *     caption track. `@mutable` youtube.captions.insert
 *
 * @since 1.0.0
 */
class CaptionSnippet extends Part
{
    /** A `audioTrackType` of `unknown`. */
    public const AUDIO_TRACK_TYPE_UNKNOWN = 'unknown';

    /** A `audioTrackType` of `primary`. */
    public const AUDIO_TRACK_TYPE_PRIMARY = 'primary';

    /** A `audioTrackType` of `commentary`. */
    public const AUDIO_TRACK_TYPE_COMMENTARY = 'commentary';

    /** A `audioTrackType` of `descriptive`. */
    public const AUDIO_TRACK_TYPE_DESCRIPTIVE = 'descriptive';

    /** A `failureReason` of `unknownFormat`. */
    public const FAILURE_REASON_UNKNOWN_FORMAT = 'unknownFormat';

    /** A `failureReason` of `unsupportedFormat`. */
    public const FAILURE_REASON_UNSUPPORTED_FORMAT = 'unsupportedFormat';

    /** A `failureReason` of `processingFailed`. */
    public const FAILURE_REASON_PROCESSING_FAILED = 'processingFailed';

    /** A `status` of `serving`. */
    public const STATUS_SERVING = 'serving';

    /** A `status` of `syncing`. */
    public const STATUS_SYNCING = 'syncing';

    /** A `status` of `failed`. */
    public const STATUS_FAILED = 'failed';

    /** A `trackKind` of `standard`. */
    public const TRACK_KIND_STANDARD = 'standard';

    /** A `trackKind` of `ASR`. */
    public const TRACK_KIND_ASR = 'ASR';

    /** A `trackKind` of `forced`. */
    public const TRACK_KIND_FORCED = 'forced';

    /** @var list<string> */
    protected array $dates = [
        'lastUpdated',
    ];
}
