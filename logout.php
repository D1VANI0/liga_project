<?php
require __DIR__ . '/includes/app.php';

logoutUser();

header('Location: index.php?message=' . rawurlencode('Wylogowano administratora.'));
exit;
