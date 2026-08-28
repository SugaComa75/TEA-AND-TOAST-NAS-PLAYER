<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

$appRoot = dirname(__DIR__);
$release = require $appRoot . '/config/release.php';
$includedFiles = ['.htaccess', 'index.php', 'README.md'];
$includedDirectories = ['assets', 'src', 'views'];
$includedConfig = ['config/bootstrap.php', 'config/release.php'];

foreach ($includedDirectories as $directory) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($appRoot . '/' . $directory, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $includedFiles[] = str_replace('\\', '/', substr($file->getPathname(), strlen($appRoot) + 1));
        }
    }
}
$includedFiles = array_merge($includedFiles, $includedConfig);
$includedFiles = array_values(array_unique($includedFiles));
sort($includedFiles, SORT_STRING);

$files = [];
foreach ($includedFiles as $relativePath) {
    $absolutePath = $appRoot . '/' . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
    if (!is_file($absolutePath)) {
        throw new RuntimeException("Missing managed release file: {$relativePath}");
    }
    $files[$relativePath] = [
        'sha256' => hash_file('sha256', $absolutePath),
        'size' => filesize($absolutePath),
    ];
}

$manifest = [
    'schema' => 1,
    'version' => (string) $release['version'],
    'ref' => (string) $release['ref'],
    'repository' => (string) $release['repository'],
    'generated_at' => gmdate('c'),
    'files' => $files,
];
$json = json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
if (file_put_contents($appRoot . '/release-manifest.json', $json, LOCK_EX) === false) {
    throw new RuntimeException('Could not write release-manifest.json.');
}
echo "Generated release-manifest.json for {$manifest['version']} with " . count($files) . " managed files.\n";
