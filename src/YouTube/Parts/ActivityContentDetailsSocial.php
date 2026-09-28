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
 * Details about a social network post.
 *
 * @property string|null $author The author of the social network post.
 * @property string|null $imageUrl An image of the post's author.
 * @property string|null $referenceUrl The URL of the social network post.
 * @property \YouTube\Parts\ResourceId|null $resourceId The `resourceId` object encapsulates information that
 *     identifies the resource associated with a social network post.
 * @property string|null $type The name of the social network. One of the `TYPE_*` constants.
 *
 * @since 1.0.0
 */
class ActivityContentDetailsSocial extends Part
{
    /** A `type` of `unspecified`. */
    public const TYPE_UNSPECIFIED = 'unspecified';

    /** A `type` of `googlePlus`. */
    public const TYPE_GOOGLE_PLUS = 'googlePlus';

    /** A `type` of `facebook`. */
    public const TYPE_FACEBOOK = 'facebook';

    /** A `type` of `twitter`. */
    public const TYPE_TWITTER = 'twitter';

    /** @var array<string, string> */
    protected array $casts = [
        'resourceId' => 'ResourceId',
    ];
}
