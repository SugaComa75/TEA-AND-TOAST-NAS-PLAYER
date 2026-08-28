<?php
declare(strict_types=1);

require_once __DIR__ . '/src/core.php';

$configFile = __DIR__ . '/config/local.php';
$installed = is_file($configFile);
$error = '';
$success = false;
$defaults = [
    'data_root' => dirname((string) ($_SERVER['DOCUMENT_ROOT'] ?? __DIR__)) . DIRECTORY_SEPARATOR . 'data',
    'library_name' => 'Music',
    'library_root' => '',
    'display_name' => '',
    'email' => '',
    'accent_colour' => '#8b5cf6',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$installed) {
    foreach ($defaults as $key => $value) {
        $defaults[$key] = trim((string) ($_POST[$key] ?? $value));
    }
    try {
        if (PHP_VERSION_ID < 80100) {
            throw new RuntimeException('PHP 8.1 or newer is required.');
        }
        foreach (['pdo_sqlite', 'fileinfo'] as $extension) {
            if (!extension_loaded($extension)) {
                throw new RuntimeException("The {$extension} PHP extension is required.");
            }
        }
        $documentRoot = realpath((string) ($_SERVER['DOCUMENT_ROOT'] ?? __DIR__)) ?: __DIR__;
        $dataRoot = $defaults['data_root'];
        if (!str_starts_with($dataRoot, '/') && !preg_match('/^[A-Za-z]:[\\\\\/]/', $dataRoot)) {
            throw new RuntimeException('The private data folder must be an absolute server path.');
        }
        if (!is_dir($dataRoot) && !mkdir($dataRoot, 0770, true) && !is_dir($dataRoot)) {
            throw new RuntimeException('The private data folder could not be created.');
        }
        $dataReal = realpath($dataRoot);
        if ($dataReal === false || !is_writable($dataReal)) {
            throw new RuntimeException('The private data folder is not writable by PHP.');
        }
        if (tt_path_is_inside($dataReal, $documentRoot)) {
            throw new RuntimeException('The private data folder must be outside public_html/document root.');
        }
        $libraryReal = realpath($defaults['library_root']);
        if ($libraryReal === false || !is_dir($libraryReal) || !is_readable($libraryReal)) {
            throw new RuntimeException('The NAS music folder does not exist or PHP cannot read it.');
        }
        if ($defaults['library_name'] === '' || $defaults['display_name'] === '') {
            throw new RuntimeException('Enter the library name and administrator display name.');
        }
        $email = filter_var($defaults['email'], FILTER_VALIDATE_EMAIL);
        $password = (string) ($_POST['password'] ?? '');
        if (!$email || strlen($password) < 10) {
            throw new RuntimeException('Enter a valid email address and a password of at least 10 characters.');
        }
        if (!preg_match('/^#[0-9a-f]{6}$/i', $defaults['accent_colour'])) {
            throw new RuntimeException('The accent must be a six-digit hex colour.');
        }

        $db = tt_open_database($dataReal);
        $db->beginTransaction();
        $stmt = $db->prepare("INSERT INTO users (display_name, email, password_hash, role) VALUES (?, ?, ?, 'super_admin')");
        $stmt->execute([$defaults['display_name'], $email, password_hash($password, PASSWORD_DEFAULT)]);
        $stmt = $db->prepare('INSERT INTO libraries (name, root_path) VALUES (?, ?)');
        $stmt->execute([$defaults['library_name'], $libraryReal]);
        tt_set_setting($db, 'accent_colour', strtolower($defaults['accent_colour']));
        $db->commit();

        $config = "<?php\ndeclare(strict_types=1);\n\nreturn " . var_export(['data_root' => $dataReal], true) . ";\n";
        $temporary = $configFile . '.tmp-' . bin2hex(random_bytes(4));
        if (file_put_contents($temporary, $config, LOCK_EX) === false || !rename($temporary, $configFile)) {
            throw new RuntimeException('The installer could not write config/local.php. Check folder permissions.');
        }
        $success = true;
        $installed = true;
    } catch (Throwable $exception) {
        if (isset($db) && $db instanceof PDO && $db->inTransaction()) {
            $db->rollBack();
        }
        $error = $exception->getMessage();
    }
}

$requirements = [
    'PHP 8.1+' => PHP_VERSION_ID >= 80100,
    'PDO SQLite' => extension_loaded('pdo_sqlite'),
    'Fileinfo' => extension_loaded('fileinfo'),
];
?><!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Install Tea &amp; Toast NAS Player</title><link rel="stylesheet" href="assets/app.css"></head>
<body class="installer"><main class="install-shell">
<p class="eyebrow">TEA &amp; TOAST SOFTWARE</p><h1>Install NAS Player</h1>
<p class="muted">Connect music anywhere the NAS lets PHP read it. Only accounts and preferences use the private database; tracks remain in their original folders.</p>
<section class="card requirements"><h2>Server requirements</h2><?php foreach ($requirements as $label => $ok): ?><span class="pill <?= $ok ? 'ok' : 'bad' ?>"><?= $ok ? '✓' : '×' ?> <?= tt_h($label) ?></span><?php endforeach; ?></section>
<?php if ($error): ?><div class="alert error"><?= tt_h($error) ?></div><?php endif; ?>
<?php if ($success): ?><section class="card success"><h2>Installation complete</h2><p>Your account and first library are ready. Delete or rename <code>install.php</code> after confirming the player opens.</p><a class="button" href="./">Open the player</a></section>
<?php elseif ($installed): ?><section class="card"><h2>Already installed</h2><p>The local configuration exists, so this installer is locked.</p><a class="button" href="./">Return to the player</a></section>
<?php else: ?><form method="post">
<section class="card"><h2>1. Storage</h2><label>Private data folder<input name="data_root" required value="<?= tt_h($defaults['data_root']) ?>"></label><small>Absolute, writable, and outside public_html. This holds one small account/settings database.</small><label>First library name<input name="library_name" required value="<?= tt_h($defaults['library_name']) ?>"></label><label>NAS music folder<input name="library_root" required placeholder="/volume1/Music or /share/Multimedia" value="<?= tt_h($defaults['library_root']) ?>"></label><small>No tracks are copied and no catalogue is built.</small></section>
<section class="card"><h2>2. Super Administrator</h2><label>Display name<input name="display_name" required value="<?= tt_h($defaults['display_name']) ?>"></label><label>Email<input type="email" name="email" required value="<?= tt_h($defaults['email']) ?>"></label><label>Password<input type="password" name="password" required minlength="10" autocomplete="new-password"></label></section>
<section class="card"><h2>3. Appearance</h2><label>Accent colour<input name="accent_colour" type="color" value="<?= tt_h($defaults['accent_colour']) ?>"></label></section>
<button class="button primary" type="submit">Install player</button></form><?php endif; ?>
</main></body></html>
