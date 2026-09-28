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
 * Basic details about a video category, such as its localized title. Next Id: 20
 *
 * @property bool|null $containsSyntheticMedia Indicates if the video contains altered or synthetic media.
 * @property bool|null $embeddable This value indicates if the video can be embedded on another website.
 *     `@mutable` youtube.videos.insert youtube.videos.update
 * @property string|null $failureReason This value explains why a video failed to upload. This property is only
 *     present if the uploadStatus property indicates that the upload failed. One of the `FAILURE_REASON_*`
 *     constants.
 * @property string|null $license The video's license. `@mutable` youtube.videos.insert youtube.videos.update One
 *     of the `LICENSE_*` constants.
 * @property bool|null $madeForKids
 * @property string|null $privacyStatus The video's privacy status. One of the `PRIVACY_STATUS_*` constants.
 * @property bool|null $publicStatsViewable This value indicates if the extended video statistics on the watch
 *     page can be viewed by everyone. Note that the view count, likes, etc will still be visible if this is
 *     disabled. `@mutable` youtube.videos.insert youtube.videos.update
 * @property \Carbon\CarbonImmutable|null $publishAt The date and time when the video is scheduled to publish. It
 *     can be set only if the privacy status of the video is private..
 * @property string|null $rejectionReason This value explains why YouTube rejected an uploaded video. This
 *     property is only present if the uploadStatus property indicates that the upload was rejected. One of the
 *     `REJECTION_REASON_*` constants.
 * @property bool|null $selfDeclaredMadeForKids
 * @property string|null $uploadStatus The status of the uploaded video. One of the `UPLOAD_STATUS_*` constants.
 *
 * @since 1.0.0
 */
class VideoStatus extends Part
{
    /** Unable to convert video content. */
    public const FAILURE_REASON_CONVERSION = 'conversion';

    /** Invalid file format. */
    public const FAILURE_REASON_INVALID_FILE = 'invalidFile';

    /** Empty file. */
    public const FAILURE_REASON_EMPTY_FILE = 'emptyFile';

    /** File was too small. */
    public const FAILURE_REASON_TOO_SMALL = 'tooSmall';

    /** Unsupported codec. */
    public const FAILURE_REASON_CODEC = 'codec';

    /** Upload wasn't finished. */
    public const FAILURE_REASON_UPLOAD_ABORTED = 'uploadAborted';

    /** Standard YouTube license. */
    public const LICENSE_YOUTUBE = 'youtube';

    /** Creative Commons license. */
    public const LICENSE_CREATIVE_COMMON = 'creativeCommon';

    /** A `privacyStatus` of `public`. */
    public const PRIVACY_STATUS_PUBLIC = 'public';

    /** A `privacyStatus` of `unlisted`. */
    public const PRIVACY_STATUS_UNLISTED = 'unlisted';

    /** A `privacyStatus` of `private`. */
    public const PRIVACY_STATUS_PRIVATE = 'private';

    /** Copyright infringement. */
    public const REJECTION_REASON_COPYRIGHT = 'copyright';

    /** Inappropriate video content. */
    public const REJECTION_REASON_INAPPROPRIATE = 'inappropriate';

    /** Duplicate upload in the same channel. */
    public const REJECTION_REASON_DUPLICATE = 'duplicate';

    /** Terms of use violation. */
    public const REJECTION_REASON_TERMS_OF_USE = 'termsOfUse';

    /** Uploader account was suspended. */
    public const REJECTION_REASON_UPLOADER_ACCOUNT_SUSPENDED = 'uploaderAccountSuspended';

    /** Video duration was too long. */
    public const REJECTION_REASON_LENGTH = 'length';

    /** Blocked by content owner. */
    public const REJECTION_REASON_CLAIM = 'claim';

    /** Uploader closed his/her account. */
    public const REJECTION_REASON_UPLOADER_ACCOUNT_CLOSED = 'uploaderAccountClosed';

    /** Trademark infringement. */
    public const REJECTION_REASON_TRADEMARK = 'trademark';

    /** An unspecified legal reason. */
    public const REJECTION_REASON_LEGAL = 'legal';

    /** Video has been uploaded but not processed yet. */
    public const UPLOAD_STATUS_UPLOADED = 'uploaded';

    /** Video has been successfully processed. */
    public const UPLOAD_STATUS_PROCESSED = 'processed';

    /** Processing has failed. See FailureReason. */
    public const UPLOAD_STATUS_FAILED = 'failed';

    /** Video has been rejected. See RejectionReason. */
    public const UPLOAD_STATUS_REJECTED = 'rejected';

    /** Video has been deleted. */
    public const UPLOAD_STATUS_DELETED = 'deleted';

    /** @var list<string> */
    protected array $dates = [
        'publishAt',
    ];
}
