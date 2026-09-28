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
 * Detailed settings of a stream.
 *
 * @property string|null $closedCaptionsIngestionUrl The ingestion URL where the closed captions of this stream
 *     are sent.
 * @property bool|null $isReusable Indicates whether the stream is reusable, which means that it can be bound to
 *     multiple broadcasts. It is common for broadcasters to reuse the same stream for many different broadcasts if
 *     those broadcasts occur at different times. If you set this value to false, then the stream will not be
 *     reusable, which means that it can only be bound to one broadcast. Non-reusable streams differ from reusable
 *     streams in the following ways: - A non-reusable stream can only be bound to one broadcast. - A non-reusable
 *     stream might be deleted by an automated process after the broadcast ends. - The liveStreams.list method does
 *     not list non-reusable streams if you call the method and set the mine parameter to true. The only way to use
 *     that method to retrieve the resource for a non-reusable stream is to use the id parameter to identify the
 *     stream.
 *
 * @since 1.0.0
 */
class LiveStreamContentDetails extends Part
{
}
