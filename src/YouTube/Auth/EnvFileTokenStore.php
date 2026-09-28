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
 * Keeps the grant in a `.env` file, beside the rest of the settings.
 *
 * Only the refresh token is written. Google does not rotate it, so the file
 * changes once, after a device sign-in, and not every hour: access tokens are
 * minted from the refresh token as they are needed and never written down.
 * An access token already in the file is read, for a quick test with a token
 * pasted in by hand.
 *
 * Keys are `YOUTUBE_REFRESH_TOKEN` and `YOUTUBE_ACCESS_TOKEN` (the prefix is
 * configurable), matched without regard to case. An existing line keeps its
 * spelling and its place; a missing one is appended. Every other line is left
 * exactly as it was. The file is replaced in one step, so a crash cannot leave
 * it half written, and is readable by its owner only where the system allows.
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
final class EnvFileTokenStore implements TokenStoreInterface
{
    public function __construct(
        private readonly string $path,
        private readonly string $prefix = 'YOUTUBE_',
    ) {
    }

    public function load(): array
    {
        $parsed = $this->parse();
        $out = [];

        foreach (['access_token', 'refresh_token'] as $key) {
            $value = $parsed[$this->key($key)] ?? '';
            if ($value !== '') {
                $out[$key] = $value;
            }
        }

        return $out;
    }

    public function save(array $token): void
    {
        $refresh = (string) ($token['refresh_token'] ?? '');

        if ($refresh === '' || ($this->parse()[$this->key('refresh_token')] ?? null) === $refresh) {
            return;
        }

        $this->write([$this->key('refresh_token') => $refresh]);
    }

    /** The lowercase `.env` key for a token field. */
    private function key(string $field): string
    {
        return strtolower($this->prefix . $field);
    }

    /**
     * Every `KEY=value` pair in the file, keys lowercased.
     *
     * @return array<string, string>
     */
    private function parse(): array
    {
        if (! is_file($this->path)) {
            return [];
        }

        $out = [];
        foreach (file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
            $trimmed = trim($line);
            if ($trimmed === '' || $trimmed[0] === '#' || ! str_contains($trimmed, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $trimmed, 2);
            $out[strtolower(trim($key))] = trim($value, " \t\"'");
        }

        return $out;
    }

    /**
     * Replaces the given keys in place, appending any that are not there.
     *
     * @param array<string, string> $updates Lowercase key => value.
     */
    private function write(array $updates): void
    {
        $lines = is_file($this->path) ? (file($this->path, FILE_IGNORE_NEW_LINES) ?: []) : [];
        $seen = [];
        // Whether the file spells its keys in capitals, for any that are added.
        $uppercase = $lines === [];

        foreach ($lines as $i => $line) {
            $trimmed = trim($line);
            if ($trimmed === '' || $trimmed[0] === '#' || ! str_contains($trimmed, '=')) {
                continue;
            }

            $key = trim(explode('=', $trimmed, 2)[0]);
            $lower = strtolower($key);

            if ($key === strtoupper($key)) {
                $uppercase = true;
            }

            if (isset($updates[$lower])) {
                $lines[$i] = $key . '=' . $updates[$lower];
                $seen[$lower] = true;
            }
        }

        foreach ($updates as $key => $value) {
            if (! isset($seen[$key])) {
                $lines[] = ($uppercase ? strtoupper($key) : $key) . '=' . $value;
            }
        }

        $contents = implode("\n", $lines) . "\n";
        $temp = @tempnam(dirname($this->path), '.env');
        if ($temp === false) {
            throw new \RuntimeException("Unable to create a temporary file beside {$this->path}");
        }

        if (@file_put_contents($temp, $contents) === false || ! @rename($temp, $this->path)) {
            @unlink($temp);

            throw new \RuntimeException("Unable to write {$this->path}");
        }

        @chmod($this->path, 0o600);
    }
}
