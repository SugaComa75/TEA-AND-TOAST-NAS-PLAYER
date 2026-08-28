# Security review

## Trust boundaries

The database contains logical media references. It is not trusted to name arbitrary server files. Every filesystem operation on a track resolves the reference through `realpath()`, verifies that the canonical result is `MEDIA_ROOT` or a descendant, rejects missing files and NUL bytes, and applies an extension allowlist.

This blocks `../` traversal, absolute-path injection, prefix-confusion paths such as `/media-old`, and symbolic links that leave the media tree.

## Attack surfaces and mitigations

| Surface | Mitigation |
| --- | --- |
| Stream and download IDs | Integer IDs, database lookup, privacy checks, canonical path validation, allowlisted formats, bounded byte ranges |
| Scanner | Administrator gate, recursive extension allowlist, canonical root check, excluded internal directories |
| Uploads and audio editor | Login/role checks retained, extension validation retained, destination under `MEDIA_UPLOAD_ROOT`, canonical validation before indexing |
| Cover art | Embedded art stored in SQLite; adjacent artwork is read only beside an already validated media file |
| Database and caches | Configurable `DATA_ROOT` outside web root; Apache deny rules retained; Nginx deny example documented |
| Direct media URLs | No web-server mapping is created; media is served only by application endpoints |

## Operational recommendations

- Prefer read-only access to the library. Grant write access only to the uploads subtree when possible.
- Keep `DATA_ROOT` and `MEDIA_ROOT` outside the document root.
- Do not expose the NAS media share through a web-server alias.
- Restrict administrator accounts, keep PHP and the host OS patched, and back up SQLite consistently.
- Review the original application's broad CORS policy and public API settings before exposing it to the internet; this refactor does not redesign those existing features.

## Installer and administrator controls

- install.php uses CSRF protection, no-store headers, a restrictive Content Security Policy, and refuses to overwrite a database containing users.
- The installer writes no plaintext password; the Super Administrator password is stored with password_hash() in the private SQLite database.
- Delete install.php immediately after successful setup. The presence of config/local.php also locks the installer against reuse.
- Only the Super Administrator may promote administrators or change their module permissions.
- Administrator persistence cookies are HttpOnly, SameSite=Lax, and Secure on HTTPS.

## Residual risk

The upstream application is a very large single PHP file with administration, upload, social, IDE, database-manager, and file-manager features. The present work narrows external-media access but is not a complete audit of every upstream feature. Internet-facing deployments should disable unused modules at the reverse proxy or place the service behind authentication.
