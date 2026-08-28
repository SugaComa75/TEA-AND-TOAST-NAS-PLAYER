# Tea & Toast Software changes

Rebuilt and Extended by Tea & Toast Software.

## Modified files

- index.php — small front controller that loads configuration, the backend, and the main view.
- config/bootstrap.php — merges installer-generated local settings, preserves environment overrides, validates safe relative upload paths, and enforces canonical media boundaries.
- README.md — documents the installer and administrator workflow.
- docs/INSTALLATION.md — documents portable public_html installation and external NAS/data paths.
- docs/SECURITY.md — documents path boundaries and operational controls.

## New application modules

- backend.php — existing server-side routing, database, API, admin, scanning, and request behavior moved out of index.php.
- views/app.php — the main HTML view.
- views/head-script.php — the PHP-aware head script partial.
- views/app-script.php — the PHP-aware main application script partial.
- assets/css/app.css — the primary application stylesheet.
- install.php — guarded first-run HTML installer for requirements, external paths, SQLite, and the first Super Administrator.
- docs/AUTHENTICATION.md — registration, verification, administrator promotion, and recovery guide.

## Existing portability files

- config/config.php — deployment defaults.
- docs/MIGRATION.md — upgrade, rescan, backup, and rollback procedure.
- tests/path_security_test.php — focused traversal and symlink-boundary checks.

Administrator persistence cookies now use HttpOnly, SameSite=Lax, and Secure on HTTPS. Only the Super Administrator can promote administrators or change their module permissions.

The application no longer generates an application-root .htaccess file. This prevents ASUSTOR and shared-host Apache installations from failing with Error 500 when a directive is not permitted by AllowOverride.

Full Scan now skips ASUSTOR #Recycle, Synology @eaDir, and any other unreadable child directory instead of terminating the scan with an UnexpectedValueException.

No original licence, author credit, acknowledgement, or bundled getID3 file has been removed or replaced.
