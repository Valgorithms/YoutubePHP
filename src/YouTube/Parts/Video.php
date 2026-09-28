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
 * A *video* resource represents a YouTube video.
 *
 * @property \YouTube\Parts\VideoAgeGating|null $ageGating Age restriction details related to a video. This data
 *     can only be retrieved by the video owner.
 * @property \YouTube\Parts\BrandPartner|null $brandPartner
 * @property \YouTube\Parts\VideoContentDetails|null $contentDetails The contentDetails object contains
 *     information about the video content, including the length of the video and its aspect ratio.
 * @property string|null $etag Etag of this resource.
 * @property \YouTube\Parts\VideoFileDetails|null $fileDetails The fileDetails object encapsulates information
 *     about the video file that was uploaded to YouTube, including the file's resolution, duration, audio and video
 *     codecs, stream bitrates, and more. This data can only be retrieved by the video owner.
 * @property string|null $id The ID that YouTube uses to uniquely identify the video.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string "youtube#video".
 * @property \YouTube\Parts\VideoLiveStreamingDetails|null $liveStreamingDetails The liveStreamingDetails object
 *     contains metadata about a live video broadcast. The object will only be present in a video resource if the
 *     video is an upcoming, live, or completed live broadcast.
 * @property array<string, \YouTube\Parts\VideoLocalization>|null $localizations The localizations object
 *     contains localized versions of the basic details about the video, such as its title and description.
 * @property \YouTube\Parts\VideoMonetizationDetails|null $monetizationDetails The monetizationDetails object
 *     encapsulates information about the monetization status of the video.
 * @property \YouTube\Parts\VideoPaidProductPlacementDetails|null $paidProductPlacementDetails
 * @property \YouTube\Parts\VideoPlayer|null $player The player object contains information that you would use to
 *     play the video in an embedded player.
 * @property \YouTube\Parts\VideoProcessingDetails|null $processingDetails The processingDetails object
 *     encapsulates information about YouTube's progress in processing the uploaded video file. The properties in the
 *     object identify the current processing status and an estimate of the time remaining until YouTube finishes
 *     processing the video. This part also indicates whether different types of data or content, such as file
 *     details or thumbnail images, are available for the video. The processingProgress object is designed to be
 *     polled so that the video uploaded can track the progress that YouTube has made in processing the uploaded
 *     video file. This data can only be retrieved by the video owner.
 * @property \YouTube\Parts\VideoProjectDetails|null $projectDetails Deprecated. The projectDetails object
 *     contains information about the project specific video metadata. b/157517979: This part was never populated
 *     after it was added. However, it sees non-zero traffic because there is generated client code in the wild that
 *     refers to it [1]. We keep this field and do NOT remove it because otherwise V3 would return an error when this
 *     part gets requested [2]. [1]
 *     https://developers.google.com/resources/api-libraries/documentation/youtube/v3/csharp/latest/classGoogle_1_1Apis_1_1YouTube_1_1v3_1_1Data_1_1VideoProjectDetails.html
 *     [2] http://google3/video/youtube/src/python/servers/data_api/common.py?l=1565-1569&rcl=344141677
 * @property \YouTube\Parts\VideoRecordingDetails|null $recordingDetails The recordingDetails object encapsulates
 *     information about the location, date and address where the video was recorded.
 * @property \YouTube\Parts\VideoSnippet|null $snippet The snippet object contains basic details about the video,
 *     such as its title, description, and category.
 * @property \YouTube\Parts\VideoStatistics|null $statistics The statistics object contains statistics about the
 *     video.
 * @property \YouTube\Parts\VideoStatus|null $status The status object contains information about the video's
 *     uploading, processing, and privacy statuses.
 * @property \YouTube\Parts\VideoSuggestions|null $suggestions The suggestions object encapsulates suggestions
 *     that identify opportunities to improve the video quality or the metadata for the uploaded video. This data can
 *     only be retrieved by the video owner.
 * @property \YouTube\Parts\VideoTopicDetails|null $topicDetails The topicDetails object encapsulates information
 *     about Freebase topics associated with the video.
 *
 * @link https://developers.google.com/youtube/v3/docs/videos
 *
 * @since 1.0.0
 */
class Video extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'ageGating' => 'VideoAgeGating',
        'brandPartner' => 'BrandPartner',
        'contentDetails' => 'VideoContentDetails',
        'fileDetails' => 'VideoFileDetails',
        'liveStreamingDetails' => 'VideoLiveStreamingDetails',
        'localizations' => 'Map of VideoLocalization',
        'monetizationDetails' => 'VideoMonetizationDetails',
        'paidProductPlacementDetails' => 'VideoPaidProductPlacementDetails',
        'player' => 'VideoPlayer',
        'processingDetails' => 'VideoProcessingDetails',
        'projectDetails' => 'VideoProjectDetails',
        'recordingDetails' => 'VideoRecordingDetails',
        'snippet' => 'VideoSnippet',
        'statistics' => 'VideoStatistics',
        'status' => 'VideoStatus',
        'suggestions' => 'VideoSuggestions',
        'topicDetails' => 'VideoTopicDetails',
    ];
}
