<?php
declare(strict_types=1);

const ADMIN_LOGIN = 'admin';
const ADMIN_PASSWORD_HASH = '$2y$10$0mBjL31ml2HUKKe0/cEh8uP.YfHGxFpF3hPsYXueVzmfTt6E4usy2';

function isLoggedIn(): bool
{
    return isset($_SESSION['user']) && $_SESSION['user'] === ADMIN_LOGIN;
}

function currentUser(): ?string
{
    return isLoggedIn() ? ADMIN_LOGIN : null;
}

function attemptLogin(string $login, string $password): bool
{
    if ($login !== ADMIN_LOGIN || !password_verify($password, ADMIN_PASSWORD_HASH)) {
        return false;
    }

    session_regenerate_id(true);
    $_SESSION['user'] = ADMIN_LOGIN;

    return true;
}

function logoutUser(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], (bool) $params['secure'], (bool) $params['httponly']);
    }

    session_destroy();
}

function requireLogin(string $target = 'admin.php'): void
{
    if (isLoggedIn()) {
        return;
    }

    header('Location: login.php?next=' . rawurlencode($target) . '&message=' . rawurlencode('Zaloguj się, aby otworzyć panel administracyjny.'));
    exit;
}

function handleLoginPost(): ?string
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return null;
    }

    $login = trim((string) ($_POST['login'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $next = sanitizeLocalPath((string) ($_POST['next'] ?? 'admin.php'));

    if (attemptLogin($login, $password)) {
        $separator = str_contains($next, '?') ? '&' : '?';
        header('Location: ' . $next . $separator . 'message=' . rawurlencode('Zalogowano jako administrator.'));
        exit;
    }

    return 'Nieprawidłowy login lub hasło.';
}

function sanitizeLocalPath(string $path): string
{
    if ($path === '' || str_contains($path, '://') || str_starts_with($path, '//')) {
        return 'admin.php';
    }

    return ltrim($path, '/');
}
