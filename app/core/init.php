<?php

/**
 * Bootstrap lõi ứng dụng.
 * Nạp các class cần thiết trước khi khởi tạo App.
 */

/** Đường dẫn gốc ứng dụng trên web server (vd: '' hoặc '/WebProgramming-online_course') — dùng cho link CSS/ảnh và route */
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
