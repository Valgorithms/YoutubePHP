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
 * One prepared HTTP request: the verb, the absolute URL, the headers and the
 * encoded body, plus the name of the API method it calls.
 *
 * The method name (`liveChatMessages.list`) is what the quota meter charges and
 * what the log shows. The URL is never logged, because an API key or an OAuth
 * code can travel in it.
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
final class Request
{
    /**
     * @param string                $endpoint The API method it calls, e.g. `liveChatMessages.list`.
     * @param array<string, string> $headers
     */
    public function __construct(
        private readonly string $endpoint,
        private readonly string $method,
        private readonly string $url,
        private readonly string $content = '',
        private array $headers = [],
    ) {
    }

    /** The API method it calls, e.g. `liveChatMessages.list`. */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getMethod(): string
    {
        return strtoupper($this->method);
    }

    /** The absolute URL, query included. */
    public function getUrl(): string
    {
        return $this->url;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    /** @return array<string, string> */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeader(string $name): ?string
    {
        foreach ($this->headers as $key => $value) {
            if (strcasecmp($key, $name) === 0) {
                return $value;
            }
        }

        return null;
    }

    public function withHeader(string $name, string $value): self
    {
        $copy = clone $this;
        $copy->headers[$name] = $value;

        return $copy;
    }

    public function __toString(): string
    {
        return $this->getMethod() . ' ' . $this->endpoint;
    }
}
