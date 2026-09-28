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
use React\Promise\PromiseInterface;

use function React\Promise\reject;
use function React\Promise\resolve;

use YouTube\Auth\OAuth;
use YouTube\Auth\ReauthorizerInterface;
use YouTube\Auth\TokenStoreInterface;
use YouTube\Http\Exceptions\QuotaExceededException;
use YouTube\Http\Exceptions\UnauthorizedException;
use YouTube\Parts\Channel;
use YouTube\YouTube;

/**
 * The client's grant: starting, refreshing, recovering from a 401, and
 * signing in again only when that is really what it takes.
 */
final class YouTubeTest extends TestCase
{
    private ScriptedDriver $driver;

    private int $now = 1_800_000_000;

    /** @var list<array<string, mixed>> */
    private array $saved = [];

    /** @var array<string, mixed> */
    private array $stored = [];

    private int $signIns = 0;

    /** @var (\Closure(): PromiseInterface)|null */
    private ?\Closure $signIn = null;

    protected function setUp(): void
    {
        $this->driver = new ScriptedDriver();
    }

    /** @param array<string, mixed> $options */
    private function client(array $options = [], ?FastLoop $loop = null): YouTube
    {
        return new YouTube($options + [
            'client_id' => 'client-id',
            'client_secret' => 'client-secret',
            'driver' => $this->driver,
            'loop' => $loop ?? new FastLoop(Loop::get(), fire: false),
            'clock' => fn (): float => (float) $this->now,
            'token_store' => $this->store(),
            'reauthorize' => $this->reauthorizer(),
        ]);
    }

    private function store(): TokenStoreInterface
    {
        return new class ($this) implements TokenStoreInterface {
            public function __construct(private readonly YouTubeTest $test)
            {
            }

            public function load(): array
            {
                return $this->test->stored();
            }

            public function save(array $token): void
            {
                $this->test->saved($token);
            }
        };
    }

    private function reauthorizer(): ReauthorizerInterface
    {
        return new class ($this) implements ReauthorizerInterface {
            public function __construct(private readonly YouTubeTest $test)
            {
            }

            public function reauthorize(): PromiseInterface
            {
                return $this->test->signingIn();
            }
        };
    }

    /** @internal */
    public function stored(): array
    {
        return $this->stored;
    }

    /** @internal */
    public function saved(array $token): void
    {
        $this->saved[] = $token;
    }

    /** @internal */
    public function signingIn(): PromiseInterface
    {
        ++$this->signIns;

        return $this->signIn !== null
            ? ($this->signIn)()
            : resolve(['access_token' => 'signed-in', 'refresh_token' => 'new-refresh', 'expires_in' => 3599]);
    }

    private function scriptChannel(): void
    {
        $this->driver->respond(200, [
            'kind' => 'youtube#channelListResponse',
            'items' => [['kind' => 'youtube#channel', 'id' => 'UCme', 'snippet' => ['title' => 'Me']]],
        ]);
    }

    private function scriptRefresh(string $token = 'fresh', array $extra = []): void
    {
        $this->driver->respond(200, ['access_token' => $token, 'expires_in' => 3599, 'scope' => 'https://www.googleapis.com/auth/youtube', 'token_type' => 'Bearer'] + $extra);
    }

    public function testStartingWithARefreshTokenMintsAnAccessTokenAndLoadsTheChannel(): void
    {
        $this->scriptRefresh();
        $this->scriptChannel();
        $youtube = $this->client(['refresh_token' => 'refresh']);
        $ready = 0;
        $youtube->on('ready', static function () use (&$ready): void {
            ++$ready;
        });

        $channel = await($youtube->bootstrap());

        $this->assertInstanceOf(Channel::class, $channel);
        $this->assertSame('UCme', $channel->id);
        $this->assertSame($channel, $youtube->getChannel());
        $this->assertSame(1, $ready);
        $this->assertSame(OAuth::TOKEN_URL, $this->driver->requests[0]->getUrl());
        $this->assertSame('Bearer fresh', $this->driver->requests[1]->getHeader('Authorization'));
        $this->assertContains(['mine', 'true'], ScriptedDriver::queryPairs($this->driver->requests[1]));
        $this->assertSame(0, $this->signIns);
    }

    public function testTheStoreFeedsTheStart(): void
    {
        $this->stored = ['refresh_token' => 'kept'];
        $this->scriptRefresh();
        $this->scriptChannel();

        await($this->client()->bootstrap());

        parse_str($this->driver->requests[0]->getContent(), $form);
        $this->assertSame('kept', $form['refresh_token']);
    }

    public function testWithNothingStoredItSignsInAndKeepsTheGrant(): void
    {
        $this->scriptChannel();

        await($this->client()->bootstrap());

        $this->assertSame(1, $this->signIns);
        $this->assertSame('new-refresh', $this->saved[0]['refresh_token']);
        $this->assertSame('Bearer signed-in', $this->driver->last()->getHeader('Authorization'));
    }

    public function testTheTokenIsRefreshedFiveMinutesBeforeItRunsOut(): void
    {
        $loop = new FastLoop(Loop::get(), fire: false);
        $this->scriptRefresh();
        $this->scriptChannel();

        await($this->client(['refresh_token' => 'refresh'], $loop)->bootstrap());

        $this->assertSame([3599.0 - YouTube::REFRESH_BEFORE], $loop->delays);
    }

    public function testA401IsRecoveredFromAndTheCallRetried(): void
    {
        $youtube = $this->client(['token' => 'stale', 'refresh_token' => 'refresh']);
        $this->driver->error(401, 'authError', 'Invalid Credentials');
        $this->scriptRefresh('fresh');
        $this->scriptChannel();

        $response = await($youtube->channels->list(part: 'id', mine: true));

        $this->assertSame('UCme', $response->items->first()->id);
        $this->assertCount(3, $this->driver->requests);
        $this->assertSame('Bearer fresh', $this->driver->last()->getHeader('Authorization'));
    }

