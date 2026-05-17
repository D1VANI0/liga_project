<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    $sessionPath = __DIR__ . '/../data/sessions';
    if (!is_dir($sessionPath)) {
        mkdir($sessionPath, 0775, true);
    }
    session_save_path($sessionPath);
    session_start();
}

require_once __DIR__ . '/config.php';
<<<<<<< HEAD
=======
require_once __DIR__ . '/database.php';
>>>>>>> 1c95d67abd59be267ccc96fde4b746c11bbb116b
require_once __DIR__ . '/models/league_model.php';
require_once __DIR__ . '/services/league_service.php';
require_once __DIR__ . '/controllers/auth_controller.php';
require_once __DIR__ . '/controllers/admin_controller.php';
require_once __DIR__ . '/controllers/app_controller.php';
require_once __DIR__ . '/views/layout.php';
