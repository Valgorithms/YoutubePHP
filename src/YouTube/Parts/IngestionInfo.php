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
 * Describes information necessary for ingesting an RTMP, HTTP, or SRT stream.
 *
 * @property string|null $backupIngestionAddress The backup ingestion URL that you should use to stream video to
 *     YouTube. You have the option of simultaneously streaming the content that you are sending to the
 *     ingestionAddress to this URL.
 * @property string|null $ingestionAddress The primary ingestion URL that you should use to stream video to
 *     YouTube. You must stream video to this URL. Depending on which application or tool you use to encode your
 *     video stream, you may need to enter the stream URL and stream name separately or you may need to concatenate
 *     them in the following format: *STREAM_URL/STREAM_NAME*
 * @property string|null $rtmpsBackupIngestionAddress This ingestion url may be used instead of
 *     backupIngestionAddress in order to stream via RTMPS. Not applicable to non-RTMP streams.
 * @property string|null $rtmpsIngestionAddress This ingestion url may be used instead of ingestionAddress in
 *     order to stream via RTMPS. Not applicable to non-RTMP streams.
 * @property string|null $streamName The stream name that YouTube assigns to the video stream.
 *
 * @since 1.0.0
 */
class IngestionInfo extends Part
{
}
