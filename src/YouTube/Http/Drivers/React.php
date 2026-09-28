<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Http\Drivers;

use Psr\Http\Message\ResponseInterface;
use React\EventLoop\LoopInterface;
use React\Http\Browser;
use React\Promise\PromiseInterface;
use React\Socket\Connector;
use YouTube\Http\DriverInterface;
use YouTube\Http\Request;

/**
 * The default {@see DriverInterface}: a non-blocking {@see Browser} from
 * `react/http`.
 *
 * Error responses resolve rather than reject, so {@see \YouTube\Http\Http} can
 * read Google's error body and map it to a typed exception. The timeout covers a
 * whole ordinary request, but only the wait for the headers of a streaming one:
 * the live chat stream stays open for as long as the chat is busy.
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
final class React implements DriverInterface
{
    private Browser $browser;

    /**
     * @param array<string, mixed> $socketOptions Passed to `React\Socket\Connector`
     *                                            (e.g. a `tls.cafile` on Windows).
     */
    public function __construct(LoopInterface $loop, array $socketOptions = [], float $timeout = 60.0)
    {
        $this->browser = (new Browser($socketOptions === [] ? null : new Connector($socketOptions, $loop), $loop))
            ->withRejectErrorResponse(false)
            ->withTimeout($timeout)
            ->withFollowRedirects(false);
    }

    /**
     * @return PromiseInterface<ResponseInterface>
     */
    public function runRequest(Request $request, bool $streaming = false): PromiseInterface
    {
        $arguments = [$request->getMethod(), $request->getUrl(), $request->getHeaders(), $request->getContent()];

        return $streaming
            ? $this->browser->requestStreaming(...$arguments)
            : $this->browser->request(...$arguments);
    }
}
