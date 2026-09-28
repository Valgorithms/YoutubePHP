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

use Psr\Http\Message\ResponseInterface;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;

use function React\Promise\reject;

use YouTube\Http\DriverInterface;
use YouTube\Http\Drivers\React as ReactDriver;
use YouTube\Http\Request;

/**
 * Google's OAuth 2.0 endpoints, for the two grants a headless bot needs:
 *
 * - **Device sign-in:** {@see deviceCode()} gets a code for the user to enter
 *   at `google.com/device`, and {@see pollDeviceToken()} waits for them.
 *   {@see DeviceCodeReauthorizer} runs the whole exchange.
 * - **Refresh:** {@see refreshToken()} trades the long-lived refresh token for
 *   an access token, which lasts an hour. Google does not rotate refresh
 *   tokens, so the one from sign-in keeps working until it is revoked.
 *
 * Both need the OAuth client's secret, even for a client of the "TVs and
 * Limited Input devices" type. Token payloads come back with `scope` as a list
 * and an `expires_at` Unix time added beside Google's `expires_in`.
 *
 * Nothing here is charged against the API quota.
 *
 * @link https://developers.google.com/identity/protocols/oauth2/limited-input-device
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
final class OAuth
{
    public const DEVICE_CODE_URL = 'https://oauth2.googleapis.com/device/code';

    public const TOKEN_URL = 'https://oauth2.googleapis.com/token';

    public const REVOKE_URL = 'https://oauth2.googleapis.com/revoke';

    /** The grant type a device sign-in is polled with. */
    public const DEVICE_GRANT = 'urn:ietf:params:oauth:grant-type:device_code';

    /**
     * @param (\Closure(): int)|null $clock The time as a Unix timestamp, for tests.
     */
    public function __construct(
        private readonly string $clientId,
        private readonly string $clientSecret,
        private readonly DriverInterface $driver,
        private readonly ?\Closure $clock = null,
    ) {
    }

    /**
     * @param array<string, mixed> $socketOptions Forwarded to the socket connector.
     */
    public static function create(
        string $clientId,
        string $clientSecret = '',
        ?LoopInterface $loop = null,
        array $socketOptions = [],
    ): self {
        return new self($clientId, $clientSecret, new ReactDriver($loop ?? Loop::get(), $socketOptions, 20.0));
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * Starts a device sign-in.
     *
     * Google calls the address `verification_url`; the payload carries it as
     * `verification_uri` too, the RFC 8628 name other providers use.
     *
     * @param list<string> $scopes
     *
     * @return PromiseInterface<array{device_code: string, user_code: string, verification_uri: string, verification_url: string, expires_in: int, interval: int}>
     */
    public function deviceCode(array $scopes): PromiseInterface
    {
        return $this->form('oauth.deviceCode', self::DEVICE_CODE_URL, [
            'client_id' => $this->clientId,
            'scope' => implode(' ', $scopes),
        ])->then(static function (array $device): array {
            $device['verification_uri'] ??= $device['verification_url'] ?? 'https://www.google.com/device';
            $device['verification_url'] ??= $device['verification_uri'];

            return $device;
        });
    }

    /**
     * Asks whether a device sign-in has been approved yet. Rejects with an
     * {@see OAuthException} whose error is `authorization_pending` until it is.
     *
     * @return PromiseInterface<array<string, mixed>> The token payload.
     */
    public function pollDeviceToken(string $deviceCode): PromiseInterface
    {
        return $this->form('oauth.token', self::TOKEN_URL, [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'device_code' => $deviceCode,
            'grant_type' => self::DEVICE_GRANT,
        ])->then($this->normalise(...));
    }

    /**
     * A fresh access token for a refresh token.
     *
     * @return PromiseInterface<array<string, mixed>> The token payload, without a refresh token:
     *                                               the one sent keeps working.
     */
    public function refreshToken(string $refreshToken): PromiseInterface
    {
        return $this->form('oauth.token', self::TOKEN_URL, [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ])->then($this->normalise(...));
    }

    /**
     * Revokes a token, and with it the whole grant: revoking an access token
     * revokes its refresh token too.
     *
     * @return PromiseInterface<null>
     */
    public function revoke(string $token): PromiseInterface
    {
        return $this->form('oauth.revoke', self::REVOKE_URL, ['token' => $token])->then(static fn (): mixed => null);
    }

    /**
     * @param array<string, string> $params
     *
     * @return PromiseInterface<array<string, mixed>>
     */
    private function form(string $endpoint, string $url, array $params): PromiseInterface
    {
        if (array_key_exists('client_secret', $params) && $this->clientSecret === '') {
            return reject(new OAuthException('invalid_client', 'Google needs the OAuth client secret for this, even for a device client'));
        }

        $request = new Request($endpoint, 'POST', $url, http_build_query($params, '', '&', PHP_QUERY_RFC3986), [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
        ]);

        return $this->driver->runRequest($request)->then(
            static function (ResponseInterface $response): array {
                $status = $response->getStatusCode();
                $body = (string) $response->getBody();
                $data = json_decode($body, true);

                if ($status >= 200 && $status < 300) {
                    return is_array($data) ? $data : [];
                }

                throw new OAuthException(
                    is_array($data) && is_string($data['error'] ?? null) ? $data['error'] : 'http_' . $status,
                    is_array($data) && is_string($data['error_description'] ?? null) ? $data['error_description'] : '',
                    $status,
                );
            },
            static function (\Throwable $e): never {
                throw $e instanceof OAuthException ? $e : new OAuthException('transport_error', $e->getMessage(), 0, $e);
            },
        );
    }

    /**
     * @param array<string, mixed> $token
     *
     * @return array<string, mixed>
     */
    private function normalise(array $token): array
    {
        if (is_string($token['scope'] ?? null)) {
            $token['scope'] = array_values(array_filter(explode(' ', $token['scope'])));
        }

        if (isset($token['expires_in']) && is_numeric($token['expires_in'])) {
            $token['expires_in'] = (int) $token['expires_in'];
            $token['expires_at'] = $this->now() + $token['expires_in'];
        }

        return $token;
    }

    private function now(): int
    {
        return $this->clock !== null ? ($this->clock)() : time();
    }
}
