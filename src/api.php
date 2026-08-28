<?php
declare(strict_types=1);

$api = (string) $_GET['api'];
$libraryId = (int) ($_GET['library'] ?? $_POST['library'] ?? 0);
$stmt = $db->prepare('SELECT id, name, root_path FROM libraries WHERE id = ? AND enabled = 1');
$stmt->execute([$libraryId]);
$library = $stmt->fetch();

try {
    if (!$library) {
        throw new RuntimeException('Library not found.');
    }
    $relativePath = (string) ($_GET['path'] ?? $_POST['path'] ?? '');
    switch ($api) {
        case 'browse':
            $result = tt_browse_directory($library['root_path'], $relativePath);
            $favoriteStmt = $db->prepare('SELECT relative_path FROM favorites WHERE user_id = ? AND library_id = ?');
            $favoriteStmt->execute([(int) $currentUser['id'], $libraryId]);
            $favorites = array_fill_keys($favoriteStmt->fetchAll(PDO::FETCH_COLUMN), true);
            foreach ($result['tracks'] as &$track) {
                $track['favorite'] = isset($favorites[$track['path']]);
            }
            unset($track);
            tt_json(['ok' => true, 'library' => ['id' => $library['id'], 'name' => $library['name']], 'data' => $result]);

        case 'random':
            $track = tt_random_track($library['root_path']);
            if (!$track) {
                throw new RuntimeException('No playable track was found in this library.');
            }
            tt_json(['ok' => true, 'track' => $track]);

        case 'stream':
            $absolute = tt_resolve_library_path($library['root_path'], $relativePath);
            if (!tt_is_audio_file($absolute)) {
                throw new RuntimeException('Unsupported audio file.');
            }
            tt_stream_file($absolute);

        case 'artwork':
            $directory = tt_resolve_library_path($library['root_path'], $relativePath, true);
            $artwork = tt_find_artwork($directory, (string) ($_GET['kind'] ?? 'album'));
            if ($artwork !== null) {
                tt_stream_file($artwork);
            }
            http_response_code(404);
            exit;

        case 'favorite':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new RuntimeException('POST required.');
            }
            tt_require_csrf();
            tt_resolve_library_path($library['root_path'], $relativePath);
            $check = $db->prepare('SELECT 1 FROM favorites WHERE user_id = ? AND library_id = ? AND relative_path = ?');
            $check->execute([(int) $currentUser['id'], $libraryId, tt_normalize_relative_path($relativePath)]);
            if ($check->fetchColumn()) {
                $delete = $db->prepare('DELETE FROM favorites WHERE user_id = ? AND library_id = ? AND relative_path = ?');
                $delete->execute([(int) $currentUser['id'], $libraryId, tt_normalize_relative_path($relativePath)]);
                tt_json(['ok' => true, 'favorite' => false]);
            }
            $insert = $db->prepare('INSERT INTO favorites (user_id, library_id, relative_path) VALUES (?, ?, ?)');
            $insert->execute([(int) $currentUser['id'], $libraryId, tt_normalize_relative_path($relativePath)]);
            tt_json(['ok' => true, 'favorite' => true]);

        default:
            tt_json(['ok' => false, 'error' => 'Unknown request.'], 404);
    }
} catch (Throwable $exception) {
    tt_json(['ok' => false, 'error' => $exception->getMessage()], 400);
}
