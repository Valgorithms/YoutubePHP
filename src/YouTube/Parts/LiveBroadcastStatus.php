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
 * Live broadcast state.
 *
 * @property string|null $lifeCycleStatus The broadcast's status. The status can be updated using the API's
 *     liveBroadcasts.transition method. One of the `LIFE_CYCLE_STATUS_*` constants.
 * @property string|null $liveBroadcastPriority Priority of the live broadcast event (internal state). One of the
 *     `LIVE_BROADCAST_PRIORITY_*` constants.
 * @property bool|null $madeForKids Whether the broadcast is made for kids or not, decided by YouTube instead of
 *     the creator. This field is read only.
 * @property string|null $privacyStatus The broadcast's privacy status. Note that the broadcast represents
 *     exactly one YouTube video, so the privacy settings are identical to those supported for videos. In addition,
 *     you can set this field by modifying the broadcast resource or by setting the privacyStatus field of the
 *     corresponding video resource. One of the `PRIVACY_STATUS_*` constants.
 * @property string|null $recordingStatus The broadcast's recording status. One of the `RECORDING_STATUS_*`
 *     constants.
 * @property bool|null $selfDeclaredMadeForKids This field will be set to True if the creator declares the
 *     broadcast to be kids only: go/live-cw-work.
 *
 * @since 1.0.0
 */
class LiveBroadcastStatus extends Part
{
    /** No value or the value is unknown. */
    public const LIFE_CYCLE_STATUS_LIFE_CYCLE_STATUS_UNSPECIFIED = 'lifeCycleStatusUnspecified';

    /** Incomplete settings, but otherwise valid */
    public const LIFE_CYCLE_STATUS_CREATED = 'created';

    /** Complete settings */
    public const LIFE_CYCLE_STATUS_READY = 'ready';

    /** Visible only to partner, may need special UI treatment */
    public const LIFE_CYCLE_STATUS_TESTING = 'testing';

    /** Viper is recording; this means the "clock" is running */
    public const LIFE_CYCLE_STATUS_LIVE = 'live';

    /** The broadcast is finished. */
    public const LIFE_CYCLE_STATUS_COMPLETE = 'complete';

    /** This broadcast was removed by admin action */
    public const LIFE_CYCLE_STATUS_REVOKED = 'revoked';

    /** Transition into TESTING has been requested */
    public const LIFE_CYCLE_STATUS_TEST_STARTING = 'testStarting';

    /** Transition into LIVE has been requested */
    public const LIFE_CYCLE_STATUS_LIVE_STARTING = 'liveStarting';

    /** A `liveBroadcastPriority` of `liveBroadcastPriorityUnspecified`. */
    public const LIVE_BROADCAST_PRIORITY_LIVE_BROADCAST_PRIORITY_UNSPECIFIED = 'liveBroadcastPriorityUnspecified';

    /** Low priority broadcast: for low view count HoAs or other low priority broadcasts. */
    public const LIVE_BROADCAST_PRIORITY_LOW = 'low';

    /** Normal priority broadcast: for regular HoAs and broadcasts. */
    public const LIVE_BROADCAST_PRIORITY_NORMAL = 'normal';

    /** High priority broadcast: for high profile HoAs, like PixelCorp ones. */
    public const LIVE_BROADCAST_PRIORITY_HIGH = 'high';

    /** A `privacyStatus` of `public`. */
    public const PRIVACY_STATUS_PUBLIC = 'public';

    /** A `privacyStatus` of `unlisted`. */
    public const PRIVACY_STATUS_UNLISTED = 'unlisted';

    /** A `privacyStatus` of `private`. */
    public const PRIVACY_STATUS_PRIVATE = 'private';

    /** No value or the value is unknown. */
    public const RECORDING_STATUS_LIVE_BROADCAST_RECORDING_STATUS_UNSPECIFIED = 'liveBroadcastRecordingStatusUnspecified';

    /** The recording has not yet been started. */
    public const RECORDING_STATUS_NOT_RECORDING = 'notRecording';

    /** The recording is currently on. */
    public const RECORDING_STATUS_RECORDING = 'recording';

    /** The recording is completed, and cannot be started again. */
    public const RECORDING_STATUS_RECORDED = 'recorded';
}
