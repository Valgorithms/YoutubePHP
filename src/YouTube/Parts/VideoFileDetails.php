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
 * Describes original video file properties, including technical details about audio and video streams,
 * but also metadata information like content length, digitization time, or geotagging information.
 *
 * @property \Discord\Helpers\Collection<\YouTube\Parts\VideoFileDetailsAudioStream>|null $audioStreams A list of
 *     audio streams contained in the uploaded video file. Each item in the list contains detailed metadata about an
 *     audio stream.
 * @property string|null $bitrateBps The uploaded video file's combined (video and audio) bitrate in bits per
 *     second. A 64-bit number, as a string.
 * @property string|null $container The uploaded video file's container format.
 * @property string|null $creationTime The date and time when the uploaded video file was created. The value is
 *     specified in ISO 8601 format. Currently, the following ISO 8601 formats are supported: - Date only: YYYY-MM-DD
 *     - Naive time: YYYY-MM-DDTHH:MM:SS - Time with timezone: YYYY-MM-DDTHH:MM:SS+HH:MM
 * @property string|null $durationMs The length of the uploaded video in milliseconds. A 64-bit number, as a
 *     string.
 * @property string|null $fileName The uploaded file's name. This field is present whether a video file or
 *     another type of file was uploaded.
 * @property string|null $fileSize The uploaded file's size in bytes. This field is present whether a video file
 *     or another type of file was uploaded. A 64-bit number, as a string.
 * @property string|null $fileType The uploaded file's type as detected by YouTube's video processing engine.
 *     Currently, YouTube only processes video files, but this field is present whether a video file or another type
 *     of file was uploaded. One of the `FILE_TYPE_*` constants.
 * @property \Discord\Helpers\Collection<\YouTube\Parts\VideoFileDetailsVideoStream>|null $videoStreams A list of
 *     video streams contained in the uploaded video file. Each item in the list contains detailed metadata about a
 *     video stream.
 *
 * @since 1.0.0
 */
class VideoFileDetails extends Part
{
    /** Known video file (e.g., an MP4 file). */
    public const FILE_TYPE_VIDEO = 'video';

    /** Audio only file (e.g., an MP3 file). */
    public const FILE_TYPE_AUDIO = 'audio';

    /** Image file (e.g., a JPEG image). */
    public const FILE_TYPE_IMAGE = 'image';

    /** Archive file (e.g., a ZIP archive). */
    public const FILE_TYPE_ARCHIVE = 'archive';

    /** Document or text file (e.g., MS Word document). */
    public const FILE_TYPE_DOCUMENT = 'document';

    /** Movie project file (e.g., Microsoft Windows Movie Maker project). */
    public const FILE_TYPE_PROJECT = 'project';

    /** Other non-video file type. */
    public const FILE_TYPE_OTHER = 'other';

    /** @var array<string, string> */
    protected array $casts = [
        'audioStreams' => 'Array of VideoFileDetailsAudioStream',
        'videoStreams' => 'Array of VideoFileDetailsVideoStream',
    ];
}
