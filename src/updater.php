<?php
declare(strict_types=1);

const TT_UPDATE_PROTECTED_PATHS = [
    'install.php',
    'config/local.php',
    'data/',
    'storage/',
    'update-backups/',
    'CHANGELOG.txt',
    'UAT_SCRIPT.txt',
    '.git/',
    '.github/',
    'tests/',
    'tools/',
];

function tt_update_release_config(string $appRoot): array
{
    $path = $appRoot . '/config/release.php';
    $release = is_file($path) ? require $path : [];
    if (!is_array($release) || empty($release['version']) || empty($release['ref']) || empty($release['repository'])) {
        throw new RuntimeException('The application release configuration is missing or invalid.');
    }
    $release['manifest'] = (string) ($release['manifest'] ?? 'release-manifest.json');
    return $release;
}

function tt_update_normalize_path(string $path): string
{
    $path = str_replace('\\', '/', trim($path));
    $path = ltrim($path, '/');
    if ($path === '' || str_contains($path, "\0")) {
        throw new RuntimeException('The update contains an invalid empty path.');
    }
    $parts = [];
    foreach (explode('/', $path) as $part) {
        if ($part === '' || $part === '.') {
            continue;
        }
        if ($part === '..' || str_contains($part, ':')) {
            throw new RuntimeException('The update contains an unsafe path.');
        }
        $parts[] = $part;
    }
    if (!$parts) {
        throw new RuntimeException('The update contains an invalid path.');
    }
    return implode('/', $parts);
}

function tt_update_path_is_protected(string $path): bool
{
    $path = strtolower(tt_update_normalize_path($path));
    foreach (TT_UPDATE_PROTECTED_PATHS as $protected) {
        $protected = strtolower($protected);
        if (str_ends_with($protected, '/')) {
            if (str_starts_with($path . '/', $protected)) {
                return true;
            }
        } elseif ($path === $protected) {
            return true;
        }
    }
    return false;
}

function tt_update_absolute_path(string $appRoot, string $relativePath): string
{
    $relativePath = tt_update_normalize_path($relativePath);
    return rtrim($appRoot, '/\\') . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
}

function tt_update_state_path(string $dataRoot): string
{
    return rtrim($dataRoot, '/\\') . DIRECTORY_SEPARATOR . 'update-state.json';
}

function tt_update_save_state(string $dataRoot, array $state): void
{
    $path = tt_update_state_path($dataRoot);
    $temporary = $path . '.tmp-' . bin2hex(random_bytes(5));
    $json = json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR) . PHP_EOL;
    if (file_put_contents($temporary, $json, LOCK_EX) === false || !rename($temporary, $path)) {
        @unlink($temporary);
        throw new RuntimeException('The updater could not save its private installation state.');
    }
}

function tt_update_read_manifest_file(string $path): array
{
    if (!is_file($path) || !is_readable($path)) {
        throw new RuntimeException('release-manifest.json is missing. Regenerate the release before installing it.');
    }
    try {
        $manifest = json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException $exception) {
        throw new RuntimeException('release-manifest.json is invalid.', 0, $exception);
    }
    return tt_update_validate_manifest($manifest);
}

function tt_update_validate_manifest(mixed $manifest, ?string $expectedRepository = null, ?string $expectedRef = null): array
{
    if (!is_array($manifest) || ($manifest['schema'] ?? null) !== 1 || !is_array($manifest['files'] ?? null)) {
        throw new RuntimeException('The release manifest format is not supported.');
    }
    if ($expectedRepository !== null && strcasecmp((string) ($manifest['repository'] ?? ''), $expectedRepository) !== 0) {
        throw new RuntimeException('The release manifest belongs to a different GitHub repository.');
    }
    if ($expectedRef !== null && (string) ($manifest['ref'] ?? '') !== $expectedRef) {
        throw new RuntimeException("The release manifest does not match the published release tag. Expected ref '{$expectedRef}', received '" . (string) ($manifest['ref'] ?? '') . "'.");
    }
    $validatedFiles = [];
    foreach ($manifest['files'] as $path => $metadata) {
        $path = tt_update_normalize_path((string) $path);
        if (tt_update_path_is_protected($path)) {
            throw new RuntimeException("The release manifest attempts to manage protected path: {$path}");
        }
        $hash = strtolower((string) ($metadata['sha256'] ?? ''));
        if (!preg_match('/^[a-f0-9]{64}$/', $hash)) {
            throw new RuntimeException("The release manifest has an invalid hash for {$path}.");
        }
        $validatedFiles[$path] = ['sha256' => $hash, 'size' => max(0, (int) ($metadata['size'] ?? 0))];
    }
    ksort($validatedFiles, SORT_STRING);
    $manifest['files'] = $validatedFiles;
    return $manifest;
}

