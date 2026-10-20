# Uploading reviewed videos from GitHub Actions

This guide uses YouTubePHP for a **manual, owner-approved upload** from trusted
default-branch code. Start with one small clip, an inspection-only run and no
schedule. A PR producing a video must never receive the channel credentials.

YouTubePHP supplies the API client, OAuth refresh and multipart media calls. It
does **not** supply Google consent, GitHub environment configuration, artifact
provenance, human content approval or a durable upload journal. Those are the
repository integration's responsibility. The [small PHP example](https://github.com/Valgorithms/YoutubePHP/blob/main/examples/ReviewedUpload.php)
is tested with a fake transport; it deliberately has no executable CLI or default
journal. The [Civ13 example](civ13-uploader-example.md) links a complete, separately
tested integration, including its controller and setup helper. **Copying the two
workflow templates below alone does not create a functioning uploader.**

## Choose a starting point

| Route | What to copy or implement |
| --- | --- |
| Small standalone integration | The library calls below and `ReviewedUpload.php`; implement your own trusted CLI, approval/provenance checks and durable journal as specified below. No Civ13 code is assumed. |
| Adapt the working Civ13 integration | Review its linked controller, PHP adapter, local authorization helper, policies, tests and workflows together. Replace every hard-coded project/repository/channel/owner/default-branch/visibility policy in a PR. Check licenses before copying code. |

The standalone example is restricted to reviewed, non-synthetic development clips
which are not made for kids. Its category/audience declarations are not suitable
defaults for arbitrary videos. Change them only with accurate owner-reviewed
content declarations and corresponding tests.

Record these choices before creating persistent access:

```text
Google project:       <GOOGLE_PROJECT_ID>
Owning Google account:<OWNER_ACCOUNT>              (keep private)
Channel:              <CHANNEL_HANDLE> / <CHANNEL_ID>
Repository:           <OWNER>/<REPOSITORY>
Default branch:       <DEFAULT_BRANCH>
Protected environment:<ENVIRONMENT>, e.g. youtube-upload
Required reviewer:    <OWNER_GITHUB_LOGIN>
Visibility policy:    unlisted OR public, explicitly approved
```

An unlisted link can be shared by anyone who has it. Public uploads are also
discoverable. Pin the selected privacy policy in trusted code/approval; do not
allow an untrusted artifact to choose it. Do not change older videos' visibility.

## 1. Prepare and pin the dependency

In your **consumer repository**, create a separate project directory (these are
Bash commands). Resolve dependencies locally, review the lock, then commit both
files. No grant or upload occurs here.

```bash
mkdir -p tools/youtube
cd tools/youtube
composer init --name=example/reviewed-youtube-uploader \
  --description='Reviewed manual video uploader' --license=proprietary --no-interaction
composer config repositories.youtubephp vcs https://github.com/Valgorithms/YoutubePHP
composer config minimum-stability dev
composer config prefer-stable true
composer config allow-plugins false
composer config platform.php 8.4.0
composer require --no-interaction --no-scripts --no-plugins \
  'vzgcoders/youtubephp:dev-main#7ce9b24eb26a32af7ffcd4936d8083c06a428fb0'
composer validate
```

Choose the package name/license for your consumer; `proprietary` above is an
illustrative application license, not a change to YouTubePHP's MIT license.
The exact commit is the version tested in the case study, not a recommendation
to ignore later fixes. Composer warns about the intentional commit-ref constraint
(`validate --strict` therefore exits nonzero); the normal `validate` command still
checks the schema. Review
both the pinned source **and the lock's resolved transitive references**. Do not
use global path overrides when generating a portable consumer lock. A library
checkout ignores its own `composer.lock`; your consumer application should commit
its lock. CI installs it, never runs `composer update`:

```bash
composer install --working-dir=tools/youtube --no-dev --no-interaction \
  --no-scripts --no-plugins --prefer-dist --no-progress
```

Use PHP 8.4+, JSON and mbstring. At this pin, media is read completely into memory
and sent in **one multipart request**; resumable upload is not implemented. Cap
clips before PHP starts; the example uses 32 MiB. Use a bounded process/job timeout
and enough memory for the file and multipart copy (Civ13 uses 256 MiB).

## 2. Google project, consent and channel

