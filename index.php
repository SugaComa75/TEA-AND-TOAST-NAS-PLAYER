<?php
declare(strict_types=1);

require __DIR__ . '/config/bootstrap.php';

$error = '';
$notice = '';
$currentUser = null;
if (!empty($_SESSION['user_id'])) {
    $stmt = $db->prepare('SELECT id, display_name, email, role, active FROM users WHERE id = ?');
    $stmt->execute([(int) $_SESSION['user_id']]);
    $currentUser = $stmt->fetch() ?: null;
    if (!$currentUser || !(int) $currentUser['active']) {
        unset($_SESSION['user_id']);
        $currentUser = null;
    }
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'login') {
        tt_require_csrf();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = ? AND active = 1');
        $stmt->execute([trim((string) ($_POST['email'] ?? ''))]);
        $candidate = $stmt->fetch();
        if (!$candidate || !password_verify((string) ($_POST['password'] ?? ''), $candidate['password_hash'])) {
            throw new RuntimeException('The email address or password is incorrect.');
        }
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $candidate['id'];
        header('Location: ./');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'register') {
        tt_require_csrf();
        if (tt_setting($db, 'registration_enabled', '0') !== '1') {
            throw new RuntimeException('Registration is currently closed.');
        }
        $name = trim((string) ($_POST['display_name'] ?? ''));
        $email = filter_var(trim((string) ($_POST['email'] ?? '')), FILTER_VALIDATE_EMAIL);
        $password = (string) ($_POST['password'] ?? '');
        if ($name === '' || !$email || strlen($password) < 8) {
            throw new RuntimeException('Enter a name, a valid email address, and a password of at least 8 characters.');
        }
        $stmt = $db->prepare("INSERT INTO users (display_name, email, password_hash, role) VALUES (?, ?, ?, 'user')");
        $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
        $notice = 'Your account has been created. You can now sign in.';
    }

    if (isset($_GET['logout'])) {
        $_SESSION = [];
        session_destroy();
        header('Location: ./');
        exit;
    }
} catch (Throwable $exception) {
    $error = $exception instanceof PDOException && str_contains(strtolower($exception->getMessage()), 'unique')
        ? 'That email address is already registered.'
        : $exception->getMessage();
}

if (!$currentUser) {
    $registrationEnabled = tt_setting($db, 'registration_enabled', '0') === '1';
    $siteName = tt_setting($db, 'site_name', 'Tea & Toast NAS Player');
    $accent = tt_setting($db, 'accent_colour', '#8b5cf6');
    require __DIR__ . '/views/login.php';
    exit;
}

if (isset($_GET['api'])) {
    require __DIR__ . '/src/api.php';
}

if (isset($_GET['admin'])) {
    if (!tt_is_admin($currentUser)) {
        http_response_code(403);
        exit('Access denied.');
    }
    require __DIR__ . '/src/admin.php';
    exit;
}

$libraries = $db->query('SELECT id, name FROM libraries WHERE enabled = 1 ORDER BY name COLLATE NOCASE')->fetchAll();
$siteName = tt_setting($db, 'site_name', 'Tea & Toast NAS Player');
$accent = tt_setting($db, 'accent_colour', '#8b5cf6');
require __DIR__ . '/views/player.php';
