<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

/** Resolve a local URL against a directory without permitting escape from the site. */
function docsLocalTarget(string $root, string $directory, string $href): ?string
{
    $href = html_entity_decode($href, ENT_QUOTES | ENT_HTML5);
    if (preg_match('~^(?:[a-z][a-z0-9+.-]*:|//|#)~i', $href)) {
        return null;
    }
    $path = rawurldecode(explode('?', explode('#', $href, 2)[0], 2)[0]);
    if ($path === '') {
        return null;
    }
    // Pages is published under /YoutubePHP/, not the origin root.
    if (str_starts_with($path, '/') || str_contains($path, '\\') || str_contains($path, "\0")) {
        throw new RuntimeException('Unsupported root/escaped local URL');
    }
    $target = realpath($directory . '/' . $path);
    if ($target === false || ($target !== $root && ! str_starts_with($target, $root . DIRECTORY_SEPARATOR))) {
        throw new RuntimeException('Broken/local-escaping link: ' . $path);
    }

    return $target;
}

/** Respect the first HTML base element; it must itself resolve within this site. */
function docsCheckLinks(string $root, string $file, string $content): void
{
    $document = new DOMDocument();
    $previous = libxml_use_internal_errors(true);
    try {
        if (! $document->loadHTML($content)) {
            throw new RuntimeException('Invalid generated HTML');
        }
    } finally {
        libxml_clear_errors();
        libxml_use_internal_errors($previous);
    }
    $directory = dirname($file);
    $base = $document->getElementsByTagName('base')->item(0);
    if ($base !== null && $base->hasAttribute('href')) {
        $href = html_entity_decode($base->getAttribute('href'), ENT_QUOTES | ENT_HTML5);
        if (preg_match('~^(?:[a-z][a-z0-9+.-]*:|//)~i', $href)) {
            throw new RuntimeException('External HTML base is not allowed');
        }
        $target = docsLocalTarget($root, $directory, $href);
        if ($target !== null) {
            $path = explode('?', explode('#', $href, 2)[0], 2)[0];
            $directory = str_ends_with($path, '/') ? $target : dirname($target);
        }
    }
    foreach ($document->getElementsByTagName('*') as $node) {
        if ($node->nodeName === 'base') {
            continue; // Resolved against the document, not against itself.
        }
        foreach (['href', 'src'] as $attribute) {
            if ($node->hasAttribute($attribute)) {
                docsLocalTarget($root, $directory, $node->getAttribute($attribute));
            }
        }
    }
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') !== __FILE__) {
    return; // Tests can exercise URL semantics without reading a real build.
}

/** Bounded smoke check of the actual public build, never the repository tree. */
$root = realpath(dirname(__DIR__) . '/build');
if ($root === false) {
    throw new RuntimeException('Build output missing');
}
$required = ['index.html', 'classes/YouTube-YouTube.html', 'graphs/classes.svg', 'guides/index.html',
    'guides/github-actions-uploader.html', 'guides/civ13-uploader-example.html'];
foreach ($required as $path) {
    if (! is_file($root . '/' . $path)) {
        throw new RuntimeException('Required generated page missing: ' . $path);
    }
}
$bytes = 0;
$html = 0;
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS));
foreach ($iterator as $file) {
    if ($file->isLink() || ! $file->isFile()) {
        throw new RuntimeException('Only regular generated files may be published');
    }
    $relative = str_replace('\\', '/', substr($file->getPathname(), strlen($root) + 1));
    if (preg_match('~(^|/)(vendor|\.git|\.env|composer\.(json|lock)|client[^/]*\.json)(/|$)~i', $relative)) {
        throw new RuntimeException('Private or dependency file in public output');
    }
    $bytes += $file->getSize();
    if ($bytes > 32 * 1024 * 1024) {
        throw new RuntimeException('Generated site exceeds 32 MiB cap');
    }
    $content = file_get_contents($file->getPathname());
    if (preg_match('~PHP Stack trace|PHP (?:Deprecated|Warning|Fatal error):|[A-Z]:[/\\\\]Users[/\\\\]|/home/runner/work/|\bya29\.[A-Za-z0-9_-]{20,}|\b1//[A-Za-z0-9_-]{30,}~', $content)) {
        throw new RuntimeException('Diagnostic, local path or token-shaped content in public HTML');
    }
    if ($file->getExtension() !== 'html') {
        continue;
    }
    ++$html;
    docsCheckLinks($root, $file->getPathname(), $content);
}
file_put_contents($root . '/.nojekyll', '');
printf("Public docs checked: %d HTML pages, %d bytes; required API and uploader guides present.\n", $html, $bytes);
