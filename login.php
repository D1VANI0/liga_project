<?php
require __DIR__ . '/includes/app.php';

$data = loadData();
$next = sanitizeLocalPath((string) ($_GET['next'] ?? 'admin.php'));
$error = handleLoginPost();
$context = [
    'league' => $data['league'],
    'flash' => $error ?? ($_GET['message'] ?? null),
];

renderHeader('Logowanie', $context, 'Dostep do operacji administracyjnych bez uzycia bazy danych.');
?>
<section class="login-wrap">
    <form class="action-card login-card" method="post">
        <input type="hidden" name="next" value="<?= h($next) ?>">
        <h2>Panel administratora</h2>
        <label>Login <input name="login" required maxlength="40" autocomplete="username" value="admin"></label>
        <label>Haslo <input type="password" name="password" required autocomplete="current-password" placeholder="Liga2026!"></label>
        <button type="submit">Zaloguj</button>
        <p class="form-note">Dane demo: login <strong>admin</strong>, haslo <strong>Liga2026!</strong>.</p>
    </form>
</section>
<?php renderFooter(); ?>
