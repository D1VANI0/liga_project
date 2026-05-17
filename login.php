<?php
require __DIR__ . '/includes/app.php';

$next = sanitizeLocalPath((string) ($_GET['next'] ?? $_POST['next'] ?? 'admin.php'));
$error = handleLoginPost();

if (isLoggedIn()) {
    header('Location: ' . $next);
    exit;
}

$data = loadData();
$context = [
    'league' => $data['league'],
    'flash' => $error ?? ($_GET['message'] ?? null),
];

renderHeader('Logowanie', $context, 'Dostęp do panelu administratora.');
?>
<section class="login-wrap">
    <form class="action-card login-card" method="post">
        <input type="hidden" name="next" value="<?= h($next) ?>">
        <h2>Panel administratora</h2>
        <label>Nazwa użytkownika <input name="login" required maxlength="40" autocomplete="username" placeholder="login"></label>
        <label>Hasło <input type="password" name="password" required autocomplete="current-password" placeholder="hasło"></label>
        <button type="submit">Zaloguj</button>
    </form>
</section>
<?php renderFooter(); ?>
