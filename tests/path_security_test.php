<?php
/** Focused CLI checks for the Tea & Toast external-media boundary. */
$sandbox = sys_get_temp_dir() . '/php_music_path_test_' . bin2hex(random_bytes(4));
$media = $sandbox . '/media';
$data = $sandbox . '/data';
$outside = $sandbox . '/outside';
mkdir($media, 0750, true);
mkdir($data, 0750, true);
mkdir($outside, 0750, true);
file_put_contents($media . '/allowed.mp3', 'test');
file_put_contents($outside . '/secret.mp3', 'secret');
putenv('PHP_MUSIC_MEDIA_ROOT=' . $media);
putenv('PHP_MUSIC_DATA_ROOT=' . $data);
require dirname(__DIR__) . '/config/bootstrap.php';

$checks = [
    'relative media path' => php_music_require_media_file('allowed.mp3') !== false,
    'portable media path' => php_music_require_media_file('media://allowed.mp3') !== false,
    'dot-dot traversal rejected' => php_music_require_media_file('../outside/secret.mp3') === false,
    'absolute outside path rejected' => php_music_require_media_file($outside . '/secret.mp3') === false,
    'unsupported extension rejected' => php_music_require_media_file('media://notes.txt') === false,
];

if (function_exists('symlink') && @symlink($outside . '/secret.mp3', $media . '/escape.mp3')) {
    $checks['symlink escape rejected'] = php_music_require_media_file('media://escape.mp3') === false;
}

$failed = array_keys(array_filter($checks, function ($passed) { return !$passed; }));
foreach ($checks as $name => $passed) echo ($passed ? 'PASS ' : 'FAIL ') . $name . PHP_EOL;
exit($failed ? 1 : 0);
