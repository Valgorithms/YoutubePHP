<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Auth;

/**
 * This file is generated from spec/discovery.json (YouTube Data API v3, revision 20260924) by
 * tools/generate.php. Do not edit it by hand - run `composer spec:build` instead.
 *
 * The OAuth scopes the YouTube Data API accepts. A sign-in asks for them, and
 * each method needs one of those it lists.
 *
 * @link https://developers.google.com/youtube/v3/guides/auth/installed-apps#identify-access-scopes
 *
 * @since 1.0.0
 */
final class Scope
{
    /** Manage your YouTube account */
    public const YOUTUBE = 'https://www.googleapis.com/auth/youtube';

    /**
     * See a list of your current active channel members, their current level, and when they became a
     * member
     */
    public const YOUTUBE_CHANNEL_MEMBERSHIPS_CREATOR = 'https://www.googleapis.com/auth/youtube.channel-memberships.creator';

    /** See, edit, and permanently delete your YouTube videos, ratings, comments and captions */
    public const YOUTUBE_FORCE_SSL = 'https://www.googleapis.com/auth/youtube.force-ssl';

    /** View your YouTube account */
    public const YOUTUBE_READONLY = 'https://www.googleapis.com/auth/youtube.readonly';

    /** Manage your YouTube videos */
    public const YOUTUBE_UPLOAD = 'https://www.googleapis.com/auth/youtube.upload';

    /** View and manage your assets and associated content on YouTube */
    public const YOUTUBEPARTNER = 'https://www.googleapis.com/auth/youtubepartner';

    /**
     * View private information of your YouTube channel relevant during the audit process with a YouTube
     * partner
     */
    public const YOUTUBEPARTNER_CHANNEL_AUDIT = 'https://www.googleapis.com/auth/youtubepartner-channel-audit';

    /** @return list<string> Every scope. */
    public static function all(): array
    {
        return array_values((new \ReflectionClass(self::class))->getConstants());
    }
}