function tt_update_initialize_state(string $appRoot, string $dataRoot): array
{
    $release = tt_update_release_config($appRoot);
    $manifest = tt_update_read_manifest_file($appRoot . '/' . $release['manifest']);
    $files = [];
    foreach ($manifest['files'] as $path => $metadata) {
        $files[$path] = strtolower((string) $metadata['sha256']);
    }
    $state = [
        'schema' => 1,
        'version' => (string) $release['version'],
        'ref' => (string) $release['ref'],
        'repository' => (string) $release['repository'],
        'files' => $files,
        'partial' => false,
        'updated_at' => gmdate('c'),
    ];
    tt_update_save_state($dataRoot, $state);
    return $state;
}

function tt_update_load_state(string $appRoot, string $dataRoot): array
{
    $path = tt_update_state_path($dataRoot);
    if (!is_file($path)) {
        return tt_update_initialize_state($appRoot, $dataRoot);
    }
    try {
        $state = json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException $exception) {
        throw new RuntimeException('The private update-state.json file is invalid.', 0, $exception);
    }
    if (!is_array($state) || ($state['schema'] ?? null) !== 1 || !is_array($state['files'] ?? null)) {
        throw new RuntimeException('The private update state format is invalid.');
    }
    return $state;
}

function tt_update_validate_repository(string $repository): string
{
    $repository = trim($repository);
    if (!preg_match('/^[A-Za-z0-9_.-]+\/[A-Za-z0-9_.-]+$/', $repository)) {
        throw new RuntimeException('Enter the GitHub repository as owner/name.');
    }
    return $repository;
}

function tt_update_http_get(string $url, bool $json = false): string|array
{
    $headers = [
        'User-Agent: Tea-and-Toast-NAS-Player-Updater',
        $json ? 'Accept: application/vnd.github+json' : 'Accept: application/octet-stream',
        'X-GitHub-Api-Version: 2022-11-28',
    ];
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => implode("\r\n", $headers),
            'timeout' => 25,
            'ignore_errors' => true,
        ],
        'ssl' => ['verify_peer' => true, 'verify_peer_name' => true],
    ]);
    $body = @file_get_contents($url, false, $context);
    $responseHeaders = $http_response_header ?? [];
    $status = 0;
    if (isset($responseHeaders[0]) && preg_match('/\s(\d{3})\s/', $responseHeaders[0], $matches)) {
        $status = (int) $matches[1];
    }
    if ($body === false || $status < 200 || $status >= 300) {
        $suffix = $status ? " (HTTP {$status})" : '';
        throw new RuntimeException('GitHub could not be reached or did not return the requested release' . $suffix . '.');
    }
    if (!$json) {
        return $body;
    }
    try {
        $decoded = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException $exception) {
        throw new RuntimeException('GitHub returned an invalid response.', 0, $exception);
    }
    if (!is_array($decoded)) {
        throw new RuntimeException('GitHub returned an unexpected response.');
    }
    return $decoded;
}

function tt_update_raw_url(string $repository, string $ref, string $path): string
{
    [$owner, $name] = explode('/', tt_update_validate_repository($repository), 2);
    $encodedPath = implode('/', array_map('rawurlencode', explode('/', tt_update_normalize_path($path))));
    return 'https://raw.githubusercontent.com/' . rawurlencode($owner) . '/' . rawurlencode($name) . '/' . rawurlencode($ref) . '/' . $encodedPath;
}

