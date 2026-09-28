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

use function React\Async\await;

use React\EventLoop\Loop;
use React\Stream\ThroughStream;
use YouTube\Api\AbstractApi;
use YouTube\Http\Media;
use YouTube\Http\ResponseStream;
use YouTube\Parts\LiveChatMessage;
use YouTube\Parts\LiveChatMessageListResponse;
use YouTube\Quota\Cost;
use YouTube\YouTube;

/**
 * The generated resource APIs: that they cover the discovery document, and
 * that a few representative calls put the right request on the wire.
 */
final class GeneratedApiTest extends TestCase
{
    private ScriptedDriver $driver;

    private YouTube $youtube;

    protected function setUp(): void
    {
        $this->driver = new ScriptedDriver();
        $this->youtube = new YouTube(['token' => 'access-token', 'driver' => $this->driver, 'loop' => Loop::get()]);
    }

    /**
     * Every method in the discovery document, as `resource.method` => its spec.
     *
     * @return array<string, array<string, mixed>>
     */
    private static function discoveryMethods(): array
    {
        $document = json_decode((string) file_get_contents(dirname(__DIR__) . '/spec/discovery.json'), true);
        $methods = [];

        $walk = static function (array $resources, string $prefix) use (&$walk, &$methods): void {
            foreach ($resources as $name => $resource) {
                foreach ($resource['methods'] ?? [] as $method => $spec) {
                    $methods[$prefix . $name . '.' . $method] = $spec;
                }
                $walk($resource['resources'] ?? [], $prefix . $name . '.');
            }
        };
        $walk($document['resources'], '');

        return $methods;
    }

    public function testEveryMethodGoogleDocumentsIsThere(): void
    {
        $missing = [];

        foreach (self::discoveryMethods() as $id => $spec) {
            [$resource, $method] = $id === 'youtube.v3.liveChat.messages.stream'
                ? ['liveChatMessages', 'stream']
                : explode('.', $id);

            $api = $this->youtube->{$resource};
            $this->assertInstanceOf(AbstractApi::class, $api);

            if (! method_exists($api, $method)) {
                $missing[] = $id;
            }
        }

        $this->assertSame([], $missing);
        $this->assertCount(83, self::discoveryMethods());
    }

    public function testEveryMethodHasACost(): void
    {
        foreach (get_object_vars($this->youtube) as $resource => $api) {
            if (! $api instanceof AbstractApi) {
                continue;
            }

            foreach ((new \ReflectionClass($api))->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                if ($method->getDeclaringClass()->getName() === $api::class) {
                    $this->assertArrayHasKey($resource . '.' . $method->getName(), Cost::METHODS);
                }
            }
        }
    }

    public function testListingChatPutsTheRightRequestOnTheWire(): void
    {
        $this->driver->respond(200, [
            'kind' => 'youtube#liveChatMessageListResponse',
            'pollingIntervalMillis' => 2500,
            'items' => [['id' => 'm1', 'snippet' => ['type' => 'textMessageEvent', 'displayMessage' => 'hi']]],
        ]);

        $page = await($this->youtube->liveChatMessages->list(liveChatId: 'chat', part: ['snippet', 'authorDetails'], maxResults: 200));

        $request = $this->driver->last();
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('youtube/v3/liveChat/messages', ScriptedDriver::path($request));
        $this->assertSame(
            [['liveChatId', 'chat'], ['part', 'snippet'], ['part', 'authorDetails'], ['maxResults', '200']],
            ScriptedDriver::queryPairs($request),
        );
        $this->assertInstanceOf(LiveChatMessageListResponse::class, $page);
        $this->assertSame('hi', $page->items->first()->snippet->displayMessage);
        $this->assertSame(1, $this->youtube->getMeter()->used());
    }

    public function testPostingSendsThePartAsJson(): void
    {
        $this->driver->respond(200, ['id' => 'm2', 'snippet' => ['type' => 'textMessageEvent']]);

        $message = new LiveChatMessage(null, [
            'snippet' => ['liveChatId' => 'chat', 'type' => 'textMessageEvent', 'textMessageDetails' => ['messageText' => 'hello']],
        ]);

        $posted = await($this->youtube->liveChatMessages->insert('snippet', $message));

        $this->assertSame('POST', $this->driver->last()->getMethod());
        $this->assertSame([['part', 'snippet']], ScriptedDriver::queryPairs($this->driver->last()));
        $this->assertSame(json_encode($message), $this->driver->last()->getContent());
        $this->assertInstanceOf(LiveChatMessage::class, $posted);
        $this->assertSame(50, $this->youtube->getMeter()->used());
    }

    public function testAPathParameterIsEncodedAndADownloadIsTheBody(): void
    {
        $this->driver->respond(200, 'WEBVTT');

        $file = await($this->youtube->captions->download('a/b c', tfmt: 'vtt'));

        $this->assertSame('WEBVTT', $file);
        $this->assertSame('youtube/v3/captions/a%2Fb%20c', ScriptedDriver::path($this->driver->last()));
        $this->assertSame([['tfmt', 'vtt']], ScriptedDriver::queryPairs($this->driver->last()));
    }

    public function testAnUploadGoesToTheUploadPath(): void
    {
        $this->driver->respond(200, ['id' => 'v1']);

        await($this->youtube->videos->insert('snippet', ['snippet' => ['title' => 'A test']], new Media('bytes', 'video/mp4')));

        $this->assertSame('upload/youtube/v3/videos', ScriptedDriver::path($this->driver->last()));
        $this->assertSame(1, $this->youtube->getMeter()->used('uploads'), 'from its own bucket');
    }

    public function testTheChatStreamEmitsPagesAsTheyArrive(): void
    {
        $body = new ThroughStream();
        $this->driver->respond(200, $body);

        $stream = await($this->youtube->liveChatMessages->stream(liveChatId: 'chat', part: 'snippet'));
        $pages = [];
        $stream->on('data', static function (LiveChatMessageListResponse $page) use (&$pages): void {
            $pages[] = $page;
        });

        $body->write('[{"nextPageToken": "a", "items": [{"id": "m1"}]}');
        $body->write(',{"nextPageToken": "b", "items": []}');

        $this->assertInstanceOf(ResponseStream::class, $stream);
        $this->assertTrue($this->driver->streaming[0]);
        $this->assertSame('youtube/v3/liveChat/messages/stream', ScriptedDriver::path($this->driver->last()));
        $this->assertSame(['a', 'b'], array_map(static fn (LiveChatMessageListResponse $page): string => $page->nextPageToken, $pages));
        $this->assertSame('m1', $pages[0]->items->first()->id);
    }
}
