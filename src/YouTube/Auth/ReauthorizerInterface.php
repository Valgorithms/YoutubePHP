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

use React\Promise\PromiseInterface;

/**
 * A way to get a brand-new grant when the existing one can no longer be
 * refreshed: there is no refresh token, or Google revoked it.
 *
 * {@see \YouTube\YouTube} calls this as a last resort. Every Google sign-in
 * needs a person at a browser, so an implementation may take as long as that
 * takes; the client waits on the promise. Reject it to give up and let the
 * original failure surface.
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
interface ReauthorizerInterface
{
    /**
     * @return PromiseInterface<array{access_token: string, refresh_token?: string|null, expires_in?: int|null, expires_at?: int|null, scope?: list<string>|null, token_type?: string|null}>
     */
    public function reauthorize(): PromiseInterface;
}
