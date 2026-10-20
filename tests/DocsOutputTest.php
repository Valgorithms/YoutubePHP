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

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__) . '/tools/check-docs.php';

final class DocsOutputTest extends TestCase
{
    private string $root;

    protected function setUp(): void
    {
        $path = sys_get_temp_dir() . '/youtubephp-docs-' . bin2hex(random_bytes(8));
        mkdir($path);
        $this->root = realpath($path);
        mkdir($this->root . '/guides');
        mkdir($this->root . '/images');
        foreach (['index.html', 'guides/page.html', 'images/icon.png'] as $file) {
            file_put_contents($this->root . '/' . $file, 'offline fixture');
        }
    }

    protected function tearDown(): void
    {
        foreach (['index.html', 'guides/page.html', 'images/icon.png'] as $file) {
            unlink($this->root . '/' . $file);
        }
        rmdir($this->root . '/guides');
        rmdir($this->root . '/images');
        rmdir($this->root);
    }

    public function testPhpDocumentorBaseResolvesAssetsAndRootNavigation(): void
    {
        docsCheckLinks(
            $this->root,
            $this->root . '/guides/page.html',
            '<html><head><base href="../"></head><body><img src="images/icon.png"><a href="index.html#anchor">Home</a></body></html>',
        );
        $this->assertSame($this->root, docsLocalTarget($this->root, $this->root . '/guides', '../'));
    }

    public function testWithoutBaseLinksRemainRelativeToDocument(): void
    {
        docsCheckLinks(
            $this->root,
            $this->root . '/guides/page.html',
            '<html><body><img src="../images/icon.png"><a href="#anchor">Here</a></body></html>',
        );
        $this->assertSame(
            $this->root . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'icon.png',
            docsLocalTarget($this->root, $this->root . '/guides', '../images/icon.png'),
        );
    }

    public static function invalidCases(): array
    {
        return [
            ['<base href="../"><img src="images/missing.png">'],
            ['<base href="../../"><img src="images/icon.png">'],
            ['<base href="https://example.invalid/"><img src="images/icon.png">'],
            ['<base href="../"><a href="%2e%2e/">escape</a>'],
        ];
    }

    #[DataProvider('invalidCases')]
    public function testBrokenAssetsAndEscapingBasesStillFail(string $markup): void
    {
        $this->expectException(\RuntimeException::class);
        docsCheckLinks($this->root, $this->root . '/guides/page.html', '<html><body>' . $markup . '</body></html>');
    }
}
