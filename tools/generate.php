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
 * Generates the library surface from `spec/discovery.json` and `spec/quota.json`:
 *
 *  - `src/YouTube/Parts/*.php`       one part per schema, with its enum values as constants
 *  - `src/YouTube/Api/*Api.php`      one class per resource, one method per API method
 *  - `src/YouTube/Api/Resources.php` the trait that puts them on the client
 *  - `src/YouTube/Auth/Scope.php`    the OAuth scopes
 *  - `src/YouTube/Quota/Cost.php`    what each method costs against the daily quota
 *
 * Everything it writes is overwritten on the next run, so hand-written
 * behaviour goes in `src/YouTube/Parts/Concerns/<Schema>Behaviour.php`: a trait
 * the generator mixes into the matching part when the file exists.
 *
 * A generated class or method keeps the `@since` it was first generated with.
 * One that is new gets the library's current version, `YouTube::VERSION`.
 *
 * The run fails, and writes nothing, if a method has no cost in
 * `spec/quota.json`, if the quota file names a method that no longer exists,
 * or if Google adds a nested resource nobody has mapped yet.
 *
 * Usage: composer spec:build (or php tools/generate.php)
 */

$root = dirname(__DIR__);
$document = json_decode(file_get_contents($root . '/spec/discovery.json'), true, 512, JSON_THROW_ON_ERROR);
$quota = json_decode(file_get_contents($root . '/spec/quota.json'), true, 512, JSON_THROW_ON_ERROR);

$revision = (string) $document['revision'];

const HEADER = <<<'PHP'
    <?php

    /*
     * This file is a part of the YouTubePHP project.
     *
     * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
     *
     * This file is subject to the MIT license that is bundled
     * with this source code in the LICENSE file.
     */

    PHP;

/** Where the reference pages live. */
const DOCS = 'https://developers.google.com/youtube/v3/';

/** Resources documented with the Live Streaming API rather than the Data API. */
const LIVE_RESOURCES = ['liveBroadcasts', 'liveChatBans', 'liveChatMessages', 'liveChatModerators', 'liveStreams', 'superChatEvents'];

/** Resources and methods Google has no reference page for. */
const UNDOCUMENTED = [
    'abuseReports',
    'liveBroadcasts.insertCuepoint',
    'tests',
    'thirdPartyLinks',
    'videoTrainability',
];

/**
 * Nested resources folded into a top-level one, with what their methods are
 * called there. Google publishes the server-streamed live chat method as
 * `youtube.v3.liveChat.messages.stream`; it is `liveChatMessages.stream` here,
 * beside the rest of live chat.
 *
 * `required` names parameters the discovery document forgets to mark required.
 * `streamed` methods resolve with a {@see \YouTube\Http\ResponseStream}.
 */
const MERGED = [
    'youtube.v3.liveChat.messages' => [
        'resource' => 'liveChatMessages',
        'methods' => [
            'stream' => [
                'name' => 'stream',
                'required' => ['liveChatId', 'part'],
                'streamed' => true,
                'docs' => 'live/docs/liveChatMessages/streamList',
            ],
        ],
    ],
];

/** A line about each resource, since the discovery document has none. */
const RESOURCE_DESCRIPTIONS = [
    'abuseReports' => 'Reports of abuse.',
    'activities' => 'What a channel has been doing: uploads, likes, playlist changes and the rest of its feed.',
    'captions' => 'The caption tracks of videos.',
    'channelBanners' => "Uploading a channel's banner image.",
    'channelSections' => "The shelves on a channel's page.",
    'channels' => "Channels, the signed-in account's own included.",
    'commentThreads' => 'Top-level comments, with their replies.',
    'comments' => 'Single comments and replies, and moderating them.',
    'i18nLanguages' => 'The interface languages YouTube supports.',
    'i18nRegions' => 'The content regions YouTube supports.',
    'liveBroadcasts' => 'Live broadcasts: scheduling one, binding it to a stream, going live and ending it.',
    'liveChatBans' => 'Banning people from a live chat, and lifting bans.',
    'liveChatMessages' => 'Live chat: reading it, posting to it, and deleting from it.',
    'liveChatModerators' => "A live chat's moderators.",
    'liveStreams' => 'The video streams that live broadcasts are fed from.',
    'members' => "A channel's members, which the API also calls sponsors.",
    'membershipsLevels' => "A channel's membership levels.",
    'playlistImages' => "Playlists' cover images.",
    'playlistItems' => 'The videos in playlists.',
    'playlists' => 'Playlists.',
    'search' => 'Searching for videos, channels and playlists. It has its own quota: 100 calls a day.',
    'subscriptions' => 'Subscriptions between channels.',
    'superChatEvents' => 'The Super Chats and Super Stickers bought on the signed-in channel.',
    'tests' => 'An internal method Google uses to test the API.',
    'thirdPartyLinks' => 'Links between a channel and third-party services.',
    'thumbnails' => "Setting a video's custom thumbnail.",
    'videoAbuseReportReasons' => 'The reasons a video can be reported for.',
    'videoCategories' => 'The categories a video can be filed under.',
    'videoTrainability' => 'Whether a video may be used to train AI models.',
    'videos' => 'Videos: listing, uploading, updating, rating and reporting them.',
    'watermarks' => "A channel's watermark image.",
];

