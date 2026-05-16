<?php
require __DIR__ . '/includes/app.php';

$data = loadData();
$next = sanitizeLocalPath((string) ($_GET['next'] ?? 'admin.php'));
$error = handleLoginPost();
$context = [
    'league' => $data['league'],
    'flash' => $error ?? ($_GET['message'] ?? null),
];

renderHeader('Logowanie', $context, 'Dostęp do operacji administracyjnych bez użycia bazy danych.');
?>
<section class="login-wrap">
    <form class="action-card login-card" method="post">
        <input type="hidden" name="next" value="<?= h($next) ?>">
        <h2>Panel administratora</h2>
        <label>Nazwa użytkownika <input name="login" required maxlength="40" autocomplete="username" value="admin"></label>
        <label>Hasło <input type="password" name="password" required autocomplete="current-password" placeholder="Liga2026!"></label>
        <button type="submit">Zaloguj</button>
        <p class="form-note">Dane demonstracyjne: użytkownik <strong>admin</strong>, hasło <strong>Liga2026!</strong>.</p>
    </form>
</section>
<?php renderFooter(); ?>
