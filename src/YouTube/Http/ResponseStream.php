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

use Evenement\EventEmitter;
use React\Stream\ReadableStreamInterface;
use React\Stream\Util;
use React\Stream\WritableStreamInterface;
use YouTube\Http\Exceptions\HttpException;

/**
 * The body of a server-streamed call, as a stream of parts.
 *
 * Google serves a streamed method over plain HTTP as one JSON array whose
 * elements arrive as the server produces them, possibly hours apart. This reads
 * the array as it comes and emits each element, hydrated, as soon as it is
 * complete:
 *
 * ```php
 * $youtube->liveChatMessages->stream(liveChatId: $id, part: ['snippet', 'authorDetails'])
 *     ->then(function (ResponseStream $stream) {
 *         $stream->on('data', fn (LiveChatMessageListResponse $page) => ...);
 *         $stream->on('close', fn () => print("the server closed the stream\n"));
 *     });
 * ```
 *
 * Events, as for any readable stream: `data` with each element, `error` with
 * an {@see HttpException} when the server reports one mid-stream or the body
 * is not a JSON array, `end` when the array closes normally, and `close`
 * after either.
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
final class ResponseStream extends EventEmitter implements ReadableStreamInterface
{
    /** Whether the array's opening `[` has been read. */
    private bool $started = false;

    /** Whether the array's closing `]` has been read. */
    private bool $finished = false;

    /** Nesting depth inside the current element; 0 between elements. */
    private int $depth = 0;

    private bool $inString = false;

    private bool $escaped = false;

    /** The current element, so far. */
    private string $element = '';

    private bool $closed = false;

    /**
     * @param \Closure(array<string, mixed>): mixed $hydrate  Turns one decoded element into what `data` carries.
     * @param string                                $endpoint The API method, for error messages.
     */
    public function __construct(
        private readonly ReadableStreamInterface $source,
        private readonly \Closure $hydrate,
        private readonly string $endpoint = '',
    ) {
        if (! $source->isReadable()) {
            $this->close();

            return;
        }

        $source->on('data', $this->feed(...));
        $source->on('error', fn (\Throwable $e) => $this->fail(
            $e instanceof HttpException ? $e : new HttpException("{$this->endpoint}: the stream failed: {$e->getMessage()}", 0, null, null, [], null, $this->endpoint, $e),
        ));
        $source->on('end', $this->end(...));
        $source->on('close', $this->close(...));
    }

    /** Reads the next piece of the body, emitting every element it completes. */
    private function feed(string $chunk): void
    {
        $length = strlen($chunk);

        for ($i = 0; $i < $length && ! $this->closed; ++$i) {
            $char = $chunk[$i];

            if ($this->depth > 0) {
                $this->element .= $char;

                if ($this->inString) {
                    if ($this->escaped) {
                        $this->escaped = false;
                    } elseif ($char === '\\') {
                        $this->escaped = true;
                    } elseif ($char === '"') {
                        $this->inString = false;
                    }
                } elseif ($char === '"') {
                    $this->inString = true;
                } elseif ($char === '{' || $char === '[') {
                    ++$this->depth;
                } elseif (($char === '}' || $char === ']') && --$this->depth === 0) {
                    $this->emitElement();
                }

                continue;
            }

            if (ctype_space($char) || ($this->started && $char === ',')) {
                continue;
            }

            if (! $this->started && $char === '[') {
                $this->started = true;
            } elseif ($this->started && ! $this->finished && $char === '{') {
                $this->depth = 1;
                $this->element = $char;
            } elseif ($this->started && ! $this->finished && $char === ']') {
                $this->finished = true;
            } else {
                $this->fail(new HttpException("{$this->endpoint}: the stream is not a JSON array (unexpected \"{$char}\")", 0, null, null, [], null, $this->endpoint));
            }
        }
    }

    private function emitElement(): void
    {
        $decoded = json_decode($this->element, true);
        $this->element = '';

        if (! is_array($decoded)) {
            $this->fail(new HttpException("{$this->endpoint}: the stream sent an element that is not JSON", 0, null, null, [], null, $this->endpoint));

            return;
        }

        if (isset($decoded['error'])) {
            $this->fail(HttpException::fromError($decoded, 0, $this->endpoint));

            return;
        }

        $this->emit('data', [($this->hydrate)($decoded)]);
    }

    private function end(): void
    {
        if ($this->closed) {
            return;
        }

        if ($this->depth > 0) {
            $this->fail(new HttpException("{$this->endpoint}: the stream ended in the middle of an element", 0, null, null, [], null, $this->endpoint));

            return;
        }

        $this->emit('end');
        $this->close();
    }

    private function fail(HttpException $e): void
    {
        if ($this->closed) {
            return;
        }

        $this->emit('error', [$e]);
        $this->close();
    }

    public function isReadable(): bool
    {
        return ! $this->closed;
    }

    public function pause(): void
    {
        $this->source->pause();
    }

    public function resume(): void
    {
        $this->source->resume();
    }

    /**
     * @param array<string, mixed> $options
     */
    public function pipe(WritableStreamInterface $dest, array $options = []): WritableStreamInterface
    {
        return Util::pipe($this, $dest, $options);
    }

    public function close(): void
    {
        if ($this->closed) {
            return;
        }

        $this->closed = true;
        $this->source->close();
        $this->emit('close');
        $this->removeAllListeners();
    }
}