function fail(string $message): never
{
    fwrite(STDERR, $message . "\n");

    exit(1);
}

/** Marks a file as generated, so nobody edits it by hand. */
function generatedNote(string $revision): string
{
    return "This file is generated from spec/discovery.json (YouTube Data API v3, revision {$revision}) by tools/generate.php. "
        . 'Do not edit it by hand - run `composer spec:build` instead.';
}

/** Writes a generated file with LF endings, whatever the host platform uses. */
function writeGenerated(string $path, string $contents): void
{
    if (! is_dir(dirname($path))) {
        mkdir(dirname($path), 0o777, true);
    }

    file_put_contents($path, str_replace("\r\n", "\n", $contents));
}

/** StudlyCase for a camelCase name. */
function studly(string $name): string
{
    return ucfirst($name);
}

/** SCREAMING_SNAKE_CASE for a camelCase name or an enum value. */
function constantName(string $value): string
{
    $value = preg_replace('/(?<=[a-z0-9])(?=[A-Z])/', '_', $value);
    $value = preg_replace('/[^A-Za-z0-9]+/', '_', $value);

    return strtoupper(trim($value, '_'));
}

/**
 * Makes description text safe for a docblock: no comment terminator, no HTML
 * for the documentation site to render, and no `@word` that could be read as a
 * tag at the start of a wrapped line.
 */
function docSafe(string $text): string
{
    $text = str_replace('*/', '*\/', $text);
    $text = preg_replace('/<\/?[a-zA-Z][^>]*>/', '`$0`', $text);

    return preg_replace('/(?<![\w`])@(\w+)/', '`@$1`', $text);
}

/**
 * Wraps text into docblock lines. Single line breaks become spaces; blank lines
 * stay paragraph breaks.
 *
 * A tag (`@param string $name`) goes in front as it is, unescaped, and makes
 * the whole thing one paragraph: a tag's description cannot have two.
 *
 * @return list<string>
 */
function wrapDoc(string $text, int $width = 100, string $continuation = '', string $tag = ''): array
{
    $text = docSafe(trim($text));
    if ($tag !== '') {
        $text = trim($tag . ' ' . preg_replace('/\s+/', ' ', $text));
    }

    $lines = [];
    $paragraphs = preg_split('/\n\s*\n/', $text);

    foreach ($paragraphs as $index => $paragraph) {
        if ($index > 0) {
            $lines[] = '';
        }

        $flat = preg_replace('/\s+/', ' ', trim($paragraph));
        foreach (explode("\n", wordwrap($flat, $width, "\n", false)) as $i => $line) {
            $lines[] = ($i === 0 ? '' : $continuation) . $line;
        }
    }

    return $lines;
}

/** Renders docblock body lines with the leading ` * `, on one line when they fit. */
function docBlock(array $lines, string $indent = ''): string
{
    if (count($lines) === 1 && ! str_starts_with($lines[0], '@') && strlen($indent . '/** ' . $lines[0] . ' */') <= 120) {
        return $indent . '/** ' . $lines[0] . " */\n";
    }

    $out = $indent . "/**\n";

    foreach ($lines as $line) {
        $out .= rtrim($indent . ' * ' . $line) . "\n";
    }

    return $out . $indent . " */\n";
}

/** Whether a schema node names or contains a part, which needs hydrating. */
function tokenOf(array $spec): ?string
{
    if (isset($spec['$ref'])) {
        return $spec['$ref'];
    }

    if (($spec['type'] ?? null) === 'array') {
        $inner = tokenOf($spec['items'] ?? []);

        return $inner === null ? null : 'Array of ' . $inner;
    }

    if (($spec['type'] ?? null) === 'object' && isset($spec['additionalProperties'])) {
        $inner = tokenOf($spec['additionalProperties']);

        return $inner === null ? null : 'Map of ' . $inner;
    }

    return null;
}

/** Whether a string holds an RFC 3339 timestamp. */
function isDate(array $spec): bool
{
    return ($spec['type'] ?? null) === 'string' && in_array($spec['format'] ?? null, ['date-time', 'google-datetime'], true);
}

