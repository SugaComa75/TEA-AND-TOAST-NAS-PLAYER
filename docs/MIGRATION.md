# Migration and rollback

## Upgrade

1. Back up the existing application directory and `music.db` while the application is stopped.
2. Deploy the new files without deleting `LICENSE`, `README.md`, or getID3 notices.
3. Move or copy `music.db` to the configured `DATA_ROOT`.
4. Set `MEDIA_ROOT` to the common ancestor of the music, audiobook, and podcast folders that should be scanned.
5. Confirm PHP can read the library and write `DATA_ROOT`.
6. Sign in as the super administrator and run **Full Scan**.

The scan converts resolvable legacy absolute paths to portable `media://relative/path` values. Playlists continue to reference song IDs, so no playlist schema migration is required. Records that no longer exist beneath `MEDIA_ROOT` are removed by the original differential scan behavior.

## Before scanning a large library

- Keep a copy of the old database.
- Confirm that the configured root is correct; a scan of an empty or incorrect root can remove indexed records.
- Test with a copy of the database if downtime or playlist history is important.

## Rollback

Stop the application, restore the prior code and database together, and restore the previous media layout if it changed. Do not use a database already converted to `media://` paths with an older release that does not understand that scheme.
