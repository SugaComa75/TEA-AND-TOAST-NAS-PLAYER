<?php
declare(strict_types=1);

require_once __DIR__ . '/updater.php';

$error = '';
$notice = '';
$updatePlan = null;
$updateResult = null;
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        tt_require_csrf();
        $action = (string) ($_POST['action'] ?? '');
        if ($action === 'add_library') {
            $name = trim((string) ($_POST['name'] ?? ''));
            $root = trim((string) ($_POST['root_path'] ?? ''));
            $real = realpath($root);
            if ($name === '' || $real === false || !is_dir($real) || !is_readable($real)) {
                throw new RuntimeException('Enter a library name and an absolute folder path PHP can read.');
            }
            $stmt = $db->prepare('INSERT INTO libraries (name, root_path) VALUES (?, ?)');
            $stmt->execute([$name, $real]);
            $notice = 'Library added.';
        } elseif ($action === 'toggle_library') {
            $stmt = $db->prepare('UPDATE libraries SET enabled = CASE enabled WHEN 1 THEN 0 ELSE 1 END WHERE id = ?');
            $stmt->execute([(int) ($_POST['id'] ?? 0)]);
            $notice = 'Library status changed.';
        } elseif ($action === 'create_user') {
            $name = trim((string) ($_POST['display_name'] ?? ''));
            $email = filter_var(trim((string) ($_POST['email'] ?? '')), FILTER_VALIDATE_EMAIL);
            $password = (string) ($_POST['password'] ?? '');
            $role = in_array($_POST['role'] ?? '', ['user', 'admin'], true) ? (string) $_POST['role'] : 'user';
            if ($name === '' || !$email || strlen($password) < 8) {
                throw new RuntimeException('The user needs a name, valid email, and password of at least 8 characters.');
            }
            $stmt = $db->prepare('INSERT INTO users (display_name, email, password_hash, role) VALUES (?, ?, ?, ?)');
            $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $role]);
            $notice = 'User created.';
        } elseif ($action === 'toggle_user') {
            $id = (int) ($_POST['id'] ?? 0);
            if ($id === (int) $currentUser['id']) {
                throw new RuntimeException('You cannot disable your own account.');
            }
            $stmt = $db->prepare("UPDATE users SET active = CASE active WHEN 1 THEN 0 ELSE 1 END WHERE id = ? AND role != 'super_admin'");
            $stmt->execute([$id]);
            $notice = 'User status changed.';
        } elseif ($action === 'settings') {
            $siteName = trim((string) ($_POST['site_name'] ?? ''));
            $accent = trim((string) ($_POST['accent_colour'] ?? ''));
            if ($siteName === '' || !preg_match('/^#[0-9a-f]{6}$/i', $accent)) {
                throw new RuntimeException('Enter a site name and a six-digit hex colour such as #8b5cf6.');
            }
            tt_set_setting($db, 'site_name', $siteName);
            tt_set_setting($db, 'accent_colour', strtolower($accent));
            tt_set_setting($db, 'registration_enabled', isset($_POST['registration_enabled']) ? '1' : '0');
            $notice = 'Settings saved.';
        } elseif ($action === 'update_settings') {
            if (($currentUser['role'] ?? '') !== 'super_admin') {
                throw new RuntimeException('Only the Super Administrator can configure application updates.');
            }
            $repository = tt_update_validate_repository((string) ($_POST['update_repository'] ?? ''));
            tt_set_setting($db, 'update_repository', $repository);
            $notice = 'Update repository saved.';
        } elseif ($action === 'check_update') {
            if (($currentUser['role'] ?? '') !== 'super_admin') {
                throw new RuntimeException('Only the Super Administrator can check application updates.');
            }
            $releaseInfo = tt_update_release_config(dirname(__DIR__));
            $repository = tt_setting($db, 'update_repository', (string) $releaseInfo['repository']);
            $updatePlan = tt_update_build_plan(dirname(__DIR__), (string) $config['data_root'], $repository);
        } elseif ($action === 'install_update') {
            if (($currentUser['role'] ?? '') !== 'super_admin') {
                throw new RuntimeException('Only the Super Administrator can install application updates.');
            }
            $releaseInfo = tt_update_release_config(dirname(__DIR__));
            $repository = tt_setting($db, 'update_repository', (string) $releaseInfo['repository']);
            $updateResult = tt_update_apply(dirname(__DIR__), (string) $config['data_root'], $repository);
            $notice = "Updated {$updateResult['updated']} safe file(s) to version {$updateResult['version']}."
                . ($updateResult['protected'] ? " {$updateResult['protected']} locally modified file(s) were protected." : '');
        }
    }
} catch (Throwable $exception) {
    $error = $exception instanceof PDOException && str_contains(strtolower($exception->getMessage()), 'unique')
        ? 'That email address or library path already exists.'
        : $exception->getMessage();
}

$libraries = $db->query('SELECT * FROM libraries ORDER BY name COLLATE NOCASE')->fetchAll();
$users = $db->query('SELECT id, display_name, email, role, active, created_at FROM users ORDER BY display_name COLLATE NOCASE')->fetchAll();
$siteName = tt_setting($db, 'site_name', 'Tea & Toast NAS Player');
$accent = tt_setting($db, 'accent_colour', '#8b5cf6');
$registrationEnabled = tt_setting($db, 'registration_enabled', '0') === '1';
$releaseInfo = tt_update_release_config(dirname(__DIR__));
$updateRepository = tt_setting($db, 'update_repository', (string) $releaseInfo['repository']);
$updateState = null;
$updateStateError = '';
try {
    $updateState = tt_update_load_state(dirname(__DIR__), (string) $config['data_root']);
} catch (Throwable $exception) {
    $updateStateError = $exception->getMessage();
}
require __DIR__ . '/../views/admin.php';
