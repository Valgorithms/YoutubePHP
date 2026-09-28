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

use Psr\Http\Message\ResponseInterface;
use React\Promise\PromiseInterface;

/**
 * The transport {@see \YouTube\YouTube} sends every API call through.
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
interface HttpInterface
{
    /**
     * Sends one API call.
     *
     * @param string                                     $endpoint   The API method, e.g. `liveChatMessages.list`, for quota and logs.
     * @param string                                     $method     The HTTP verb.
     * @param string                                     $path       Relative to the API root, e.g. `youtube/v3/liveChat/messages`.
     * @param array<string, mixed>                       $query      Null values are left out; a list repeats its key.
     * @param array<string, mixed>|\JsonSerializable|null $body      Sent as JSON.
     * @param Media|null                                 $media      A file to upload, sent to `$uploadPath`.
     * @param string|null                                $uploadPath Where uploads for this method go, e.g. `/upload/youtube/v3/videos`.
     * @param bool                                       $download   Resolve with the response body as it is: a caption file, say.
     *
     * @return PromiseInterface<mixed> The decoded JSON, null for an empty response, or the body when downloading.
     */
    public function request(
        string $endpoint,
        string $method,
        string $path,
        array $query = [],
        array|\JsonSerializable|null $body = null,
        ?Media $media = null,
        ?string $uploadPath = null,
        bool $download = false,
    ): PromiseInterface;

    /**
     * Opens a server-streamed call: a GET whose response keeps arriving for as
     * long as the server has more to send. Not retried.
     *
     * @param array<string, mixed> $query
     *
     * @return PromiseInterface<ResponseInterface> Resolves once the headers of a 200 arrive, with a body
     *                                             that is a `React\Stream\ReadableStreamInterface`.
     *                                             Rejects with the mapped exception for any other status.
     */
    public function stream(string $endpoint, string $path, array $query = []): PromiseInterface;

    /** The OAuth access token to send, or null to send none. */
    public function setToken(?string $token): void;
}
