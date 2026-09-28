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
 * Information about the playlist item's privacy status.
 *
 * @property string|null $privacyStatus This resource's privacy status. One of the `PRIVACY_STATUS_*` constants.
 *
 * @since 1.0.0
 */
class PlaylistItemStatus extends Part
{
    /** A `privacyStatus` of `public`. */
    public const PRIVACY_STATUS_PUBLIC = 'public';

    /** A `privacyStatus` of `unlisted`. */
    public const PRIVACY_STATUS_UNLISTED = 'unlisted';

    /** A `privacyStatus` of `private`. */
    public const PRIVACY_STATUS_PRIVATE = 'private';
}
