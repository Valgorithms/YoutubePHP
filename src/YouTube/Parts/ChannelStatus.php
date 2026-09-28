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
 * JSON template for the status part of a channel.
 *
 * @property bool|null $isChannelMonetizationEnabled Whether the channel is considered ypp monetization enabled.
 *     See go/yppornot for more details.
 * @property bool|null $isLinked If true, then the user is linked to either a YouTube username or G+ account.
 *     Otherwise, the user doesn't have a public YouTube identity.
 * @property string|null $longUploadsStatus The long uploads status of this channel. See
 *     https://support.google.com/youtube/answer/71673 for more information. One of the `LONG_UPLOADS_STATUS_*`
 *     constants.
 * @property bool|null $madeForKids
 * @property string|null $privacyStatus Privacy status of the channel. One of the `PRIVACY_STATUS_*` constants.
 * @property bool|null $selfDeclaredMadeForKids
 *
 * @since 1.0.0
 */
class ChannelStatus extends Part
{
    /** A `longUploadsStatus` of `longUploadsUnspecified`. */
    public const LONG_UPLOADS_STATUS_LONG_UPLOADS_UNSPECIFIED = 'longUploadsUnspecified';

    /** A `longUploadsStatus` of `allowed`. */
    public const LONG_UPLOADS_STATUS_ALLOWED = 'allowed';

    /** A `longUploadsStatus` of `eligible`. */
    public const LONG_UPLOADS_STATUS_ELIGIBLE = 'eligible';

    /** A `longUploadsStatus` of `disallowed`. */
    public const LONG_UPLOADS_STATUS_DISALLOWED = 'disallowed';

    /** A `privacyStatus` of `public`. */
    public const PRIVACY_STATUS_PUBLIC = 'public';

    /** A `privacyStatus` of `unlisted`. */
    public const PRIVACY_STATUS_UNLISTED = 'unlisted';

    /** A `privacyStatus` of `private`. */
    public const PRIVACY_STATUS_PRIVATE = 'private';
}
