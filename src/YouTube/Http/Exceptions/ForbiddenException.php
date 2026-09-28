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
 * 403: the account may not do this - moderate a chat it does not own, read a
 * private resource. Subclasses name the 403s that mean something narrower.
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
class ForbiddenException extends HttpException
{
}
