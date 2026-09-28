<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Parts;

use Carbon\CarbonImmutable;
use YouTube\Factory\Factory;
use YouTube\YouTube;

/**
 * Base model for one YouTube Data API resource or object.
 *
 * Mirrors DiscordPHP's `Part`: `get{Attr}Attribute` / `set{Attr}Attribute`
 * mutator hooks, property and array access, and JSON serialisation. The classes
 * under `Parts/` are generated from Google's discovery document and declare only
 * data: `$casts` (attribute to type token, used to hydrate nested objects) and
 * `$dates`. Behaviour lives in the hand-written traits under `Parts/Concerns`,
 * which the generator mixes back in.
 *
 * Attributes the discovery document does not declare are kept as they arrived,
 * so a field Google added after this build was generated still reads back.
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
abstract class Part implements \ArrayAccess, \JsonSerializable
{
    /**
     * Attribute name => type token (`"LiveChatMessageSnippet"`,
     * `"Array of Thumbnail"`, `"Map of VideoLocalization"`), used to hydrate
     * nested objects into parts.
     *
     * @var array<string, string>
     */
    protected array $casts = [];

    /**
     * Attribute names holding RFC 3339 timestamps, read back as
     * {@see CarbonImmutable}. They are stored and serialised as the strings
     * YouTube sent.
     *
     * @var list<string>
     */
    protected array $dates = [];

    /** @var array<string, mixed> */
    private array $attributes = [];

    /**
     * @param YouTube|null                $youtube    The client, for behaviour that calls the API.
     * @param array<string, mixed>|object $attributes
     */
    public function __construct(
        protected readonly ?YouTube $youtube = null,
        array|object $attributes = [],
    ) {
        $this->fill((array) $attributes);
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function fill(array $attributes): void
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute((string) $key, $value);
        }
    }

    public function setAttribute(string $key, mixed $value): void
    {
        $setter = 'set' . self::studly($key) . 'Attribute';
        if (method_exists($this, $setter)) {
            $this->{$setter}($value);

            return;
        }

        if ($value !== null && isset($this->casts[$key])) {
            $value = $this->factory()->create($this->casts[$key], $value);
        }

        $this->attributes[$key] = $value;
    }

    public function getAttribute(string $key): mixed
    {
        $getter = 'get' . self::studly($key) . 'Attribute';
        if (method_exists($this, $getter)) {
            return $this->{$getter}();
        }

        $value = $this->attributes[$key] ?? null;

        if (is_string($value) && $value !== '' && in_array($key, $this->dates, true)) {
            try {
                return CarbonImmutable::parse($value);
            } catch (\Throwable) {
                // Not a timestamp after all: hand back what YouTube sent.
                return $value;
            }
        }

        return $value;
    }

    /**
     * Writes straight to the attribute bag, skipping the `set{Key}Attribute` hook
     * and any cast. For use *inside* a mutator, which would otherwise have no way
     * to store its shaped value without recursing through {@see setAttribute()}.
     */
    protected function setRawAttribute(string $key, mixed $value): void
    {
        $this->attributes[$key] = $value;
    }

    /** Reads straight from the attribute bag, skipping the `get{Key}Attribute` hook. */
    public function getRawAttribute(string $key): mixed
    {
        return $this->attributes[$key] ?? null;
    }

    public function attributeExists(string $key): bool
    {
        return array_key_exists($key, $this->attributes)
            || method_exists($this, 'get' . self::studly($key) . 'Attribute');
    }

    /** @return array<string, mixed> */
    public function getRawAttributes(): array
    {
        return $this->attributes;
    }

    /** @return array<string, string> */
    public function getCasts(): array
    {
        return $this->casts;
    }

    /** @return list<string> */
    public function getDates(): array
    {
        return $this->dates;
    }

    /**
     * The client this part came from.
     *
     * @throws \LogicException When the part was built without one.
     */
    public function getYouTube(): YouTube
    {
        return $this->youtube ?? throw new \LogicException(static::class . ' was built without a client, so it cannot call the API.');
    }

    /** Builds another part from the same client - for nested objects. */
    protected function factory(): Factory
    {
        return $this->youtube?->getFactory() ?? Factory::standalone();
    }

    public function __get(string $name): mixed
    {
        return $this->getAttribute($name);
    }

    public function __set(string $name, mixed $value): void
    {
        $this->setAttribute($name, $value);
    }

    public function __isset(string $name): bool
    {
        return $this->getAttribute($name) !== null;
    }

    public function __unset(string $name): void
    {
        unset($this->attributes[$name]);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->attributeExists((string) $offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->getAttribute((string) $offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->setAttribute((string) $offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->attributes[(string) $offset]);
    }

    /**
     * The payload this part would be sent back to YouTube as: nested parts and
     * collections flattened, timestamps as RFC 3339 strings.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $out = [];

        foreach ($this->attributes as $key => $value) {
            $out[$key] = self::serialize($value);
        }

        return $out;
    }

    private static function serialize(mixed $value): mixed
    {
        if ($value instanceof \DateTimeInterface) {
            return CarbonImmutable::instance($value)->utc()->format('Y-m-d\TH:i:s\Z');
        }

        if ($value instanceof \JsonSerializable) {
            return $value->jsonSerialize();
        }

        if ($value instanceof \Traversable) {
            $value = iterator_to_array($value);
        }

        if (is_array($value)) {
            return array_map(self::serialize(...), $value);
        }

        return $value;
    }

    /** @return array<string, mixed> */
    public function __debugInfo(): array
    {
        return $this->jsonSerialize();
    }

    public function __toString(): string
    {
        return json_encode($this->jsonSerialize(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '{}';
    }

    private static function studly(string $value): string
    {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $value)));
    }
}
