<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Http;

use React\Promise\Deferred;

/**
 * A request waiting in {@see Http}'s queue, with the promise its caller holds
 * and the attempts made at it so far.
 *
 * @internal
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
final class PendingRequest
{
    public int $attempts = 0;

    /**
     * @param Deferred<mixed> $deferred
     */
    public function __construct(
        public readonly Request $request,
        public readonly Deferred $deferred,
        public readonly bool $download = false,
    ) {
    }
}
