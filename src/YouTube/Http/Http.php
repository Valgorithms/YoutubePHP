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

use Carbon\CarbonImmutable;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;

use function React\Promise\reject;

use React\Stream\ReadableStreamInterface;
use YouTube\Http\Drivers\React as ReactDriver;
use YouTube\Http\Exceptions\HttpException;
use YouTube\Http\Exceptions\QuotaExceededException;
use YouTube\Http\Exceptions\RateLimitedException;
use YouTube\Quota\Meter;
use YouTube\YouTube;

/**
 * Non-blocking transport for the YouTube Data API.
 *
 * Calls queue behind a concurrency ceiling. Each attempt is charged to the
 * {@see Meter} when one is set, and a call today's quota cannot pay for is
 * refused before it is sent. Errors come back as the exception Google's reason
 * code means ({@see HttpException::fromResponse()}).
 *
 * Retries:
 * - **Rate limits** are waited out, for `Retry-After` when YouTube says and
 *   with a doubling back-off when it does not. They mean the request was not
 *   processed, so every verb is retried.
 * - **Server errors and dropped connections** back off and retry too, but only
 *   for verbs that can be repeated safely. A `POST` that failed halfway may
 *   have posted a chat message already, and a second copy is worse than an
 *   error, so a `POST` is retried only on a 503.
 * - **Quota** is not retried: nothing comes back until midnight Pacific.
 *
 * @link https://developers.google.com/youtube/v3/docs/errors
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
final class Http implements HttpInterface
{
    /** The API root. */
    public const BASE_URL = 'https://youtube.googleapis.com/';

    /** In-flight request ceiling. */
    public const CONCURRENT_REQUESTS = 8;

    /** Give up after this many attempts at one request. */
    public const MAX_ATTEMPTS = 4;

    /** Verbs a retry cannot turn into a duplicate. */
    private const IDEMPOTENT = ['GET', 'HEAD', 'PUT', 'DELETE'];

    private LoggerInterface $logger;

    private ?DriverInterface $driver;

    private ?string $token = null;

    private ?string $apiKey = null;

    private ?Meter $meter = null;

    /** @var \SplQueue<PendingRequest> */
    private \SplQueue $queue;

    private int $inFlight = 0;

    /**
     * @param float $backoff Multiplies every wait before a retry. 0 retries at once, for tests.
     */
    public function __construct(
        private readonly LoopInterface $loop,
        ?LoggerInterface $logger = null,
        ?DriverInterface $driver = null,
        private readonly string $baseUrl = self::BASE_URL,
        private readonly float $backoff = 1.0,
    ) {
        $this->logger = $logger ?? new NullLogger();
        $this->driver = $driver;
        $this->queue = new \SplQueue();
    }

    /**
     * A transport with the default ReactPHP driver on the shared event loop.
     *
     * @param array<string, mixed> $socketOptions Forwarded to the socket connector.
     */
    public static function create(
        ?LoggerInterface $logger = null,
        ?LoopInterface $loop = null,
        array $socketOptions = [],
        string $baseUrl = self::BASE_URL,
    ): self {
        $loop ??= Loop::get();

        return new self($loop, $logger, new ReactDriver($loop, $socketOptions), $baseUrl);
    }

    public function setDriver(DriverInterface $driver): void
    {
        $this->driver = $driver;
    }

    public function setToken(?string $token): void
    {
        $this->token = $token === '' ? null : $token;
    }

    /**
     * An API key, sent when there is no access token. It reads public data
     * only: anything about the signed-in account needs OAuth.
     */
    public function setApiKey(?string $apiKey): void
    {
        $this->apiKey = $apiKey === '' ? null : $apiKey;
    }

    public function setMeter(?Meter $meter): void
    {
        $this->meter = $meter;
    }

    public function getMeter(): ?Meter
    {
        return $this->meter;
    }

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
        if ($this->driver === null) {
            return reject(new HttpException('No HTTP driver configured. Pass one to the constructor or call Http::create().'));
        }

        try {
            $request = $this->prepare($endpoint, $method, $path, $query, $body, $media, $uploadPath);
        } catch (\JsonException $e) {
            return reject(new HttpException("{$endpoint}: could not encode the request body: {$e->getMessage()}", 0, null, null, [], null, $endpoint, $e));
        }

        if ($this->meter !== null && ! $this->meter->canAfford($endpoint)) {
            return reject(QuotaExceededException::local($endpoint, $this->meter));
        }

        $deferred = new Deferred();
        $this->queue->enqueue(new PendingRequest($request, $deferred, $download));
        $this->pump();

        return $deferred->promise();
    }

    public function stream(string $endpoint, string $path, array $query = []): PromiseInterface
    {
        if ($this->driver === null) {
            return reject(new HttpException('No HTTP driver configured. Pass one to the constructor or call Http::create().'));
        }

        if ($this->meter !== null && ! $this->meter->canAfford($endpoint)) {
            return reject(QuotaExceededException::local($endpoint, $this->meter));
        }

        $request = $this->authorize(new Request($endpoint, 'GET', $this->url($path, $query)));
        $this->meter?->spend($endpoint);
        $this->logger->debug("→ {$request} (streaming)");

        return $this->driver->runRequest($request, true)->then(
            function (ResponseInterface $response) use ($endpoint): PromiseInterface|ResponseInterface {
                if ($response->getStatusCode() === 200) {
                    return $response;
                }

                return self::buffer($response)->then(function (string $body) use ($response, $endpoint): never {
                    throw $this->mapError($response, $body, $endpoint);
                });
            },
            function (\Throwable $e) use ($endpoint): never {
                if ($e instanceof HttpException) {
                    throw $e;
                }

                throw new HttpException("{$endpoint}: transport error: {$e->getMessage()}", 0, null, null, [], null, $endpoint, $e);
            },
        );
    }

    /**
     * @param array<string, mixed>                       $query
     * @param array<string, mixed>|\JsonSerializable|null $body
     *
     * @throws \JsonException
     */
    private function prepare(
        string $endpoint,
        string $method,
        string $path,
        array $query,
        array|\JsonSerializable|null $body,
        ?Media $media,
        ?string $uploadPath,
    ): Request {
        $json = $body === null ? null : json_encode($body, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        if ($media === null) {
            return new Request(
                $endpoint,
                $method,
                $this->url($path, $query),
                $json ?? '',
                $json === null ? [] : ['Content-Type' => 'application/json'],
            );
        }

        $target = $uploadPath ?? $path;

        if ($json === null) {
            // The file alone.
            return new Request(
                $endpoint,
                $method,
                $this->url($target, ['uploadType' => 'media'] + $query),
                $media->contents,
                ['Content-Type' => $media->mimeType],
            );
        }

        // The metadata and the file together, as Google's "multipart" upload.
        $boundary = 'youtubephp' . bin2hex(random_bytes(12));
        $content = "--{$boundary}\r\n"
            . "Content-Type: application/json; charset=UTF-8\r\n\r\n"
            . $json . "\r\n"
            . "--{$boundary}\r\n"
            . "Content-Type: {$media->mimeType}\r\n\r\n"
            . $media->contents . "\r\n"
            . "--{$boundary}--\r\n";

        return new Request(
            $endpoint,
            $method,
            $this->url($target, ['uploadType' => 'multipart'] + $query),
            $content,
            ['Content-Type' => 'multipart/related; boundary=' . $boundary],
        );
    }

    /**
     * The absolute URL for a path and its query. A list repeats its key, the
     * way Google reads repeated parameters; null values are left out.
     *
     * @param array<string, mixed> $query
     */
    public function url(string $path, array $query = []): string
    {
        $url = $this->baseUrl . ltrim($path, '/');
        $pairs = [];

        foreach ($query as $key => $value) {
            foreach (is_array($value) ? $value : [$value] as $item) {
                if ($item !== null) {
                    $pairs[] = rawurlencode((string) $key) . '=' . rawurlencode(self::scalar($item));
                }
            }
        }

        return $pairs === [] ? $url : $url . '?' . implode('&', $pairs);
    }

    private static function scalar(mixed $value): string
    {
        return match (true) {
            is_bool($value) => $value ? 'true' : 'false',
            $value instanceof \DateTimeInterface => CarbonImmutable::instance($value)->utc()->format('Y-m-d\TH:i:s\Z'),
            $value instanceof \BackedEnum => (string) $value->value,
            default => (string) $value,
        };
    }

    /** Adds the credentials, fresh for each attempt: a retry may follow a refresh. */
    private function authorize(Request $request): Request
    {
        $request = $request
            ->withHeader('Accept', 'application/json')
            ->withHeader('User-Agent', 'YouTubePHP/' . YouTube::VERSION . ' (+https://github.com/Valgorithms/YoutubePHP)');

        if ($this->token !== null) {
            return $request->withHeader('Authorization', 'Bearer ' . $this->token);
        }

        if ($this->apiKey !== null) {
            // A header, not the `key` parameter, so the key stays out of URLs.
            return $request->withHeader('X-Goog-Api-Key', $this->apiKey);
        }

        return $request;
    }

    /** Dispatches queued requests up to the concurrency ceiling. */
    private function pump(): void
    {
        while ($this->inFlight < self::CONCURRENT_REQUESTS && ! $this->queue->isEmpty()) {
            $this->send($this->queue->dequeue());
        }
    }

    private function send(PendingRequest $pending): void
    {
        $request = $this->authorize($pending->request);
        $attempt = ++$pending->attempts;
        ++$this->inFlight;

        $this->meter?->spend($request->getEndpoint());
        $this->logger->debug("→ {$request}" . ($attempt > 1 ? " (attempt {$attempt})" : ''));

        $this->driver->runRequest($request)->then(
            function (ResponseInterface $response) use ($pending): void {
                --$this->inFlight;
                $this->handleResponse($pending, $response);
            },
            function (\Throwable $e) use ($pending): void {
                --$this->inFlight;
                $this->handleTransportError($pending, $e);
            },
        );
    }

    private function handleResponse(PendingRequest $pending, ResponseInterface $response): void
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        $endpoint = $pending->request->getEndpoint();

        if ($status >= 200 && $status < 300) {
            if ($pending->download || trim($body) === '') {
                $pending->deferred->resolve($pending->download ? $body : null);
            } else {
                $decoded = json_decode($body, true);
                if (is_array($decoded)) {
                    $pending->deferred->resolve($decoded);
                } else {
                    $pending->deferred->reject(new HttpException("{$endpoint}: the response was not JSON ({$status})", $status, null, null, [], $response, $endpoint));
                }
            }

            $this->pump();

            return;
        }

        $exception = $this->mapError($response, $body, $endpoint);

        if ($exception instanceof QuotaExceededException && $this->meter !== null) {
            $this->meter->exhaust($endpoint);
            $exception->setResetsAt($this->meter->resetsAt());
        }

        $delay = $this->retryDelay($pending, $exception);

        if ($delay !== null) {
            $this->logger->warning("{$exception->getMessage()} - retrying in {$delay}s");
            $this->retry($pending, $delay);

            return;
        }

        $pending->deferred->reject($exception);
        $this->pump();
    }

    private function handleTransportError(PendingRequest $pending, \Throwable $e): void
    {
        $request = $pending->request;
        $endpoint = $request->getEndpoint();

        if ($pending->attempts < self::MAX_ATTEMPTS && in_array($request->getMethod(), self::IDEMPOTENT, true)) {
            $delay = 1.0 * $pending->attempts;
            $this->logger->warning("transport error on {$request}: {$e->getMessage()} - retrying in {$delay}s");
            $this->retry($pending, $delay);

            return;
        }

        $pending->deferred->reject(new HttpException("{$endpoint}: transport error: {$e->getMessage()}", 0, null, null, [], null, $endpoint, $e));
        $this->pump();
    }

    /** Seconds to wait before trying a failed request again, or null to give up. */
    private function retryDelay(PendingRequest $pending, HttpException $e): ?float
    {
        if ($pending->attempts >= self::MAX_ATTEMPTS) {
            return null;
        }

        if ($e instanceof RateLimitedException) {
            return $e->getRetryAfter() ?? 2.0 ** $pending->attempts;
        }

        $status = $e->getStatus();
        $idempotent = in_array($pending->request->getMethod(), self::IDEMPOTENT, true);

        if ($status === 503 || ($idempotent && ($status >= 500 || $status === 408))) {
            return 0.5 * 2 ** ($pending->attempts - 1);
        }

        return null;
    }

    private function retry(PendingRequest $pending, float $delay): void
    {
        $this->loop->addTimer(max(0.0, $delay * $this->backoff), function () use ($pending): void {
            $this->queue->unshift($pending);
            $this->pump();
        });
    }

    /**
     * The exception an error response stands for. A streamed method wraps its
     * error in a one-element list, which is unwrapped first.
     */
    private function mapError(ResponseInterface $response, string $body, string $endpoint): HttpException
    {
        $decoded = json_decode($body, true);

        if (is_array($decoded) && array_is_list($decoded) && is_array($decoded[0] ?? null)) {
            $decoded = $decoded[0];
        }

        return HttpException::fromResponse($response, is_array($decoded) ? $decoded : null, $endpoint);
    }

    /**
     * The whole body of a response, streamed or not.
     *
     * @return PromiseInterface<string>
     */
    private static function buffer(ResponseInterface $response): PromiseInterface
    {
        $body = $response->getBody();

        if (! $body instanceof ReadableStreamInterface || ! $body->isReadable()) {
            return \React\Promise\resolve((string) $body);
        }

        $deferred = new Deferred();
        $buffer = '';

        $body->on('data', static function (string $chunk) use (&$buffer): void {
            $buffer .= $chunk;
        });
        $body->on('error', static fn (\Throwable $e) => $deferred->reject($e));
        $body->on('close', static function () use (&$buffer, $deferred): void {
            $deferred->resolve($buffer);
        });

        return $deferred->promise();
    }
}
