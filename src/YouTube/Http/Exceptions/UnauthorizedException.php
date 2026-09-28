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
 * 401: the access token is missing, expired or revoked.
 *
 * {@see \YouTube\YouTube} recovers from this by itself when it can - it
 * refreshes the token, or signs in again - and retries the call once.
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
class UnauthorizedException extends HttpException
{
}
