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

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function React\Async\await;

use React\EventLoop\Loop;
use React\Stream\ThroughStream;
use YouTube\Http\Exceptions\BadRequestException;
use YouTube\Http\Exceptions\HttpException;
use YouTube\Http\Exceptions\LiveChatDisabledException;
use YouTube\Http\Exceptions\LiveChatEndedException;
use YouTube\Http\Exceptions\LiveChatNotFoundException;
use YouTube\Http\Exceptions\MissingScopeException;
use YouTube\Http\Exceptions\QuotaExceededException;
use YouTube\Http\Exceptions\RateLimitedException;
use YouTube\Http\Exceptions\ServerException;
use YouTube\Http\Exceptions\UnauthorizedException;
use YouTube\Http\Http;
use YouTube\Http\Media;
use YouTube\Quota\Meter;

/**
 * The transport: what goes on the wire, what comes back, and which failures
 * are tried again.
 */
final class HttpTest extends TestCase
{
    private ScriptedDriver $driver;

    private Http $http;

    protected function setUp(): void
    {
        $this->driver = new ScriptedDriver();
        $this->http = new Http(Loop::get(), null, $this->driver, Http::BASE_URL, 0.0);
        $this->http->setToken('access-token');
    }

    public function testAListRepeatsItsKeyAndNullsAreLeftOut(): void
    {
        $this->driver->respond(200, ['items' => []]);

        await($this->http->request('videos.list', 'GET', 'youtube/v3/videos', [
            'part' => ['id', 'snippet'],
            'mine' => true,
            'pageToken' => null,
            'publishedAfter' => new \DateTimeImmutable('2026-09-27 12:00:00', new \DateTimeZone('America/Los_Angeles')),
        ]));

        $request = $this->driver->last();
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('youtube/v3/videos', ScriptedDriver::path($request));
        $this->assertSame(
            [['part', 'id'], ['part', 'snippet'], ['mine', 'true'], ['publishedAfter', '2026-09-27T19:00:00Z']],
            ScriptedDriver::queryPairs($request),
        );
    }

    public function testTheTokenIsSentAsABearer(): void
    {
        $this->driver->respond(200, []);

        await($this->http->request('channels.list', 'GET', 'youtube/v3/channels'));

        $this->assertSame('Bearer access-token', $this->driver->last()->getHeader('Authorization'));
        $this->assertNull($this->driver->last()->getHeader('X-Goog-Api-Key'));
    }

    public function testAnApiKeyGoesInAHeaderNotTheUrl(): void
    {
        $this->http->setToken(null);
        $this->http->setApiKey('the-key');
        $this->driver->respond(200, []);

        await($this->http->request('videos.list', 'GET', 'youtube/v3/videos', ['id' => 'abc']));

        $request = $this->driver->last();
        $this->assertSame('the-key', $request->getHeader('X-Goog-Api-Key'));
        $this->assertNull($request->getHeader('Authorization'));
        $this->assertStringNotContainsString('the-key', $request->getUrl());
    }

    public function testABodyIsSentAsJson(): void
    {
        $this->driver->respond(200, ['id' => 'm1']);

        $result = await($this->http->request('liveChatMessages.insert', 'POST', 'youtube/v3/liveChat/messages', ['part' => 'snippet'], [
            'snippet' => ['liveChatId' => 'chat', 'type' => 'textMessageEvent', 'textMessageDetails' => ['messageText' => 'héllo / there']],
        ]));

        $request = $this->driver->last();
        $this->assertSame(['id' => 'm1'], $result);
        $this->assertSame('application/json', $request->getHeader('Content-Type'));
        $this->assertSame(
            '{"snippet":{"liveChatId":"chat","type":"textMessageEvent","textMessageDetails":{"messageText":"héllo / there"}}}',
            $request->getContent(),
        );
    }

    public function testAnEmptyResponseResolvesNull(): void
    {
        $this->driver->respond(204);

        $this->assertNull(await($this->http->request('liveChatMessages.delete', 'DELETE', 'youtube/v3/liveChat/messages', ['id' => 'm1'])));
    }

    /**
     * @return iterable<string, array{0: int, 1: string, 2: class-string<HttpException>}>
     */
    public static function errors(): iterable
    {
        yield 'quota' => [403, 'quotaExceeded', QuotaExceededException::class];
        yield 'chat ended' => [403, 'liveChatEnded', LiveChatEndedException::class];
        yield 'chat disabled' => [403, 'liveChatDisabled', LiveChatDisabledException::class];
        yield 'no such chat' => [404, 'liveChatNotFound', LiveChatNotFoundException::class];
        yield 'narrow grant' => [403, 'insufficientPermissions', MissingScopeException::class];
        yield 'dead token' => [401, 'authError', UnauthorizedException::class];
        yield 'bad message' => [400, 'messageTextInvalid', BadRequestException::class];
    }

