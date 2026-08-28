# Registration and administrator accounts

## First installation

The recommended install.php flow creates the first account as:

- status = super_admin
- is_admin = 1
- verified = yes

The password is stored only as a PHP password_hash() value in the private SQLite database. The installer requires at least 12 characters and never writes the password to a configuration file.

If the installer is not used but the storage paths are configured manually, the existing fallback setup screen still makes the first successful registration the Super Administrator.

## Later registrations

Subsequent registrations:

- create ordinary user accounts;
- hash passwords with PASSWORD_DEFAULT;
- log the new user in immediately;
- leave upload verification set to no;
- do not grant administrator access.

A registered user can browse and use public features, but uploading remains blocked until an administrator verifies the account.

## Administrator access

Open ?access=admin and sign in with an account whose status is super_admin or admin, or whose is_admin flag is enabled.

Only the Super Administrator can promote or revoke administrators and change their module permissions. This prevents a limited administrator from escalating another account. Admin persistence cookies use HttpOnly, SameSite=Lax, and Secure when the request is HTTPS.

The Super Administrator can:

1. verify or suspend ordinary users;
2. promote a user to administrator;
3. choose the admin modules that promoted user may access;
4. revoke administrator status later.

The Super Administrator account itself cannot be demoted through the normal toggle.

## Recovery

Back up DATA_ROOT/music.db before account recovery or migration. If the original Super Administrator password is lost, use the application's reset-link workflow from another authorized administrator where available, or restore a known-good database backup. Never rerun the installer against an existing user database; it deliberately refuses to overwrite users.

