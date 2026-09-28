<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Tests;

use PHPUnit\Framework\TestCase;
use YouTube\Auth\EnvFileTokenStore;

/**
 * Keeping the grant in `.env`: the refresh token, written once, and every
 * other line left alone.
 */
final class EnvFileTokenStoreTest extends TestCase
{
    private string $dir;

    private string $path;

    protected function setUp(): void
    {
        $this->dir = sys_get_temp_dir() . '/youtubephp-env-' . bin2hex(random_bytes(6));
        mkdir($this->dir);
        $this->path = $this->dir . '/settings.env';
    }

    protected function tearDown(): void
    {
        foreach (glob($this->dir . '/{,.}*', GLOB_BRACE) ?: [] as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }
        @rmdir($this->dir);
    }

    public function testWhatIsStoredIsRead(): void
    {
        file_put_contents($this->path, "DISCORD_TOKEN=x\nyoutube_refresh_token=\"refresh\"\nYOUTUBE_ACCESS_TOKEN=access\n");

        $this->assertSame(['access_token' => 'access', 'refresh_token' => 'refresh'], (new EnvFileTokenStore($this->path))->load());
    }

    public function testNothingStoredReadsAsEmpty(): void
    {
        $this->assertSame([], (new EnvFileTokenStore($this->path))->load());
    }

    public function testANewRefreshTokenReplacesTheOldInPlace(): void
    {
        file_put_contents($this->path, "# Settings\nDISCORD_TOKEN=x\nYOUTUBE_REFRESH_TOKEN=old\nTWITCH_NICK=me\n");

        (new EnvFileTokenStore($this->path))->save(['access_token' => 'a', 'refresh_token' => 'new']);

        $this->assertSame("# Settings\nDISCORD_TOKEN=x\nYOUTUBE_REFRESH_TOKEN=new\nTWITCH_NICK=me\n", file_get_contents($this->path));
    }

    public function testAMissingKeyIsAppendedInTheFilesOwnCase(): void
    {
        file_put_contents($this->path, "DISCORD_TOKEN=x\n");

        (new EnvFileTokenStore($this->path))->save(['access_token' => 'a', 'refresh_token' => 'new']);

        $this->assertSame("DISCORD_TOKEN=x\nYOUTUBE_REFRESH_TOKEN=new\n", file_get_contents($this->path));
    }

    public function testAccessTokensAreNeverWritten(): void
    {
        file_put_contents($this->path, "YOUTUBE_REFRESH_TOKEN=same\n");
        $before = filemtime($this->path);
        touch($this->path, $before - 100);

        (new EnvFileTokenStore($this->path))->save(['access_token' => 'minted-hourly', 'refresh_token' => 'same', 'expires_in' => 3599]);

        clearstatcache();
        $this->assertSame($before - 100, filemtime($this->path), 'an unchanged refresh token leaves the file alone');
        $this->assertStringNotContainsString('minted-hourly', file_get_contents($this->path));
    }

    public function testAnotherPrefixKeepsItsOwnKeys(): void
    {
        (new EnvFileTokenStore($this->path, 'STREAM_YT_'))->save(['access_token' => 'a', 'refresh_token' => 'r']);

        $this->assertSame("STREAM_YT_REFRESH_TOKEN=r\n", file_get_contents($this->path));
        $this->assertSame(['refresh_token' => 'r'], (new EnvFileTokenStore($this->path, 'STREAM_YT_'))->load());
    }
}
