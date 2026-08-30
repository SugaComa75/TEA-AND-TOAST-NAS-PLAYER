<?php
declare(strict_types=1);

require dirname(__DIR__) . '/src/updater.php';

function test_assert(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

$testRoot = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'tea-toast-updater-' . bin2hex(random_bytes(5));
$appRoot = $testRoot . DIRECTORY_SEPARATOR . 'app';
$dataRoot = $testRoot . DIRECTORY_SEPARATOR . 'data';
mkdir($appRoot . DIRECTORY_SEPARATOR . 'assets', 0770, true);
mkdir($dataRoot, 0770, true);

try {
    $fixtures = [
        'safe.txt' => 'old-safe',
        'local.txt' => 'custom-local',
        'remove.txt' => 'old-remove',
        'unchanged.txt' => 'same',
        'existing-new.txt' => 'local-collision',
    ];
    foreach ($fixtures as $path => $content) {
        file_put_contents($appRoot . DIRECTORY_SEPARATOR . $path, $content);
    }
    $state = [
        'schema' => 1,
        'version' => '0.1.0',
        'ref' => 'v0.1.0',
        'repository' => 'owner/repository',
        'files' => [
            'safe.txt' => hash('sha256', 'old-safe'),
            'local.txt' => hash('sha256', 'old-local'),
            'remove.txt' => hash('sha256', 'old-remove'),
            'unchanged.txt' => hash('sha256', 'same'),
        ],
    ];
    $target = tt_update_validate_manifest([
        'schema' => 1,
        'version' => '0.3.0',
        'ref' => 'v0.3.0',
        'repository' => 'owner/repository',
        'files' => [
            'safe.txt' => ['sha256' => hash('sha256', 'new-safe'), 'size' => 8],
            'local.txt' => ['sha256' => hash('sha256', 'new-local'), 'size' => 9],
            'unchanged.txt' => ['sha256' => hash('sha256', 'same'), 'size' => 4],
            'add.txt' => ['sha256' => hash('sha256', 'new-file'), 'size' => 8],
            'existing-new.txt' => ['sha256' => hash('sha256', 'upstream-file'), 'size' => 13],
        ],
    ], 'owner/repository', 'v0.3.0');

    $comparison = tt_update_compare_files($appRoot, $state, $target);
    test_assert($comparison['counts']['safe'] === 3, 'Expected update, add and delete to be safe.');
    test_assert($comparison['counts']['conflict'] === 2, 'Expected two local conflicts to be protected.');
    test_assert($comparison['counts']['unchanged'] === 1, 'Expected one unchanged file.');

    $statuses = [];
    foreach ($comparison['entries'] as $entry) {
        $statuses[$entry['path']] = $entry['status'] . ':' . $entry['action'];
    }
    test_assert($statuses['safe.txt'] === 'safe:update', 'Safe update classification failed.');
    test_assert($statuses['add.txt'] === 'safe:add', 'Safe addition classification failed.');
    test_assert($statuses['remove.txt'] === 'safe:delete', 'Safe deletion classification failed.');
    test_assert($statuses['local.txt'] === 'conflict:update', 'Local modification was not protected.');
    test_assert($statuses['existing-new.txt'] === 'conflict:add', 'Local path collision was not protected.');
    test_assert(tt_update_path_is_protected('config/local.php'), 'Local configuration must be protected.');
    test_assert(tt_update_path_is_protected('data/example.sqlite'), 'Private data must be protected.');
    test_assert(!tt_update_path_is_protected('assets/app.css'), 'Application assets must remain updateable.');

    $blocked = false;
    try {
        tt_update_validate_manifest([
            'schema' => 1,
            'files' => ['install.php' => ['sha256' => hash('sha256', 'bad'), 'size' => 3]],
        ]);
    } catch (RuntimeException) {
        $blocked = true;
    }
    test_assert($blocked, 'A manifest containing install.php must be rejected.');
    $installedState = tt_update_initialize_state(dirname(__DIR__), $dataRoot);
    $releaseManifest = tt_update_read_manifest_file(dirname(__DIR__) . '/release-manifest.json');
    test_assert($installedState['version'] === tt_update_release_config(dirname(__DIR__))['version'], 'Installed version state was not initialized.');
    test_assert($installedState['files'] === array_map(
        static fn(array $metadata): string => $metadata['sha256'],
        $releaseManifest['files']
    ), 'Installed state must use the signed release baseline, not locally altered hashes.');
    echo "Updater classification and protected-path tests passed.\n";
} finally {
    tt_update_remove_tree($testRoot);
}



