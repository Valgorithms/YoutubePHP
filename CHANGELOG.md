# Changelog

All notable changes to this project are documented here. The format follows
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and the project uses
[Semantic Versioning](https://semver.org/).

## [Unreleased]

The first version: an async ReactPHP client for the YouTube Data API v3,
generated from Google's discovery document. It replaces the empty 2021 stub
that required `google/apiclient`.

### Added

- Every method of the Data API v3, 83 of them across 31 resources, as
  `$youtube-><resource>-><method>()`, with Google's parameters by name.
  Results come back as parts, one per schema, with enum values as constants.
- The live chat stream, `liveChatMessages->stream()`: YouTube pushes each
  message over one long-lived HTTP request, read as it arrives.
- `LiveChat\ChatReader`, which reads a chat as it happens and keeps reading
  through dropped connections. It streams, and falls back to polling. It
  leaves out the history sent on joining and gives each kind of message its own
  event.
- `LiveChat\BroadcastWatcher`, which notices the signed-in channel going live
  and ending.
- Sign-in with Google's device flow. The grant then refreshes itself, recovers
  from a 401, and signs in again only when Google revokes it.
  `EnvFileTokenStore` keeps the refresh token in `.env`.
- A quota meter that counts each call against the day's quota in Pacific time,
  refuses calls that cannot be paid for, keeps a reserve back from background
  work, and survives restarts.
- An exception for each error reason that matters, such as quota, rate
  limits, and chat ended, disabled or not found. Rate limits and server errors
  are retried, but never in a way that could post a chat message twice.
- Uploads in a single request, and caption downloads.
- `composer spec:build` to regenerate from a new revision, and a CI check that
  the committed code is exactly what the committed spec generates.
- CI on Linux and Windows with PHP 8.4 and 8.5, and a class reference built by
  phpDocumentor.
