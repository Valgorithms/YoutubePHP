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
use YouTube\Examples\ReviewedUpload;
use YouTube\Examples\SingleInsertDriver;
use YouTube\Http\Request;
use YouTube\YouTube;

require_once dirname(__DIR__) . '/examples/ReviewedUpload.php';

/** Offline documentation contracts; this synthetic byte string is not gameplay. */
final class ReviewedUploadTest extends TestCase
{
    private const CHANNEL = 'UC1234567890123456789012';

    private const ID = 'abcDEF123_-';

    private string $path;

    private ScriptedDriver $driver;

    private ReviewedUpload $example;

    protected function setUp(): void
    {
        $this->path = tempnam(sys_get_temp_dir(), 'youtubephp-example-');
        file_put_contents($this->path, "\0\0\0\x18ftypmp42offline-fixture");
        $this->driver = new ScriptedDriver();
        $youtube = new YouTube([
            'token' => 'mock-access-token',
            'scopes' => ReviewedUpload::SCOPES,
            'driver' => new SingleInsertDriver($this->driver),
            'loop' => Loop::get(),
        ]);
        $this->example = new ReviewedUpload($youtube);
    }

    protected function tearDown(): void
    {
        unlink($this->path);
    }

    private function owner(string $channel = self::CHANNEL): void
    {
        $this->driver->respond(200, ['items' => [['id' => $channel]]]);
    }

    private function insert(string $privacy = 'unlisted', ?\Closure $reserve = null, ?\Closure $saveId = null): mixed
    {
        return await($this->example->insert(
            $this->path,
            hash_file('sha256', $this->path),
            self::CHANNEL,
            $privacy,
            'Reviewed development clip',
            'Observed behavior and known limits.',
            $reserve ?? static fn (): bool => true,
            $saveId ?? static fn (): bool => true,
        ));
    }

    public static function privacyCases(): array
    {
        return [['unlisted'], ['public']];
    }

    #[DataProvider('privacyCases')]
    public function testReservesBeforeSendingAndPersistsIdBeforeReadback(string $privacy): void
    {
        $this->owner();
        $events = [];
        $this->driver->handle(function (Request $request) use (&$events, $privacy) {
            $this->assertSame(['reserved'], $events);
            $this->assertSame('POST', $request->getMethod());
            $this->assertSame('videos.insert', $request->getEndpoint());
            $this->assertContains(['notifySubscribers', 'false'], ScriptedDriver::queryPairs($request));
            $content = $request->getContent();
            $this->assertStringContainsString('"privacyStatus":"' . $privacy . '"', $content);
            $this->assertStringContainsString('"selfDeclaredMadeForKids":false', $content);
            $this->assertStringContainsString('"containsSyntheticMedia":false', $content);
            $this->assertStringContainsString('Content-Type: video/mp4', $content);
            $this->assertStringContainsString(file_get_contents($this->path), $content);
            $events[] = 'insert';

            return new \React\Http\Message\Response(200, [], json_encode(['id' => self::ID]));
        });
        $id = $this->insert($privacy, function ($channel, $sha) use (&$events): bool {
            $this->assertSame(self::CHANNEL, $channel);
            $this->assertSame(hash_file('sha256', $this->path), $sha);
            $events[] = 'reserved';

            return true;
        }, function ($id) use (&$events): bool {
            $this->assertSame(self::ID, $id);
            $events[] = 'saved';

            return true;
        });
        $this->assertSame(self::ID, $id);
        $this->assertSame(['reserved', 'insert', 'saved'], $events);
        $this->assertCount(2, $this->driver->requests); // No implicit verification before persistence.
    }

    public function testRejectedReservationSendsNoMedia(): void
    {
        $this->owner();
        try {
            $this->insert(reserve: static fn (): bool => false);
            $this->fail('Expected reservation rejection');
        } catch (\RuntimeException $error) {
            $this->assertStringContainsString('Reservation', $error->getMessage());
        }
        $this->assertCount(1, $this->driver->requests);
    }

