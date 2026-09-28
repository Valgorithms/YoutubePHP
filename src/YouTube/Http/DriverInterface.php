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

use Psr\Http\Message\ResponseInterface;
use React\Promise\PromiseInterface;

/**
 * Executes a single prepared {@see Request} and resolves with the raw
 * {@see ResponseInterface}, success or error status alike. Retries, error
 * mapping and quota are {@see Http}'s job, not the driver's.
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
interface DriverInterface
{
    /**
     * @param bool $streaming Resolve as soon as the headers arrive, with a body
     *                        that is a `React\Stream\ReadableStreamInterface`
     *                        still receiving data. Only the live chat stream
     *                        asks for this.
     *
     * @return PromiseInterface<ResponseInterface>
     */
    public function runRequest(Request $request, bool $streaming = false): PromiseInterface;
}
