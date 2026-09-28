<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Http\Exceptions;

use Psr\Http\Message\ResponseInterface;

/**
 * A request YouTube refused, or one that never got an answer.
 *
 * Google's errors carry a *reason* beside the status (`quotaExceeded`,
 * `liveChatEnded`, `forbidden`), and the reason is usually what a caller needs:
 * a quota running out and a chat that ended are both 403s. {@see fromResponse()}
 * picks the exception class by reason first and by status after, so each can be
 * caught on its own.
 *
 * The status is the exception code, and 0 for a failure that never reached
 * YouTube.
 *
 * @link https://developers.google.com/youtube/v3/docs/errors
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
class HttpException extends \RuntimeException
{
    /** @var array<string, class-string<HttpException>> Google's reason => the exception that means it. */
    private const REASONS = [
        'quotaExceeded' => QuotaExceededException::class,
        'dailyLimitExceeded' => QuotaExceededException::class,
        'dailyLimitExceededUnreg' => QuotaExceededException::class,
        'rateLimitExceeded' => RateLimitedException::class,
        'userRateLimitExceeded' => RateLimitedException::class,
        'RATE_LIMIT_EXCEEDED' => RateLimitedException::class,
        'liveChatEnded' => LiveChatEndedException::class,
        'liveChatDisabled' => LiveChatDisabledException::class,
        'liveChatNotFound' => LiveChatNotFoundException::class,
        'insufficientPermissions' => MissingScopeException::class,
        'ACCESS_TOKEN_SCOPE_INSUFFICIENT' => MissingScopeException::class,
    ];

    /** @var array<int, class-string<HttpException>> */
    private const STATUSES = [
        400 => BadRequestException::class,
        401 => UnauthorizedException::class,
        403 => ForbiddenException::class,
        404 => NotFoundException::class,
        409 => ConflictException::class,
        429 => RateLimitedException::class,
    ];

    /**
     * @param int                             $code     The HTTP status, or 0 when there was no response.
     * @param string|null                     $reason   Google's reason code, e.g. `quotaExceeded`.
     * @param string|null                     $domain   Google's error domain, e.g. `youtube.quota`.
     * @param list<array<string, mixed>>      $errors   Every entry of the error's `errors` list.
     * @param string                          $endpoint The API method called, e.g. `liveChatMessages.list`.
     */
    public function __construct(
        string $message,
        int $code = 0,
        private readonly ?string $reason = null,
        private readonly ?string $domain = null,
        private readonly array $errors = [],
        private readonly ?ResponseInterface $response = null,
        private readonly string $endpoint = '',
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * The exception an error response stands for.
     *
     * @param array<string, mixed>|null $decoded The decoded body, if it was JSON.
     */
    public static function fromResponse(ResponseInterface $response, ?array $decoded, string $endpoint): self
    {
        return self::fromError($decoded ?? [], $response->getStatusCode(), $endpoint, $response);
    }

    /**
     * The exception an error body stands for, with or without the response it
     * came in. A streamed call reports an error that arrives after its headers
     * as one element of the stream, which has no status line of its own.
     *
     * @param array<string, mixed> $decoded The decoded body: `{"error": {...}}`.
     * @param int                  $status  The HTTP status; the error's own `code` is used when it has one.
     */
    public static function fromError(array $decoded, int $status, string $endpoint, ?ResponseInterface $response = null): self
    {
        $error = is_array($decoded['error'] ?? null) ? $decoded['error'] : [];
        $errors = array_values(array_filter($error['errors'] ?? [], is_array(...)));
        $first = $errors[0] ?? [];

        if ($response === null && is_int($error['code'] ?? null)) {
            $status = $error['code'];
        }

        $reason = self::reasonOf($error, $first);
        $domain = isset($first['domain']) ? (string) $first['domain'] : null;
        $message = (string) ($error['message'] ?? $first['message'] ?? $response?->getReasonPhrase() ?? 'Unknown error');

        $class = self::REASONS[$reason ?? ''] ?? self::STATUSES[$status] ?? ($status >= 500 ? ServerException::class : self::class);
        $label = $endpoint === '' ? '' : $endpoint . ': ';

        return new $class(
            $label . rtrim($message, '.') . '. (' . $status . ($reason === null ? '' : ' ' . $reason) . ')',
            $status,
            $reason,
            $domain,
            $errors,
            $response,
            $endpoint,
        );
    }

    /**
     * The reason code: the classic `errors[0].reason`, or the `ErrorInfo` detail
     * the newer format uses for scope and rate-limit failures.
     *
     * @param array<string, mixed> $error
     * @param array<string, mixed> $first
     */
    private static function reasonOf(array $error, array $first): ?string
    {
        foreach ($error['details'] ?? [] as $detail) {
            if (is_array($detail) && isset($detail['reason'], self::REASONS[$detail['reason']])) {
                return (string) $detail['reason'];
            }
        }

        return isset($first['reason']) ? (string) $first['reason'] : null;
    }

    /** The HTTP status, or 0 when there was no response. */
    public function getStatus(): int
    {
        return $this->getCode();
    }

    /** Google's reason code, e.g. `quotaExceeded`, when it gave one. */
    public function getReason(): ?string
    {
        return $this->reason;
    }

    /** Google's error domain, e.g. `youtube.quota`, when it gave one. */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /** @return list<array<string, mixed>> Every entry of the error's `errors` list. */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }

    /** The API method called, e.g. `liveChatMessages.list`. */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /** Seconds to wait before trying again, when the response said. */
    public function getRetryAfter(): ?float
    {
        $header = $this->response?->getHeaderLine('Retry-After') ?? '';

        return is_numeric($header) ? (float) $header : null;
    }
}
