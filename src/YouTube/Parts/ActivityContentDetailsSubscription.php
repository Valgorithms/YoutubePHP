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
 * Information about a channel that a user subscribed to.
 *
 * @property \YouTube\Parts\ResourceId|null $resourceId The `resourceId` object contains information that
 *     identifies the resource that the user subscribed to.
 *
 * @since 1.0.0
 */
class ActivityContentDetailsSubscription extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'resourceId' => 'ResourceId',
    ];
}
