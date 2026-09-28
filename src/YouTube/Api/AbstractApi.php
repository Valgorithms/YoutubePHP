<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Api;

use Psr\Http\Message\ResponseInterface;
use React\Promise\PromiseInterface;
use React\Stream\ReadableStreamInterface;
use React\Stream\ThroughStream;
use YouTube\Http\Media;
use YouTube\Http\ResponseStream;
use YouTube\YouTube;

/**
 * What every generated resource API extends: one call, sent through the client
 * and hydrated into the part the method returns.
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
abstract class AbstractApi
{
    public function __construct(protected readonly YouTube $youtube)
    {
    }

    /**
     * @param string                                     $endpoint   The API method, e.g. `liveChatMessages.list`.
     * @param array<string, mixed>                       $query
     * @param array<string, mixed>|\JsonSerializable|null $body
     * @param string|null                                $returns    The type token the result hydrates as; null leaves it raw.
     *
     * @return PromiseInterface<mixed>
     */
    protected function call(
        string $endpoint,
        string $method,
        string $path,
        array $query = [],
        array|\JsonSerializable|null $body = null,
        ?string $returns = null,
        ?Media $media = null,
        ?string $uploadPath = null,
        bool $download = false,
    ): PromiseInterface {
        return $this->youtube
            ->request($endpoint, $method, $path, $query, $body, $media, $uploadPath, $download)
            ->then(fn (mixed $result): mixed => $returns === null || $result === null
                ? $result
                : $this->youtube->getFactory()->create($returns, $result));
    }

    /**
     * Opens a server-streamed call and reads its body as it arrives.
     *
     * @param array<string, mixed> $query
     * @param string               $returns The type token each element hydrates as.
     *
     * @return PromiseInterface<ResponseStream>
     */
    protected function streamed(string $endpoint, string $path, array $query, string $returns): PromiseInterface
    {
        return $this->youtube->stream($endpoint, $path, $query)->then(function (ResponseInterface $response) use ($endpoint, $returns): ResponseStream {
            $body = $response->getBody();
            $hydrate = fn (array $element): mixed => $this->youtube->getFactory()->create($returns, $element);

            if ($body instanceof ReadableStreamInterface) {
                return new ResponseStream($body, $hydrate, $endpoint);
            }

            // A driver that read the whole body first: replay it once the
            // caller has had the chance to listen.
            $replay = new ThroughStream();
            $stream = new ResponseStream($replay, $hydrate, $endpoint);
            $this->youtube->getLoop()->futureTick(static fn () => $replay->end((string) $body));

            return $stream;
        });
    }
}
