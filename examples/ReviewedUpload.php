<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Examples;

use Psr\Http\Message\ResponseInterface;
use React\Http\Message\Response;
use React\Promise\PromiseInterface;

use function React\Promise\resolve;

use YouTube\Http\DriverInterface;
use YouTube\Http\Media;
use YouTube\Http\Request;
use YouTube\YouTube;

/**
 * A one-attempt transport policy for the small-video example, not a library default.
 * A new process must still check a shared durable receipt before using this driver.
 */
final class SingleInsertDriver implements DriverInterface
{
    private bool $sent = false;

    public function __construct(private readonly DriverInterface $inner)
    {
    }

    public function runRequest(Request $request, bool $streaming = false): PromiseInterface
    {
        $routes = [
            'oauth.token' => ['POST', 'oauth2.googleapis.com', '/token'],
            'channels.list' => ['GET', 'youtube.googleapis.com', '/youtube/v3/channels'],
            'videos.list' => ['GET', 'youtube.googleapis.com', '/youtube/v3/videos'],
            'videos.insert' => ['POST', 'youtube.googleapis.com', '/upload/youtube/v3/videos'],
        ];
        $url = parse_url($request->getUrl());
        $route = [$request->getMethod(), $url['host'] ?? '', $url['path'] ?? ''];
        if ($streaming || ($url['scheme'] ?? '') !== 'https' || isset($url['user']) || isset($url['pass'])
            || isset($url['port']) || ($routes[$request->getEndpoint()] ?? null) !== $route) {
            return resolve($this->stopped());
        }
        if ($request->getEndpoint() === 'videos.insert') {
            if ($this->sent) {
                return resolve($this->stopped());
            }
            $this->sent = true; // Before handing any bytes to the underlying driver.
        }

        return $this->inner->runRequest($request, false)->then(
            fn (ResponseInterface $response): ResponseInterface =>
                $response->getStatusCode() >= 200 && $response->getStatusCode() < 300
                    ? $response : $this->stopped(),
            fn (\Throwable $error): ResponseInterface => $this->stopped(),
        );
    }

    private function stopped(): ResponseInterface
    {
        // Avoid the library's 401/429/503 retry paths and leaking service/auth bodies.
        return new Response(
            400,
            ['Content-Type' => 'application/json'],
            '{"error":{"code":400,"message":"Stopped; reconcile the durable receipt before retry"}}',
        );
    }
}

/**
 * Library calls only. No .env loading, grant, CLI, artifact downloader or journal.
 * See docs/github-actions-uploader.md for the mandatory repository-owned controls.
 */
final class ReviewedUpload
{
    public const SCOPES = [
        'https://www.googleapis.com/auth/youtube.readonly',
        'https://www.googleapis.com/auth/youtube.upload',
    ];

    public function __construct(private readonly YouTube $youtube)
    {
    }

    /**
     * Both callbacks must finish a DURABLE shared-store write before returning true.
     * The caller has already verified content/audience approval and file provenance.
     *
     * @param \Closure(string, string): bool $reserve Channel + media SHA dedup/reservation
     * @param \Closure(string): bool         $saveId  Save ID before ANY status readback
     */
    public function insert(
        string $path,
        string $sha256,
        string $channelId,
        string $privacy,
        string $title,
        string $description,
        \Closure $reserve,
        \Closure $saveId,
    ): PromiseInterface {
        self::validateTarget($channelId, $privacy);
        if (! preg_match('/^[a-f0-9]{64}$/D', $sha256) || ! is_file($path) || is_link($path)
            || filesize($path) < 12 || filesize($path) > 32 * 1024 * 1024
            || hash_file('sha256', $path) !== $sha256) {
            throw new \InvalidArgumentException('Invalid reviewed media');
        }
        foreach ([[$title, 100, false], [$description, 4000, true]] as [$text, $limit, $allowEmpty]) {
            if ((! $allowEmpty && $text === '') || strlen($text) > $limit
                || ! preg_match('/^[\x20-\x3B\x3D\x3F-\x7E]*$/D', $text)) {
                throw new \InvalidArgumentException('Invalid reviewed metadata');
            }
        }
        // Read once: the bytes sent are exactly the bytes hashed here.
        $media = Media::fromFile($path, 'video/mp4');
        if (strlen($media->contents) > 32 * 1024 * 1024 || hash('sha256', $media->contents) !== $sha256
            || substr($media->contents, 4, 4) !== 'ftyp') {
            throw new \InvalidArgumentException('Media changed or is not MP4');
        }

        return $this->youtube->channels->list(part: 'id', mine: true)->then(
            function ($response) use ($channelId, $sha256, $privacy, $title, $description, $media, $reserve) {
                if (count($response->items) !== 1 || $response->items->first()->id !== $channelId) {
                    throw new \RuntimeException('Wrong owner channel');
                }
                if ($reserve($channelId, $sha256) !== true) {
                    throw new \RuntimeException('Reservation not confirmed; no insert');
                }

                return $this->youtube->videos->insert(
                    part: 'snippet,status',
                    body: [
                        'snippet' => ['title' => $title, 'description' => $description, 'categoryId' => '20'],
                        // This example is ONLY for reviewed, non-synthetic, non-kids development clips.
                        'status' => ['privacyStatus' => $privacy, 'selfDeclaredMadeForKids' => false,
                            'containsSyntheticMedia' => false],
                    ],
                    media: $media,
                    notifySubscribers: false,
                );
            },
        )->then(function ($video) use ($saveId): string {
            if (! is_string($video->id) || ! preg_match('/^[A-Za-z0-9_-]{11}$/D', $video->id)) {
                throw new \RuntimeException('Missing ID; reservation remains blocked');
            }
            if ($saveId($video->id) !== true) {
                throw new \RuntimeException('ID persistence unconfirmed; reservation remains blocked');
            }

            return $video->id;
        });
    }

    /** One owner readback, suitable for bounded polling of a previously saved ID. */
    public function verified(string $id, string $channelId, string $privacy): PromiseInterface
    {
        self::validateTarget($channelId, $privacy);
        if (! preg_match('/^[A-Za-z0-9_-]{11}$/D', $id)) {
            throw new \InvalidArgumentException('Invalid video ID');
        }

        return $this->youtube->videos->list(part: 'snippet,status,processingDetails', id: $id)
            ->then(function ($response) use ($id, $channelId, $privacy): bool {
                $video = $response->items->first();
                if (count($response->items) !== 1 || $video->id !== $id
                    || $video->snippet->channelId !== $channelId || $video->status->privacyStatus !== $privacy
                    || in_array($video->status->uploadStatus, ['failed', 'rejected', 'deleted'], true)
                    || in_array($video->processingDetails?->processingStatus, ['failed', 'terminated'], true)) {
                    throw new \RuntimeException('Owner readback mismatch');
                }

                return $video->status->uploadStatus === 'processed'
                    && $video->processingDetails?->processingStatus === 'succeeded';
            });
    }

    private static function validateTarget(string $channelId, string $privacy): void
    {
        if (! preg_match('/^UC[A-Za-z0-9_-]{22}$/D', $channelId)
            || ! in_array($privacy, ['unlisted', 'public'], true)) {
            throw new \InvalidArgumentException('Invalid approved destination or visibility');
        }
    }
}
