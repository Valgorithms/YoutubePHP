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
 * Rights management policy for YouTube resources.
 *
 * @property bool|null $allowed The value of allowed indicates whether the access to the policy is allowed or
 *     denied by default.
 * @property list<string>|null $exception A list of region codes that identify countries where the default policy
 *     do not apply.
 *
 * @since 1.0.0
 */
class AccessPolicy extends Part
{
}
