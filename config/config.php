<?php
/**
 * PHP Music deployment configuration.
 *
 * Rebuilt and Extended by Tea & Toast Software.
 * Keep this file outside version control when it contains site-specific paths.
 */
return [
    // Absolute path to the media library. This may be outside the web root.
    'MEDIA_ROOT' => getenv('PHP_MUSIC_MEDIA_ROOT') ?: dirname(__DIR__, 2) . '/media',

    // Writable application state. For production, place this outside public_html.
    'DATA_ROOT' => getenv('PHP_MUSIC_DATA_ROOT') ?: dirname(__DIR__, 2) . '/data',

    // New uploads are stored beneath MEDIA_ROOT in this relative directory.
    'UPLOADS_DIRECTORY' => getenv('PHP_MUSIC_UPLOADS_DIRECTORY') ?: 'uploads',

    // Extensions included by the music library scanner.
    'AUDIO_EXTENSIONS' => ['mp3', 'm4a', 'flac', 'ogg', 'wav', 'aac', 'opus', 'wma', 'm4r'],
    'VIDEO_EXTENSIONS' => ['mp4', 'webm', 'm4v', 'mov', 'ogv', 'mkv'],

    // Set true only when videos should be indexed with the audio library.
    'INDEX_VIDEO' => false,
];
