# Tea & Toast updater release guide

The in-player updater downloads the **latest GitHub Release**, then reads `release-manifest.json` from the exact commit/tag named by that release. It downloads every managed file listed in the manifest.

## Required files in the published tag

The tag must contain these files at its repository root. Paths are relative to the installed `Player` directory:

- `release-manifest.json`
- `.htaccess`
- `index.php`
- `README.md`
- `assets/`
- `src/`
- `views/`
- `config/bootstrap.php`
- `config/release.php`

The manifest lists every file installed by the updater. `tools/`, `tests/`, `config/local.php`, private data, and SQLite files are intentionally excluded or protected.

## Publish a release

Run these commands from the directory containing the application files (`Player`):

```powershell
# Choose a new release number. Never reuse an existing published tag.
# Example: 0.3.1
# Edit config/release.php so these values agree:
# version = 0.3.1, ref = v0.3.1, repository = SugaComa75/Tea-and-Toast-NAS-Player

php tools/build-release.php
php -l index.php
php -l src/core.php
php -l src/admin.php
php -l src/updater.php
php -l views/admin.php
php -l views/player.php
php -l views/profile.php
php tests/updater-test.php
php tests/artwork-test.php

# Confirm the generated values.
Get-Content release-manifest.json | ConvertFrom-Json | Select-Object version,ref,repository

# Commit and push the application files and manifest together.
git add .
git commit -m "Prepare release v0.3.1"
git push origin main

# Create the tag only after the manifest-containing commit is on GitHub.
git tag -a v0.3.1 -m "Tea & Toast NAS Player v0.3.1"
git push origin v0.3.1
```

Then create a GitHub Release for the exact tag `v0.3.1` and make it the newest/latest release. No ZIP asset is required: this updater reads raw files from the tag.

## Values that must match

| Location | Example |
|---|---|
| `config/release.php` → `version` | `0.3.1` |
| `config/release.php` → `ref` | `v0.3.1` |
| `release-manifest.json` → `version` | `0.3.1` |
| `release-manifest.json` → `ref` | `v0.3.1` |
| GitHub Release tag | `v0.3.1` |
| Raw manifest URL | `.../v0.3.1/release-manifest.json` |

The tag is case-sensitive. The tag may include `v` or not, but the exact same string must be used in `config/release.php`, `release-manifest.json`, and GitHub. Do not generate the manifest, then change the version or tag afterward.

## Verify GitHub before testing the player

Replace `v0.3.1` with the tag you published:

```powershell
$repo = 'SugaComa75/Tea-and-Toast-NAS-Player'
$tag = 'v0.3.1'
$manifest = Invoke-RestMethod "https://raw.githubusercontent.com/$repo/$tag/release-manifest.json"
$manifest.version
$manifest.ref
$manifest.repository
```

Expected output is `0.3.1`, `v0.3.1`, and `SugaComa75/Tea-and-Toast-NAS-Player`. A 404 means the manifest is not at the repository root of the tag. A different `ref` means the manifest was generated for another tag.

## Fix for the current error

The installed app was built from the `0.3.0` release. If that GitHub release contains an old or mismatched manifest, do not overwrite the existing tag. Use a new patch release such as `0.3.2`, set both `version` and `ref` to that value, regenerate the manifest, commit it, push the commit, create the matching tag, and publish that tag as the latest release.

Finally open **Admin → Application updates → Check for updates**. The updater will compare the installed state, show safe changes, back up affected files, and install verified files only.

## Keep private files private

Keep `config/local.php`, the SQLite data directory, backups, update state, and secrets outside the managed release files. The updater protects local configuration and data from replacement.

