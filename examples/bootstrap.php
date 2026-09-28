<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

/**
 * Shared setup for the examples: the autoloader, the `.env` file beside
 * composer.json, and a CA bundle for Windows builds of PHP that ship without one.
 *
 * The library itself reads no configuration and needs no dotenv package; this
 * is only so the examples run straight out of a checkout:
 *
 *     cp example.env .env   # then put your OAuth client in it
 *     php examples/live-chat.php
 *
 * Values already in the real environment win over the file.
 */

use YouTube\Auth\EnvFileTokenStore;
use YouTube\YouTube;

require __DIR__ . '/../vendor/autoload.php';

const ENV_FILE = __DIR__ . '/../.env';

(static function (): void {
    if (! is_readable(ENV_FILE)) {
        return;
    }

    foreach (file(ENV_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#') || ! str_contains($line, '=')) {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);

        if ($key !== '' && getenv($key) === false) {
            putenv($key . '=' . trim(trim($value), "\"'"));
        }
    }
})();

/**
 * The socket options the client needs on this machine.
 *
 * A Windows PHP build usually has no CA bundle, so TLS to googleapis.com fails
 * until one is pointed at. Everywhere else this is empty and the system store
 * is used.
 *
 * @return array<string, mixed>
 */
function socket_options(): array
{
    foreach ([ini_get('openssl.cafile'), getenv('SSL_CERT_FILE'), 'C:/php/cacert.pem'] as $cafile) {
        if (is_string($cafile) && $cafile !== '' && is_file($cafile)) {
            return ['tls' => ['cafile' => $cafile]];
        }
    }

    return [];
}

/**
 * A client signed in as the account that streams: from the refresh token in
 * `.env` when there is one, and with a device code on the console when not.
 * The sign-in's refresh token is written back to `.env`.
 */
function youtube(): YouTube
{
    $clientId = (string) getenv('YOUTUBE_CLIENT_ID');
    $clientSecret = (string) getenv('YOUTUBE_CLIENT_SECRET');

    if ($clientId === '' || $clientSecret === '') {
        fwrite(STDERR, "No YOUTUBE_CLIENT_ID and YOUTUBE_CLIENT_SECRET found.\n\nCreate an OAuth client of type \"TVs and Limited Input devices\" in the Google Cloud console,\nand put its id and secret in a .env file next to composer.json (see example.env).\n");
        exit(1);
    }

    return new YouTube([
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'token_store' => new EnvFileTokenStore(ENV_FILE),
        'device_prompt' => static function (array $device): void {
            printf("\nSign in: go to %s and enter %s\nThe code works for %d minutes.\n\n", $device['verification_uri'], $device['user_code'], intdiv((int) $device['expires_in'], 60));
        },
        'socket_options' => socket_options(),
        'quota' => ['path' => __DIR__ . '/../.quota.json'],
    ]);
}
