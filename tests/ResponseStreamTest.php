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

use PHPUnit\Framework\TestCase;
use React\Stream\ThroughStream;
use YouTube\Http\Exceptions\HttpException;
use YouTube\Http\Exceptions\LiveChatEndedException;
use YouTube\Http\ResponseStream;

/**
 * Reading a JSON array as it arrives, one element at a time, however the
 * network happens to cut it up.
 */
final class ResponseStreamTest extends TestCase
{
    private ThroughStream $source;

    private ResponseStream $stream;

    /** @var list<array<string, mixed>> */
    private array $elements = [];

    /** @var list<\Throwable> */
    private array $errors = [];

    /** @var list<string> */
    private array $events = [];

    protected function setUp(): void
    {
        $this->source = new ThroughStream();
        $this->stream = new ResponseStream($this->source, static fn (array $element): array => $element, 'liveChatMessages.stream');
        $this->stream->on('data', function (array $element): void {
            $this->elements[] = $element;
        });
        $this->stream->on('error', function (\Throwable $e): void {
            $this->errors[] = $e;
        });
        $this->stream->on('end', function (): void {
            $this->events[] = 'end';
        });
        $this->stream->on('close', function (): void {
            $this->events[] = 'close';
        });
    }

    public function testEachElementIsEmittedAsSoonAsItIsComplete(): void
    {
        $this->source->write("[{\n  \"nextPageToken\": \"a\",\n  \"items\": []\n}\n");
        $this->assertSame([['nextPageToken' => 'a', 'items' => []]], $this->elements, 'before the array closes');

        $this->source->write(',{"nextPageToken": "b"}');
        $this->source->end(']');

        $this->assertSame(['a', 'b'], array_column($this->elements, 'nextPageToken'));
        $this->assertSame(['end', 'close'], $this->events);
        $this->assertSame([], $this->errors);
    }

    public function testAnElementCutAnywhereIsPutBackTogether(): void
    {
        $json = '[{"items": [{"snippet": {"displayMessage": "a \"quoted\" {brace} and [bracket] \\\\"}}], "nextPageToken": "t"}]';

        // One byte at a time: every possible cut.
        foreach (str_split($json) as $byte) {
            $this->source->write($byte);
        }
        $this->source->end();

        $this->assertCount(1, $this->elements);
        $this->assertSame('a "quoted" {brace} and [bracket] \\', $this->elements[0]['items'][0]['snippet']['displayMessage']);
        $this->assertSame([], $this->errors);
    }

    public function testAnErrorPartWayThroughEndsTheStream(): void
    {
        $this->source->write('[{"nextPageToken": "a"}');
        $this->source->write(',{"error": {"code": 403, "message": "The live chat is no longer live.", "errors": [{"reason": "liveChatEnded"}]}}');

        $this->assertCount(1, $this->elements);
        $this->assertCount(1, $this->errors);
        $this->assertInstanceOf(LiveChatEndedException::class, $this->errors[0]);
        $this->assertSame(403, $this->errors[0]->getStatus());
        $this->assertSame(['close'], $this->events);
        $this->assertFalse($this->source->isReadable(), 'the connection is closed too');
    }

    public function testABodyThatIsNotAnArrayIsAnError(): void
    {
        $this->source->write('<html>');

        $this->assertCount(1, $this->errors);
        $this->assertInstanceOf(HttpException::class, $this->errors[0]);
        $this->assertStringContainsString('not a JSON array', $this->errors[0]->getMessage());
    }

    public function testAConnectionThatDropsMidElementIsAnError(): void
    {
        $this->source->write('[{"nextPageToken": "a"');
        $this->source->end();

        $this->assertSame([], $this->elements);
        $this->assertCount(1, $this->errors);
        $this->assertStringContainsString('in the middle of an element', $this->errors[0]->getMessage());
    }

    public function testClosingItClosesTheConnection(): void
    {
        $this->stream->close();

        $this->assertFalse($this->source->isReadable());
        $this->assertFalse($this->stream->isReadable());
        $this->assertSame(['close'], $this->events);
    }
}
