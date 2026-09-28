<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Tests;

use Psr\Http\Message\ResponseInterface;
use React\Http\Message\Response;
use React\Promise\PromiseInterface;

use function React\Promise\reject;
use function React\Promise\resolve;

use React\Stream\ReadableStreamInterface;
use YouTube\Http\DriverInterface;
use YouTube\Http\Request;

/**
 * A stand-in {@see DriverInterface} that records every request and answers
 * each with the next scripted response, in order. Nothing touches the network.
 */
final class ScriptedDriver implements DriverInterface
{
    /** @var list<Request> */
    public array $requests = [];

    /** @var list<bool> Whether each request asked to stream. */
    public array $streaming = [];

    /** @var list<ResponseInterface|\Throwable|\Closure(Request): (ResponseInterface|PromiseInterface)> */
    private array $script = [];

    /**
     * Queues a response.
     *
     * @param array<mixed>|string|ReadableStreamInterface $body     JSON-encoded when an array.
     * @param array<string, string>                        $headers
     */
    public function respond(int $status, array|string|ReadableStreamInterface $body = '', array $headers = []): self
    {
        if (is_array($body)) {
            $body = json_encode($body, JSON_THROW_ON_ERROR);
            $headers += ['Content-Type' => 'application/json'];
        }

        $this->script[] = new Response($status, $headers, $body);

        return $this;
    }

    /** Queues a Google-style error. */
    public function error(int $status, string $reason, string $message = 'Something went wrong.', array $headers = []): self
    {
        return $this->respond($status, [
            'error' => [
                'code' => $status,
                'message' => $message,
                'errors' => [['message' => $message, 'domain' => 'youtube.test', 'reason' => $reason]],
            ],
        ], $headers);
    }

    /** Queues a failure that never reached a server. */
    public function fail(\Throwable $e): self
    {
        $this->script[] = $e;

        return $this;
    }

    /**
     * Queues a callback that builds the response from the request.
     *
     * @param \Closure(Request): (ResponseInterface|PromiseInterface) $handler
     */
    public function handle(\Closure $handler): self
    {
        $this->script[] = $handler;

        return $this;
    }

    public function runRequest(Request $request, bool $streaming = false): PromiseInterface
    {
        $this->requests[] = $request;
        $this->streaming[] = $streaming;

        if ($this->script === []) {
            return reject(new \LogicException('Nothing was scripted for ' . $request . ' ' . $request->getUrl()));
        }

        $next = array_shift($this->script);

        return match (true) {
            $next instanceof \Throwable => reject($next),
            $next instanceof \Closure => resolve($next($request)),
            default => resolve($next),
        };
    }

    /** How many responses are still waiting to be used. */
    public function remaining(): int
    {
        return count($this->script);
    }

    /** The most recent request. */
    public function last(): Request
    {
        return $this->requests[array_key_last($this->requests)] ?? throw new \LogicException('No request was made.');
    }

    /**
     * The query string of a request, as its pairs in order: repeated keys are
     * repeated here too.
     *
     * @return list<array{0: string, 1: string}>
     */
    public static function queryPairs(Request $request): array
    {
        $query = (string) parse_url($request->getUrl(), PHP_URL_QUERY);
        $pairs = [];

        foreach ($query === '' ? [] : explode('&', $query) as $pair) {
            [$key, $value] = explode('=', $pair, 2) + [1 => ''];
            $pairs[] = [rawurldecode($key), rawurldecode($value)];
        }

        return $pairs;
    }

    /** The path of a request, without the API root. */
    public static function path(Request $request): string
    {
        return ltrim((string) parse_url($request->getUrl(), PHP_URL_PATH), '/');
    }
}
