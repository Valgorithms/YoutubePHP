<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Http;

/**
 * A file to upload: a video, a thumbnail, a caption track, a banner.
 *
 * Uploads go in one request, as `multipart/related` when there is metadata to
 * send beside the file and as the bare file when there is not. That suits
 * thumbnails, banners and captions. A large video is better sent with Google's
 * resumable protocol, which this library does not implement yet: a single
 * request holds the whole file in memory and starts over if it fails.
 *
 * @link https://developers.google.com/youtube/v3/guides/using_resumable_upload_protocol
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
final class Media
{
    /**
     * @param string $contents The file's bytes.
     * @param string $mimeType What they are, e.g. `image/png` or `video/mp4`.
     */
    public function __construct(
        public readonly string $contents,
        public readonly string $mimeType = 'application/octet-stream',
    ) {
    }

    /**
     * Reads a file from disk. The read blocks, so do it before the loop is
     * busy, or keep the file small.
     *
     * @throws \RuntimeException When the file cannot be read.
     */
    public static function fromFile(string $path, ?string $mimeType = null): self
    {
        $contents = @file_get_contents($path);

        if ($contents === false) {
            throw new \RuntimeException("Cannot read {$path}");
        }

        return new self($contents, $mimeType ?? self::guessMimeType($path));
    }

    private static function guessMimeType(string $path): string
    {
        return match (strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'mp4', 'm4v' => 'video/mp4',
            'mov' => 'video/quicktime',
            'webm' => 'video/webm',
            'mkv' => 'video/x-matroska',
            'srt' => 'application/x-subrip',
            'vtt' => 'text/vtt',
            'xml', 'ttml' => 'text/xml',
            default => 'application/octet-stream',
        };
    }
}
