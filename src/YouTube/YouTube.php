<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube;

use Evenement\EventEmitterInterface;
use Evenement\EventEmitterTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;

use function React\Promise\reject;
use function React\Promise\resolve;

use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use YouTube\Api\Resources;
use YouTube\Auth\DeviceCodeReauthorizer;
use YouTube\Auth\OAuth;
use YouTube\Auth\OAuthException;
use YouTube\Auth\ReauthorizerInterface;
use YouTube\Auth\Scope;
use YouTube\Auth\TokenStoreInterface;
use YouTube\Factory\Factory;
use YouTube\Http\DriverInterface;
use YouTube\Http\Drivers\React as ReactDriver;
use YouTube\Http\Exceptions\QuotaExceededException;
use YouTube\Http\Exceptions\UnauthorizedException;
use YouTube\Http\Http;
use YouTube\Http\Media;
use YouTube\Parts\Channel;
use YouTube\Parts\ChannelListResponse;
use YouTube\Quota\Cost;
use YouTube\Quota\Meter;

/**
 * The YouTube client: the same role `Discord\Discord` plays under DiscordPHP.
 *
 * It owns the OAuth grant, the {@see Http} transport, the {@see Factory}, the
 * quota {@see Meter}, and one API object per resource of the Data API v3:
 * `$youtube->liveChatMessages`, `$youtube->videos`, and the rest, generated from
 * Google's discovery document ({@see Resources}).
 *
 * ```php
 * $youtube = new YouTube([
 *     'client_id' => '...',
 *     'client_secret' => '...',
 *     'token_store' => new EnvFileTokenStore(__DIR__ . '/.env'),
 *     'device_prompt' => fn (array $device) => print("Enter {$device['user_code']} at {$device['verification_uri']}\n"),
 * ]);
 *
 * $youtube->on('ready', function (YouTube $youtube) {
 *     $youtube->liveBroadcasts->list(part: 'snippet', broadcastStatus: 'active')
 *         ->then(fn ($response) => print(count($response->items) . " live now\n"));
 * });
 *
 * $youtube->run();
 * ```
 *
 * The grant looks after itself:
 *
 * - **Start:** a refresh token, from the options or the `token_store`, is
 *   traded for an access token. With none, a `device_prompt` signs in with
 *   Google's device flow and the store keeps the result.
 * - **Refresh:** access tokens last an hour, and each is refreshed five
 *   minutes before it runs out. A call that still gets a 401 recovers the
 *   token and is retried once.
 * - **Revoked:** when Google refuses the refresh token itself (`invalid_grant`)
 *   the client signs in again. A refresh that fails for any other reason, such
 *   as the network, is not a reason to ask anyone for a code.
 *
 * With only an `api_key` the client reads public data and signs nobody in.
 *
 * Events:
 *
 * | Event             | Arguments                                   | When                                           |
 * | ----------------- | ------------------------------------------- | ---------------------------------------------- |
 * | `ready`           | `YouTube`                                   | Signed in, with the account's channel loaded.  |
 * | `error`           | `Throwable`, `YouTube`                      | {@see run()} could not start.                  |
 * | `token_refreshed` | `YouTube`                                   | A new access token from the refresh token.     |
 * | `reauthorized`    | `YouTube`                                   | A new grant from signing in again.             |
 * | `grant_expires`   | `int` seconds, `YouTube`                    | Google will end the grant soon, see below.     |
 * | `quota.exhausted` | `string` bucket, `CarbonImmutable` reset, `YouTube` | A quota bucket ran out today. Once a day each. |
 * | `closed`          | `YouTube`                                   | {@see close()} was called.                     |
 *
 * `grant_expires` means the Google Cloud project's OAuth consent screen is in
 * *Testing*, where every grant ends after seven days. Publishing the app ends
 * that.
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
final class YouTube implements EventEmitterInterface
{
    use EventEmitterTrait;
    use Resources;

    public const VERSION = '1.0.0';

    /** Seconds before an access token expires that it is refreshed. */
    public const REFRESH_BEFORE = 300;

    /** @var array<string, mixed> */
    private array $options;

    private LoopInterface $loop;

    private LoggerInterface $logger;

    private Http $http;

    private OAuth $oauth;

    private Factory $factory;

    private Meter $meter;

    private ReauthorizerInterface $reauthorizer;

    private ?TokenStoreInterface $tokenStore;

    private ?string $token;

    private ?string $refreshToken;

    /** When the access token expires, as a Unix time, if known. */
    private ?int $expiresAt = null;

    /** @var list<string> The scopes the grant holds, once Google has said. */
    private array $scopes = [];

    /** The refresh in flight, shared by every caller that arrives during it. */
    private ?PromiseInterface $refreshing = null;

    /** The sign-in in flight, shared the same way. */
    private ?PromiseInterface $reauthorizing = null;

    private ?TimerInterface $refreshTimer = null;

    private ?Channel $channel = null;

    private ?PromiseInterface $loadingChannel = null;

    /** @var array<string, string> Bucket => the quota day it was reported exhausted. */
    private array $exhausted = [];

    /**
     * @param array<string, mixed> $options
     *
     *     client_id      string                The OAuth client's id.
     *     client_secret  string                Its secret. Google needs it even for a device client.
     *     token          ?string               An access token.
     *     refresh_token  ?string               A refresh token, from an earlier sign-in.
     *     api_key        ?string               For public data, when nobody signs in.
     *     scopes         list<string>          What a sign-in asks for. Default: {@see Scope::YOUTUBE}.
     *     token_store    ?TokenStoreInterface  Where the grant is kept between runs.
     *     device_prompt  ?callable             Signs in with the device flow, showing it the code.
     *     reauthorize    ?ReauthorizerInterface Any other way to sign in again.
     *     quota          array                 `daily`, `search`, `uploads`: the project's allowances.
     *                                          `reserve`: units background work leaves alone.
     *                                          `path`: a file to keep the count in.
     *     loop           ?LoopInterface
     *     logger         ?LoggerInterface
     *     socket_options array                 For `React\Socket\Connector`.
     *     driver         ?DriverInterface      Replaces the HTTP driver, for tests.
     *     clock          ?\Closure(): float    Replaces the clock, for tests.
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options);

        $this->loop = $this->options['loop'];
        $this->logger = $this->options['logger'];
        $this->tokenStore = $this->options['token_store'];
        $this->token = $this->options['token'];
        $this->refreshToken = $this->options['refresh_token'];

        // Fall back to what the last run kept, so a grant survives a restart
        // without the caller plumbing it through.
        if ($this->tokenStore !== null) {
            $stored = $this->tokenStore->load();
            $this->token ??= $stored['access_token'] ?? null;
            $this->refreshToken ??= $stored['refresh_token'] ?? null;
            $this->expiresAt = isset($stored['expires_at']) ? (int) $stored['expires_at'] : null;
        }

        $driver = $this->options['driver'];

        $this->http = new Http($this->loop, $this->logger, $driver ?? new ReactDriver($this->loop, $this->options['socket_options']));
        $this->http->setApiKey($this->options['api_key']);
        $this->http->setToken($this->token);

        $quota = $this->options['quota'];
        $this->meter = new Meter(
            ['default' => $quota['daily'], 'search' => $quota['search'], 'uploads' => $quota['uploads']],
            $quota['reserve'],
            $quota['path'],
            $this->options['clock'],
            $this->logger,
        );
        $this->http->setMeter($this->meter);

        $this->oauth = new OAuth(
            $this->options['client_id'],
            $this->options['client_secret'],
            $driver ?? new ReactDriver($this->loop, $this->options['socket_options'], 20.0),
            $this->options['clock'] === null ? null : fn (): int => (int) ($this->options['clock'])(),
        );

        $this->reauthorizer = $this->options['reauthorize']
            ?? ($this->options['device_prompt'] !== null
                ? new DeviceCodeReauthorizer($this->oauth, $this->options['scopes'], $this->options['device_prompt'], $this->loop, $this->options['clock'] === null ? null : fn (): int => (int) ($this->options['clock'])())
                : DeviceCodeReauthorizer::disabled());

        $this->factory = new Factory($this);
        $this->bootResources();
    }

    /**
     * Signs in, loads the account's channel, and emits `ready`.
     *
     * @return PromiseInterface<Channel|null> The signed-in account's channel, or null with only an API key.
     */
    public function bootstrap(): PromiseInterface
    {
        return $this->acquireToken()
            ->then(fn (): PromiseInterface => $this->token === null ? resolve(null) : $this->me())
            ->then(function (?Channel $channel): ?Channel {
                $this->logger->info('youtube client ready', $channel === null ? [] : [
                    'channel' => $channel->snippet?->title,
                    'channel_id' => $channel->id,
                ]);
                $this->emit('ready', [$this]);

                return $channel;
            });
    }

    /** Bootstraps, then runs the event loop. */
    public function run(): void
    {
        $this->bootstrap()->then(null, function (\Throwable $e): void {
            $this->logger->error('youtube client failed to start: ' . $e->getMessage());
            $this->emit('error', [$e, $this]);
        });

        $this->loop->run();
    }

    /**
     * Stops the client's own timers. The loop belongs to whoever runs it, and
     * is left alone.
     */
    public function close(): void
    {
        if ($this->refreshTimer !== null) {
            $this->loop->cancelTimer($this->refreshTimer);
            $this->refreshTimer = null;
        }

        $this->emit('closed', [$this]);
    }

    /**
     * The signed-in account's channel. Loaded once, for one unit of quota.
     *
     * @return PromiseInterface<Channel>
     */
    public function me(): PromiseInterface
    {
        if ($this->channel !== null) {
            return resolve($this->channel);
        }

        return $this->loadingChannel ??= $this->channels->list(part: ['id', 'snippet'], mine: true)
            ->then(function (ChannelListResponse $response): Channel {
                $channel = $response->items?->first();

                if (! $channel instanceof Channel) {
                    throw new \RuntimeException('The signed-in Google account has no YouTube channel. Sign in with the account that owns the channel.');
                }

                return $this->channel = $channel;
            })
            ->finally(function (): void {
                $this->loadingChannel = null;
            });
    }

    /** The signed-in account's channel, once {@see me()} has loaded it. */
    public function getChannel(): ?Channel
    {
        return $this->channel;
    }

    // -- Calls ----------------------------------------------------------------

    /**
     * Sends one API call, recovering from a dead token once. The generated
     * resource APIs go through here; so can a call to a method this build does
     * not know.
     *
     * A 401 refreshes the token (or signs in again, if that is what it takes)
     * and the call is retried once. If that fails too, the original 401 is what
     * surfaces: the caller asked about the call, not about the plumbing.
     *
     * @param array<string, mixed>                       $query
     * @param array<string, mixed>|\JsonSerializable|null $body
     *
     * @return PromiseInterface<mixed> The decoded JSON, unhydrated.
     */
    public function request(
        string $endpoint,
        string $method,
        string $path,
        array $query = [],
        array|\JsonSerializable|null $body = null,
        ?Media $media = null,
        ?string $uploadPath = null,
        bool $download = false,
    ): PromiseInterface {
        return $this->recovering(
            $endpoint,
            fn (): PromiseInterface => $this->http->request($endpoint, $method, $path, $query, $body, $media, $uploadPath, $download),
        );
    }

    /**
     * Opens a server-streamed call, recovering from a dead token the same way.
     *
     * @param array<string, mixed> $query
     *
     * @return PromiseInterface<\Psr\Http\Message\ResponseInterface> See {@see Http::stream()}.
     */
    public function stream(string $endpoint, string $path, array $query = []): PromiseInterface
    {
        return $this->recovering($endpoint, fn (): PromiseInterface => $this->http->stream($endpoint, $path, $query));
    }

    /**
     * @param \Closure(): PromiseInterface $send
     */
    private function recovering(string $endpoint, \Closure $send, bool $retry = true): PromiseInterface
    {
        return $send()->catch(function (\Throwable $e) use ($endpoint, $send, $retry): PromiseInterface {
            if ($e instanceof QuotaExceededException) {
                $this->quotaExhausted($endpoint);
            }

            if (! $retry || ! $e instanceof UnauthorizedException || ($this->token === null && $this->refreshToken === null)) {
                throw $e;
            }

            $this->logger->info("401 on {$endpoint} - recovering the token and retrying");

            return $this->recoverToken()->then(
                fn (): PromiseInterface => $this->recovering($endpoint, $send, false),
                function (\Throwable $recovery) use ($e): never {
                    $this->logger->error('could not recover the YouTube token: ' . $recovery->getMessage());

                    throw $e;
                },
            );
        });
    }

    /** Tells listeners once a day, per bucket, that its quota is gone. */
    private function quotaExhausted(string $endpoint): void
    {
        $bucket = $this->meter->bucket($endpoint);
        $day = $this->meter->day();

        if (($this->exhausted[$bucket] ?? null) === $day) {
            return;
        }

        $this->exhausted[$bucket] = $day;
        $this->logger->warning("the YouTube {$bucket} quota is spent until " . $this->meter->resetsAt()->toIso8601String());
        $this->emit('quota.exhausted', [$bucket, $this->meter->resetsAt(), $this]);
    }

    // -- The grant ----------------------------------------------------------------

    /** @return PromiseInterface<string|null> The access token, or null with only an API key. */
    private function acquireToken(): PromiseInterface
    {
        if ($this->token !== null && $this->expiresAt !== null && $this->expiresAt - $this->now() > self::REFRESH_BEFORE) {
            $this->scheduleRefresh();

            return resolve($this->token);
        }

        if ($this->refreshToken !== null) {
            return $this->recoverToken();
        }

        if ($this->token !== null) {
            // Pasted in by hand, lifetime unknown: use it until YouTube refuses it.
            return resolve($this->token);
        }

        if ($this->options['device_prompt'] !== null || $this->options['reauthorize'] !== null) {
            return $this->reauthorize();
        }

        if ($this->options['api_key'] !== null) {
            return resolve(null);
        }

        return reject(new \RuntimeException(
            'YouTube needs credentials: a "refresh_token" (or a "token_store" holding one), a "device_prompt" to sign in with, or an "api_key" for public data.',
        ));
    }

    /**
     * Gets back to a usable token: refresh if there is a refresh token, sign in
     * again if there is not or Google has revoked it.
     *
     * @return PromiseInterface<string>
     */
    private function recoverToken(): PromiseInterface
    {
        if ($this->refreshToken === null) {
            return $this->reauthorize();
        }

        return $this->refreshAccessToken()->catch(function (\Throwable $e): PromiseInterface {
            if (! $e instanceof OAuthException || ! $e->isInvalidGrant()) {
                throw $e;
            }

            $this->logger->warning('Google revoked the YouTube grant (' . $e->getDescription() . ') - signing in again');
            $this->refreshToken = null;

            return $this->reauthorize();
        });
    }

    /**
     * Trades the refresh token for a fresh access token. Concurrent callers
     * share one attempt. Emits `token_refreshed`.
     *
     * @return PromiseInterface<string> The new access token.
     */
    public function refreshAccessToken(): PromiseInterface
    {
        if ($this->refreshToken === null) {
            return reject(new \RuntimeException('There is no refresh token to refresh with'));
        }

        if ($this->refreshing !== null) {
            return $this->refreshing;
        }

        $deferred = new Deferred();
        // Returned from a local: Google may answer before this returns, and
        // the handlers below clear the shared copy when it does.
        $promise = $this->refreshing = $deferred->promise();

        $this->oauth->refreshToken($this->refreshToken)->then(
            function (array $token) use ($deferred): void {
                $this->refreshing = null;
                $this->applyToken($token);
                $this->logger->debug('youtube access token refreshed');
                $this->emit('token_refreshed', [$this]);
                $deferred->resolve($this->token);
            },
            function (\Throwable $e) use ($deferred): void {
                $this->refreshing = null;
                $deferred->reject($e);
            },
        );

        return $promise;
    }

    /**
     * Gets a brand-new grant from the configured {@see ReauthorizerInterface}.
     * Concurrent callers share one attempt, so a burst of 401s cannot ask
     * anyone for a code twice. Emits `reauthorized`.
     *
     * @return PromiseInterface<string> The new access token.
     */
    public function reauthorize(): PromiseInterface
    {
        if ($this->reauthorizing !== null) {
            return $this->reauthorizing;
        }

        $this->logger->info('signing in to YouTube');

        $deferred = new Deferred();
        $promise = $this->reauthorizing = $deferred->promise();

        $this->reauthorizer->reauthorize()->then(
            function (array $token) use ($deferred): void {
                $this->reauthorizing = null;
                $this->applyToken($token);
                $this->logger->info('signed in to YouTube', ['scopes' => $this->scopes]);
                $this->emit('reauthorized', [$this]);
                $deferred->resolve($this->token);
            },
            function (\Throwable $e) use ($deferred): void {
                $this->reauthorizing = null;
                $this->logger->error('signing in to YouTube failed: ' . $e->getMessage());
                $deferred->reject($e);
            },
        );

        return $promise;
    }

    /**
     * Adopts a token payload from any grant: hands it to the transport, plans
     * the next refresh, and writes it through to the store.
     *
     * @param array<string, mixed> $token
     */
    private function applyToken(array $token): void
    {
        $this->token = (string) $token['access_token'];

        if (! empty($token['refresh_token'])) {
            $this->refreshToken = (string) $token['refresh_token'];
        }

        $this->expiresAt = match (true) {
            isset($token['expires_at']) => (int) $token['expires_at'],
            isset($token['expires_in']) => $this->now() + (int) $token['expires_in'],
            default => null,
        };

        if (isset($token['scope']) && is_array($token['scope'])) {
            $this->scopes = array_values($token['scope']);
        }

        $this->http->setToken($this->token);
        $this->scheduleRefresh();

        // Only a consent screen in Testing gives a refresh token an end date.
        if (isset($token['refresh_token_expires_in']) && is_numeric($token['refresh_token_expires_in'])) {
            $seconds = (int) $token['refresh_token_expires_in'];
            $this->logger->warning(sprintf(
                'Google will end this YouTube sign-in in %d days, because the OAuth consent screen is in Testing. Publish the app to keep it signed in.',
                intdiv($seconds, 86400),
            ));
            $this->emit('grant_expires', [$seconds, $this]);
        }

        $this->persist($token);
    }

    /** Refreshes the access token a little before it runs out. */
    private function scheduleRefresh(): void
    {
        if ($this->refreshTimer !== null) {
            $this->loop->cancelTimer($this->refreshTimer);
            $this->refreshTimer = null;
        }

        if ($this->refreshToken === null || $this->expiresAt === null) {
            return;
        }

        $delay = max(30, $this->expiresAt - $this->now() - self::REFRESH_BEFORE);

        $this->refreshTimer = $this->loop->addTimer($delay, function (): void {
            $this->refreshTimer = null;
            $this->recoverToken()->then(null, function (\Throwable $e): void {
                // The next call's 401 tries again.
                $this->logger->warning('could not refresh the YouTube token ahead of time: ' . $e->getMessage());
            });
        });
    }

    /**
     * A store that cannot be written is logged and swallowed: losing it must
     * not fail a call that otherwise worked.
     *
     * @param array<string, mixed> $token
     */
    private function persist(array $token): void
    {
        if ($this->tokenStore === null) {
            return;
        }

        try {
            $this->tokenStore->save($token + ['refresh_token' => $this->refreshToken]);
        } catch (\Throwable $e) {
            $this->logger->error('could not keep the YouTube grant: ' . $e->getMessage());
        }
    }

    private function now(): int
    {
        return $this->options['clock'] !== null ? (int) ($this->options['clock'])() : time();
    }

    // -- Accessors ------------------------------------------------------------------

    public function getFactory(): Factory
    {
        return $this->factory;
    }

    public function getHttp(): Http
    {
        return $this->http;
    }

    public function getOAuth(): OAuth
    {
        return $this->oauth;
    }

    /** Today's quota count. */
    public function getMeter(): Meter
    {
        return $this->meter;
    }

    public function getLoop(): LoopInterface
    {
        return $this->loop;
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /** @return list<string> The scopes the grant holds, once Google has said. */
    public function getScopes(): array
    {
        return $this->scopes;
    }

    /** Whether calls go out with an access token, rather than an API key or nothing. */
    public function isSignedIn(): bool
    {
        return $this->token !== null;
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return array<string, mixed>
     */
    private function resolveOptions(array $options): array
    {
        $resolver = new OptionsResolver();

        $resolver->setDefaults([
            'client_id' => '',
            'client_secret' => '',
            'token' => null,
            'refresh_token' => null,
            'api_key' => null,
            'scopes' => [Scope::YOUTUBE],
            'token_store' => null,
            'device_prompt' => null,
            'reauthorize' => null,
            'quota' => [],
            'loop' => null,
            'logger' => null,
            'socket_options' => [],
            'driver' => null,
            'clock' => null,
        ]);

        $resolver
            ->setAllowedTypes('client_id', 'string')
            ->setAllowedTypes('client_secret', 'string')
            ->setAllowedTypes('token', ['null', 'string'])
            ->setAllowedTypes('refresh_token', ['null', 'string'])
            ->setAllowedTypes('api_key', ['null', 'string'])
            ->setAllowedTypes('scopes', 'string[]')
            ->setAllowedTypes('token_store', ['null', TokenStoreInterface::class])
            ->setAllowedTypes('device_prompt', ['null', 'callable'])
            ->setAllowedTypes('reauthorize', ['null', ReauthorizerInterface::class])
            ->setAllowedTypes('quota', 'array')
            ->setAllowedTypes('loop', ['null', LoopInterface::class])
            ->setAllowedTypes('logger', ['null', LoggerInterface::class])
            ->setAllowedTypes('socket_options', 'array')
            ->setAllowedTypes('driver', ['null', DriverInterface::class])
            ->setAllowedTypes('clock', ['null', \Closure::class]);

        $blank = static fn ($options, ?string $value): ?string => $value === '' ? null : $value;
        $resolver->setNormalizer('token', $blank);
        $resolver->setNormalizer('refresh_token', $blank);
        $resolver->setNormalizer('api_key', $blank);
        $resolver->setNormalizer('loop', static fn ($options, ?LoopInterface $loop): LoopInterface => $loop ?? Loop::get());
        $resolver->setNormalizer('logger', static fn ($options, ?LoggerInterface $logger): LoggerInterface => $logger ?? new NullLogger());
        $resolver->setNormalizer('quota', static function ($options, array $quota): array {
            $defaults = [
                'daily' => Cost::DAILY['default'],
                'search' => Cost::DAILY['search'],
                'uploads' => Cost::DAILY['uploads'],
                'reserve' => 0,
                'path' => null,
            ];

            $unknown = array_diff(array_keys($quota), array_keys($defaults));
            if ($unknown !== []) {
                throw new InvalidOptionsException('Unknown quota option(s): ' . implode(', ', $unknown) . '. Known: ' . implode(', ', array_keys($defaults)) . '.');
            }

            $quota += $defaults;
            foreach (['daily', 'search', 'uploads', 'reserve'] as $key) {
                if (! is_int($quota[$key]) || $quota[$key] < 0) {
                    throw new InvalidOptionsException("The quota option \"{$key}\" must be a whole number, 0 or more.");
                }
            }

            if ($quota['path'] !== null && ! is_string($quota['path'])) {
                throw new InvalidOptionsException('The quota option "path" must be a file path or null.');
            }

            return $quota;
        });

        return $resolver->resolve($options);
    }
}
