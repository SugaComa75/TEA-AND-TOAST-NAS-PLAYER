<?php
declare(strict_types=1);

const TT_AUDIO_EXTENSIONS = ['mp3', 'm4a', 'aac', 'flac', 'wav', 'ogg', 'opus'];
const TT_IGNORED_DIRECTORIES = ['#recycle', '@eadir', '$recycle.bin', 'system volume information'];

function tt_open_database(string $dataRoot): PDO
{
    if (!is_dir($dataRoot) && !mkdir($dataRoot, 0770, true) && !is_dir($dataRoot)) {
        throw new RuntimeException('Unable to create the private data directory.');
    }
    $databasePath = rtrim($dataRoot, '/\\') . DIRECTORY_SEPARATOR . 'tea-toast.sqlite';
    $db = new PDO('sqlite:' . $databasePath, null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $db->exec('PRAGMA foreign_keys = ON');
    $db->exec('PRAGMA busy_timeout = 5000');
    $db->exec('PRAGMA journal_mode = WAL');
    tt_ensure_schema($db);
    return $db;
}

function tt_ensure_schema(PDO $db): void
{
    $db->exec(<<<'SQL'
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    display_name TEXT NOT NULL,
    email TEXT NOT NULL COLLATE NOCASE UNIQUE,
    password_hash TEXT NOT NULL,
    role TEXT NOT NULL DEFAULT 'user' CHECK(role IN ('user','admin','super_admin')),
    active INTEGER NOT NULL DEFAULT 1,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS libraries (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    root_path TEXT NOT NULL UNIQUE,
    enabled INTEGER NOT NULL DEFAULT 1,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS settings (
    setting_key TEXT PRIMARY KEY,
    setting_value TEXT NOT NULL
);
CREATE TABLE IF NOT EXISTS favorites (
    user_id INTEGER NOT NULL,
    library_id INTEGER NOT NULL,
    relative_path TEXT NOT NULL,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, library_id, relative_path),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (library_id) REFERENCES libraries(id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS playlists (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    name TEXT NOT NULL,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS playlist_tracks (
    playlist_id INTEGER NOT NULL,
    library_id INTEGER NOT NULL,
    relative_path TEXT NOT NULL,
    position INTEGER NOT NULL DEFAULT 0,
    PRIMARY KEY (playlist_id, library_id, relative_path),
    FOREIGN KEY (playlist_id) REFERENCES playlists(id) ON DELETE CASCADE,
    FOREIGN KEY (library_id) REFERENCES libraries(id) ON DELETE CASCADE
);
SQL);
    $defaults = [
        'site_name' => 'Tea & Toast NAS Player',
        'accent_colour' => '#8b5cf6',
        'registration_enabled' => '0',
    ];
    $stmt = $db->prepare('INSERT OR IGNORE INTO settings (setting_key, setting_value) VALUES (?, ?)');
    foreach ($defaults as $key => $value) {
        $stmt->execute([$key, $value]);
    }
}

function tt_normalize_relative_path(string $path): string
{
    $path = str_replace('\\', '/', trim(rawurldecode($path)));
    $parts = [];
    foreach (explode('/', $path) as $part) {
        if ($part === '' || $part === '.') {
            continue;
        }
        if ($part === '..' || str_contains($part, "\0")) {
            throw new RuntimeException('Invalid path.');
        }
        $parts[] = $part;
    }
    return implode('/', $parts);
}

function tt_path_is_inside(string $candidate, string $root): bool
{
    $candidate = rtrim(str_replace('\\', '/', $candidate), '/');
    $root = rtrim(str_replace('\\', '/', $root), '/');
    $caseInsensitive = DIRECTORY_SEPARATOR === '\\';
    if ($caseInsensitive) {
        $candidate = strtolower($candidate);
        $root = strtolower($root);
    }
    return $candidate === $root || str_starts_with($candidate . '/', $root . '/');
}

function tt_resolve_library_path(string $root, string $relativePath, bool $mustBeDirectory = false): string
{
    $rootReal = realpath($root);
    if ($rootReal === false || !is_dir($rootReal)) {
        throw new RuntimeException('Library root is unavailable.');
    }
    $relativePath = tt_normalize_relative_path($relativePath);
    $candidate = $relativePath === ''
        ? $rootReal
        : $rootReal . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
    $real = realpath($candidate);
    if ($real === false || !tt_path_is_inside($real, $rootReal)) {
        throw new RuntimeException('The requested path is unavailable.');
    }
    if ($mustBeDirectory && !is_dir($real)) {
        throw new RuntimeException('The requested folder is unavailable.');
    }
    return $real;
}

function tt_should_ignore_directory(string $name): bool
{
    return str_starts_with($name, '.') || in_array(strtolower($name), TT_IGNORED_DIRECTORIES, true);
}

function tt_is_audio_file(string $filename): bool
{
    return in_array(strtolower(pathinfo($filename, PATHINFO_EXTENSION)), TT_AUDIO_EXTENSIONS, true);
}

function tt_find_artwork(string $directory, string $kind = 'album'): ?string
{
    if (!is_dir($directory) || !is_readable($directory)) {
        return null;
    }
    $artistNames = ['artist.jpg', 'artist.jpeg', 'artist.png', 'artist.webp'];
    $albumNames = [
        'cover.jpg', 'cover.jpeg', 'cover.png', 'cover.webp',
        'folder.jpg', 'folder.jpeg', 'folder.png', 'folder.webp',
        'front.jpg', 'front.jpeg', 'front.png', 'front.webp',
    ];
    $preferred = $kind === 'artist'
        ? array_merge($artistNames, $albumNames)
        : array_merge($albumNames, $artistNames);
    $available = [];
    try {
        foreach (new DirectoryIterator($directory) as $item) {
            if ($item->isFile() && $item->isReadable()) {
                $name = strtolower($item->getFilename());
                if (in_array($name, $preferred, true) && !isset($available[$name])) {
                    $available[$name] = $item->getPathname();
                }
            }
        }
    } catch (UnexpectedValueException) {
        return null;
    }
    foreach ($preferred as $name) {
        if (isset($available[$name])) {
            return $available[$name];
        }
    }
    return null;
}

function tt_display_title(string $filename): string
{
    $title = pathinfo($filename, PATHINFO_FILENAME);
    $title = preg_replace('/^\s*\d{1,3}(?:[-_. ]+)\s*/u', '', $title) ?? $title;
    return trim(str_replace('_', ' ', $title));
}

function tt_browse_directory(string $root, string $relativePath): array
{
    $relativePath = tt_normalize_relative_path($relativePath);
    $directory = tt_resolve_library_path($root, $relativePath, true);
    $folders = [];
    $tracks = [];
    try {
        $iterator = new DirectoryIterator($directory);
        foreach ($iterator as $item) {
            if ($item->isDot() || !$item->isReadable()) {
                continue;
            }
            $name = $item->getFilename();
            $childPath = $relativePath === '' ? $name : $relativePath . '/' . $name;
            if ($item->isDir()) {
                if (!tt_should_ignore_directory($name)) {
                    $folders[] = ['name' => $name, 'path' => $childPath];
                }
                continue;
            }
            if ($item->isFile() && tt_is_audio_file($name)) {
                $parts = $relativePath === '' ? [] : explode('/', $relativePath);
                $tracks[] = [
                    'name' => $name,
                    'title' => tt_display_title($name),
                    'path' => $childPath,
                    'album' => $parts ? (string) end($parts) : '',
                    'album_artist' => $parts ? (string) $parts[0] : '',
                    'extension' => strtolower($item->getExtension()),
                    'size' => $item->getSize(),
                ];
            }
        }
    } catch (UnexpectedValueException $exception) {
        throw new RuntimeException('This folder cannot be read by the web server.', 0, $exception);
    }
    usort($folders, static fn(array $a, array $b): int => strnatcasecmp($a['name'], $b['name']));
    usort($tracks, static fn(array $a, array $b): int => strnatcasecmp($a['name'], $b['name']));
    return ['path' => $relativePath, 'folders' => $folders, 'tracks' => $tracks];
}

function tt_random_track(string $root): ?array
{
    $rootReal = realpath($root);
    if ($rootReal === false) {
        return null;
    }
    for ($attempt = 0; $attempt < 24; $attempt++) {
        $directory = $rootReal;
        for ($depth = 0; $depth < 16; $depth++) {
            $folders = [];
            $tracks = [];
            try {
                foreach (new DirectoryIterator($directory) as $item) {
                    if ($item->isDot() || !$item->isReadable()) {
                        continue;
                    }
                    if ($item->isDir() && !tt_should_ignore_directory($item->getFilename())) {
                        $folders[] = $item->getPathname();
                    } elseif ($item->isFile() && tt_is_audio_file($item->getFilename())) {
                        $tracks[] = $item->getPathname();
                    }
                }
            } catch (UnexpectedValueException) {
                break;
            }
            if ($tracks && (!$folders || random_int(0, 3) === 0)) {
                $absolute = $tracks[array_rand($tracks)];
                $relative = ltrim(str_replace('\\', '/', substr($absolute, strlen($rootReal))), '/');
                $parent = dirname($relative);
                $parts = $parent === '.' ? [] : explode('/', $parent);
                return [
                    'path' => $relative,
                    'title' => tt_display_title(basename($absolute)),
                    'album' => $parts ? (string) end($parts) : '',
                    'album_artist' => $parts ? (string) $parts[0] : '',
                ];
            }
            if (!$folders) {
                break;
            }
            $directory = $folders[array_rand($folders)];
        }
    }
    return null;
}

function tt_stream_file(string $absolutePath): never
{
    if (!is_file($absolutePath) || !is_readable($absolutePath)) {
        http_response_code(404);
        exit;
    }
    $size = filesize($absolutePath);
    if ($size === false) {
        http_response_code(500);
        exit;
    }
    $start = 0;
    $end = max(0, $size - 1);
    $status = 200;
    $range = $_SERVER['HTTP_RANGE'] ?? '';
    if ($range !== '' && preg_match('/bytes=(\d*)-(\d*)/', $range, $matches)) {
        if ($matches[1] === '' && $matches[2] !== '') {
            $length = min((int) $matches[2], $size);
            $start = $size - $length;
        } else {
            $start = (int) ($matches[1] === '' ? 0 : $matches[1]);
            $end = $matches[2] === '' ? $end : min((int) $matches[2], $end);
        }
        if ($start > $end || $start >= $size) {
            header('Content-Range: bytes */' . $size);
            http_response_code(416);
            exit;
        }
        $status = 206;
    }
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($absolutePath) ?: 'application/octet-stream';
    http_response_code($status);
    header('Content-Type: ' . $mime);
    header('Accept-Ranges: bytes');
    header('Content-Length: ' . ($end - $start + 1));
    header('Content-Disposition: inline; filename="' . addcslashes(basename($absolutePath), '"\\') . '"');
    if ($status === 206) {
        header("Content-Range: bytes {$start}-{$end}/{$size}");
    }
    session_write_close();
    $handle = fopen($absolutePath, 'rb');
    if ($handle === false) {
        http_response_code(500);
        exit;
    }
    fseek($handle, $start);
    $remaining = $end - $start + 1;
    while ($remaining > 0 && !feof($handle) && connection_status() === CONNECTION_NORMAL) {
        $chunk = fread($handle, min(1024 * 1024, $remaining));
        if ($chunk === false || $chunk === '') {
            break;
        }
        echo $chunk;
        flush();
        $remaining -= strlen($chunk);
    }
    fclose($handle);
    exit;
}

function tt_setting(PDO $db, string $key, string $default = ''): string
{
    $stmt = $db->prepare('SELECT setting_value FROM settings WHERE setting_key = ?');
    $stmt->execute([$key]);
    $value = $stmt->fetchColumn();
    return $value === false ? $default : (string) $value;
}

function tt_set_setting(PDO $db, string $key, string $value): void
{
    $stmt = $db->prepare('INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON CONFLICT(setting_key) DO UPDATE SET setting_value = excluded.setting_value');
    $stmt->execute([$key, $value]);
}

function tt_csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(24));
    }
    return (string) $_SESSION['csrf'];
}

function tt_require_csrf(): void
{
    $provided = $_POST['csrf'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
    if (!is_string($provided) || !hash_equals(tt_csrf_token(), $provided)) {
        throw new RuntimeException('Your session token expired. Refresh and try again.');
    }
}

function tt_json(array $payload, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

function tt_is_admin(array $user): bool
{
    return in_array($user['role'] ?? '', ['admin', 'super_admin'], true);
}

function tt_h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