/** The PHPDoc type an attribute reads back as. */
function attributeDocType(array $spec, bool $top = true): string
{
    if (isset($spec['$ref'])) {
        return '\\YouTube\\Parts\\' . $spec['$ref'];
    }

    return match ($spec['type'] ?? 'any') {
        'string' => $top && isDate($spec) ? '\\Carbon\\CarbonImmutable' : 'string',
        'integer' => 'int',
        'number' => 'float',
        'boolean' => 'bool',
        'array' => tokenOf($spec['items'] ?? []) !== null
            ? '\\Discord\\Helpers\\Collection<' . attributeDocType($spec['items'], false) . '>'
            : 'list<' . attributeDocType($spec['items'] ?? [], false) . '>',
        'object' => 'array<string, ' . (isset($spec['additionalProperties']) ? attributeDocType($spec['additionalProperties'], false) : 'mixed') . '>',
        default => 'mixed',
    };
}

/** A PHP single-quoted string literal. */
function literal(string $value): string
{
    return "'" . str_replace(['\\', "'"], ['\\\\', "\\'"], $value) . "'";
}

/** The version the library is at now, which new classes and methods are `@since`. */
function currentVersion(string $root): string
{
    if (preg_match("/public const VERSION = '([^']+)';/", (string) file_get_contents($root . '/src/YouTube/YouTube.php'), $match) !== 1) {
        fail('Could not read YouTube::VERSION from src/YouTube/YouTube.php.');
    }

    return $match[1];
}

/**
 * The `@since` of every generated class and method, before this run replaces
 * them: `Class` and `Class::method` => version.
 *
 * @return array<string, string>
 */
function previousSince(string $root): array
{
    $since = [];

    foreach ([...glob($root . '/src/YouTube/Parts/*.php'), ...glob($root . '/src/YouTube/Api/*.php')] as $file) {
        $class = basename($file, '.php');
        $code = (string) file_get_contents($file);

        if (preg_match('/@since (\S+)\n \*\/\n(?:(?:final|abstract) )?(?:class|trait) /', $code, $match) === 1) {
            $since[$class] = $match[1];
        }

        preg_match_all('/@since (\S+)\n     \*\/\n    public function (\w+)\(/', $code, $matches, PREG_SET_ORDER);
        foreach ($matches as [, $version, $method]) {
            $since[$class . '::' . $method] = $version;
        }
    }

    return $since;
}

/** Renders a PHP array literal for a flat list of strings. */
function listLiteral(array $values, string $indent): string
{
    if ($values === []) {
        return '[]';
    }

    $out = "[\n";
    foreach ($values as $value) {
        $out .= $indent . '    ' . literal($value) . ",\n";
    }

    return $out . $indent . ']';
}

/** Renders a PHP array literal for a string => literal map. */
function mapLiteral(array $map, string $indent, bool $rawValues = false): string
{
    if ($map === []) {
        return '[]';
    }

    $out = "[\n";
    foreach ($map as $key => $value) {
        $out .= $indent . '    ' . literal((string) $key) . ' => ' . ($rawValues ? $value : literal((string) $value)) . ",\n";
    }

    return $out . $indent . ']';
}

$version = currentVersion($root);
$since = previousSince($root);

/** The `@since` for a class or method: kept if it had one, the current version if it is new. */
$sinceOf = static fn (string $key): string => $since[$key] ?? $version;

// ---------------------------------------------------------------------------
// Schemas
// ---------------------------------------------------------------------------

$schemas = $document['schemas'];

/*
 * An object described inline, rather than by reference, becomes a schema of
 * its own named after where it sits: `ChannelContentDetails.relatedPlaylists`
 * is `ChannelContentDetailsRelatedPlaylists`.
 */
$promote = static function (string $owner, array $properties) use (&$promote, &$schemas): array {
    foreach ($properties as $field => $spec) {
        $target = &$properties[$field];
        if (($spec['type'] ?? null) === 'array' && isset($spec['items']['properties'])) {
            $target = &$properties[$field]['items'];
        }

        if (($target['type'] ?? null) === 'object' && isset($target['properties'])) {
            $name = $owner . studly($field);
            if (isset($schemas[$name])) {
                fail("Cannot name the inline object {$owner}.{$field}: {$name} is taken.");
            }

            $schemas[$name] = [
                'id' => $name,
                'type' => 'object',
                'description' => $target['description'] ?? "The `{$field}` object of a {$owner}.",
                'properties' => $promote($name, $target['properties']),
            ];
            $target = ['$ref' => $name] + array_diff_key($target, array_flip(['type', 'properties']));
        }

        unset($target);
    }

    return $properties;
};

foreach (array_keys($schemas) as $name) {
    $schemas[$name]['properties'] = $promote($name, $schemas[$name]['properties'] ?? []);
}

ksort($schemas, SORT_STRING);

// ---------------------------------------------------------------------------
// Resources and methods
// ---------------------------------------------------------------------------

/**
 * Every method, grouped by the resource it is generated under.
 *
 * @var array<string, array<string, array<string, mixed>>> $resources
 */
$resources = [];