    /**
     * @param class-string<HttpException> $expected
     */
    #[DataProvider('errors')]
    public function testGoogleReasonsBecomeTheirOwnExceptions(int $status, string $reason, string $expected): void
    {
        $this->driver->error($status, $reason, 'It did not work.');

        try {
            await($this->http->request('liveChatMessages.insert', 'POST', 'youtube/v3/liveChat/messages', [], ['snippet' => []]));
            $this->fail('expected ' . $expected);
        } catch (HttpException $e) {
            $this->assertInstanceOf($expected, $e);
            $this->assertSame($status, $e->getStatus());
            $this->assertSame($reason, $e->getReason());
            $this->assertSame('liveChatMessages.insert', $e->getEndpoint());
            $this->assertSame("liveChatMessages.insert: It did not work. ({$status} {$reason})", $e->getMessage());
        }
    }

    public function testTheNewerErrorFormatIsReadToo(): void
    {
        $this->driver->respond(403, [
            'error' => [
                'code' => 403,
                'message' => 'Request had insufficient authentication scopes.',
                'status' => 'PERMISSION_DENIED',
                'details' => [[
                    '@type' => 'type.googleapis.com/google.rpc.ErrorInfo',
                    'reason' => 'ACCESS_TOKEN_SCOPE_INSUFFICIENT',
                    'domain' => 'googleapis.com',
                ]],
            ],
        ]);

        $this->expectException(MissingScopeException::class);

        await($this->http->request('liveChatBans.insert', 'POST', 'youtube/v3/liveChat/bans', [], ['snippet' => []]));
    }

    public function testARateLimitIsWaitedOutAndRetried(): void
    {
        $meter = new Meter();
        $this->http->setMeter($meter);
        $this->driver
            ->error(403, 'rateLimitExceeded', 'Too fast.', ['Retry-After' => '0'])
            ->respond(200, ['id' => 'm1']);

        $result = await($this->http->request('liveChatMessages.insert', 'POST', 'youtube/v3/liveChat/messages', [], ['snippet' => []]));

        $this->assertSame(['id' => 'm1'], $result);
        $this->assertCount(2, $this->driver->requests, 'a rate limit means it was not processed, so even a POST is retried');
        $this->assertSame(100, $meter->used(), 'every attempt costs');
    }

    public function testARateLimitThatNeverLiftsGivesUp(): void
    {
        foreach (range(1, Http::MAX_ATTEMPTS) as $attempt) {
            $this->driver->error(429, 'rateLimitExceeded', 'Too fast.');
        }

        $this->expectException(RateLimitedException::class);

        try {
            await($this->http->request('liveChatMessages.list', 'GET', 'youtube/v3/liveChat/messages'));
        } finally {
            $this->assertCount(Http::MAX_ATTEMPTS, $this->driver->requests);
        }
    }

    public function testAServerErrorIsRetriedForAGet(): void
    {
        $this->driver->error(500, 'backendError')->respond(200, ['ok' => true]);

        $this->assertSame(['ok' => true], await($this->http->request('videos.list', 'GET', 'youtube/v3/videos')));
        $this->assertCount(2, $this->driver->requests);
    }

    public function testAServerErrorIsNotRetriedForAPost(): void
    {
        $this->driver->error(500, 'backendError')->respond(200, ['id' => 'duplicate']);

        try {
            await($this->http->request('liveChatMessages.insert', 'POST', 'youtube/v3/liveChat/messages', [], ['snippet' => []]));
            $this->fail('expected the 500 to surface');
        } catch (ServerException) {
            $this->assertCount(1, $this->driver->requests, 'a second copy of a chat message is worse than an error');
        }
    }

    public function testUnavailableIsRetriedEvenForAPost(): void
    {
        $this->driver->error(503, 'backendError')->respond(200, ['id' => 'm1']);

        $this->assertSame(['id' => 'm1'], await($this->http->request('liveChatMessages.insert', 'POST', 'youtube/v3/liveChat/messages', [], ['snippet' => []])));
    }

    public function testADroppedConnectionIsRetriedForAGet(): void
    {
        $this->driver->fail(new \RuntimeException('Connection reset'))->respond(200, ['ok' => true]);

        $this->assertSame(['ok' => true], await($this->http->request('videos.list', 'GET', 'youtube/v3/videos')));
    }