function tt_update_compare_files(string $appRoot, array $state, array $targetManifest): array
{
    $baseline = $state['files'];
    $target = $targetManifest['files'];
    $allPaths = array_values(array_unique(array_merge(array_keys($baseline), array_keys($target))));
    sort($allPaths, SORT_STRING);
    $entries = [];
    $counts = ['safe' => 0, 'conflict' => 0, 'local' => 0, 'unchanged' => 0, 'already_current' => 0];
    foreach ($allPaths as $path) {
        if (tt_update_path_is_protected($path)) {
            continue;
        }
        $absolute = tt_update_absolute_path($appRoot, $path);
        $currentHash = is_file($absolute) ? strtolower((string) hash_file('sha256', $absolute)) : null;
        $baselineHash = isset($baseline[$path]) ? strtolower((string) $baseline[$path]) : null;
        $targetHash = isset($target[$path]) ? strtolower((string) $target[$path]['sha256']) : null;
        $entry = ['path' => $path, 'baseline_hash' => $baselineHash, 'current_hash' => $currentHash, 'target_hash' => $targetHash];
        if ($targetHash === $baselineHash) {
            if ($currentHash === $baselineHash) {
                $counts['unchanged']++;
                continue;
            }
            $entry += ['action' => 'keep', 'status' => 'local', 'label' => 'Local modification retained'];
            $counts['local']++;
        } elseif ($targetHash === null) {
            $entry['action'] = 'delete';
            if ($currentHash === null) {
                $entry += ['status' => 'already_current', 'label' => 'Already removed'];
                $counts['already_current']++;
            } elseif ($baselineHash !== null && hash_equals($baselineHash, $currentHash)) {
                $entry += ['status' => 'safe', 'label' => 'Safe to remove'];
                $counts['safe']++;
            } else {
                $entry += ['status' => 'conflict', 'label' => 'Locally modified; removal skipped'];
                $counts['conflict']++;
            }
        } elseif ($baselineHash === null) {
            $entry['action'] = 'add';
            if ($currentHash === null) {
                $entry += ['status' => 'safe', 'label' => 'Safe to add'];
                $counts['safe']++;
            } elseif (hash_equals($targetHash, $currentHash)) {
                $entry += ['status' => 'already_current', 'label' => 'Already current'];
                $counts['already_current']++;
            } else {
                $entry += ['status' => 'conflict', 'label' => 'Local file already exists; skipped'];
                $counts['conflict']++;
            }
        } else {
            $entry['action'] = 'update';
            if ($currentHash !== null && hash_equals($targetHash, $currentHash)) {
                $entry += ['status' => 'already_current', 'label' => 'Already current'];
                $counts['already_current']++;
            } elseif ($currentHash !== null && hash_equals($baselineHash, $currentHash)) {
                $entry += ['status' => 'safe', 'label' => 'Safe to update'];
                $counts['safe']++;
            } else {
                $entry += ['status' => 'conflict', 'label' => 'Locally modified; update skipped'];
                $counts['conflict']++;
            }
        }
        $entries[] = $entry;
    }
    return ['entries' => $entries, 'counts' => $counts];
}

function tt_update_build_plan(string $appRoot, string $dataRoot, string $repository): array
{
    $repository = tt_update_validate_repository($repository);
    $state = tt_update_load_state($appRoot, $dataRoot);
    $release = tt_update_http_get('https://api.github.com/repos/' . $repository . '/releases/latest', true);
    $targetRef = trim((string) ($release['tag_name'] ?? ''));
    if ($targetRef === '') {
        throw new RuntimeException('The latest GitHub release does not have a tag.');
    }
    $releaseConfig = tt_update_release_config($appRoot);
    $manifestUrl = tt_update_raw_url($repository, $targetRef, (string) $releaseConfig['manifest']);
    $targetManifest = tt_update_validate_manifest(tt_update_http_get($manifestUrl, true), $repository, $targetRef);
    $comparison = tt_update_compare_files($appRoot, $state, $targetManifest);
    $entries = $comparison['entries'];
    $counts = $comparison['counts'];
    return [
        'repository' => $repository,
        'current_version' => (string) ($state['version'] ?? 'unknown'),
        'current_ref' => (string) ($state['ref'] ?? ''),
        'target_version' => (string) ($targetManifest['version'] ?? $targetRef),
        'target_ref' => $targetRef,
        'release_url' => (string) ($release['html_url'] ?? ''),
        'entries' => $entries,
        'counts' => $counts,
        'target_manifest' => $targetManifest,
        'state' => $state,
        'up_to_date' => $counts['safe'] === 0 && $counts['conflict'] === 0 && $counts['already_current'] === 0
            && (string) ($state['ref'] ?? '') === $targetRef,
    ];
}

function tt_update_ensure_directory(string $directory): void
{
    if (!is_dir($directory) && !mkdir($directory, 0770, true) && !is_dir($directory)) {
        throw new RuntimeException("Could not create update directory: {$directory}");
    }
}

function tt_update_remove_tree(string $directory): void
{
    if (!is_dir($directory)) {
        return;
    }
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($iterator as $item) {
        $item->isDir() ? @rmdir($item->getPathname()) : @unlink($item->getPathname());
    }
    @rmdir($directory);
}

