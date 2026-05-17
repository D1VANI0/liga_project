<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    $sessionPath = appConfig('APP_SESSION_PATH', sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'liga_sessions');

    if (!is_dir($sessionPath)) {
        mkdir($sessionPath, 0775, true);
    }

    if (is_dir($sessionPath) && is_writable($sessionPath)) {
        session_save_path($sessionPath);
    }

    session_start();
}

require_once __DIR__ . '/models/league_model.php';
require_once __DIR__ . '/services/league_service.php';
require_once __DIR__ . '/controllers/auth_controller.php';
require_once __DIR__ . '/controllers/admin_controller.php';
require_once __DIR__ . '/controllers/app_controller.php';
require_once __DIR__ . '/views/layout.php';