$walk = static function (array $nodes, string $prefix) use (&$walk, &$resources): void {
    foreach ($nodes as $name => $node) {
        $path = $prefix . $name;

        if (($node['methods'] ?? []) !== []) {
            $resource = $name;
            $mapping = null;

            if ($prefix !== '') {
                $mapping = MERGED[$path] ?? fail("Google added the nested resource {$path}. Map it in MERGED in tools/generate.php.");
                $resource = $mapping['resource'];
            }

            foreach ($node['methods'] as $method => $spec) {
                $extra = $mapping === null ? [] : ($mapping['methods'][$method] ?? fail("Google added {$path}.{$method}. Map it in MERGED in tools/generate.php."));
                $methodName = $extra['name'] ?? $method;

                if (isset($resources[$resource][$methodName])) {
                    fail("{$path}.{$method} would replace {$resource}.{$methodName}.");
                }

                $resources[$resource][$methodName] = $spec + ['x-extra' => $extra];
            }
        }

        $walk($node['resources'] ?? [], $path . '.');
    }
};

$walk($document['resources'], '');
ksort($resources, SORT_STRING);

foreach ($resources as &$methods) {
    ksort($methods, SORT_STRING);
}
unset($methods);

// Every method has a cost, and every cost has a method.
$endpoints = [];
foreach ($resources as $resource => $methods) {
    foreach (array_keys($methods) as $method) {
        $endpoints[] = $resource . '.' . $method;
    }
}

$missing = array_diff($endpoints, array_keys($quota['costs']));
$stale = array_diff(array_keys($quota['costs']), $endpoints);
if ($missing !== [] || $stale !== []) {
    fail(
        ($missing === [] ? '' : 'No cost in spec/quota.json for: ' . implode(', ', $missing) . ".\n")
        . ($stale === [] ? '' : 'spec/quota.json has costs for methods that no longer exist: ' . implode(', ', $stale) . '.'),
    );
}

/** The reference page for a resource, or for one of its methods. */
function docsLink(string $resource, ?string $method = null, ?string $override = null): ?string
{
    if ($override !== null) {
        return DOCS . $override;
    }

    if (in_array($resource, UNDOCUMENTED, true) || ($method !== null && in_array($resource . '.' . $method, UNDOCUMENTED, true))) {
        return null;
    }

    $section = in_array($resource, LIVE_RESOURCES, true) ? 'live/docs/' : 'docs/';

    return DOCS . $section . $resource . ($method === null ? '' : '/' . $method);
}

/**
 * The reference page a schema is documented on: a resource's own page, or the
 * list method's for a list response.
 */
$schemaLink = static function (array $schema) use ($resources): ?string {
    $kind = $schema['properties']['kind']['default'] ?? null;
    if (! is_string($kind) || ! str_starts_with($kind, 'youtube#')) {
        return null;
    }

    $base = substr($kind, strlen('youtube#'));
    $method = null;
    if (str_ends_with($base, 'ListResponse')) {
        $base = substr($base, 0, -strlen('ListResponse'));
        $method = 'list';
    }

    $candidates = [$base, $base . 's', preg_replace('/y$/', 'ies', $base)];
    foreach ($candidates as $resource) {
        if (isset($resources[$resource]) && ($method === null || isset($resources[$resource][$method]))) {
            return docsLink($resource, $method);
        }
    }

    return null;
};

// ---------------------------------------------------------------------------
// Parts
// ---------------------------------------------------------------------------

$partsDir = $root . '/src/YouTube/Parts';
$concernsDir = $partsDir . '/Concerns';
$apiDir = $root . '/src/YouTube/Api';

/*
 * Clears out the previous run, so a schema or resource dropped upstream does
 * not linger as a stale class. Only generated files go: `Part.php`,
 * `AbstractApi.php` and everything under `Concerns/` are hand-written.
 */
foreach (glob($partsDir . '/*.php') as $file) {
    if (basename($file) !== 'Part.php') {
        unlink($file);
    }
}

foreach (glob($apiDir . '/*.php') as $file) {
    if (basename($file) !== 'AbstractApi.php') {
        unlink($file);
    }
}

$enumCount = 0;

