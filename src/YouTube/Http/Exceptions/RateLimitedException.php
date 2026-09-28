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
 * Too many requests, too quickly: Google's `rateLimitExceeded`, or a 429.
 *
 * For live chat it means polling faster than the chat's `pollingIntervalMillis`,
 * or posting faster than YouTube lets one account post. {@see \YouTube\Http\Http}
 * backs off and retries it a few times before giving up with this.
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
class RateLimitedException extends HttpException
{
}
