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
use YouTube\Auth\DeviceCodeReauthorizer;
use YouTube\Auth\OAuth;
use YouTube\Auth\OAuthException;
use YouTube\Auth\Scope;

/**
 * Google's OAuth endpoints, and the device sign-in built on them.
 */
final class OAuthTest extends TestCase
{
    private ScriptedDriver $driver;

    private OAuth $oauth;

    private int $now = 1_800_000_000;

    protected function setUp(): void
    {
        $this->driver = new ScriptedDriver();
        $this->oauth = new OAuth('client-id', 'client-secret', $this->driver, fn (): int => $this->now);
    }

    /** @return array<string, string> */
    private static function form(\YouTube\Http\Request $request): array
    {
        parse_str($request->getContent(), $fields);

        return $fields;
    }

    public function testADeviceCodeCarriesTheAddressUnderBothNames(): void
    {
        $this->driver->respond(200, [
            'device_code' => 'dev',
            'user_code' => 'ABC-DEF-GHI',
            'verification_url' => 'https://www.google.com/device',
            'expires_in' => 1800,
            'interval' => 5,
        ]);

        $device = await($this->oauth->deviceCode([Scope::YOUTUBE]));

        $this->assertSame('https://www.google.com/device', $device['verification_uri']);
        $this->assertSame('https://www.google.com/device', $device['verification_url']);
        $this->assertSame(OAuth::DEVICE_CODE_URL, $this->driver->last()->getUrl());
        $this->assertSame(['client_id' => 'client-id', 'scope' => Scope::YOUTUBE], self::form($this->driver->last()));
    }

    public function testARefreshComesBackWithItsScopesListedAndItsExpiry(): void
    {
        $this->driver->respond(200, [
            'access_token' => 'fresh',
            'expires_in' => 3599,
            'scope' => Scope::YOUTUBE . ' ' . Scope::YOUTUBE_READONLY,
            'token_type' => 'Bearer',
        ]);

        $token = await($this->oauth->refreshToken('refresh'));

        $this->assertSame('fresh', $token['access_token']);
        $this->assertSame([Scope::YOUTUBE, Scope::YOUTUBE_READONLY], $token['scope']);
        $this->assertSame($this->now + 3599, $token['expires_at']);
        $this->assertSame([
            'client_id' => 'client-id',
            'client_secret' => 'client-secret',
            'grant_type' => 'refresh_token',
            'refresh_token' => 'refresh',
        ], self::form($this->driver->last()));
    }

    public function testARefusalCarriesTheOAuthErrorCode(): void
    {
        $this->driver->respond(400, ['error' => 'invalid_grant', 'error_description' => 'Token has been expired or revoked.']);

        try {
            await($this->oauth->refreshToken('revoked'));
            $this->fail('expected invalid_grant');
        } catch (OAuthException $e) {
            $this->assertTrue($e->isInvalidGrant());
            $this->assertSame(400, $e->getStatus());
            $this->assertSame('Token has been expired or revoked.', $e->getDescription());
            $this->assertStringNotContainsString('revoked"', $e->getMessage());
        }
    }

    public function testNoSecretIsRefusedBeforeAskingGoogle(): void
    {
        $oauth = new OAuth('client-id', '', $this->driver);

        try {
            await($oauth->refreshToken('refresh'));
            $this->fail('expected a refusal');
        } catch (OAuthException $e) {
            $this->assertSame('invalid_client', $e->getError());
        }

        $this->assertSame([], $this->driver->requests);
    }

