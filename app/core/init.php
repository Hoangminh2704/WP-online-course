<?php

/**
 * Application bootstrap.
 * Loads required classes before initializing App.
 */

/** Root URL path on the web server (e.g. '' or '/WebProgramming-online_course') — used for CSS/image links and routing */
if (!defined('BASE_URL')) {
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
    $basePath = str_replace('\\', '/', dirname($scriptName));
    $basePath = rtrim($basePath, '/');
    if ($basePath === '/' || $basePath === '') {
        $basePath = '';
    }
    define('BASE_URL', $basePath);
}

require_once __DIR__ . '/App.php';
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/Database.php';
