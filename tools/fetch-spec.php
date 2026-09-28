<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

/**
 * Downloads Google's discovery document for the YouTube Data API v3 into
 * `spec/discovery.json`, the input `tools/generate.php` reads.
 *
 * Google serves the document with its keys in a different order on every
 * request, so they are sorted here: a fetch that changes nothing then leaves
 * nothing to commit, and one that does change something shows exactly what.
 * Lists keep their order, because some of them run in parallel (`enum` and
 * `enumDescriptions`) and one is significant (`parameterOrder`).
 *
 * Run it whenever Google ships a new revision:
 *
 *     composer spec:build
 *
 * @link https://developers.google.com/discovery/v1/reference/apis
 */

const DISCOVERY_URL = 'https://youtube.googleapis.com/$discovery/rest?version=v3';

$target = dirname(__DIR__) . '/spec/discovery.json';

fwrite(STDERR, 'Fetching ' . DISCOVERY_URL . " ...\n");

$context = stream_context_create([
    'http' => ['timeout' => 120, 'header' => "User-Agent: YouTubePHP-spec-fetch\r\n"],
    'ssl' => ['verify_peer' => true, 'verify_peer_name' => true],
]);

$body = @file_get_contents(DISCOVERY_URL, false, $context);

if ($body === false) {
    fwrite(STDERR, "Failed to download the discovery document. Check your network connection.\n");
    exit(1);
}

// Objects, not arrays, so an empty `{}` survives the round trip as one.
$document = json_decode($body, false);

if (! $document instanceof stdClass || ! isset($document->schemas, $document->resources, $document->revision)) {
    fwrite(STDERR, "The downloaded document is not a recognisable discovery document.\n");
    exit(1);
}

/** Sorts every object's keys, recursively, leaving lists in their order. */
function sortKeys(mixed $value): mixed
{
    if ($value instanceof stdClass) {
        $properties = get_object_vars($value);
        ksort($properties, SORT_STRING);

        $sorted = new stdClass();
        foreach ($properties as $key => $property) {
            $sorted->{$key} = sortKeys($property);
        }

        return $sorted;
    }

    if (is_array($value)) {
        return array_map(sortKeys(...), $value);
    }

    return $value;
}

$document = sortKeys($document);

file_put_contents($target, json_encode($document, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");

printf(
    "Wrote %s - %s, revision %s, %d schemas.\n",
    $target,
    $document->title,
    $document->revision,
    count(get_object_vars($document->schemas)),
);
