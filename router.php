<?php
/**
 * Router for PHP built-in server (CI3).
 * Usage:
 *   php-7.3.10 -S 127.0.0.1:8076 router.php
 */
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if ($uri !== '/' && file_exists(__DIR__ . $uri) && !is_dir(__DIR__ . $uri)) {
    return false;
}

require_once __DIR__ . '/index.php';
