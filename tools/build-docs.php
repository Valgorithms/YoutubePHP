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
 * Builds the class reference into `build/` with phpDocumentor.
 *
 * Usage: composer docs
 *
 * The builder is `discord-php/phpdoc-tool`: phpDocumentor with the DiscordPHP
 * family's patches, so that `?T|null` reads as a type rather than an error. The
 * generated parts document every attribute that way, so plain phpDocumentor
 * would render much of this API wrongly. It is the same builder DiscordPHP,
 * TwitchPHP and TelegramPHP use.
 *
 * This looks for it in the usual places; point PHPDOC at a `phpdoc` binary to
 * use a specific build.
 */

$root = dirname(__DIR__);

$candidates = [];
$configured = getenv('PHPDOC');
if (is_string($configured) && $configured !== '') {
    $candidates[] = $configured;
}
$candidates[] = $root . '/phpdoc-tool/vendor/bin/phpdoc';         // created here, as CI does
$candidates[] = dirname($root) . '/phpdoc-tool/vendor/bin/phpdoc'; // a checkout beside this one
$candidates[] = dirname($root) . '/phpdoc-tool-shared/vendor/bin/phpdoc';

$binary = null;
foreach ($candidates as $candidate) {
    if (is_file($candidate)) {
        $binary = $candidate;

        break;
    }
}

if ($binary === null) {
    fwrite(STDERR, <<<'TEXT'
        The documentation builder was not found.

        This project builds its docs with discord-php/phpdoc-tool - phpDocumentor
        plus the DiscordPHP family's patches for `?T|null` types. It is not on
        Packagist, so install it from its repository:

            composer create-project discord-php/phpdoc-tool:^1.0 phpdoc-tool \
              --no-interaction --no-progress \
              --repository='{"type":"vcs","url":"https://github.com/discord-php/phpdoc-tool"}'

        Or point this at an existing checkout:

            PHPDOC=../phpdoc-tool/vendor/bin/phpdoc composer docs

        TEXT);

    exit(1);
}

$arguments = array_map('escapeshellarg', [PHP_BINARY, $binary, '--config', $root . '/phpdoc.dist.xml', '--no-interaction']);

fwrite(STDERR, "Building the reference...\n");
passthru(implode(' ', $arguments), $status);

if ($status !== 0) {
    fwrite(STDERR, "phpDocumentor exited with {$status}.\n");

    exit($status);
}

if (! is_file($root . '/build/index.html')) {
    fwrite(STDERR, "phpDocumentor finished, but build/index.html is missing.\n");

    exit(1);
}

printf("Built the reference into %s/build.\n", $root);
printf("Serve that directory to read it: php -S localhost:8000 -t build\n");
