<?php
declare(strict_types=1);

session_set_cookie_params([
  'lifetime' => 0,
  'path' => '/',
  'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
  'httponly' => true,
  'samesite' => 'Lax',
]);
session_start();

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: no-referrer');
$nonce = base64_encode(random_bytes(18));
header("Content-Security-Policy: default-src 'none'; style-src 'unsafe-inline'; script-src 'nonce-" . $nonce . "'; img-src data:; form-action 'self'; base-uri 'none'; frame-ancestors 'none'");

$localConfigFile = __DIR__ . '/config/local.php';
$alreadyConfigured = is_file($localConfigFile);
$errors = [];
$success = false;
$installedValues = [];

function installer_h($value)
{
  return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function installer_absolute_path($value, $label)
{
  $value = rtrim(str_replace('\\', '/', trim((string)$value)), '/');
  if ($value === '' || strpos($value, "\0") !== false) {
    throw new InvalidArgumentException($label . ' is required.');
  }
  if (!(substr($value, 0, 1) === '/' || preg_match('/^[A-Za-z]:\//', $value))) {
    throw new InvalidArgumentException($label . ' must be an absolute server path.');
  }
  if ($value === '/' || preg_match('/^[A-Za-z]:$/', $value)) {
    throw new InvalidArgumentException($label . ' cannot be a filesystem root.');
  }
  return $value;
}

function installer_relative_directory($value)
{
  $value = trim(str_replace('\\', '/', (string)$value), '/');
  if ($value === '' || strpos($value, "\0") !== false || preg_match('/(^|\/)\.\.?($|\/)/', $value) || preg_match('/^[A-Za-z]:/', $value)) {
    throw new InvalidArgumentException('Uploads directory must be a safe relative directory name.');
  }
  return $value;
}

function installer_path_within($path, $root)
{
  $path = rtrim(str_replace('\\', '/', (string)$path), '/');
  $root = rtrim(str_replace('\\', '/', (string)$root), '/');
  if (DIRECTORY_SEPARATOR === '\\') {
    $path = strtolower($path);
    $root = strtolower($root);
  }
  return $path === $root || strpos($path . '/', $root . '/') === 0;
}

$requirements = [
  'PHP 7.4+' => version_compare(PHP_VERSION, '7.4.0', '>='),
  'PDO SQLite' => class_exists('PDO') && in_array('sqlite', PDO::getAvailableDrivers(), true),
  'mbstring' => extension_loaded('mbstring'),
  'fileinfo' => extension_loaded('fileinfo'),
  'GD image library' => extension_loaded('gd'),
];
$requirementsMet = !in_array(false, $requirements, true);

if (empty($_SESSION['installer_csrf'])) {
  $_SESSION['installer_csrf'] = bin2hex(random_bytes(32));
}

$defaultDataRoot = rtrim(str_replace('\\', '/', dirname(__DIR__, 2)), '/') . '/data/php-music';
$form = [
  'media_root' => $_POST['media_root'] ?? '',
  'data_root' => $_POST['data_root'] ?? $defaultDataRoot,
  'uploads_directory' => $_POST['uploads_directory'] ?? 'uploads',
  'admin_name' => $_POST['admin_name'] ?? '',
  'admin_email' => $_POST['admin_email'] ?? '',
  'enable_uploads' => isset($_POST['enable_uploads']),
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$alreadyConfigured) {
  if (!$requirementsMet) {
    $errors[] = 'Install the missing PHP requirements before continuing.';
  }
  if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['installer_csrf'], (string)$_POST['csrf_token'])) {
    $errors[] = 'The installer session expired. Reload this page and try again.';
  }

  try {
    $mediaRoot = installer_absolute_path($form['media_root'], 'Media root');
    $dataRoot = installer_absolute_path($form['data_root'], 'Data root');
    $uploadsDirectory = installer_relative_directory($form['uploads_directory']);
  } catch (InvalidArgumentException $exception) {
    $errors[] = $exception->getMessage();
  }

  $adminName = trim((string)$form['admin_name']);
  $adminEmail = filter_var($form['admin_email'], FILTER_VALIDATE_EMAIL);
  $password = (string)($_POST['admin_password'] ?? '');
  $passwordConfirm = (string)($_POST['admin_password_confirm'] ?? '');

  if (mb_strlen($adminName, 'UTF-8') < 2 || mb_strlen($adminName, 'UTF-8') > 80) {
    $errors[] = 'Administrator display name must contain 2 to 80 characters.';
  }
  if (!$adminEmail) {
    $errors[] = 'Enter a valid administrator email address.';
  }
  if (strlen($password) < 12) {
    $errors[] = 'Administrator password must contain at least 12 characters.';
  }
  if (!hash_equals($password, $passwordConfirm)) {
    $errors[] = 'Administrator passwords do not match.';
  }

  if (!$errors) {
    if (!is_dir($mediaRoot) || !is_readable($mediaRoot)) {
      $errors[] = 'Media root must already exist and be readable by PHP.';
    }
    if (!is_dir($dataRoot) && !@mkdir($dataRoot, 0750, true) && !is_dir($dataRoot)) {
      $errors[] = 'Data root could not be created.';
    }
  }

  if (!$errors) {
    $realMedia = realpath($mediaRoot);
    $realData = realpath($dataRoot);
    $realApp = realpath(__DIR__);
    if ($realMedia === false || $realData === false || $realApp === false) {
      $errors[] = 'One or more paths could not be resolved by PHP.';
    } elseif (!is_writable($realData)) {
      $errors[] = 'Data root is not writable by PHP.';
    } elseif (installer_path_within($realMedia, $realApp) || installer_path_within($realData, $realApp)) {
      $errors[] = 'Media and data roots must be outside the application web directory.';
    } elseif (installer_path_within($realData, $realMedia) || installer_path_within($realMedia, $realData)) {
      $errors[] = 'Media and data roots must be separate, non-nested directories.';
    }
  }

  if (!$errors && $form['enable_uploads']) {
    $uploadRoot = $realMedia . '/' . $uploadsDirectory;
    if (!is_dir($uploadRoot) && !@mkdir($uploadRoot, 0750, true) && !is_dir($uploadRoot)) {
      $errors[] = 'Uploads directory could not be created beneath the media root.';
    } elseif (!is_writable($uploadRoot)) {
      $errors[] = 'Uploads are enabled, but the uploads directory is not writable by PHP.';
    }
  }

  if (!$errors) {
    $config = [
      'MEDIA_ROOT' => str_replace('\\', '/', $realMedia),
      'DATA_ROOT' => str_replace('\\', '/', $realData),
      'UPLOADS_DIRECTORY' => $uploadsDirectory,
      'AUDIO_EXTENSIONS' => ['mp3', 'm4a', 'flac', 'ogg', 'wav', 'aac', 'opus', 'wma', 'm4r'],
      'VIDEO_EXTENSIONS' => ['mp4', 'webm', 'm4v', 'mov', 'ogv', 'mkv'],
      'INDEX_VIDEO' => false,
    ];
    $configText = "<?php\n/** Generated by install.php. Keep this file private. */\nreturn " . var_export($config, true) . ";\n";
    $temporaryConfig = $localConfigFile . '.tmp-' . bin2hex(random_bytes(4));
    $databaseFile = $realData . '/music.db';

    try {
      if (!is_dir(dirname($localConfigFile)) || !is_writable(dirname($localConfigFile))) {
        throw new RuntimeException('The config directory is not writable by PHP.');
      }
      if (file_put_contents($temporaryConfig, $configText, LOCK_EX) === false) {
        throw new RuntimeException('The generated configuration could not be written.');
      }

      $db = new PDO('sqlite:' . $databaseFile, null, null, [PDO::ATTR_TIMEOUT => 15]);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $db->exec('PRAGMA journal_mode=WAL; PRAGMA synchronous=NORMAL; PRAGMA foreign_keys=ON; PRAGMA busy_timeout=5000;');
      $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY,
        email TEXT UNIQUE,
        artist TEXT COLLATE NOCASE,
        password_hash TEXT,
        last_upload_date TEXT,
        daily_upload_count INTEGER DEFAULT 0,
        verified TEXT DEFAULT 'no',
        profile_picture BLOB,
        profile_picture_type TEXT,
        backup_key TEXT,
        banned INTEGER DEFAULT 0,
        settings TEXT,
        is_admin INTEGER DEFAULT 0,
        reset_requested INTEGER DEFAULT 0,
        rhythm_strikes INTEGER DEFAULT 0,
        status TEXT DEFAULT 'user',
        bio TEXT,
        profile_background BLOB,
        profile_background_type TEXT
      )");
      $db->exec('CREATE UNIQUE INDEX IF NOT EXISTS users_artist_idx ON users(artist)');

      if ((int)$db->query('SELECT COUNT(id) FROM users')->fetchColumn() !== 0) {
        throw new RuntimeException('The selected data root already contains registered users. Refusing to replace its administrator.');
      }

      $initial = mb_strtoupper(mb_substr($adminName, 0, 1, 'UTF-8'), 'UTF-8');
      $safeInitial = htmlspecialchars($initial, ENT_QUOTES | ENT_XML1, 'UTF-8');
      $avatar = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><rect width="200" height="200" fill="#ff0000"/><text x="50%" y="50%" dominant-baseline="central" text-anchor="middle" font-family="Arial,sans-serif" font-size="100" font-weight="bold" fill="#fff">' . $safeInitial . '</text></svg>';

      $db->beginTransaction();
      $statement = $db->prepare("INSERT INTO users (email, artist, password_hash, verified, is_admin, status, profile_picture, profile_picture_type) VALUES (?, ?, ?, 'yes', 1, 'super_admin', ?, 'image/svg+xml')");
      $statement->execute([$adminEmail, $adminName, password_hash($password, PASSWORD_DEFAULT), $avatar]);
      $db->commit();

      if (!@rename($temporaryConfig, $localConfigFile)) {
        throw new RuntimeException('The configuration could not be finalized atomically.');
      }
      @chmod($localConfigFile, 0640);
      @file_put_contents($realData . '/install.lock', json_encode([
        'installed_at' => gmdate('c'),
        'app_version' => '9.6',
      ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX);

      unset($_SESSION['installer_csrf']);
      $success = true;
      $alreadyConfigured = true;
      $installedValues = [
        'media_root' => $config['MEDIA_ROOT'],
        'data_root' => $config['DATA_ROOT'],
        'admin_email' => $adminEmail,
      ];
    } catch (Throwable $exception) {
      if (isset($db) && $db instanceof PDO && $db->inTransaction()) {
        $db->rollBack();
      }
      if (isset($temporaryConfig) && is_file($temporaryConfig)) {
        @unlink($temporaryConfig);
      }
      $errors[] = $exception->getMessage();
    }
  }
}

$scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/install.php');
$installDirectory = rtrim(dirname($scriptPath), '/.');
$installDirectory = $installDirectory === '' ? '/' : $installDirectory;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex,nofollow,noarchive">
  <title>Install PHP Music</title>
  <style>
    :root { color-scheme: dark; --bg:#080808; --panel:#141414; --line:#303030; --text:#f5f5f5; --muted:#a5a5a5; --accent:#ef3434; --good:#30c76f; --bad:#ff6666; }
    * { box-sizing: border-box; }
    body { margin:0; min-height:100vh; background:radial-gradient(circle at top,#231010 0,#080808 38rem); color:var(--text); font:16px/1.5 system-ui,-apple-system,"Segoe UI",sans-serif; }
    main { width:min(920px,calc(100% - 2rem)); margin:0 auto; padding:3rem 0 5rem; }
    h1,h2 { line-height:1.15; }
    h1 { margin:.35rem 0 .75rem; font-size:clamp(2rem,5vw,3.5rem); }
    h2 { margin:0 0 1rem; font-size:1.2rem; }
    p { color:var(--muted); }
    .eyebrow { color:#ff7777; font-weight:800; letter-spacing:.12em; text-transform:uppercase; font-size:.78rem; }
    .card { background:color-mix(in srgb,var(--panel) 94%,transparent); border:1px solid var(--line); border-radius:18px; padding:1.4rem; margin-top:1rem; box-shadow:0 20px 60px rgba(0,0,0,.28); }
    .grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:1rem; }
    .full { grid-column:1 / -1; }
    label { display:block; font-weight:750; margin-bottom:.4rem; }
    small,.hint { display:block; color:var(--muted); margin-top:.35rem; }
    input[type=text],input[type=email],input[type=password] { width:100%; border:1px solid #444; background:#090909; color:#fff; border-radius:10px; padding:.8rem .9rem; font:inherit; }
    input:focus { outline:2px solid color-mix(in srgb,var(--accent) 65%,transparent); border-color:var(--accent); }
    .check { display:flex; gap:.7rem; align-items:flex-start; padding:.8rem; border:1px solid var(--line); border-radius:10px; }
    .check input { margin-top:.3rem; }
    .requirements { display:flex; flex-wrap:wrap; gap:.55rem; }
    .badge { border:1px solid var(--line); border-radius:999px; padding:.38rem .65rem; font-size:.85rem; }
    .ok { color:#b8ffd1; border-color:#256e42; background:#102a1a; }
    .fail { color:#ffd0d0; border-color:#803636; background:#321515; }
    .alert { border-radius:12px; padding:1rem; margin:1rem 0; }
    .alert.error { background:#351616; border:1px solid #8a3d3d; color:#ffd5d5; }
    .alert.success { background:#102b1a; border:1px solid #2f7648; color:#d6ffe2; }
    .alert.warning { background:#33270d; border:1px solid #80641e; color:#ffe9aa; }
    ul { margin:.5rem 0; padding-left:1.25rem; }
    button,.button { display:inline-flex; align-items:center; justify-content:center; min-height:48px; border:0; border-radius:999px; padding:.75rem 1.25rem; background:var(--accent); color:#fff; font-weight:850; font:inherit; text-decoration:none; cursor:pointer; }
    code { color:#ffaaaa; overflow-wrap:anywhere; }
    .summary { display:grid; gap:.6rem; }
    .summary div { border-bottom:1px solid var(--line); padding-bottom:.6rem; }
    footer { margin-top:2rem; color:var(--muted); font-size:.9rem; }
    @media (max-width:700px) { .grid { grid-template-columns:1fr; } .full { grid-column:auto; } main { padding-top:1.5rem; } }
  </style>
</head>
<body>
<main>
  <div class="eyebrow">Tea &amp; Toast Software</div>
  <h1>Install PHP Music</h1>
  <p>Configure this copy at <code><?php echo installer_h($installDirectory); ?></code>, connect a media library outside the web root, and create the first Super Administrator.</p>

  <section class="card">
    <h2>Server requirements</h2>
    <div class="requirements">
      <?php foreach ($requirements as $label => $available): ?>
        <span class="badge <?php echo $available ? 'ok' : 'fail'; ?>"><?php echo $available ? '✓' : '✕'; ?> <?php echo installer_h($label); ?></span>
      <?php endforeach; ?>
    </div>
  </section>

  <?php if ($errors): ?>
    <div class="alert error"><strong>Installation was not completed.</strong><ul><?php foreach ($errors as $error): ?><li><?php echo installer_h($error); ?></li><?php endforeach; ?></ul></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="alert success"><strong>Installation complete.</strong> PHP Music is configured and the Super Administrator account has been created.</div>
    <section class="card">
      <h2>Installed configuration</h2>
      <div class="summary">
        <div><strong>Media root:</strong> <code><?php echo installer_h($installedValues['media_root']); ?></code></div>
        <div><strong>Data root:</strong> <code><?php echo installer_h($installedValues['data_root']); ?></code></div>
        <div><strong>Administrator:</strong> <code><?php echo installer_h($installedValues['admin_email']); ?></code></div>
      </div>
      <div class="alert warning"><strong>Required final step:</strong> delete <code>install.php</code> from the server. The installer is locked, but removing it eliminates unnecessary attack surface.</div>
      <a class="button" href="./">Open PHP Music</a>
    </section>
  <?php elseif ($alreadyConfigured): ?>
    <div class="alert warning"><strong>Installation is locked.</strong> <code>config/local.php</code> already exists. Delete <code>install.php</code> from the server, then use the application or its admin panel.</div>
    <a class="button" href="./">Open PHP Music</a>
  <?php else: ?>
    <?php if (isset($_GET['reason'])): ?><div class="alert warning">The application configuration is incomplete. Complete this form to continue.</div><?php endif; ?>
    <form method="post" action="install.php" autocomplete="off">
      <input type="hidden" name="csrf_token" value="<?php echo installer_h($_SESSION['installer_csrf']); ?>">

      <section class="card">
        <h2>1. Storage paths</h2>
        <div class="grid">
          <div class="full">
            <label for="media_root">NAS media root</label>
            <input id="media_root" name="media_root" type="text" required value="<?php echo installer_h($form['media_root']); ?>" placeholder="/volume1/Music or /share/Multimedia">
            <small>Absolute path visible to PHP. It must exist, be readable, and remain outside <code>public_html</code>. Put multiple artist/library folders beneath this root. NAS share aliases are saved as their resolved server path—for example, <code>/share/Music</code> may be reported as <code>/volume1/Music</code>.</small>
          </div>
          <div class="full">
            <label for="data_root">Private data root</label>
            <input id="data_root" name="data_root" type="text" required value="<?php echo installer_h($form['data_root']); ?>">
            <small>Writable absolute path for SQLite and application state. It must be separate from the media library and outside the web directory.</small>
          </div>
          <div>
            <label for="uploads_directory">Uploads subdirectory</label>
            <input id="uploads_directory" name="uploads_directory" type="text" required value="<?php echo installer_h($form['uploads_directory']); ?>">
            <small>Relative to the media root.</small>
          </div>
          <label class="check">
            <input name="enable_uploads" type="checkbox" value="1" <?php echo $form['enable_uploads'] ? 'checked' : ''; ?>>
            <span><strong>Enable browser uploads</strong><small>Creates/checks a writable uploads subtree. Leave off for a read-only NAS library.</small></span>
          </label>
        </div>
      </section>

      <section class="card">
        <h2>2. Super Administrator</h2>
        <div class="grid">
          <div>
            <label for="admin_name">Display name</label>
            <input id="admin_name" name="admin_name" type="text" required maxlength="80" value="<?php echo installer_h($form['admin_name']); ?>" autocomplete="name">
          </div>
          <div>
            <label for="admin_email">Email</label>
            <input id="admin_email" name="admin_email" type="email" required value="<?php echo installer_h($form['admin_email']); ?>" autocomplete="username">
          </div>
          <div>
            <label for="admin_password">Password</label>
            <input id="admin_password" name="admin_password" type="password" required minlength="12" autocomplete="new-password">
            <small>At least 12 characters.</small>
          </div>
          <div>
            <label for="admin_password_confirm">Confirm password</label>
            <input id="admin_password_confirm" name="admin_password_confirm" type="password" required minlength="12" autocomplete="new-password">
          </div>
        </div>
      </section>

      <section class="card">
        <h2>3. Create configuration</h2>
        <p>This writes <code>config/local.php</code>, initializes <code>music.db</code> in the private data root, and creates exactly one <code>super_admin</code>. Existing users are never overwritten.</p>
        <button type="submit" <?php echo $requirementsMet ? '' : 'disabled'; ?>>Install PHP Music</button>
      </section>
    </form>
  <?php endif; ?>

  <footer>After installation, ordinary registrations create unverified user accounts. The Super Administrator can verify users and grant limited administrator access from <code>?access=admin</code>.</footer>
</main>
<script nonce="<?php echo installer_h($nonce); ?>">
  document.querySelectorAll('input[type="password"]').forEach(function (input) {
    input.addEventListener('paste', function () { input.dataset.pasted = 'true'; });
  });
</script>
</body>
</html>