    public function testRecoveryIsTriedOnceAndThenTheOriginal401Surfaces(): void
    {
        $youtube = $this->client(['token' => 'stale', 'refresh_token' => 'refresh']);
        $this->driver->error(401, 'authError', 'Invalid Credentials');
        $this->scriptRefresh('fresh');
        $this->driver->error(401, 'authError', 'Invalid Credentials');

        $this->expectException(UnauthorizedException::class);

        try {
            await($youtube->channels->list(part: 'id', mine: true));
        } finally {
            $this->assertCount(3, $this->driver->requests, 'no recovery loop');
        }
    }

    public function testARevokedGrantSignsInAgain(): void
    {
        $youtube = $this->client(['token' => 'stale', 'refresh_token' => 'revoked']);
        $this->driver->error(401, 'authError', 'Invalid Credentials');
        $this->driver->respond(400, ['error' => 'invalid_grant', 'error_description' => 'Token has been expired or revoked.']);
        $this->scriptChannel();

        await($youtube->channels->list(part: 'id', mine: true));

        $this->assertSame(1, $this->signIns);
        $this->assertSame('new-refresh', $this->saved[0]['refresh_token']);
    }

    public function testANetworkBlipDuringARefreshAsksNobodyForACode(): void
    {
        $youtube = $this->client(['token' => 'stale', 'refresh_token' => 'refresh']);
        $this->driver->error(401, 'authError', 'Invalid Credentials');
        $this->driver->fail(new \RuntimeException('Connection timed out'));

        try {
            await($youtube->channels->list(part: 'id', mine: true));
            $this->fail('expected the 401 to surface');
        } catch (UnauthorizedException) {
            $this->assertSame(0, $this->signIns, 'the grant is fine; the network is not');
        }
    }

    public function testConcurrent401sShareOneRefresh(): void
    {
        $youtube = $this->client(['token' => 'stale', 'refresh_token' => 'refresh']);
        $refresh = new \React\Promise\Deferred();

        // The first call's refresh is still out when the second call's 401 arrives.
        $this->driver->error(401, 'authError');
        $this->driver->handle(static fn (): PromiseInterface => $refresh->promise());
        $this->driver->error(401, 'authError');
        $this->scriptChannel();
        $this->scriptChannel();

        $first = $youtube->channels->list(part: 'id', mine: true);
        $second = $youtube->channels->list(part: 'id', mine: true);
        $refresh->resolve(new \React\Http\Message\Response(200, [], '{"access_token": "fresh", "expires_in": 3599}'));
        await(\React\Promise\all([$first, $second]));

        $tokenRequests = array_filter($this->driver->requests, static fn ($request): bool => $request->getUrl() === OAuth::TOKEN_URL);
        $this->assertCount(1, $tokenRequests, 'one refresh, shared');
        $this->assertSame('Bearer fresh', $this->driver->last()->getHeader('Authorization'));
    }

    public function testAConsentScreenInTestingIsFlagged(): void
    {
        $this->scriptRefresh('fresh', ['refresh_token_expires_in' => 604799]);
        $this->scriptChannel();
        $youtube = $this->client(['refresh_token' => 'refresh']);
        $warned = [];
        $youtube->on('grant_expires', static function (int $seconds) use (&$warned): void {
            $warned[] = $seconds;
        });

        await($youtube->bootstrap());

        $this->assertSame([604799], $warned);
    }

    public function testRunningOutOfQuotaIsAnnouncedOnceADay(): void
    {
        $youtube = $this->client(['token' => 'token']);
        $announced = [];
        $youtube->on('quota.exhausted', static function (string $bucket) use (&$announced): void {
            $announced[] = $bucket;
        });
        $this->driver->error(403, 'quotaExceeded', 'The request cannot be completed because you have exceeded your quota.');

        foreach ([1, 2] as $attempt) {
            try {
                await($youtube->liveChatMessages->list('chat', 'snippet'));
                $this->fail('expected quotaExceeded');
            } catch (QuotaExceededException $e) {
                $this->assertSame($attempt === 2, $e->isLocal(), 'after the first, the meter refuses without asking');
            }
        }

        $this->assertSame(['default'], $announced);
        $this->assertCount(1, $this->driver->requests);
    }

    public function testAnApiKeyAloneSignsNobodyIn(): void
    {
        $youtube = new YouTube(['api_key' => 'the-key', 'driver' => $this->driver, 'loop' => Loop::get()]);
        $this->driver->respond(200, ['items' => []]);

        $this->assertNull(await($youtube->bootstrap()));
        $this->assertFalse($youtube->isSignedIn());

        await($youtube->videos->list('snippet', id: 'abc'));
        $this->assertSame('the-key', $this->driver->last()->getHeader('X-Goog-Api-Key'));
    }

    public function testNoCredentialsIsAClearError(): void
    {
        $this->expectExceptionMessage('YouTube needs credentials');

        await((new YouTube(['driver' => $this->driver, 'loop' => Loop::get()]))->bootstrap());
    }

    public function testAFailedSignInSurfaces(): void
    {
        $this->signIn = static fn (): PromiseInterface => reject(new \RuntimeException('Nobody entered the code'));

        $this->expectExceptionMessage('Nobody entered the code');

        await($this->client()->bootstrap());
    }

    public function testUnknownQuotaOptionsAreRefused(): void
    {
        $this->expectExceptionMessage('Unknown quota option(s): dialy');

        new YouTube(['quota' => ['dialy' => 5000], 'driver' => $this->driver]);
    }
}
