# YouTubePHP

An async [ReactPHP](https://reactphp.org) client for the
[YouTube Data API v3](https://developers.google.com/youtube/v3), live chat included,
built the way [DiscordPHP](https://github.com/discord-php/DiscordPHP) is built: a non-blocking HTTP
transport, an event-emitting client, and hydrated "parts" for every API object.

The API surface is **generated from Google's discovery document**. `spec/discovery.json` is the input
to the code generator, and the test suite reads the same document to prove every method in it is
reachable from PHP.

**Revision 20260924** · 83 methods · 31 resources · 210 parts.

## Requirements

- PHP 8.4 or newer
- ext-json, ext-mbstring

## Installation

```bash
composer require vzgcoders/youtubephp
```

### Windows and SSL

A Windows PHP build usually ships without a CA bundle, so TLS to `googleapis.com` fails. Point the
socket connector at one:

```php
$youtube = new YouTube([
    // ...
    'socket_options' => ['tls' => ['cafile' => 'C:/php/cacert.pem']],
]);
```

## Signing in

A bot signs in once, as the account whose channel it works for, with Google's device flow: it
shows a code, and someone enters it at `google.com/device`. Google then issues a refresh token,
which does not expire and is not rotated, so the bot mints its hour-long access tokens from it
from then on.

What you need from the [Google Cloud console](https://console.cloud.google.com):

1. A project with the **YouTube Data API v3** enabled.
2. An **OAuth consent screen**. Publish it: while it is in *Testing*, Google ends every sign-in
   after seven days. For your own channel an unverified app is fine; Google shows a warning on the
   sign-in page, which you can click through.
3. An **OAuth client** of type **TVs and Limited Input devices**. Its id and secret go in the options.
   Google needs the secret even for this kind of client.

```php
use YouTube\Auth\EnvFileTokenStore;
use YouTube\YouTube;

$youtube = new YouTube([
    'client_id' => getenv('YOUTUBE_CLIENT_ID'),
    'client_secret' => getenv('YOUTUBE_CLIENT_SECRET'),
    // Keeps the refresh token in .env, so this happens once.
    'token_store' => new EnvFileTokenStore(__DIR__ . '/.env'),
    'device_prompt' => function (array $device) {
        echo "Enter {$device['user_code']} at {$device['verification_uri']}\n";
    },
]);

$youtube->on('ready', function (YouTube $youtube) {
    echo 'Signed in as ', $youtube->getChannel()->snippet->title, "\n";
});

$youtube->run();
```

The grant then looks after itself. Each access token is refreshed five minutes before it runs
out, and a call that still gets a 401 refreshes and is retried once. If Google has revoked the
refresh token, the client signs in again with the device prompt. It does that only for
`invalid_grant`: a refresh that fails because the network is down does not ask anyone for a code.

`EnvFileTokenStore` writes only the refresh token, so the file changes once, at sign-in, and not
every hour. The device flow may ask only for the `youtube` and `youtube.readonly` scopes; `youtube`
covers reading, posting to and moderating live chat.

With only an `api_key`, the client reads public data and signs nobody in.

## Calling the API

Every resource is a property of the client, and every method takes the parameters Google documents,
by the same names. Use named arguments for the optional ones:

```php
$youtube->videos->list(part: ['snippet', 'statistics'], id: 'dQw4w9WgXcQ')
    ->then(function ($response) {
        $video = $response->items->first();
        echo $video->snippet->title, ': ', $video->statistics->viewCount, " views\n";
    });
```

- **Parts.** Results come back as parts: nested objects are parts too, lists are
  `Discord\Helpers\Collection`s, timestamps read as `CarbonImmutable`, and `localizations` maps keep
  their keys. A field Google added after this build was generated still reads back, unhydrated.
- **Constants.** Every enum is a set of constants on its part, e.g.
  `LiveChatMessageSnippet::TYPE_SUPER_CHAT_EVENT` and `LiveBroadcastStatus::LIFE_CYCLE_STATUS_LIVE`.
- **Sending.** A request body can be a part or a plain array.
- **Uploads.** Pass a `YouTube\Http\Media`, e.g. `Media::fromFile('thumb.png')`. It goes in one
  request, which suits thumbnails, banners and captions. Google's resumable protocol, which large
  videos need, is not implemented yet.
- **Downloads.** `captions->download()` resolves with the file itself.
- **Anything else.** `$youtube->request()` calls a method this build does not know.

## Live chat

Two classes read a stream's chat, and they are built to run unattended for as long as the bot
does.

- **`LiveChat\BroadcastWatcher`** notices when the signed-in channel goes live and when it stops.
  YouTube has no usable push notification for this, so it asks every two minutes (five while
  live), for one unit of quota a check. It finds scheduled events and the "Go live now" stream
  alike.
- **`LiveChat\ChatReader`** reads one chat. By default it *streams*: YouTube pushes each message as
  it is posted, over one long-lived HTTP request. If YouTube refuses the stream, it falls back to
  polling at the interval YouTube asks for.

```php
use YouTube\LiveChat\BroadcastWatcher;
use YouTube\LiveChat\ChatReader;

$watcher = new BroadcastWatcher($youtube);

$watcher->on('broadcast.live', function ($broadcast) use ($youtube) {
    $reader = new ChatReader($youtube, $broadcast->snippet->liveChatId);

    $reader->on('chat.message', fn ($message) => printf(
        "%s: %s\n",
        $message->authorDetails->displayName,
        $message->snippet->displayMessage,
    ));

    $reader->start();
});

$youtube->on('ready', fn () => $watcher->start());
```

[examples/live-chat.php](examples/live-chat.php) is the whole thing, runnable.

What the reader takes care of:

- **History:** joining sends the chat's recent history first. What was posted before the reader
  joined is not emitted, so a restart does not replay it.
- **Events:** each kind of item has its own event: `chat.message`, `chat.superchat` (Super Chats
  and Super Stickers), `chat.member` (new members, milestones, gifts), `chat.gift`, `chat.poll`,
  `chat.banned` and `chat.deleted`. `chat.item` carries everything.
- **Dropped connections:** it reconnects with the same back-off as TwitchPHP's chat client: from a
  second to a minute over about five minutes, then every five minutes. It emits
  `chat.disconnected`, `chat.reconnecting` and, once an outage, `chat.reconnect_failed`.
  `reconnect()` tries again at once.
- **Quiet streams:** a stream silent for five minutes is reopened where it left off. A connection
  the network dropped looks exactly like a quiet chat, and there is nothing to ping.
- **The end:** `chat.ended` when YouTube says the chat is over. Tell the watcher, with
  `$watcher->ended($broadcastId)`, and it reports the broadcast ended without waiting for two more
  checks.

YouTube no longer reports deleted messages as they happen. A deletion appears only as a tombstone
in a later listing, which `chat.deleted` passes on. A moderator's ban does arrive at once, as
`chat.banned`.

## Quota

Each Google Cloud project gets a daily allowance, which resets at midnight Pacific time:

- 10,000 units, shared by most methods;
- 100 `search.list` calls;
- 100 `videos.insert` calls.

A list costs 1 unit, and a write such as posting a chat message costs 50. Every request counts,
failed ones included, and a project that runs out gets `quotaExceeded` for everything until the
reset. [`Quota\Cost`](src/YouTube/Quota/Cost.php) has each method's cost, which each method's
documentation also gives.

The client counts as it goes, in a `Quota\Meter`:

- **Refusing:** a call today's quota cannot pay for is refused before it is sent, with a
  `QuotaExceededException` whose `isLocal()` is true. It costs nothing.
- **Catching up:** the count is an estimate, because other programs may use the same project. When
  Google says `quotaExceeded`, the meter marks the day spent, and the client emits
  `quota.exhausted` once a day for each bucket.
- **Reserve:** `quota.reserve` keeps units back from background work. The watcher and the reader
  stop at the reserve; commands a person gives may still spend it.
- **Pacing:** when polling, the reader slows down if YouTube's pace would spend the quota within
  six hours (`budget_hours`). When only the reserve is left, it pauses until the reset.
- **Restarts:** `quota.path` names a JSON file that keeps the count across restarts.

```php
new YouTube([
    // ...
    'quota' => [
        'daily' => 10000,   // more, if Google has granted the project more
        'reserve' => 500,
        'path' => __DIR__ . '/storage/youtube-quota.json',
    ],
]);
```

Streaming chat costs far less than polling it. Google does not publish what a stream connection
costs, so the meter counts each one as a list call.

## Errors

Google's errors carry a reason as well as a status. A quota running out and a chat that ended are
both 403s, so each reason that matters has its own exception, under
`YouTube\Http\Exceptions\HttpException`:

| Exception | Means |
| --- | --- |
| `QuotaExceededException` | The day's quota is spent. |
| `RateLimitedException` | Too fast. The transport waits these out and retries before giving up. |
| `LiveChatEndedException` | The chat is over. |
| `LiveChatDisabledException` | The broadcast has chat turned off. |
| `LiveChatNotFoundException` | No such chat. |
| `MissingScopeException` | The grant lacks a scope this needs. A new token will not help. |
| `UnauthorizedException` | The token is dead. The client recovers from this itself when it can. |
| `BadRequestException` · `ForbiddenException` · `NotFoundException` · `ConflictException` · `ServerException` | By status. |

Retries: rate limits are retried with any verb, since they mean the request was not processed.
Server errors and dropped connections are retried only for verbs that can safely be repeated. A
`POST` is retried only on a 503, because a second copy of a chat message is worse than an error.

## How the code is generated

```bash
composer spec:build     # fetch spec/discovery.json, then regenerate
composer spec:generate  # regenerate from the committed spec
```

- **Inputs:** `spec/discovery.json`, which is Google's discovery document with its keys sorted so
  a new revision diffs cleanly, and `spec/quota.json`, the costs, kept by hand from Google's quota
  calculator and method pages.
- **Outputs:** `tools/generate.php` writes the parts, one API class per resource, the scope
  constants and the cost table.
- **Checks:** it refuses to run when a method has no cost, or when Google adds a nested resource
  nobody has mapped.
- **Hand-written behaviour** goes in `src/YouTube/Parts/Concerns/<Schema>Behaviour.php`, a trait
  the generator mixes into that part.
- **`@since`:** a class or method keeps the version it was first generated in.

CI regenerates on every push and fails if the result differs from what is committed.

## Development

```bash
composer test   # PHPUnit; no network, no credentials
composer cs     # php-cs-fixer
composer docs   # the class reference, into build/
```

## Licence

MIT.