    public function testWrongChannelDoesNotReserveOrInsert(): void
    {
        $this->owner('UC0000000000000000000000');
        $reserved = false;
        try {
            $this->insert(reserve: function () use (&$reserved): bool {
                $reserved = true;

                return true;
            });
            $this->fail('Expected channel rejection');
        } catch (\RuntimeException $error) {
            $this->assertSame('Wrong owner channel', $error->getMessage());
        }
        $this->assertFalse($reserved);
        $this->assertCount(1, $this->driver->requests);
    }

    public static function errorCases(): array
    {
        return [[401], [429], [503], [0]];
    }

    #[DataProvider('errorCases')]
    public function testAmbiguousInsertNeverRetriesAndDoesNotPersistInventedId(int $status): void
    {
        $this->owner();
        if ($status === 0) {
            $this->driver->fail(new \RuntimeException('secret service details'));
        } else {
            $this->driver->error($status, 'rateLimitExceeded', 'secret service details');
        }
        $saved = false;
        try {
            $this->insert(saveId: function () use (&$saved): bool {
                $saved = true;

                return true;
            });
            $this->fail('Expected sanitized failure');
        } catch (\Throwable $error) {
            $this->assertStringNotContainsString('secret service details', $error->getMessage());
        }
        $this->assertFalse($saved);
        $this->assertCount(2, $this->driver->requests);
    }

    public function testUnknownIdAndFailedPersistenceCannotReportSuccess(): void
    {
        $this->owner();
        $this->driver->respond(200, ['id' => self::ID]);
        $this->expectExceptionMessage('ID persistence unconfirmed');
        $this->insert(saveId: static fn (): bool => false);
    }

    public function testHashMismatchStopsBeforeAnyRequest(): void
    {
        try {
            $this->example->insert(
                $this->path,
                str_repeat('0', 64),
                self::CHANNEL,
                'unlisted',
                'Title',
                '',
                static fn (): bool => true,
                static fn (): bool => true,
            );
            $this->fail('Expected hash rejection');
        } catch (\InvalidArgumentException $error) {
            $this->assertSame('Invalid reviewed media', $error->getMessage());
        }
        $this->assertCount(0, $this->driver->requests);
    }

    public static function readbackCases(): array
    {
        return [
            ['unlisted', self::CHANNEL, 'processed', 'succeeded', true],
            ['unlisted', self::CHANNEL, 'uploaded', 'processing', false],
            ['private', self::CHANNEL, 'processed', 'succeeded', null],
            ['unlisted', 'UC0000000000000000000000', 'processed', 'succeeded', null],
            ['unlisted', self::CHANNEL, 'rejected', 'failed', null],
        ];
    }

    #[DataProvider('readbackCases')]
    public function testKnownIdVerificationNeverInserts(string $privacy, string $channel, string $upload, string $processing, ?bool $expected): void
    {
        $this->driver->respond(200, ['items' => [[
            'id' => self::ID, 'snippet' => ['channelId' => $channel],
            'status' => ['privacyStatus' => $privacy, 'uploadStatus' => $upload],
            'processingDetails' => ['processingStatus' => $processing],
        ]]]);
        try {
            $actual = await($this->example->verified(self::ID, self::CHANNEL, 'unlisted'));
            $this->assertNotNull($expected);
            $this->assertSame($expected, $actual);
        } catch (\RuntimeException $error) {
            $this->assertNull($expected);
            $this->assertSame('Owner readback mismatch', $error->getMessage());
        }
        $this->assertCount(1, $this->driver->requests);
        $this->assertSame('videos.list', $this->driver->last()->getEndpoint());
    }

    public function testDriverBlocksSecondInsertAndUnexpectedEndpoint(): void
    {
        $inner = new ScriptedDriver();
        $inner->respond(200, []);
        $driver = new SingleInsertDriver($inner);
        $insert = new Request('videos.insert', 'POST', 'https://youtube.googleapis.com/upload/youtube/v3/videos');
        $this->assertSame(200, await($driver->runRequest($insert))->getStatusCode());
        $this->assertSame(400, await($driver->runRequest($insert))->getStatusCode());
        $this->assertSame(400, await($driver->runRequest(new Request('videos.list', 'GET', 'https://attacker.invalid/youtube/v3/videos')))->getStatusCode());
        $this->assertCount(1, $inner->requests);
    }
}
