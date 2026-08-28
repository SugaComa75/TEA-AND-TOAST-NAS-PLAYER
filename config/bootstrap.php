<?php
/**
 * Portable path and external-media boundary for PHP Music.
 * Rebuilt and Extended by Tea & Toast Software.
 */

$phpMusicConfigFile = __DIR__ . '/config.php';
$phpMusicLocalConfigFile = __DIR__ . '/local.php';
if (!is_file($phpMusicConfigFile)) {
    throw new RuntimeException('Missing PHP Music configuration: config/config.php');
}

$phpMusicConfig = require $phpMusicConfigFile;
if (!is_array($phpMusicConfig)) {
    throw new RuntimeException('PHP Music configuration must return an array.');
}
if (is_file($phpMusicLocalConfigFile)) {
    $phpMusicLocalConfig = require $phpMusicLocalConfigFile;
    if (!is_array($phpMusicLocalConfig)) {
        throw new RuntimeException('PHP Music local configuration must return an array.');
    }
    $phpMusicConfig = array_replace($phpMusicConfig, $phpMusicLocalConfig);
}

foreach ([
    'PHP_MUSIC_MEDIA_ROOT' => 'MEDIA_ROOT',
    'PHP_MUSIC_DATA_ROOT' => 'DATA_ROOT',
    'PHP_MUSIC_UPLOADS_DIRECTORY' => 'UPLOADS_DIRECTORY',
] as $environmentName => $configName) {
    $environmentValue = getenv($environmentName);
    if ($environmentValue !== false && trim($environmentValue) !== '') {
        $phpMusicConfig[$configName] = $environmentValue;
    }
}

function php_music_absolute_root($value, $name)
{
    if (!is_string($value) || trim($value) === '') {
        throw new RuntimeException($name . ' must be a non-empty absolute path.');
    }
    $value = rtrim(str_replace('\\', '/', trim($value)), '/');
    $isAbsolute = substr($value, 0, 1) === '/' || preg_match('/^[A-Za-z]:\//', $value);
    if (!$isAbsolute) {
        throw new RuntimeException($name . ' must be an absolute path.');
    }
    return $value;
}

function php_music_relative_directory($value, $name)
{
    if (!is_string($value) || trim($value) === '' || strpos($value, "\0") !== false) {
        throw new RuntimeException($name . ' must be a non-empty relative directory.');
    }
    $value = trim(str_replace('\\', '/', $value), '/');
    if ($value === '' || preg_match('/(^|\/)\.\.?($|\/)/', $value) || preg_match('/^[A-Za-z]:/', $value)) {
        throw new RuntimeException($name . ' must be a safe relative directory.');
    }
    return $value;
}

define('APP_ROOT', dirname(__DIR__));
define('MEDIA_ROOT', php_music_absolute_root($phpMusicConfig['MEDIA_ROOT'] ?? '', 'MEDIA_ROOT'));
define('DATA_ROOT', php_music_absolute_root($phpMusicConfig['DATA_ROOT'] ?? '', 'DATA_ROOT'));
define('UPLOADS_DIRECTORY', php_music_relative_directory($phpMusicConfig['UPLOADS_DIRECTORY'] ?? 'uploads', 'UPLOADS_DIRECTORY'));
define('MEDIA_UPLOAD_ROOT', MEDIA_ROOT . '/' . UPLOADS_DIRECTORY);
define('MEDIA_AUDIO_EXTENSIONS', array_values(array_unique(array_map('strtolower', $phpMusicConfig['AUDIO_EXTENSIONS'] ?? []))));
define('MEDIA_VIDEO_EXTENSIONS', array_values(array_unique(array_map('strtolower', $phpMusicConfig['VIDEO_EXTENSIONS'] ?? []))));
define('MEDIA_INDEX_VIDEO', !empty($phpMusicConfig['INDEX_VIDEO']));

if (!is_dir(DATA_ROOT) && !@mkdir(DATA_ROOT, 0750, true) && !is_dir(DATA_ROOT)) {
    throw new RuntimeException('Writable DATA_ROOT is unavailable: ' . DATA_ROOT);
}
if (!is_dir(MEDIA_ROOT) || !is_readable(MEDIA_ROOT)) {
    throw new RuntimeException('MEDIA_ROOT does not exist or is not readable: ' . MEDIA_ROOT);
}
// A read-only library is valid. Create the upload subtree only when permitted.
if (!is_dir(MEDIA_UPLOAD_ROOT) && is_writable(MEDIA_ROOT)) {
    @mkdir(MEDIA_UPLOAD_ROOT, 0750, true);
}

/** True only when a canonical path is the root or a descendant of it. */
function php_music_path_within($path, $root)
{
    $realPath = realpath($path);
    $realRoot = realpath($root);
    if ($realPath === false || $realRoot === false) return false;
    $realPath = rtrim(str_replace('\\', '/', $realPath), '/');
    $realRoot = rtrim(str_replace('\\', '/', $realRoot), '/');
    if (DIRECTORY_SEPARATOR === '\\') {
        $realPath = strtolower($realPath);
        $realRoot = strtolower($realRoot);
    }
    return $realPath === $realRoot || strpos($realPath . '/', $realRoot . '/') === 0;
}

/** Resolve a DB path or media-relative path without permitting traversal or symlink escape. */
function php_music_resolve_media_path($storedPath, $mustBeFile = true)
{
    if (!is_string($storedPath) || trim($storedPath) === '' || strpos($storedPath, "\0") !== false) return false;
    $candidate = str_replace('\\', '/', trim($storedPath));
    if (strpos($candidate, 'media://') === 0) {
        $candidate = MEDIA_ROOT . '/' . ltrim(substr($candidate, 8), '/');
    } elseif (!(substr($candidate, 0, 1) === '/' || preg_match('/^[A-Za-z]:\//', $candidate))) {
        $candidate = MEDIA_ROOT . '/' . ltrim($candidate, '/');
    }
    $real = realpath($candidate);
    if ($real === false || !php_music_path_within($real, MEDIA_ROOT)) return false;
    if ($mustBeFile && !is_file($real)) return false;
    return str_replace('\\', '/', $real);
}

/** Store portable media:// paths in SQLite instead of NAS-specific absolute paths. */
function php_music_store_media_path($absolutePath)
{
    $real = php_music_resolve_media_path($absolutePath, true);
    if ($real === false) return false;
    $root = rtrim(str_replace('\\', '/', realpath(MEDIA_ROOT)), '/');
    return 'media://' . ltrim(substr($real, strlen($root)), '/');
}

function php_music_supported_media_file($path)
{
    $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $allowed = MEDIA_AUDIO_EXTENSIONS;
    if (MEDIA_INDEX_VIDEO) $allowed = array_merge($allowed, MEDIA_VIDEO_EXTENSIONS);
    return in_array($extension, $allowed, true);
}

function php_music_require_media_file($storedPath)
{
    $real = php_music_resolve_media_path($storedPath, true);
    if ($real === false || !php_music_supported_media_file($real)) {
        return false;
    }
    return $real;
}
