<?php
declare(strict_types=1);

require dirname(__DIR__) . '/src/core.php';

function artwork_assert(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

$directory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'tea-toast-artwork-' . bin2hex(random_bytes(5));
mkdir($directory, 0770, true);

try {
    file_put_contents($directory . DIRECTORY_SEPARATOR . 'ARTIST.JPG', 'artist');
    file_put_contents($directory . DIRECTORY_SEPARATOR . 'Cover.PNG', 'cover');
    artwork_assert(basename((string) tt_find_artwork($directory, 'artist')) === 'ARTIST.JPG', 'Artist artwork was not preferred.');
    artwork_assert(basename((string) tt_find_artwork($directory, 'album')) === 'Cover.PNG', 'Album artwork was not preferred.');
    unlink($directory . DIRECTORY_SEPARATOR . 'Cover.PNG');
    artwork_assert(basename((string) tt_find_artwork($directory, 'album')) === 'ARTIST.JPG', 'Album artwork did not fall back to artist artwork.');
    echo "Artwork preference and case-insensitive lookup tests passed.\n";
} finally {
    foreach (glob($directory . DIRECTORY_SEPARATOR . '*') ?: [] as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    rmdir($directory);
}