foreach ($schemas as $name => $schema) {
    $behaviour = is_file($concernsDir . '/' . $name . 'Behaviour.php') ? $name . 'Behaviour' : null;

    $doc = wrapDoc(generatedNote($revision));
    $description = trim((string) ($schema['description'] ?? ''));
    // Some descriptions are notes Google left for itself.
    if ($description !== '' && preg_match('/^Next ID: \d+$/', $description) !== 1) {
        $doc[] = '';
        array_push($doc, ...wrapDoc($description));
    }

    $casts = [];
    $dates = [];
    $constants = [];
    $properties = [];

    ksort($schema['properties'], SORT_STRING);

    foreach ($schema['properties'] as $field => $property) {
        $token = tokenOf($property);
        if ($token !== null) {
            $casts[$field] = $token;
        }

        if (isDate($property)) {
            $dates[] = $field;
        }

        $notes = [];
        if (! empty($property['deprecated'])) {
            $notes[] = 'Deprecated.';
        }
        $text = trim((string) ($property['description'] ?? ''));
        if ($text !== '') {
            $notes[] = $text;
        }
        if (isset($property['enum'])) {
            $notes[] = 'One of the `' . constantName($field) . '_*` constants.';
        }
        if (in_array($property['format'] ?? null, ['int64', 'uint64'], true)) {
            $notes[] = 'A 64-bit number, as a string.';
        }
        if (! empty($property['readOnly'])) {
            $notes[] = 'Read-only.';
        }

        $properties[] = ['type' => attributeDocType($property) . '|null', 'name' => $field, 'notes' => implode(' ', $notes)];

        foreach ($property['enum'] ?? [] as $i => $value) {
            $constant = constantName($field) . '_' . constantName($value);
            if ($value === '' || isset($constants[$constant])) {
                fail("{$name}.{$field}: the enum value \"{$value}\" has no constant name of its own.");
            }

            $constants[$constant] = [
                'value' => $value,
                'description' => trim((string) ($property['enumDescriptions'][$i] ?? '')),
                'deprecated' => ! empty($property['enumDeprecated'][$i]),
                'field' => $field,
            ];
            ++$enumCount;
        }
    }

    if ($properties !== []) {
        $doc[] = '';
        foreach ($properties as $property) {
            array_push($doc, ...wrapDoc($property['notes'], 110, '    ', '@property ' . $property['type'] . ' $' . $property['name']));
        }
    }

    $link = $schemaLink($schema);
    if ($link !== null) {
        $doc[] = '';
        $doc[] = '@link ' . $link;
    }

    $doc[] = '';
    $doc[] = '@since ' . $sinceOf($name);

    $body = HEADER . "\n";
    $body .= "namespace YouTube\\Parts;\n\n";
    $body .= docBlock($doc);
    $body .= 'class ' . $name . " extends Part\n{\n";

    $members = [];

    if ($behaviour !== null) {
        $members[] = '    use Concerns\\' . $behaviour . ";\n";
    }

    foreach ($constants as $constant => $info) {
        $lines = $info['description'] !== ''
            ? wrapDoc($info['description'])
            : ['A `' . $info['field'] . '` of `' . $info['value'] . '`.'];
        if ($info['deprecated']) {
            $lines[] = '';
            $lines[] = '@deprecated';
        }

        $members[] = docBlock($lines, '    ') . '    public const ' . $constant . ' = ' . literal($info['value']) . ";\n";
    }

    if ($casts !== []) {
        $members[] = "    /** @var array<string, string> */\n"
            . '    protected array $casts = ' . mapLiteral($casts, '    ') . ";\n";
    }

    if ($dates !== []) {
        $members[] = "    /** @var list<string> */\n"
            . '    protected array $dates = ' . listLiteral($dates, '    ') . ";\n";
    }

    $body .= implode("\n", $members) . "}\n";

    writeGenerated($partsDir . '/' . $name . '.php', $body);
}

// ---------------------------------------------------------------------------
// Resource APIs
// ---------------------------------------------------------------------------

/**
 * The native and PHPDoc types of a method parameter.
 *
 * @return array{0: string, 1: string}
 */
function parameterTypes(array $parameter, bool $required): array
{
    [$native, $doc] = match ($parameter['type'] ?? 'string') {
        'boolean' => ['bool', 'bool'],
        'integer' => ['int', 'int'],
        'number' => ['float', 'float'],
        default => ($parameter['format'] ?? null) === 'google-datetime'
            ? ['\\DateTimeInterface|string', '\\DateTimeInterface|string']
            : ['string', 'string'],
    };

    if (! empty($parameter['repeated'])) {
        $native = 'array|' . $native;
        $doc = 'list<' . $doc . '>|' . $doc;
    }

    if (! $required) {
        $native = str_contains($native, '|') ? $native . '|null' : '?' . $native;
        $doc .= '|null';
    }

    return [$native, $doc];
}

/** What a parameter's documentation says, beyond Google's description. */
function parameterNotes(array $parameter): string
{
    $notes = [];

    if (! empty($parameter['deprecated'])) {
        $notes[] = 'Deprecated.';
    }

    $notes[] = trim((string) ($parameter['description'] ?? ''));

    if (isset($parameter['enum'])) {
        $notes[] = 'One of `' . implode('`, `', $parameter['enum']) . '`.';
    }

    if (isset($parameter['minimum'], $parameter['maximum'])) {
        $notes[] = "From {$parameter['minimum']} to {$parameter['maximum']}.";
    }

    if (isset($parameter['default'])) {
        $notes[] = 'YouTube assumes `' . $parameter['default'] . '` when it is left out.';
    }

    return implode(' ', array_filter($notes, static fn (string $note): bool => $note !== ''));
}