    public function testQuotaFromGoogleSpendsTheRestOfTheDay(): void
    {
        $meter = new Meter();
        $this->http->setMeter($meter);
        $this->driver->error(403, 'quotaExceeded', 'The request cannot be completed because you have exceeded your quota.');

        try {
            await($this->http->request('liveChatMessages.list', 'GET', 'youtube/v3/liveChat/messages'));
            $this->fail('expected quotaExceeded');
        } catch (QuotaExceededException $e) {
            $this->assertFalse($e->isLocal());
            $this->assertEquals($meter->resetsAt(), $e->getResetsAt());
        }

        $this->assertCount(1, $this->driver->requests, 'quota is not retried');
        $this->assertSame(0, $meter->remaining());
    }

    public function testACallTheQuotaCannotPayForIsNeverSent(): void
    {
        $meter = new Meter(['default' => 60]);
        $meter->spend('liveChatMessages.insert');
        $this->http->setMeter($meter);

        try {
            await($this->http->request('liveChatMessages.insert', 'POST', 'youtube/v3/liveChat/messages', [], ['snippet' => []]));
            $this->fail('expected a local refusal');
        } catch (QuotaExceededException $e) {
            $this->assertTrue($e->isLocal());
            $this->assertSame(0, $e->getStatus());
            $this->assertStringContainsString('costs 50, and 10 of today\'s 60 remain', $e->getMessage());
        }

        $this->assertSame([], $this->driver->requests);
    }

    public function testAnUploadWithMetadataIsMultipart(): void
    {
        $this->driver->respond(200, ['id' => 'v1']);

        await($this->http->request(
            'videos.insert',
            'POST',
            'youtube/v3/videos',
            ['part' => 'snippet'],
            ['snippet' => ['title' => 'A test']],
            new Media('VIDEO-BYTES', 'video/mp4'),
            '/upload/youtube/v3/videos',
        ));

        $request = $this->driver->last();
        $this->assertSame('upload/youtube/v3/videos', ScriptedDriver::path($request));
        $this->assertSame([['uploadType', 'multipart'], ['part', 'snippet']], ScriptedDriver::queryPairs($request));
        $this->assertMatchesRegularExpression('/^multipart\/related; boundary=(youtubephp[0-9a-f]+)$/', (string) $request->getHeader('Content-Type'));

        $boundary = substr((string) $request->getHeader('Content-Type'), strlen('multipart/related; boundary='));
        $this->assertSame(
            "--{$boundary}\r\nContent-Type: application/json; charset=UTF-8\r\n\r\n{\"snippet\":{\"title\":\"A test\"}}\r\n"
            . "--{$boundary}\r\nContent-Type: video/mp4\r\n\r\nVIDEO-BYTES\r\n--{$boundary}--\r\n",
            $request->getContent(),
        );
    }

    public function testAnUploadWithoutMetadataIsTheFileAlone(): void
    {
        $this->driver->respond(200, ['kind' => 'youtube#thumbnailSetResponse']);

        await($this->http->request('thumbnails.set', 'POST', 'youtube/v3/thumbnails/set', ['videoId' => 'v1'], null, new Media('PNG', 'image/png'), '/upload/youtube/v3/thumbnails/set'));

        $request = $this->driver->last();
        $this->assertSame([['uploadType', 'media'], ['videoId', 'v1']], ScriptedDriver::queryPairs($request));
        $this->assertSame('image/png', $request->getHeader('Content-Type'));
        $this->assertSame('PNG', $request->getContent());
    }

    public function testADownloadResolvesWithTheBody(): void
    {
        $this->driver->respond(200, "1\n00:00:00,000 --> 00:00:01,000\nHello\n", ['Content-Type' => 'application/x-subrip']);

        $this->assertStringContainsString('Hello', await($this->http->request('captions.download', 'GET', 'youtube/v3/captions/c1', download: true)));
    }

    public function testAStreamResolvesAsSoonAsTheHeadersArrive(): void
    {
        $body = new ThroughStream();
        $this->driver->respond(200, $body);

        $response = await($this->http->stream('liveChatMessages.stream', 'youtube/v3/liveChat/messages/stream', ['liveChatId' => 'chat']));

        $this->assertTrue($this->driver->streaming[0]);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertTrue($body->isReadable(), 'still arriving');
    }

    public function testAStreamThatIsRefusedRejectsWithTheMappedError(): void
    {
        $body = new ThroughStream();
        $this->driver->respond(403, $body);
        Loop::futureTick(static function () use ($body): void {
            $body->end('[{"error": {"code": 403, "message": "The live chat is no longer live.", "errors": [{"reason": "liveChatEnded", "domain": "youtube.liveChat"}]}}]');
        });

        $this->expectException(LiveChatEndedException::class);

        await($this->http->stream('liveChatMessages.stream', 'youtube/v3/liveChat/messages/stream', ['liveChatId' => 'chat']));
    }
}
