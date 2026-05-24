<?php
require __DIR__ . '/includes/app.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST' || !isLoggedIn() || !isValidCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
    header('Location: index.php?message=' . rawurlencode('Nieprawidłowy token bezpieczeństwa.'));
    exit;
}

logoutUser();

header('Location: index.php?message=' . rawurlencode('Wylogowano administratora.'));
exit;