/** The documented quota cost of a method. */
function costNote(string $endpoint, array $quota): string
{
    $cost = $quota['costs'][$endpoint];

    foreach ($quota['buckets'] as $bucket => $info) {
        if (in_array($endpoint, $info['methods'] ?? [], true)) {
            return "Costs {$cost} of the {$bucket} quota's {$info['daily']} calls a day, not the shared daily quota.";
        }
    }

    $units = $cost . ' ' . ($cost === 1 ? 'unit' : 'units');

    return isset($quota['estimated'][$endpoint])
        ? "Costs {$units} of quota, by estimate: {$quota['estimated'][$endpoint]}."
        : "Costs {$units} of quota.";
}

$resourceClasses = [];
$methodCount = 0;

foreach ($resources as $resource => $methods) {
    $class = studly($resource) . 'Api';
    $resourceClasses[$resource] = $class;
    $usesMedia = false;
    $usesStream = false;
    $rendered = [];

    foreach ($methods as $methodName => $spec) {
        $extra = $spec['x-extra'];
        $endpoint = $resource . '.' . $methodName;
        $parameters = $spec['parameters'] ?? [];
        $requiredNames = array_values(array_unique([...($spec['parameterOrder'] ?? []), ...($extra['required'] ?? [])]));
        $streamed = ! empty($extra['streamed']);
        $upload = ! empty($spec['supportsMediaUpload']);
        $download = ! empty($spec['supportsMediaDownload']);
        $request = $spec['request']['$ref'] ?? null;
        $response = $spec['response']['$ref'] ?? null;

        foreach (['body', 'media'] as $reserved) {
            if (isset($parameters[$reserved])) {
                fail("{$endpoint} has a parameter called \${$reserved}, which the generated method uses for itself.");
            }
        }

        $optionalNames = array_values(array_diff(array_keys($parameters), $requiredNames));
        sort($optionalNames, SORT_STRING);

        $doc = wrapDoc((string) ($spec['description'] ?? ''));
        $doc[] = '';
        array_push($doc, ...wrapDoc(costNote($endpoint, $quota)));
        if ($streamed) {
            $doc[] = '';
            array_push($doc, ...wrapDoc(
                'The response keeps arriving for as long as the server has more to send, as a stream of '
                . $response . ' parts. The stream ends when the server closes it; open another with the last `nextPageToken` to carry on.',
            ));
        }
        $doc[] = '';

        $signature = [];
        $query = [];
        $pathExpression = literal($spec['path']);

        $parameterDoc = static function (string $type, string $name, string $notes) use (&$doc): void {
            array_push($doc, ...wrapDoc($notes, 100, '    ', '@param ' . $type . ' $' . $name));
        };

        foreach ($requiredNames as $name) {
            $parameter = $parameters[$name] ?? fail("{$endpoint}: the required parameter {$name} is not a parameter.");
            [$native, $docType] = parameterTypes($parameter, true);
            $signature[] = '        ' . $native . ' $' . $name . ',';
            $parameterDoc($docType, $name, parameterNotes($parameter));
        }

        if ($request !== null) {
            $signature[] = '        array|\\JsonSerializable $body,';
            $parameterDoc('\\YouTube\\Parts\\' . $request . '|array<string, mixed>', 'body', "The {$request} to send.");
        }

        if ($upload) {
            $usesMedia = true;
            $accept = implode(', ', $spec['mediaUpload']['accept'] ?? []);
            $maxSize = (int) ($spec['mediaUpload']['maxSize'] ?? 0);
            $size = $maxSize >= 1 << 30 ? round($maxSize / (1 << 30)) . ' GB' : round($maxSize / (1 << 20)) . ' MB';
            $signature[] = '        ?Media $media = null,';
            $parameterDoc('Media|null', 'media', "The file to upload: {$accept}, up to {$size}. Sent in the same request as the metadata.");
        }

        foreach ($optionalNames as $name) {
            [$native, $docType] = parameterTypes($parameters[$name], false);
            $signature[] = '        ' . $native . ' $' . $name . ' = null,';
            $parameterDoc($docType, $name, parameterNotes($parameters[$name]));
        }

        foreach ($parameters as $name => $parameter) {
            if (($parameter['location'] ?? 'query') === 'path') {
                $placeholder = str_contains($spec['path'], '{+' . $name . '}') ? '{+' . $name . '}' : '{' . $name . '}';
                $encoded = $placeholder[1] === '+' ? '$' . $name : 'rawurlencode($' . $name . ')';
                $pathExpression = str_replace($placeholder, "' . " . $encoded . " . '", $pathExpression);
            }
        }
        $pathExpression = preg_replace(["/^'' \\. /", "/ \\. ''$/"], '', $pathExpression);

        foreach ([...$requiredNames, ...$optionalNames] as $name) {
            if (($parameters[$name]['location'] ?? 'query') === 'query') {
                $query[] = '                ' . literal($name) . ' => $' . $name . ',';
            }
        }

        $doc[] = '';
        if ($streamed) {
            $usesStream = true;
            $doc[] = '@return PromiseInterface<ResponseStream>';
        } elseif ($download) {
            $doc[] = '@return PromiseInterface<string> The file.';
        } else {
            $doc[] = '@return PromiseInterface<' . ($response === null ? 'null' : '\\YouTube\\Parts\\' . $response) . '>';
        }

        $link = docsLink($resource, $methodName, $extra['docs'] ?? null);
        if ($link !== null) {
            $doc[] = '';
            $doc[] = '@link ' . $link;
        }

        $doc[] = '';
        $doc[] = '@since ' . $sinceOf($class . '::' . $methodName);

        // PSR-12 puts the brace on its own line for a one-line signature, and on
        // the closing parenthesis for a wrapped one.
        $head = $signature === []
            ? '    public function ' . $methodName . "(): PromiseInterface\n    {\n"
            : '    public function ' . $methodName . "(\n" . implode("\n", $signature) . "\n    ): PromiseInterface {\n";

        $queryLiteral = $query === [] ? '[]' : "[\n" . implode("\n", $query) . "\n            ]";

        if ($streamed) {
            $call = '        return $this->streamed(' . "\n"
                . '            ' . literal($endpoint) . ",\n"
                . '            ' . $pathExpression . ",\n"
                . '            ' . $queryLiteral . ",\n"
                . '            ' . literal((string) $response) . ",\n"
                . "        );\n";
        } else {
            $arguments = [
                literal($endpoint),
                literal($spec['httpMethod']),
                $pathExpression,
            ];
            $named = [];
            if ($query !== []) {
                $named[] = 'query: ' . $queryLiteral;
            }
            if ($request !== null) {
                $named[] = 'body: $body';
            }
            if ($response !== null) {
                $named[] = 'returns: ' . literal($response);
            }
            if ($upload) {
                $named[] = 'media: $media';
                $named[] = 'uploadPath: ' . literal($spec['mediaUpload']['protocols']['simple']['path']);
            }
            if ($download) {
                $named[] = 'download: true';
            }

            $call = '        return $this->call(' . "\n";
            foreach ([...$arguments, ...$named] as $argument) {
                $call .= '            ' . $argument . ",\n";
            }
            $call .= "        );\n";
        }

        $rendered[] = docBlock($doc, '    ') . $head . $call . "    }\n";
        ++$methodCount;
    }

    $imports = ['React\\Promise\\PromiseInterface'];
    if ($usesMedia) {
        $imports[] = 'YouTube\\Http\\Media';
    }
    if ($usesStream) {
        $imports[] = 'YouTube\\Http\\ResponseStream';
    }
    sort($imports);

    $intro = wrapDoc(generatedNote($revision));
    $intro[] = '';
    array_push($intro, ...wrapDoc(RESOURCE_DESCRIPTIONS[$resource] ?? "The {$resource} resource."));
    $intro[] = '';
    $intro[] = 'Reach it as `$youtube->' . $resource . '`. Every method takes the parameters Google';
    $intro[] = 'documents, by the same names: use named arguments for the optional ones.';
    $link = docsLink($resource);
    if ($link !== null) {
        $intro[] = '';
        $intro[] = '@link ' . $link;
    }
    $intro[] = '';
    $intro[] = '@since ' . $sinceOf($class);

    $body = HEADER . "\n";
    $body .= "namespace YouTube\\Api;\n\n";
    foreach ($imports as $import) {
        $body .= 'use ' . $import . ";\n";
    }
    $body .= "\n" . docBlock($intro);
    $body .= 'final class ' . $class . " extends AbstractApi\n{\n";
    $body .= implode("\n", $rendered);
    $body .= "}\n";

    writeGenerated($apiDir . '/' . $class . '.php', $body);
}

