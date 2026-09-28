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
 * @property string|null $etag Etag of this resource.
 * @property string|null $eventId Deprecated. Serialized EventId of the request which produced this response.
 * @property \Discord\Helpers\Collection<\YouTube\Parts\CommentThread>|null $items A list of comment threads that
 *     match the request criteria.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#commentThreadListResponse".
 * @property string|null $nextPageToken The token that can be used as the value of the pageToken parameter to
 *     retrieve the next page in the result set.
 * @property \YouTube\Parts\PageInfo|null $pageInfo General pagination information.
 * @property \YouTube\Parts\TokenPagination|null $tokenPagination Deprecated.
 * @property string|null $visitorId Deprecated. The visitorId identifies the visitor.
 *
 * @link https://developers.google.com/youtube/v3/docs/commentThreads/list
 *
 * @since 1.0.0
 */
class CommentThreadListResponse extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'items' => 'Array of CommentThread',
        'pageInfo' => 'PageInfo',
        'tokenPagination' => 'TokenPagination',
    ];
}
