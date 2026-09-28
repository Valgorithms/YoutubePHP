<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Http\Exceptions;

/**
 * The live chat has ended: the broadcast is over, so there is nothing more to
 * read from it or post to it.
 *
 * @link https://developers.google.com/youtube/v3/live/docs/liveChatMessages/list#errors
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
class LiveChatEndedException extends ForbiddenException
{
}