// The trait that puts every resource on the client.
$intro = wrapDoc(generatedNote($revision));
$intro[] = '';
$intro[] = 'One API object per resource, as properties of {@see \\YouTube\\YouTube}:';
$intro[] = '`$youtube->liveChatMessages->list(...)`.';
$intro[] = '';
$intro[] = '@since ' . $sinceOf('Resources');

$body = HEADER . "\n";
$body .= "namespace YouTube\\Api;\n\n";
$body .= docBlock($intro);
$body .= "trait Resources\n{\n";
foreach ($resourceClasses as $resource => $class) {
    $body .= docBlock(wrapDoc(RESOURCE_DESCRIPTIONS[$resource] ?? "The {$resource} resource."), '    ');
    $body .= '    public readonly ' . $class . ' $' . $resource . ";\n\n";
}
$body .= "    /** Builds every resource API against this client. */\n";
$body .= "    private function bootResources(): void\n    {\n";
foreach ($resourceClasses as $resource => $class) {
    $body .= '        $this->' . $resource . ' = new ' . $class . "(\$this);\n";
}
$body .= "    }\n}\n";

writeGenerated($apiDir . '/Resources.php', $body);

// ---------------------------------------------------------------------------
// Scopes
// ---------------------------------------------------------------------------

$scopes = $document['auth']['oauth2']['scopes'];
ksort($scopes, SORT_STRING);