In the approved project in [Google Cloud Console](https://console.cloud.google.com/):

1. Enable **YouTube Data API v3**. An API key or service account does not replace
   the channel owner's OAuth grant.
2. Configure Google Auth Platform branding/support/contact details. For an initial
   owner-only test, choose **External / Testing**, and add the owning Google account
   under **Test users**. A pre-existing test-user entry need not be duplicated.
3. Add exactly these complete scope URLs in Data Access:

   ```text
   https://www.googleapis.com/auth/youtube.upload
   https://www.googleapis.com/auth/youtube.readonly
   ```

   `youtube.upload` is the minimum insertion scope. The separate `youtube.readonly`
   scope allows `channels.list(mine=true)` and owner `videos.list` status/processing
   readback; upload alone is absent from those methods' allowed scope lists in
   [API discovery](https://youtube.googleapis.com/$discovery/rest?version=v3).
   Do not silently substitute the much broader `youtube`, `force-ssl` or partner
   scopes. Reject a missing or expanded returned grant rather than guessing.
4. Create a **Desktop app** OAuth client. For an assistant-operated automated
   client, follow Google's [AI-powered client declaration](https://support.google.com/cloud/answer/15549257#agentic-client)
   when offered; it adds no scope. Do not reuse an agent-only client for a future
   mixed human/agent application without reviewing Google's requirements.
5. Keep downloaded client JSON in a private local folder outside repositories,
   synced/shared folders and chat. Use restrictive file permissions. The local
   setup process must not display or log the JSON, token response or client secret.

Choose the **Brand channel**, if applicable, during the owner's Google sign-in.
An account email, channel display name or remembered handle is not proof of the
destination. Resolve and approve its immutable `UC...` channel ID, then require
the same grant's `channels.list(part:'id', mine:true)` to return exactly that ID
before inserting media. A wrong channel stops; never switch accounts automatically.

### Desktop authorization code with PKCE, once locally

Use Google's [installed-app authorization-code flow](https://developers.google.com/youtube/data/guides/auth/installed-apps),
not a headless consent attempt inside Actions. The README's TV/device-flow bot
example is a different setup: Google's [device-flow allowed scopes](https://developers.google.com/identity/protocols/oauth2/limited-input-device#allowedscopes)
do not include the narrow `youtube.upload` scope.

A reviewed local helper must perform this sequence. YouTubePHP's `OAuth` class at
this pin implements refresh/device grants, **not** an authorization-code/PKCE
helper; implement this step separately or explicitly adapt the case-study helper.

1. Generate a cryptographically random verifier (43–128 URL-safe characters),
   `BASE64URL(SHA256(verifier))` challenge and independent unpredictable state.
   Bind a temporary IPv4 loopback listener to `127.0.0.1` on a free port.
2. The human opens `https://accounts.google.com/o/oauth2/v2/auth` with the approved
   `client_id`, exact loopback `redirect_uri`, `response_type=code`, the two scopes,
   `access_type=offline`, `code_challenge_method=S256`, challenge and state.
   Request fresh consent only when needed to obtain an approved refresh grant;
   do not continually generate new grants. Keep authorization parameters out of logs.
3. Have the human select the approved account/Brand channel and personally approve
   consent. Validate callback path, state with a constant-time comparison, absence
   of OAuth errors and a single unexpired callback. Bound the session (e.g. five
   minutes). Denial, timeout or mismatched state stops, without automatic retry.
4. POST form data to `https://oauth2.googleapis.com/token`: `grant_type=authorization_code`,
   `client_id`, `client_secret`, `code`, **the same** `redirect_uri`, and `code_verifier`.
   Perform this in the private helper, not a command that prints token JSON.
5. Check the granted scopes/token type, required refresh token and owner channel.
   Do not persist access tokens. Ask the human to confirm the **exact repository,
   environment and three secret names** before encrypted placement. No `.env` file,
   token file, workflow input, output, artifact or PR comment should carry tokens.

Keep client/token values out of shell arguments and tracing. A local helper can
pass each value to `gh secret set NAME --repo OWNER/REPOSITORY --env ENVIRONMENT`
on **stdin**, never with `--body VALUE`. The GitHub CLI encrypts secret input.
The human can instead use GitHub's environment-secret UI directly. Do not ask them
to paste secrets into chat. Revoking the Google app grant terminates its access;
merely discarding a local token does not revoke it.

External/Testing refresh tokens for these YouTube scopes [expire after seven days](https://developers.google.com/identity/protocols/oauth2#expiration).
Refresh tokens can also be revoked/invalidated for other reasons; "never expires"
is not a safe assumption. Continued use requires a separately approved renewal
or Production consent/verification plan. Never silently rotate/overwrite secrets,
broaden scopes or create another client to work around an error.

## 3. Configure the protected GitHub environment

In the consumer repository's Settings → Environments, create `<ENVIRONMENT>`:

- Require the named human owner as reviewer. Explicitly choose whether the owner
  may review their own dispatch; Civ13 allows self-review, while retaining the
  required approval step. Confirm your GitHub plan supports the desired protections.
- Disable administrator bypass. Restrict deployment branches to **only** the
  actual default branch, using an explicit branch rule. Protect that branch.
- Store exactly `YOUTUBE_CLIENT_ID`, `YOUTUBE_CLIENT_SECRET`, `YOUTUBE_REFRESH_TOKEN`
  as **environment secrets**. Do not move them to repository/organization scope
  to fix propagation. Inspection and PR jobs must not receive them.
- Keep repository and environment variables explicitly disabled:

  ```text
  YOUTUBE_UPLOAD_ENABLED=false
  YOUTUBE_UPLOAD_STOP_USE=true
  YOUTUBE_ZERO_COST_CONFIRMED=false
  ```

Do not enable uploads during credential setup. Store/rotation approval is separate
from clip approval or source PR approval. A three-secret write is not atomic:
GitHub cannot return old values for rollback. An interrupted/uncertain placement
needs owner reconciliation and uploads must remain disabled. Never knowingly
overwrite an existing grant as an incidental setup retry.

### Reusable workflow interface

These are **consumer repository templates**, not active workflows in YouTubePHP.
Replace `youtube-upload` with the approved environment. Your default branch is
read dynamically. Copy the tested PHP example into your consumer and implement
the trusted `tools/youtube/repository-uploader.php` controller contract in the next
section **before** enabling mutation. That file is intentionally not supplied as
an unsafe journal-free CLI. The templates fail if it is absent; they do not call
any Civ13 script implicitly.

Caller, `.github/workflows/youtube-upload.yml`:

```yaml
name: Reviewed YouTube upload
on:
  workflow_dispatch:
    inputs:
      execute_upload:
        type: boolean
        default: false
        description: Insert the separately approved clip after inspection
permissions:
  contents: read
  actions: read
  issues: read
  pull-requests: read
jobs:
  upload:
    if: github.ref == format('refs/heads/{0}', github.event.repository.default_branch)
    uses: ./.github/workflows/youtube-upload-worker.yml
    with:
      execute_upload: ${{ inputs.execute_upload }}
    secrets:
      YOUTUBE_CLIENT_ID: ${{ secrets.YOUTUBE_CLIENT_ID }}
      YOUTUBE_CLIENT_SECRET: ${{ secrets.YOUTUBE_CLIENT_SECRET }}
      YOUTUBE_REFRESH_TOKEN: ${{ secrets.YOUTUBE_REFRESH_TOKEN }}
```

Worker, `.github/workflows/youtube-upload-worker.yml`:

```yaml
name: Trusted YouTube worker
on:
  workflow_call:
    inputs:
      execute_upload:
        type: boolean
        required: true
    secrets:
      YOUTUBE_CLIENT_ID:
        required: true
      YOUTUBE_CLIENT_SECRET:
        required: true
      YOUTUBE_REFRESH_TOKEN:
        required: true
permissions:
  contents: read
  actions: read
  issues: read
  pull-requests: read
concurrency:
  group: youtube-destination-upload
  cancel-in-progress: false
jobs:
  inspect:
    if: >-
      github.event_name == 'workflow_dispatch' &&
      github.ref == format('refs/heads/{0}', github.event.repository.default_branch)
    runs-on: ubuntu-24.04
    timeout-minutes: 5
    steps:
      - uses: actions/checkout@11bd71901bbe5b1630ceea73d27597364c9af683 # v4.2.2
        with:
          ref: ${{ github.sha }}
          persist-credentials: false
      - uses: shivammathur/setup-php@db91e1a0e48e84637d325a7ee4d2677e146ceec4 # 2.36.0
        with:
          php-version: '8.4'
          extensions: mbstring
          coverage: none
          tools: composer:2.9.8
      - run: php tools/youtube/repository-uploader.php inspect
        env:
          GH_TOKEN: ${{ github.token }}
  upload:
    needs: inspect
    if: >-
      inputs.execute_upload && vars.YOUTUBE_UPLOAD_ENABLED == 'true' &&
      vars.YOUTUBE_UPLOAD_STOP_USE == 'false' && vars.YOUTUBE_ZERO_COST_CONFIRMED == 'true'
    environment: youtube-upload
    runs-on: ubuntu-24.04
    timeout-minutes: 8
    # If your durable journal uses GitHub Contents, grant contents:write HERE
    # AND in the caller. A callee cannot elevate a read-only caller token.
    steps:
      - uses: actions/checkout@11bd71901bbe5b1630ceea73d27597364c9af683 # v4.2.2
        with:
          ref: ${{ github.sha }}
          persist-credentials: false
      - uses: shivammathur/setup-php@db91e1a0e48e84637d325a7ee4d2677e146ceec4 # 2.36.0
        with:
          php-version: '8.4'
          extensions: mbstring
          coverage: none
          tools: composer:2.9.8
      - run: >-
          composer install --working-dir=tools/youtube --no-dev --no-interaction
          --no-scripts --no-plugins --prefer-dist --no-progress
      - name: Upload using trusted controller and protected environment
        run: php -d display_errors=0 -d memory_limit=256M tools/youtube/repository-uploader.php upload
        env:
          GH_TOKEN: ${{ github.token }}
          YOUTUBE_CLIENT_ID: ${{ secrets.YOUTUBE_CLIENT_ID }}
          YOUTUBE_CLIENT_SECRET: ${{ secrets.YOUTUBE_CLIENT_SECRET }}
          YOUTUBE_REFRESH_TOKEN: ${{ secrets.YOUTUBE_REFRESH_TOKEN }}
          YOUTUBE_UPLOAD_ENABLED: ${{ vars.YOUTUBE_UPLOAD_ENABLED }}
          YOUTUBE_UPLOAD_STOP_USE: ${{ vars.YOUTUBE_UPLOAD_STOP_USE }}
          YOUTUBE_ZERO_COST_CONFIRMED: ${{ vars.YOUTUBE_ZERO_COST_CONFIRMED }}
```

Use both **named caller bindings** and required callee declarations. Required keys
do not prove nonempty values; preflight them before PHP/OAuth transport. GitHub
does not pass environment configuration through `workflow_call`: the callee job's
`environment` selects its protected environment secrets, which take precedence
over a passed secret with the same name. The caller mappings above do not expose
those environment values to an unprotected caller. Avoid `secrets: inherit`.
See [GitHub's reusable-workflow secret rules](https://docs.github.com/en/actions/how-tos/reuse-automations/reuse-workflows).

Environment variables are not reliably available to a **job-level** `if`. The
job-level gate above uses repository variables; the controller must also read and
enforce the effective environment values at step execution and recheck both scopes
via GitHub metadata when your policy requires two independent gates. Inspection
receives a GitHub read token, no YouTube credential variables and no protected
environment. Never interpolate manifest text or workflow inputs into a shell command.

## 4. Implement the trusted controller, then connect the API calls

`repository-uploader.php` is code **you review and commit** in the consumer. It
must support `inspect` (no YouTube secrets or OAuth) and `upload`, with these contracts:

1. Read only a reviewed policy/manifest in the trusted default-branch revision.
   Validate its bounded schema, exact channel/privacy, media SHA256, title,
   description, audience/content declaration, tested commit and named human
   approval. Bind approval to those exact fields; a changed file or metadata
   invalidates approval. A default `execute_upload=false` is not content approval.
2. Prove the source run/artifact belongs to the expected repository IDs, workflow
   ID/path, event/branch, exact tested revision and successful attempt. Check PR
   association, artifact ID/name/size/digest/expiry and creation during that attempt.
   Never check out or execute producer/PR scripts in the secret-bearing job.
   Separate original recording/game revision from a later trusted packaging run.
3. Download bounded bytes using credential-free signed redirects, check archive
   and media hashes, reject traversal/symlinks/encrypted/extra entries, and probe
   MIME/header/codec/duration/dimensions **without upload secrets**. A hash is
   consistency evidence, not gameplay or publication approval. Revalidate trusted
   provenance/approval and identical media bytes in the upload job, without decoding
   media there. Use a fixed size/content policy, not artifact-provided limits.
4. Enforce disabled gates, default-branch/manual-only eligibility, destination-wide
   concurrency, a small daily upload cap, zero-cost budget and nonempty credentials.
   Treat auth/rate/quota errors as stop-use. Never print raw exceptions, auth headers,
   tokens, signed artifact URLs, media or OAuth response bodies.
5. Load the durable journal and block any existing destination+media SHA record
   across manifests, commits and one-off tools. Use a shared persistent store,
   not a runner file, cache or expiring artifact. Import known prior attempts first.
   For a small GitHub Contents journal, use a separate **data-only** branch and
   compare-and-swap the current file SHA. `contents:write` is repository-wide,
   so protect the default branch and document this privilege. It is not needed
   for inspection or a journal stored through a different approved mechanism.
6. Commit `reserved` **before** `videos.insert`. If reservation persistence is
   failed/uncertain, send no media. Persist returned ID as `uploaded` **before**
   readback; only mark `verified` after exact channel/privacy and successful
   processing. Receipt fields should contain public IDs/hashes/provenance, no auth.
   Do not delete dedup history to fit a cap; stop for reviewed maintenance.
7. Bound polling (for example 12 reads, ten seconds apart). If an ID exists, future
   attempts are **verify-only**, including after artifact expiry. If insert/ID
   persistence is uncertain, stop retries and retain the reservation. An empty
   uploads playlist does not prove no incomplete Studio draft exists; API inventory
   may not expose every draft. Reconcile with owner evidence, never another insert,
   credential/client switch or automated account selection.

The example's `reserve(channel, sha)` callback must atomically reject an existing
record and confirm a persistent write before returning `true`. Its `saveId(id)`
callback must confirm another persistent write. These are integration hooks, not
in-memory booleans. The example does not itself mark a receipt verified.

Here is the actual library connection pattern, inside that trusted controller:

```php
use YouTube\Auth\OAuth;
use YouTube\Examples\ReviewedUpload;
use YouTube\Examples\SingleInsertDriver;
use YouTube\Http\Drivers\React as ReactDriver;
use YouTube\YouTube;

// Require tools/youtube/vendor/autoload.php and your copied ReviewedUpload.php first.
// $loop is your React event loop; all three strings were preflighted, never logged.
$driver = new SingleInsertDriver(new ReactDriver($loop, [], 120.0));
$oauth = new OAuth($clientId, $clientSecret, $driver);
$session = $oauth->refreshToken($refreshToken)->then(function (array $grant) use ($driver, $loop) {
    $scopes = $grant['scope'] ?? [];
    sort($scopes);
    if ($scopes !== ReviewedUpload::SCOPES
        || strtolower($grant['token_type'] ?? '') !== 'bearer'
        || ! is_string($grant['access_token'] ?? null) || $grant['access_token'] === '') {
        throw new RuntimeException('Unexpected grant; stop without logging the response');
    }
    return new YouTube([
        'token' => $grant['access_token'],
        'scopes' => ReviewedUpload::SCOPES,
        'driver' => $driver,
        'loop' => $loop,
        // No token_store, device_prompt, refresh_token or automatic reauthorization.
    ]);
});
```

`OAuth::refreshToken` normalizes the returned scope string into an array. Chain
your promise handling from `$session` and run/stop the event loop with a bounded
deadline. Construct `new ReviewedUpload($youtube)`, call `insert(...)` with the
approved file/metadata and the **durable** callbacks above, then poll
`verified($savedId, $channelId, $privacy)`; `false` means still processing and
`true` permits the controller to persist `verified`. Close the client in cleanup.
Catch errors at the CLI boundary with a fixed sanitized diagnostic, preserving
the journal for reconciliation. Do not call `YouTube::run()` to start a bot loop.

At the tested pin, normal library behavior retries some POST failures (503/rate
limits), and a client configured with refresh credentials may replay after 401.
`SingleInsertDriver` is an **example integration policy**, not a changed library
default: it allows only four fixed HTTPS endpoints, converts non-2xx/transport
failures into a sanitized non-retryable error and rejects a second media insert.
That per-process counter is insufficient across workflow reruns; the journal is
still mandatory. Never retry an ambiguous media request just because a driver
returned an error. Larger/resumable uploads need a separately reviewed implementation.

## 5. Validate, run once, and close the gates

In this library checkout, the example has offline tests using `ScriptedDriver`,
not Google/network access. After installing the development dependencies:

```bash
php -l examples/ReviewedUpload.php
vendor/bin/phpunit --filter=ReviewedUploadTest
```

In a consumer, add tests for the full controller, durable-write ordering/failures,
dedup across reruns, tampered provenance/approval, file caps/paths, scope/channel
mismatch and no media requests on failure. Mocked API tests do not prove a real
grant, channel ownership or publication. Lint the copied YAML with actionlint;
keep setup/actions pinned and review lock changes separately.

For the first live check, inspect first with `execute_upload=false`. Confirm
standard-runner/public-repository **$0** eligibility and your existing account
budget; private-repository allowances and environment features may differ. Use
short artifact retention (e.g. one day), bounded file size, one clip per dispatch,
job timeouts and a low daily cap. Do not add larger runners, paid services or
unbounded video retention.

After a fresh exact-clip approval, open the repository **and** environment gates
only for one bounded test: enabled=true, stop-use=false, zero-cost-confirmed=true.
Dispatch the default-branch caller, then have the owner personally approve the
protected job. A separate bounded monitor must reset **both scopes** to disabled
on terminal state, failure, interruption or deadline and **read back** the result.
`always()` inside a job cannot guarantee cleanup after cancellation, outage or
runner loss. If monitoring disconnects, independently verify shutdown before
claiming gates are closed. The templates do not install a watchdog for you.

Do not call an upload successful merely because the insert returned an ID or the
Actions job completed. Verify that exact ID through owner API readback:

```text
snippet.channelId == approved immutable channel
status.privacyStatus == approved public/unlisted policy
status.uploadStatus == processed
processingDetails.processingStatus == succeeded
```

Then persist the verified receipt and return `https://www.youtube.com/watch?v=<ID>`.
A public/embeddable page or oEmbed response alone does not distinguish public from
unlisted. `notifySubscribers=false` is an explicit request parameter, not a status
field you can read back. Failed/mismatched/pending processing is not success and
never authorizes a second insert.

## Current Google limits and troubleshooting

Official documentation checked **2026-10-20**: [`videos.insert`](https://developers.google.com/youtube/data/reference/rest/v3/videos/insert)
uses a separate Video Uploads bucket of 100 calls/day, at one unit per call, and
says unverified API projects are not restricted to private viewing. Older guidance
about 1,600 units/private-only uploads should not be copied as a current rule.
Creator account settings, OAuth consent verification and actual project/account
restrictions remain separate: always recheck current official docs and returned
privacy. If Google returns private instead of the approved public/unlisted value,
stop and resolve the applicable restriction with the owner; do not change clients
or claim publication succeeded.

| Symptom | Check before doing anything else |
| --- | --- |
| API project/client setup appears complete but consent denies access | Exact project/client type, External/Testing test-user account, complete scope URLs and the selected Brand channel. |
| `invalid_grant` after a week | Testing refresh-token expiration or revocation. Stop; plan owner-approved renewal/Production verification, never loop consent. |
| Secret names exist but refresh sees empty values | Explicit caller named bindings, callee required declarations, actual callee environment name and step env. Metadata presence is not value propagation. |
| Historical successful run has empty `pull_requests` | Do not waive provenance globally. Validate exact commit-to-PR relation and original success, under a narrowly reviewed import policy; keep game and packaging commits distinct. |
| Generic upload failure, timeout or lost output | Inspect durable reservation/ID and sanitized transport evidence. Do not assume no bytes were sent. Use known-ID verification or owner reconciliation, not rerun. |
| Visibility mismatch/processing pending | Preserve saved ID; bounded verify-only checks. Never insert a replacement or change old visibility automatically. |
| Rate/quota/budget incident | Close gates and stop. Do not switch credentials/accounts to evade limits. |

For the precise fixes behind the tested integration, see the [Civ13 case study](civ13-uploader-example.md).
