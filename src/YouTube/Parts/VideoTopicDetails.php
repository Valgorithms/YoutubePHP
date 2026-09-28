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
 * Freebase topic information related to the video.
 *
 * @property list<string>|null $relevantTopicIds Similar to topic_id, except that these topics are merely
 *     relevant to the video. These are topics that may be mentioned in, or appear in the video. You can retrieve
 *     information about each topic using Freebase Topic API.
 * @property list<string>|null $topicCategories A list of Wikipedia URLs that provide a high-level description of
 *     the video's content.
 * @property list<string>|null $topicIds A list of Freebase topic IDs that are centrally associated with the
 *     video. These are topics that are centrally featured in the video, and it can be said that the video is mainly
 *     about each of these. You can retrieve information about each topic using the < a
 *     href="http://wiki.freebase.com/wiki/Topic_API">Freebase Topic API.
 *
 * @since 1.0.0
 */
class VideoTopicDetails extends Part
{
}
