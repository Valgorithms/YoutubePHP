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
 * Somewhere durable to keep the OAuth grant.
 *
 * A device sign-in needs a person, so its refresh token must survive restarts:
 * without it, every start would ask them to sign in again.
 * {@see \YouTube\YouTube} reads the store at start and writes every new token
 * payload through to it.
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
interface TokenStoreInterface
{
    /**
     * What was stored, or an empty array when nothing has been saved yet.
     *
     * @return array{access_token?: string, refresh_token?: string, expires_at?: int}
     */
    public function load(): array;

    /**
     * Keeps a token payload, as any grant returns it.
     *
     * Implementations must tolerate partial payloads: a refresh returns no
     * refresh token, because the old one keeps working.
     *
     * @param array{access_token: string, refresh_token?: string|null, expires_in?: int|null, expires_at?: int|null, scope?: list<string>|null, token_type?: string|null} $token
     */
    public function save(array $token): void;
}
