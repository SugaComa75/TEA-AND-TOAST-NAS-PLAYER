# Installation and NAS configuration

PHP Music can be installed in any directory beneath public_html while its media library and writable application data remain outside the web root.

## Recommended first-time installation

1. Extract the application into the chosen public directory, for example /home/site/public_html/music.
2. Ensure the PHP account can write to the application's config directory for the duration of setup.
3. Browse to /music/install.php.
4. Enter:
   - an absolute NAS/media root that already exists and is readable by PHP;
   - a separate, writable data root outside public_html;
   - an optional writable uploads subdirectory;
   - the first Super Administrator name, email, and password.
5. Complete the installer, open PHP Music, and then **delete install.php from the server**.
6. Open ?access=admin and run **Full Scan**.

The installer writes site-specific settings to config/local.php, creates music.db beneath the private data root, and creates exactly one super_admin. It refuses to overwrite an existing user database.

## Storage layout

A typical installation uses three separate locations:

- /home/site/public_html/music/ — web application
- /mnt/nas/Music/ — MEDIA_ROOT, outside the web root
- /home/site/private/php-music-data/ — DATA_ROOT, outside the web root

The media root may contain any number of artist, album, or library folders. The application stores portable media:// references in SQLite and streams files through validated PHP endpoints; do not expose the NAS directory with an Apache alias or Nginx alias.

Use the path visible to PHP on the web server. A Windows drive letter used by a client PC is not a valid Linux/NAS server path unless PHP itself runs on that Windows host.

The installer resolves share aliases to their canonical server path. On ASUSTOR, entering an alias such as `/share/Music` may therefore be saved and displayed as `/volume1/Music`; both names can refer to the same shared folder. Full Scan ignores protected NAS service directories such as `#Recycle` and `@eaDir` and continues through the readable library.

## Platform examples

| Platform | Typical media root | Typical data root |
| --- | --- | --- |
| ASUSTOR | /volume1/Music | /volume1/Web-private/php-music |
| Synology | /volume1/Media | /volume1/docker/php-music/data |
| QNAP | /share/Multimedia | /share/Container/php-music/data |
| TrueNAS | /mnt/tank/Media | /mnt/tank/apps/php-music/data |
| Linux | /srv/media | /var/lib/php-music |

## Permissions

- Grant read and directory-traverse permission on MEDIA_ROOT.
- Prefer a read-only media library.
- If browser uploads or tag editing are required, grant write permission only where needed, ideally MEDIA_ROOT/uploads.
- Grant read/write permission on DATA_ROOT.
- After setup, config/local.php only needs to be readable by PHP; mode 0640 is recommended.

## Manual and container configuration

For automation, edit config/config.php or provide these environment variables:

- PHP_MUSIC_MEDIA_ROOT
- PHP_MUSIC_DATA_ROOT
- PHP_MUSIC_UPLOADS_DIRECTORY

Environment variables take precedence over both config/config.php and installer-generated config/local.php.

The configuration array accepts MEDIA_ROOT, DATA_ROOT, UPLOADS_DIRECTORY, AUDIO_EXTENSIONS, VIDEO_EXTENSIONS, and INDEX_VIDEO.

## Apache

Enable PHP 7.4 or newer with PDO SQLite, mbstring, fileinfo, and GD. PHP Music does not create an application-root .htaccess file: NAS packages and shared hosts allow different directives, and an incompatible file can turn every request into an Apache 500 response. Apply any rewrite or access rules in the hosting control panel or virtual-host configuration. Directory-relative links let the app run below any URL prefix.

### Apache 500 immediately after the first application load

Early modular-installer builds generated an application-root .htaccess file at runtime. On an Apache host that disallows one of its directives, the first HTML response can appear without CSS and every refresh then returns Error 500.

Remove only the .htaccess file inside the PHP Music application directory, replace backend.php with the current build, and reload the application. Do not remove a parent-site .htaccess file. Re-running install.php does not repair this Apache-level error because Apache rejects the request before PHP starts.

## Nginx

Point the site root at the application directory; never map MEDIA_ROOT into the site. Deny direct access to config, data, views, and backend.php. Adapt the PHP-FPM location and the /music URL prefix to the server's configuration.
