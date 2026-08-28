# Tea & Toast NAS Player

A small PHP music player that browses NAS folders directly. It deliberately does not build a database catalogue of music files.

## What it does

- Requires a user to sign in before browsing or streaming anything.
- Supports multiple music folders on the same NAS.
- Opens one directory at a time, so initial load does not scan the whole library.
- Streams MP3, M4A, AAC, FLAC, WAV, OGG and Opus with HTTP range support.
- Provides random play, per-user favourites, an optional registration page, and administrator-created accounts.
- Keeps its one SQLite file outside the web root. That database contains only users, settings, library paths and user features—not the music catalogue.

## Install

1. Copy the contents of this folder into any directory under `public_html`.
2. Browse to `install.php`.
3. Enter a private writable data path outside `public_html`, one readable NAS music path, and the first administrator account.
4. Open the player and confirm the library works.
5. Delete or rename `install.php`.

The NAS folders must be readable by the PHP/web-server account. A library can be outside the web-host folder; it is served only through the authenticated streaming endpoint.

## Folder convention

The interface treats the first folder below a library as the album artist and the final parent folder as the album. It never rewrites embedded tags. Any nesting is supported, and tracks are shown from filenames.

## Current scope

This first clean build includes the player, installer and focused administrator page. Playlists, embedded-tag reading, global indexed search, updater and background manifests are intentionally left out until the basic player has been tested on the NAS.