    public function testTheDeviceSignInWaitsForApproval(): void
    {
        $prompts = [];
        $this->scriptDeviceCode(interval: 5);
        $this->driver
            ->respond(428, ['error' => 'authorization_pending', 'error_description' => 'Precondition Required'])
            ->respond(403, ['error' => 'slow_down', 'error_description' => 'Forbidden'])
            ->respond(200, ['access_token' => 'new', 'refresh_token' => 'new-refresh', 'expires_in' => 3599, 'scope' => Scope::YOUTUBE]);

        $loop = new FastLoop(Loop::get());
        $reauthorizer = new DeviceCodeReauthorizer($this->oauth, [Scope::YOUTUBE], function (array $device) use (&$prompts): void {
            $prompts[] = $device;
        }, $loop, fn (): int => $this->now);

        $token = await($reauthorizer->reauthorize());

        $this->assertSame('new-refresh', $token['refresh_token']);
        $this->assertCount(1, $prompts);
        $this->assertSame('ABC-DEF-GHI', $prompts[0]['user_code']);
        $this->assertCount(4, $this->driver->requests, 'the code, two waits, the token');
        $this->assertSame([5.0, 5.0, 10.0], $loop->delays, 'the interval Google asked for, then five seconds more when told to slow down');
        $this->assertSame(OAuth::DEVICE_GRANT, self::form($this->driver->last())['grant_type']);
    }

    public function testTwoCallersShareOneSignIn(): void
    {
        $this->scriptDeviceCode();
        $this->driver->respond(200, ['access_token' => 'new', 'expires_in' => 3599]);
        $prompts = 0;

        $reauthorizer = new DeviceCodeReauthorizer($this->oauth, [Scope::YOUTUBE], function () use (&$prompts): void {
            ++$prompts;
        }, Loop::get(), fn (): int => $this->now);

        $first = $reauthorizer->reauthorize();
        $second = $reauthorizer->reauthorize();

        $this->assertSame(await($first), await($second));
        $this->assertSame(1, $prompts, 'nobody is shown two codes');
    }

    public function testADeclinedSignInIsNotRetried(): void
    {
        $this->scriptDeviceCode();
        $this->driver->respond(403, ['error' => 'access_denied', 'error_description' => 'Forbidden']);

        $reauthorizer = new DeviceCodeReauthorizer($this->oauth, [Scope::YOUTUBE], null, Loop::get(), fn (): int => $this->now);

        try {
            await($reauthorizer->reauthorize());
            $this->fail('expected access_denied');
        } catch (OAuthException $e) {
            $this->assertSame('access_denied', $e->getError());
        }

        $this->assertSame(0, $this->driver->remaining());
    }

    public function testACodeNobodyEntersExpires(): void
    {
        $this->driver->respond(200, ['device_code' => 'dev', 'user_code' => 'X', 'verification_url' => 'https://www.google.com/device', 'expires_in' => 60, 'interval' => 0]);
        $this->driver->handle(function (): \React\Http\Message\Response {
            $this->now += 61;

            return new \React\Http\Message\Response(428, [], '{"error": "authorization_pending"}');
        });

        $reauthorizer = new DeviceCodeReauthorizer($this->oauth, [Scope::YOUTUBE], null, Loop::get(), fn (): int => $this->now);

        try {
            await($reauthorizer->reauthorize());
            $this->fail('expected the code to expire');
        } catch (OAuthException $e) {
            $this->assertSame('expired_token', $e->getError());
        }
    }

    public function testAScopeTheDeviceFlowCannotHaveIsRefusedUpFront(): void
    {
        $reauthorizer = new DeviceCodeReauthorizer($this->oauth, [Scope::YOUTUBE_FORCE_SSL], null, Loop::get());

        try {
            await($reauthorizer->reauthorize());
            $this->fail('expected invalid_scope');
        } catch (OAuthException $e) {
            $this->assertSame('invalid_scope', $e->getError());
            $this->assertStringContainsString(Scope::YOUTUBE_FORCE_SSL, $e->getMessage());
        }

        $this->assertSame([], $this->driver->requests);
    }

    private function scriptDeviceCode(int $interval = 0): void
    {
        $this->driver->respond(200, [
            'device_code' => 'dev',
            'user_code' => 'ABC-DEF-GHI',
            'verification_url' => 'https://www.google.com/device',
            'expires_in' => 1800,
            'interval' => $interval,
        ]);
    }
}