function tt_update_apply(string $appRoot, string $dataRoot, string $repository): array
{
    $lockPath = rtrim($dataRoot, '/\\') . DIRECTORY_SEPARATOR . 'update.lock';
    $lock = fopen($lockPath, 'c+');
    if ($lock === false || !flock($lock, LOCK_EX | LOCK_NB)) {
        if (is_resource($lock)) {
            fclose($lock);
        }
        throw new RuntimeException('Another update is already running.');
    }
    $stageRoot = rtrim($dataRoot, '/\\') . DIRECTORY_SEPARATOR . '.update-staging-' . bin2hex(random_bytes(6));
    $backupRoot = rtrim($dataRoot, '/\\') . DIRECTORY_SEPARATOR . 'update-backups' . DIRECTORY_SEPARATOR
        . gmdate('Ymd-His') . '-' . bin2hex(random_bytes(3));
    $applied = [];
    try {
        $plan = tt_update_build_plan($appRoot, $dataRoot, $repository);
        tt_update_ensure_directory($stageRoot);
        foreach ($plan['entries'] as $entry) {
            if ($entry['status'] !== 'safe' || !in_array($entry['action'], ['add', 'update'], true)) {
                continue;
            }
            $content = tt_update_http_get(tt_update_raw_url($repository, $plan['target_ref'], $entry['path']));
            if (!hash_equals((string) $entry['target_hash'], hash('sha256', $content))) {
                throw new RuntimeException("Hash verification failed for {$entry['path']}.");
            }
            $staged = tt_update_absolute_path($stageRoot, $entry['path']);
            tt_update_ensure_directory(dirname($staged));
            if (file_put_contents($staged, $content, LOCK_EX) === false) {
                throw new RuntimeException("Could not stage {$entry['path']}.");
            }
        }

        $safeEntries = array_values(array_filter($plan['entries'], static fn(array $entry): bool => $entry['status'] === 'safe'));
        if ($safeEntries) {
            tt_update_ensure_directory($backupRoot);
        }
        foreach ($safeEntries as $entry) {
            $destination = tt_update_absolute_path($appRoot, $entry['path']);
            $backup = tt_update_absolute_path($backupRoot, $entry['path']);
            $existed = is_file($destination);
            if ($existed) {
                tt_update_ensure_directory(dirname($backup));
                if (!copy($destination, $backup)) {
                    throw new RuntimeException("Could not back up {$entry['path']}.");
                }
            }
            if ($entry['action'] === 'delete') {
                if ($existed && !unlink($destination)) {
                    throw new RuntimeException("Could not remove {$entry['path']}.");
                }
            } else {
                $staged = tt_update_absolute_path($stageRoot, $entry['path']);
                tt_update_ensure_directory(dirname($destination));
                $temporary = $destination . '.update-' . bin2hex(random_bytes(4));
                if (!copy($staged, $temporary)) {
                    @unlink($temporary);
                    throw new RuntimeException("Could not install {$entry['path']}.");
                }
                $previous = null;
                if ($existed) {
                    $previous = $destination . '.previous-' . bin2hex(random_bytes(4));
                    if (!rename($destination, $previous)) {
                        @unlink($temporary);
                        throw new RuntimeException("Could not prepare {$entry['path']} for replacement.");
                    }
                }
                if (!rename($temporary, $destination)) {
                    if ($previous !== null) {
                        @rename($previous, $destination);
                    }
                    @unlink($temporary);
                    throw new RuntimeException("Could not install {$entry['path']}.");
                }
                if ($previous !== null) {
                    @unlink($previous);
                }
            }
            $applied[] = ['path' => $entry['path'], 'destination' => $destination, 'backup' => $backup, 'existed' => $existed];
        }

        $state = $plan['state'];
        foreach ($plan['entries'] as $entry) {
            if (!in_array($entry['status'], ['safe', 'already_current'], true)) {
                continue;
            }
            if ($entry['target_hash'] === null) {
                unset($state['files'][$entry['path']]);
            } else {
                $state['files'][$entry['path']] = $entry['target_hash'];
            }
        }
        $state['version'] = $plan['target_version'];
        $state['ref'] = $plan['target_ref'];
        $state['repository'] = $repository;
        $state['partial'] = $plan['counts']['conflict'] > 0;
        $state['updated_at'] = gmdate('c');
        tt_update_save_state($dataRoot, $state);
        tt_update_remove_tree($stageRoot);
        flock($lock, LOCK_UN);
        fclose($lock);
        return [
            'version' => $plan['target_version'],
            'updated' => count($safeEntries),
            'protected' => $plan['counts']['conflict'] + $plan['counts']['local'],
            'backup' => $safeEntries ? $backupRoot : null,
        ];
    } catch (Throwable $exception) {
        foreach (array_reverse($applied) as $item) {
            if ($item['existed'] && is_file($item['backup'])) {
                @copy($item['backup'], $item['destination']);
            } elseif (!$item['existed'] && is_file($item['destination'])) {
                @unlink($item['destination']);
            }
        }
        tt_update_remove_tree($stageRoot);
        flock($lock, LOCK_UN);
        fclose($lock);
        throw $exception;
    }
}

