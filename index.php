<?php
/**
 * PHP Music front controller.
 * Rebuilt and Extended by Tea & Toast Software.
 */
define('PHP_MUSIC_FRONT_CONTROLLER', true);

try {
  require_once __DIR__ . '/config/bootstrap.php';
} catch (RuntimeException $exception) {
  if (is_file(__DIR__ . '/install.php') && !headers_sent()) {
    header('Location: install.php?reason=configuration');
    exit;
  }
  throw $exception;
}

require __DIR__ . '/backend.php';
require __DIR__ . '/views/app.php';
