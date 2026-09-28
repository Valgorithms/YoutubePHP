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
 * A *third party account link* resource represents a link between a YouTube account or a channel and
 * an account on a third-party service.
 *
 * @property string|null $etag Etag of this resource
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#thirdPartyLink".
 * @property string|null $linkingToken The linking_token identifies a YouTube account and channel with which the
 *     third party account is linked.
 * @property \YouTube\Parts\ThirdPartyLinkSnippet|null $snippet The snippet object contains basic details about
 *     the third- party account link.
 * @property \YouTube\Parts\ThirdPartyLinkStatus|null $status The status object contains information about the
 *     status of the link.
 *
 * @since 1.0.0
 */
class ThirdPartyLink extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'snippet' => 'ThirdPartyLinkSnippet',
        'status' => 'ThirdPartyLinkStatus',
    ];
}
