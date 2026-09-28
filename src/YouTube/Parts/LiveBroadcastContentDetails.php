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
 * Detailed settings of a broadcast.
 *
 * @property \YouTube\Parts\AvailabilityConfig|null $availabilityConfig Optional. The broadcast's availability
 *     config. Used to set specific region availability or block specific regions It is optional - if not set, it is
 *     not enforced.
 * @property string|null $boundStreamId This value uniquely identifies the live stream bound to the broadcast.
 * @property \Carbon\CarbonImmutable|null $boundStreamLastUpdateTimeMs The date and time that the live stream
 *     referenced by boundStreamId was last updated.
 * @property string|null $closedCaptionsType One of the `CLOSED_CAPTIONS_TYPE_*` constants.
 * @property bool|null $enableAutoStart This setting indicates whether auto start is enabled for this broadcast.
 *     The default value for this property is false. This setting can only be used by Events.
 * @property bool|null $enableAutoStop This setting indicates whether auto stop is enabled for this broadcast.
 *     The default value for this property is false. This setting can only be used by Events.
 * @property bool|null $enableClosedCaptions Deprecated. This setting indicates whether HTTP POST closed
 *     captioning is enabled for this broadcast. The ingestion URL of the closed captions is returned through the
 *     liveStreams API. This is mutually exclusive with using the closed_captions_type property, and is equivalent to
 *     setting closed_captions_type to CLOSED_CAPTIONS_HTTP_POST.
 * @property bool|null $enableContentEncryption This setting indicates whether YouTube should enable content
 *     encryption for the broadcast.
 * @property bool|null $enableDvr This setting determines whether viewers can access DVR controls while watching
 *     the video. DVR controls enable the viewer to control the video playback experience by pausing, rewinding, or
 *     fast forwarding content. The default value for this property is true. *Important:* You must set the value to
 *     true and also set the enableArchive property's value to true if you want to make playback available
 *     immediately after the broadcast ends.
 * @property bool|null $enableEmbed This setting indicates whether the broadcast video can be played in an
 *     embedded player. If you choose to archive the video (using the enableArchive property), this setting will also
 *     apply to the archived video.
 * @property bool|null $enableLowLatency Deprecated. Indicates whether this broadcast has low latency enabled.
 * @property string|null $latencyPreference If both this and enable_low_latency are set, they must match.
 *     LATENCY_NORMAL should match enable_low_latency=false LATENCY_LOW should match enable_low_latency=true
 *     LATENCY_ULTRA_LOW should have enable_low_latency omitted. One of the `LATENCY_PREFERENCE_*` constants.
 * @property string|null $mesh The mesh for projecting the video if projection is mesh. The mesh value must be a
 *     UTF-8 string containing the base-64 encoding of 3D mesh data that follows the Spherical Video V2 RFC
 *     specification for an mshp box, excluding the box size and type but including the following four reserved zero
 *     bytes for the version and flags.
 * @property \YouTube\Parts\MonitorStreamInfo|null $monitorStream The monitorStream object contains information
 *     about the monitor stream, which the broadcaster can use to review the event content before the broadcast
 *     stream is shown publicly.
 * @property string|null $projection The projection format of this broadcast. This defaults to rectangular. One
 *     of the `PROJECTION_*` constants.
 * @property bool|null $recordFromStart Automatically start recording after the event goes live. The default
 *     value for this property is true. *Important:* You must also set the enableDvr property's value to true if you
 *     want the playback to be available immediately after the broadcast ends. If you set this property's value to
 *     true but do not also set the enableDvr property to true, there may be a delay of around one day before the
 *     archived video will be available for playback.
 * @property bool|null $startWithSlate Deprecated. This setting indicates whether the broadcast should
 *     automatically begin with an in-stream slate when you update the broadcast's status to live. After updating the
 *     status, you then need to send a liveCuepoints.insert request that sets the cuepoint's eventState to end to
 *     remove the in-stream slate and make your broadcast stream visible to viewers.
 * @property string|null $stereoLayout The 3D stereo layout of this broadcast. This defaults to mono. One of the
 *     `STEREO_LAYOUT_*` constants.
 *
 * @since 1.0.0
 */
class LiveBroadcastContentDetails extends Part
{
    /** A `closedCaptionsType` of `closedCaptionsTypeUnspecified`. */
    public const CLOSED_CAPTIONS_TYPE_CLOSED_CAPTIONS_TYPE_UNSPECIFIED = 'closedCaptionsTypeUnspecified';

    /** A `closedCaptionsType` of `closedCaptionsDisabled`. */
    public const CLOSED_CAPTIONS_TYPE_CLOSED_CAPTIONS_DISABLED = 'closedCaptionsDisabled';

    /** A `closedCaptionsType` of `closedCaptionsHttpPost`. */
    public const CLOSED_CAPTIONS_TYPE_CLOSED_CAPTIONS_HTTP_POST = 'closedCaptionsHttpPost';

    /** A `closedCaptionsType` of `closedCaptionsEmbedded`. */
    public const CLOSED_CAPTIONS_TYPE_CLOSED_CAPTIONS_EMBEDDED = 'closedCaptionsEmbedded';

    /** A `latencyPreference` of `latencyPreferenceUnspecified`. */
    public const LATENCY_PREFERENCE_LATENCY_PREFERENCE_UNSPECIFIED = 'latencyPreferenceUnspecified';

    /** Best for: highest quality viewer playbacks and higher resolutions. */
    public const LATENCY_PREFERENCE_NORMAL = 'normal';

    /** Best for: near real-time interaction, with minimal playback buffering. */
    public const LATENCY_PREFERENCE_LOW = 'low';

    /** Best for: real-time interaction Does not support: Closed captions, 1440p, and 4k resolutions */
    public const LATENCY_PREFERENCE_ULTRA_LOW = 'ultraLow';

    /** A `projection` of `projectionUnspecified`. */
    public const PROJECTION_PROJECTION_UNSPECIFIED = 'projectionUnspecified';

    /** A `projection` of `rectangular`. */
    public const PROJECTION_RECTANGULAR = 'rectangular';

    /** A `projection` of `360`. */
    public const PROJECTION_360 = '360';

    /** A `projection` of `mesh`. */
    public const PROJECTION_MESH = 'mesh';

    /** A `stereoLayout` of `stereoLayoutUnspecified`. */
    public const STEREO_LAYOUT_STEREO_LAYOUT_UNSPECIFIED = 'stereoLayoutUnspecified';

    /** A `stereoLayout` of `mono`. */
    public const STEREO_LAYOUT_MONO = 'mono';

    /** A `stereoLayout` of `leftRight`. */
    public const STEREO_LAYOUT_LEFT_RIGHT = 'leftRight';

    /** A `stereoLayout` of `topBottom`. */
    public const STEREO_LAYOUT_TOP_BOTTOM = 'topBottom';

    /** @var array<string, string> */
    protected array $casts = [
        'availabilityConfig' => 'AvailabilityConfig',
        'monitorStream' => 'MonitorStreamInfo',
    ];

    /** @var list<string> */
    protected array $dates = [
        'boundStreamLastUpdateTimeMs',
    ];
}
