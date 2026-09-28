<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Auth;

use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;

use function React\Promise\reject;

/**
 * Signs in again with Google's device flow: shows a code, then waits for
 * someone to enter it at `google.com/device` with the account that should be
 * signed in.
 *
 * The prompt callback receives `{verification_uri, user_code, expires_in,
 * interval}` and decides how to show it: a log line, a DM to the bot's owner.
 * The code lasts about thirty minutes. Polling follows the interval Google asks
 * for and slows down when told to.
 *
 * Google lets the device flow ask for only some scopes. Of YouTube's, those are
 * {@see DEVICE_SCOPES}: `youtube`, which covers reading, posting to and
 * moderating live chat, and `youtube.readonly`. Asking for any other fails
 * before a code is shown.
 *
 * @link https://developers.google.com/identity/protocols/oauth2/limited-input-device#allowedscopes
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
final class DeviceCodeReauthorizer implements ReauthorizerInterface
{
    /** The YouTube scopes Google allows a device sign-in to ask for. */
    public const DEVICE_SCOPES = [Scope::YOUTUBE, Scope::YOUTUBE_READONLY];

    private LoopInterface $loop;

    /** The attempt in flight, so concurrent callers share one prompt. */
    private ?PromiseInterface $pending = null;

    /**
     * @param list<string>                                     $scopes The scopes to ask for.
     * @param (callable(array<string, mixed>): void)|null        $prompt Shown the code to enter.
     * @param (\Closure(): int)|null                           $clock  The time as a Unix timestamp, for tests.
     */
    public function __construct(
        private readonly OAuth $oauth,
        private readonly array $scopes = [Scope::YOUTUBE],
        private $prompt = null,
        ?LoopInterface $loop = null,
        private readonly ?\Closure $clock = null,
    ) {
        $this->loop = $loop ?? Loop::get();
    }

    public function reauthorize(): PromiseInterface
    {
        return $this->pending ??= $this->start()->finally(function (): void {
            $this->pending = null;
        });
    }

    /** @return PromiseInterface<array<string, mixed>> */
    private function start(): PromiseInterface
    {
        $refused = array_values(array_diff($this->scopes, self::DEVICE_SCOPES));
        if ($refused !== []) {
            return reject(new OAuthException(
                'invalid_scope',
                'A device sign-in cannot ask for ' . implode(', ', $refused) . '. Ask for ' . implode(' or ', self::DEVICE_SCOPES) . ' instead',
            ));
        }

        return $this->oauth->deviceCode($this->scopes)->then(function (array $device): PromiseInterface {
            if ($this->prompt !== null) {
                ($this->prompt)($device);
            }

            $deferred = new Deferred();
            $this->poll(
                $deferred,
                (string) $device['device_code'],
                (float) ($device['interval'] ?? 5),
                $this->now() + (int) ($device['expires_in'] ?? 1800),
            );

            return $deferred->promise();
        });
    }

    /**
     * @param Deferred<array<string, mixed>> $deferred
     */
    private function poll(Deferred $deferred, string $deviceCode, float $interval, int $deadline): void
    {
        if ($this->now() >= $deadline) {
            $deferred->reject(new OAuthException('expired_token', 'The code expired before anyone entered it'));

            return;
        }

        $this->loop->addTimer(max(0.0, $interval), function () use ($deferred, $deviceCode, $interval, $deadline): void {
            $this->oauth->pollDeviceToken($deviceCode)->then(
                static fn (array $token) => $deferred->resolve($token),
                function (\Throwable $e) use ($deferred, $deviceCode, $interval, $deadline): void {
                    $error = $e instanceof OAuthException ? $e->getError() : '';

                    match ($error) {
                        // Not entered yet: keep waiting.
                        'authorization_pending' => $this->poll($deferred, $deviceCode, $interval, $deadline),
                        // Polling too often: Google asks for five more seconds.
                        'slow_down' => $this->poll($deferred, $deviceCode, $interval + 5, $deadline),
                        // A blip on the way to Google is not a refusal.
                        'transport_error' => $this->poll($deferred, $deviceCode, $interval, $deadline),
                        default => $deferred->reject($e),
                    };
                },
            );
        });
    }

    private function now(): int
    {
        return $this->clock !== null ? ($this->clock)() : time();
    }

    /**
     * A reauthorizer that never succeeds: the default, so a headless client
     * surfaces the original failure instead of waiting on a prompt nobody sees.
     */
    public static function disabled(): ReauthorizerInterface
    {
        return new class () implements ReauthorizerInterface {
            public function reauthorize(): PromiseInterface
            {
                return reject(new \RuntimeException('Signing in again is not set up: give the client a "device_prompt" or a "reauthorize" option'));
            }
        };
    }
}
