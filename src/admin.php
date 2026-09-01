<?php
declare(strict_types=1);

require_once __DIR__ . '/updater.php';
$error = ''; $notice = ''; $updatePlan = null; $updateResult = null; $returnFocus = '';
$focusableSections = ['admin-libraries', 'admin-users', 'admin-create-user', 'admin-player-settings', 'admin-updates'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array((string) ($_POST['return_focus'] ?? ''), $focusableSections, true)) $returnFocus = (string) $_POST['return_focus'];
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        tt_require_csrf(); $action = (string) ($_POST['action'] ?? '');
        if ($action === 'add_library') {
            $name = trim((string) ($_POST['name'] ?? '')); $root = trim((string) ($_POST['root_path'] ?? '')); $real = realpath($root);
            if ($name === '' || $real === false || !is_dir($real) || !is_readable($real)) throw new RuntimeException('Enter a library name and an absolute folder path PHP can read.');
            $sortOrder = (int) $db->query('SELECT COALESCE(MAX(sort_order), -1) + 1 FROM libraries')->fetchColumn();
            $stmt = $db->prepare('INSERT INTO libraries (name, root_path, sort_order) VALUES (?, ?, ?)'); $stmt->execute([$name, $real, $sortOrder]); $notice = 'Library added.';
        } elseif ($action === 'edit_library') {
            $id = (int) ($_POST['id'] ?? 0); $name = trim((string) ($_POST['name'] ?? '')); $root = trim((string) ($_POST['root_path'] ?? '')); $real = realpath($root);
            if ($id < 1 || $name === '' || $real === false || !is_dir($real) || !is_readable($real)) throw new RuntimeException('Enter a library name and an absolute folder path PHP can read.');
            $stmt = $db->prepare('UPDATE libraries SET name = ?, root_path = ? WHERE id = ?'); $stmt->execute([$name, $real, $id]); $notice = 'Library updated.';
        } elseif ($action === 'delete_library') {
            $id = (int) ($_POST['id'] ?? 0); if ($id < 1) throw new RuntimeException('Library not found.');
            $stmt = $db->prepare('DELETE FROM libraries WHERE id = ?'); $stmt->execute([$id]); $notice = 'Library deleted.';
        } elseif ($action === 'reorder_libraries') {
            $ids = array_values(array_filter(array_map('intval', (array) ($_POST['library_ids'] ?? [])), static fn(int $id): bool => $id > 0));
            $known = array_map('intval', $db->query('SELECT id FROM libraries')->fetchAll(PDO::FETCH_COLUMN)); $check = $ids; sort($known); sort($check);
            if ($check !== $known) throw new RuntimeException('The library order was not valid. Refresh and try again.');
            $db->beginTransaction(); $stmt = $db->prepare('UPDATE libraries SET sort_order = ? WHERE id = ?');
            foreach ($ids as $position => $id) $stmt->execute([$position, $id]);
            $db->commit(); $notice = 'Library order saved.';
        } elseif ($action === 'toggle_library') {
            $stmt = $db->prepare('UPDATE libraries SET enabled = CASE enabled WHEN 1 THEN 0 ELSE 1 END WHERE id = ?'); $stmt->execute([(int) ($_POST['id'] ?? 0)]); $notice = 'Library status changed.';
        } elseif ($action === 'create_user') {
            $name = trim((string) ($_POST['display_name'] ?? '')); $email = filter_var(trim((string) ($_POST['email'] ?? '')), FILTER_VALIDATE_EMAIL); $role = in_array($_POST['role'] ?? '', ['user', 'admin'], true) ? (string) $_POST['role'] : 'user';
            if ($name === '' || !$email) throw new RuntimeException('The user needs a name and valid email.');
            $password = bin2hex(random_bytes(6)); $stmt = $db->prepare("INSERT INTO users (display_name, email, password_hash, role, must_change_password, auth_source) VALUES (?, ?, ?, ?, 1, 'local')");
            $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $role]); $notice = "User created. Temporary password: {$password} (show it to the user now; it will not be shown again.)";
        } elseif ($action === 'toggle_user') {
            $id = (int) ($_POST['id'] ?? 0); if ($id === (int) $currentUser['id']) throw new RuntimeException('You cannot disable your own account.');
            $stmt = $db->prepare("UPDATE users SET active = CASE active WHEN 1 THEN 0 ELSE 1 END WHERE id = ? AND role != 'super_admin'"); $stmt->execute([$id]); $notice = 'User status changed.';
        } elseif ($action === 'delete_user') {
            $id = (int) ($_POST['id'] ?? 0); if ($id === (int) $currentUser['id']) throw new RuntimeException('You cannot delete your own account.');
            $stmt = $db->prepare("DELETE FROM users WHERE id = ? AND role != 'super_admin'"); $stmt->execute([$id]); $notice = 'User deleted.';
        } elseif ($action === 'settings') {
            $siteName = trim((string) ($_POST['site_name'] ?? '')); $accent = trim((string) ($_POST['accent_colour'] ?? ''));
            if ($siteName === '' || !preg_match('/^#[0-9a-f]{6}$/i', $accent)) throw new RuntimeException('Enter a site name and a six-digit hex colour such as #8b5cf6.');
            tt_set_setting($db, 'site_name', $siteName); tt_set_setting($db, 'accent_colour', strtolower($accent)); tt_set_setting($db, 'registration_enabled', isset($_POST['registration_enabled']) ? '1' : '0'); $notice = 'Settings saved.';
        } elseif ($action === 'update_settings') {
            if (($currentUser['role'] ?? '') !== 'super_admin') throw new RuntimeException('Only the Super Administrator can configure application updates.');
            tt_set_setting($db, 'update_repository', tt_update_validate_repository((string) ($_POST['update_repository'] ?? ''))); $notice = 'Update repository saved.';
        } elseif ($action === 'check_update') {
            if (($currentUser['role'] ?? '') !== 'super_admin') throw new RuntimeException('Only the Super Administrator can check application updates.');
            $releaseInfo = tt_update_release_config(dirname(__DIR__)); $updatePlan = tt_update_build_plan(dirname(__DIR__), (string) $config['data_root'], tt_setting($db, 'update_repository', (string) $releaseInfo['repository']));
        } elseif ($action === 'install_update') {
            if (($currentUser['role'] ?? '') !== 'super_admin') throw new RuntimeException('Only the Super Administrator can install application updates.');
            $releaseInfo = tt_update_release_config(dirname(__DIR__)); $updateResult = tt_update_apply(dirname(__DIR__), (string) $config['data_root'], tt_setting($db, 'update_repository', (string) $releaseInfo['repository'])); $notice = "Updated {$updateResult['updated']} safe file(s) to version {$updateResult['version']}." . ($updateResult['protected'] ? " {$updateResult['protected']} locally modified file(s) were protected." : '');
        }
    }
} catch (Throwable $exception) { $error = $exception instanceof PDOException && str_contains(strtolower($exception->getMessage()), 'unique') ? 'That email address or library path already exists.' : $exception->getMessage(); }
$libraries = $db->query('SELECT * FROM libraries ORDER BY sort_order, name COLLATE NOCASE')->fetchAll();
$users = $db->query('SELECT id, display_name, email, role, active, created_at FROM users ORDER BY display_name COLLATE NOCASE')->fetchAll();
$siteName = tt_setting($db, 'site_name', 'Tea & Toast NAS Player'); $accent = tt_setting($db, 'accent_colour', '#8b5cf6'); $registrationEnabled = tt_setting($db, 'registration_enabled', '0') === '1';
$releaseInfo = tt_update_release_config(dirname(__DIR__)); $updateRepository = tt_setting($db, 'update_repository', (string) $releaseInfo['repository']); $updateState = null; $updateStateError = '';
try { $updateState = tt_update_load_state(dirname(__DIR__), (string) $config['data_root']); } catch (Throwable $exception) { $updateStateError = $exception->getMessage(); }
require __DIR__ . '/../views/admin.php';
