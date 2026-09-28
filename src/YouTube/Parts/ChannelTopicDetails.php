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
 * Freebase topic information related to the channel.
 *
 * @property list<string>|null $topicCategories A list of Wikipedia URLs that describe the channel's content.
 * @property list<string>|null $topicIds Deprecated. A list of Freebase topic IDs associated with the channel.
 *     You can retrieve information about each topic using the Freebase Topic API.
 *
 * @since 1.0.0
 */
class ChannelTopicDetails extends Part
{
}
