<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Factory;

use Discord\Helpers\Collection;
use YouTube\Exceptions\PartException;
use YouTube\Parts\Part;
use YouTube\YouTube;

/**
 * Builds {@see Part}s from raw API payloads.
 *
 * The unit of work is a *type token*: a schema name from the discovery document
 * (`"LiveChatMessage"`), a list of one (`"Array of Thumbnail"`), or a map keyed
 * by string (`"Map of VideoLocalization"`, which is how `localizations` arrive).
 * Generated parts declare tokens in `$casts` and generated API methods declare
 * one as their result, so one hydrator covers nested objects and call results
 * alike.
 *
 * @since 1.0.0
 *
 * @author Valithor Obsidion <valithor@valgorithms.com>
 */
final class Factory
{
    /** Where generated parts live. */
    public const PART_NAMESPACE = 'YouTube\\Parts\\';

    private const LIST_PREFIX = 'Array of ';

    private const MAP_PREFIX = 'Map of ';

    private static ?self $standalone = null;

    public function __construct(private readonly ?YouTube $youtube = null)
    {
    }

    /**
     * A factory with no client behind it, for parts built on their own - from a
     * stored payload, say, or in a test.
     */
    public static function standalone(): self
    {
        return self::$standalone ??= new self();
    }

    /**
     * Hydrates a value according to its type token.
     *
     * Scalars pass through untouched, `Array of X` becomes a {@see Collection}
     * of parts (or a plain list, for scalars), `Map of X` keeps its keys and
     * hydrates its values, and a schema name becomes the matching part.
     */
    public function create(string $token, mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        if (str_starts_with($token, self::LIST_PREFIX)) {
            if (! is_array($value)) {
                return $value;
            }

            $inner = substr($token, strlen(self::LIST_PREFIX));
            $items = array_map(fn ($item): mixed => $this->create($inner, $item), array_values($value));
            $class = $this->partClassFor($inner);

            return $class === null ? $items : new Collection($items, null, $class);
        }

        if (str_starts_with($token, self::MAP_PREFIX)) {
            if (! is_array($value) && ! is_object($value)) {
                return $value;
            }

            $inner = substr($token, strlen(self::MAP_PREFIX));

            return array_map(fn ($item): mixed => $this->create($inner, $item), (array) $value);
        }

        $class = $this->partClassFor($token);

        if ($value instanceof Part) {
            // Already hydrated. Re-wrapping it would lose everything, because a
            // part's attributes live behind its accessors, not on the object.
            return $class === null || $value instanceof $class
                ? $value
                : $this->part($class, $value->jsonSerialize());
        }

        if ($class === null || ! is_array($value) && ! is_object($value)) {
            return $value;
        }

        return $this->part($class, (array) $value);
    }

    /**
     * Builds one part.
     *
     * @template T of Part
     *
     * @param class-string<T>      $class
     * @param array<string, mixed> $attributes
     *
     * @return T
     *
     * @throws PartException When the class is not a part.
     */
    public function part(string $class, array $attributes = []): Part
    {
        if (! class_exists($class) || ! is_subclass_of($class, Part::class)) {
            throw new PartException("{$class} is not a part.");
        }

        return new $class($this->youtube, $attributes);
    }

    /**
     * The part class a schema name maps to, or null when it names none.
     *
     * @return class-string<Part>|null
     */
    public function partClassFor(string $type): ?string
    {
        $class = self::PART_NAMESPACE . $type;

        return class_exists($class) && is_subclass_of($class, Part::class) ? $class : null;
    }

    public function getYouTube(): ?YouTube
    {
        return $this->youtube;
    }
}
