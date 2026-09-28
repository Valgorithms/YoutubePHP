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

/**
 * Google's OAuth server refused a request.
 *
 * {@see getError()} is the OAuth error code, which says what to do next:
 * `authorization_pending` and `slow_down` while a device sign-in waits for its
 * user, `access_denied` when they declined it, `expired_token` when they took
 * too long, and `invalid_grant` when a refresh token has been revoked or has
 * expired.
 *
 * @link https://developers.google.com/identity/protocols/oauth2/limited-input-device#step-6:-handle-responses-to-polling-requests
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
final class OAuthException extends \RuntimeException
{
    /**
     * @param string $error       The OAuth error code, e.g. `invalid_grant`.
     * @param string $description Google's explanation, when it gave one.
     * @param int    $status      The HTTP status, or 0 when there was no response.
     */
    public function __construct(
        private readonly string $error,
        private readonly string $description = '',
        int $status = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct(
            'Google refused the sign-in request: ' . $error . ($description === '' ? '' : ' (' . $description . ')'),
            $status,
            $previous,
        );
    }

    /** The OAuth error code, e.g. `invalid_grant`. */
    public function getError(): string
    {
        return $this->error;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /** The HTTP status, or 0 when there was no response. */
    public function getStatus(): int
    {
        return $this->getCode();
    }

    /** The refresh token no longer works: someone must sign in again. */
    public function isInvalidGrant(): bool
    {
        return $this->error === 'invalid_grant';
    }
}
