<?php
declare(strict_types=1);

$appRoot = dirname(__DIR__);
$localConfig = __DIR__ . '/local.php';
if (!is_file($localConfig)) {
    header('Location: install.php');
    exit;
}

$config = require $localConfig;
if (!is_array($config) || empty($config['data_root'])) {
    throw new RuntimeException('The local configuration is invalid. Run the installer again.');
}

require_once $appRoot . '/src/core.php';

ini_set('session.use_strict_mode', '1');
session_name('tea_toast_player');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/\\') . '/',
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

$db = tt_open_database((string) $config['data_root']);
