# Civ13: a verified uploader integration

This is a specific deployment record, separate from the [generic setup guide](github-actions-uploader.md).
It is evidence for the named revision, not authorization to upload another clip
or reuse its Google grant. No credential values are included here.

## Verified result

On 2026-10-20, [run 39447608392](https://github.com/Civ13/Civ13/actions/runs/39447608392)
uploaded [Civ13 development test: cable power disconnect and reconnect (PR #3031)](https://www.youtube.com/watch?v=37MeTKVBs7I)
to **ValZarTech / @valzartech8995**, immutable channel
`UCFRx_n3Mh3FfvL9yOUfG-yw`. Owner API readback confirmed that exact ID/channel,
`privacyStatus=public`, `uploadStatus=processed` and `processingStatus=succeeded`
before the durable receipt became `verified`. Independent unauthenticated oEmbed
confirmed title/handle; that public readback alone cannot establish visibility.

The owner explicitly replaced an earlier unlisted-only request with **public** for
this new clip. `notifySubscribers=false` was explicit in the insert request and
covered by the framework multipart test; it is not a readable video-status field.
The environment retains the historical name `youtube-unlisted`; the name is not
the visibility policy. No older video visibility was changed.

All three gates were read back disabled at both repository and environment scope
after completion (2026-10-20T15:23:29.835014Z): enabled=false, stop-use=true,
zero-cost-confirmed=false. No recurring upload/capture schedule was installed.

## Review the complete integration, not isolated files

Trusted source commit: `8710dc0264f927b3d19e49dfea50c0b09f0d9675`.
All links below are immutable:

- [Full integration/setup guide](https://github.com/Civ13/Civ13/blob/8710dc0264f927b3d19e49dfea50c0b09f0d9675/docs/youtube-upload.md)
- [Manual caller](https://github.com/Civ13/Civ13/blob/8710dc0264f927b3d19e49dfea50c0b09f0d9675/.github/workflows/youtube-upload.yml),
  [trusted worker](https://github.com/Civ13/Civ13/blob/8710dc0264f927b3d19e49dfea50c0b09f0d9675/.github/workflows/youtube-upload-worker.yml),
  [credential-free historical importer](https://github.com/Civ13/Civ13/blob/8710dc0264f927b3d19e49dfea50c0b09f0d9675/.github/workflows/youtube-prepare-import.yml)
- [Controller and durable journal](https://github.com/Civ13/Civ13/blob/8710dc0264f927b3d19e49dfea50c0b09f0d9675/tools/youtube/upload.py),
  [PHP adapter](https://github.com/Civ13/Civ13/blob/8710dc0264f927b3d19e49dfea50c0b09f0d9675/tools/youtube/adapter.php),
  [local PKCE/secret-placement helper](https://github.com/Civ13/Civ13/blob/8710dc0264f927b3d19e49dfea50c0b09f0d9675/tools/youtube/authorize.py)
- [Offline tests](https://github.com/Civ13/Civ13/tree/8710dc0264f927b3d19e49dfea50c0b09f0d9675/tests/youtube_upload),
  [exact approved import material](https://github.com/Civ13/Civ13/blob/8710dc0264f927b3d19e49dfea50c0b09f0d9675/tools/youtube/imports/pr3031.json)

The adapter pinned YouTubePHP `7ce9b24eb26a32af7ffcd4936d8083c06a428fb0` and a
reviewed Composer lock. This deployment passed 74 Python tests, 53 PHP assertions,
four workflow lints, independent review with no must-fix finding, and CodeQL with
zero findings. Those checks are distinct from the successful live owner readback.

These files contain **Civ13-specific policy**, not portable defaults: repository
IDs, owner reviewer, Google project, channel, branch, content/visibility rules,
historical import and receipt-key namespace. Read the source license before
copying; adapt them together in a reviewed consumer PR with matching tests.

## What made the run safe and repeatable

The human personally performed local Desktop PKCE consent for the approved
project/channel and confirmed encrypted storage of exactly three protected
environment secrets. No Google login was performed in Actions. The grant used
only `youtube.upload` plus separately justified `youtube.readonly`. The environment
required the owner reviewer, allowed that owner's self-review, disabled admin
bypass and allowed only `master`. The setup helper created no environment and
refused secret overwrite; gate variables stayed disabled throughout setup.

Untrusted gameplay/test producers and credential-free inspection were separated
from trusted upload code. Both jobs used the reviewed default-branch dispatch
commit. The secret-bearing job never checked out or executed PR scripts, treated
artifact metadata as code, or decoded video. Actions and dependency references
were pinned; secrets entered only the final trusted adapter step.

The approved source was [PR3031](https://github.com/Civ13/Civ13/pull/3031), tested game
commit `861a04010f2819493d5c37d0adf542eea9b78988`, original successful CI run
`38127733413`. The video was owner-attested native DreamSeeker capture in an
isolated, controlled **pregame** scene, not a CI recording or multiplayer/production
acceptance run. The reviewed copy masked the Game ID only, retaining 26 native
frame presentation times, no audio/interpolation; its ending was 0.44 seconds
longer. Approved MP4: 1,308,770 bytes, 41 seconds,
SHA256 `7a0605e3e4c799beaf76fbd5b9b02ddf27a80fb9e5c4df28853248b742851456`.

A private local/Library file was not assumed accessible to a GitHub runner.
The owner-approved exact masked bytes were made available through an approved
public GitHub attachment, then a separate trusted importer packaged them without
capturing/transforming the game. The original tested game revision and later
packaging revision/run remained distinct. Successful final sequence:

1. [Importer 39447256895](https://github.com/Civ13/Civ13/actions/runs/39447256895)
   produced artifact `12276292330`, 1,309,110 bytes,
   SHA256 `90c67ba7f95ef656566a1884c2c69c3db2e01dd51b49a629c6ff72e519919157`.
2. [Inspection 39447373692](https://github.com/Civ13/Civ13/actions/runs/39447373692)
   validated provenance/content consistency without channel credentials.
3. Owner-approved [upload 39447608392](https://github.com/Civ13/Civ13/actions/runs/39447608392)
   persisted reservation, returned ID, then verified receipt. A bounded monitor
   reset/read back both gate scopes after terminal success.

The data-only `youtube-upload-receipts` branch used Contents API compare-and-swap,
with a source key incorporating repository/game commit/media SHA and a separate
global channel+media SHA scan. A destination-wide lock, two reservations per
rolling 24 hours, 32 MiB media cap, one-day artifact retention and bounded ledger
prevented unbounded work/storage. Per-process transport policy prevented library
POST retries; durable state prevented duplicates across reruns and one-off tools.

An unrelated older one-off clip remained `uncertain` and blocked. Success for this
different approved hash did not clear it. Missing IDs/possible incomplete drafts
require owner reconciliation, not a new API insert or credential/account switch.

## Two failures worth reproducing in integration tests

**Historical PR provenance — [PR3247](https://github.com/Civ13/Civ13/pull/3247).**
The original successful run reported `pull_requests=[]` despite belonging to the
merged PR's exact game revision. The fix was limited to this approved historical
import: require commit-to-PR API association, retained exact PR head SHA, both
repository IDs, original successful CI and owner attestation/comment hash. Generic
empty or conflicting associations still fail. Do not waive provenance globally
or call the later packaging run a recorder/test run.

**Empty reusable-workflow credentials — [PR3248](https://github.com/Civ13/Civ13/pull/3248).**
Run `39443514193` stopped with a sanitized framework error although the three secret
names existed. Missing named caller bindings resolved to empty credentials.
The framework rejected empty client secret **locally before OAuth/YouTube HTTP**;
transport evidence and unchanged journal positively reconciled no transmission.
That evidence justified a corrected bounded test without rotating credentials.
The fix added named caller mappings, required callee declarations and nonempty
credential preflight before PHP. The callee's protected environment still supplies
the actual environment-scoped values. Secret-name presence never proves propagation.

Other generic errors do not imply this same safe failure point. Read the durable
receipt and transport evidence first. Once an ID exists, verify that ID; do not
insert a second video. An uncertain media outcome remains blocked until resolved.
