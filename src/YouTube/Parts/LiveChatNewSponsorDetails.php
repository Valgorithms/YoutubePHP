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
 * @property bool|null $isUpgrade If the viewer just had upgraded from a lower level. For viewers that were not
 *     members at the time of purchase, this field is false.
 * @property string|null $memberLevelName The name of the Level that the viewer just had joined. The Level names
 *     are defined by the YouTube channel offering the Membership. In some situations this field isn't filled.
 *
 * @since 1.0.0
 */
class LiveChatNewSponsorDetails extends Part
{
}