$intro = wrapDoc(generatedNote($revision));
$intro[] = '';
$intro[] = 'The OAuth scopes the YouTube Data API accepts. A sign-in asks for them, and';
$intro[] = 'each method needs one of those it lists.';
$intro[] = '';
$intro[] = '@link https://developers.google.com/youtube/v3/guides/auth/installed-apps#identify-access-scopes';
$intro[] = '';
$intro[] = '@since ' . $version;

$body = HEADER . "\n";
$body .= "namespace YouTube\\Auth;\n\n";
$body .= docBlock($intro);
$body .= "final class Scope\n{\n";
foreach ($scopes as $url => $info) {
    $body .= docBlock(wrapDoc((string) $info['description']), '    ');
    $body .= '    public const ' . constantName(substr($url, strrpos($url, '/auth/') + 6)) . ' = ' . literal($url) . ";\n\n";
}
$body .= "    /** @return list<string> Every scope. */\n";
$body .= "    public static function all(): array\n    {\n";
$body .= "        return array_values((new \\ReflectionClass(self::class))->getConstants());\n    }\n}\n";

writeGenerated($root . '/src/YouTube/Auth/Scope.php', $body);

// ---------------------------------------------------------------------------
// Quota costs
// ---------------------------------------------------------------------------

$costs = $quota['costs'];
ksort($costs, SORT_STRING);

$buckets = [];
$daily = [];
foreach ($quota['buckets'] as $bucket => $info) {
    $daily[$bucket] = (string) $info['daily'];
    foreach ($info['methods'] ?? [] as $method) {
        $buckets[$method] = $bucket;
    }
}
ksort($buckets, SORT_STRING);

$estimated = array_keys($quota['estimated']);
sort($estimated, SORT_STRING);

$intro = [
    'This file is generated from spec/quota.json by tools/generate.php. Do not edit',
    'it by hand - edit spec/quota.json and run `composer spec:generate` instead.',
    '',
    'What each method costs against the daily quota, as Google publishes it. Most',
    'methods share one bucket of 10,000 units a day; `search.list` and',
    '`videos.insert` have buckets of their own, counted in calls.',
    '',
];
foreach ($quota['sources'] as $source) {
    if (str_starts_with($source, 'http')) {
        $intro[] = '@link ' . $source;
    }
}
$intro[] = '';
$intro[] = '@since ' . $version;

$body = HEADER . "\n";
$body .= "namespace YouTube\\Quota;\n\n";
$body .= docBlock($intro);
$body .= "final class Cost\n{\n";
$body .= "    /** @var array<string, int> Method => what one call costs, in its bucket's units. */\n";
$body .= '    public const METHODS = ' . mapLiteral(array_map('strval', $costs), '    ', true) . ";\n\n";
$body .= "    /** @var array<string, string> Method => its bucket, for the methods outside the default one. */\n";
$body .= '    public const BUCKETS = ' . mapLiteral($buckets, '    ') . ";\n\n";
$body .= "    /** @var array<string, int> Bucket => Google's default daily allowance. */\n";
$body .= '    public const DAILY = ' . mapLiteral($daily, '    ', true) . ";\n\n";
$body .= "    /** @var list<string> Methods whose cost Google does not publish, and is estimated. */\n";
$body .= '    public const ESTIMATED = ' . listLiteral($estimated, '    ') . ";\n\n";
$body .= "    /** What one call to a method costs. A method this build does not know counts as a read. */\n";
$body .= "    public static function of(string \$endpoint): int\n    {\n";
$body .= "        return self::METHODS[\$endpoint] ?? 1;\n    }\n\n";
$body .= "    /** The bucket a method draws from. */\n";
$body .= "    public static function bucketOf(string \$endpoint): string\n    {\n";
$body .= "        return self::BUCKETS[\$endpoint] ?? Meter::DEFAULT_BUCKET;\n    }\n}\n";

writeGenerated($root . '/src/YouTube/Quota/Cost.php', $body);

// ---------------------------------------------------------------------------

printf(
    "Generated %d parts (%d enum constants), %d methods across %d resources, %d scopes, %d costs.\n",
    count($schemas),
    $enumCount,
    $methodCount,
    count($resourceClasses),
    count($scopes),
    count($costs),
);
