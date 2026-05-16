<?php
declare(strict_types=1);

function h(string|int|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function isActive(string $file): string
{
    return basename((string) $_SERVER['SCRIPT_NAME']) === $file ? 'active' : '';
}

function renderHeader(string $title, array $context, string $subtitle = ''): void
{
    $league = $context['league'];
    $subtitle = $subtitle !== '' ? $subtitle : 'Panel ligi przygotowany pod wdrożenie w chmurze';
    ?>
    <!doctype html>
    <html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= h($title) ?> - System Liga</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <aside class="sidebar">
            <a class="brand" href="index.php">
                <span class="brand-mark">L</span>
                <span>
                    <strong><?= h($league['name']) ?></strong>
                    <small><?= h($league['season']) ?></small>
                </span>
            </a>
            <nav class="main-nav" aria-label="Główne">
                <a class="<?= isActive('index.php') ?>" href="index.php">Panel</a>
                <a class="<?= isActive('standings.php') ?>" href="standings.php">Tabela</a>
                <a class="<?= isActive('matches.php') ?>" href="matches.php">Mecze</a>
                <a class="<?= isActive('teams.php') ?>" href="teams.php">Drużyny</a>
                <a class="<?= isActive('players.php') ?>" href="players.php">Zawodnicy</a>
                <a class="<?= isActive('reports.php') ?>" href="reports.php">Raporty</a>
                <a class="<?= isActive('admin.php') ?>" href="admin.php">Administracja</a>
            </nav>
            <div class="deploy-card">
                <span>Wdrożenie</span>
                <strong>Usługa aplikacji</strong>
                <small>JSON teraz, SQL później</small>
            </div>
        </aside>
        <div class="shell">
            <header class="page-header">
                <div>
                    <p class="eyebrow"><?= h($league['schedule']) ?></p>
                    <h1><?= h($title) ?></h1>
                    <p><?= h($subtitle) ?></p>
                </div>
                <?php if (isLoggedIn()): ?>
                    <a class="primary-link" href="logout.php">Wyloguj admina</a>
                <?php else: ?>
                    <a class="primary-link" href="login.php">Logowanie</a>
                <?php endif; ?>
            </header>
            <?php if ($context['flash'] !== null): ?>
                <div class="flash" role="status"><?= h($context['flash']) ?></div>
            <?php endif; ?>
            <main>
    <?php
}

function renderFooter(): void
{
    ?>
            </main>
            <footer class="app-footer">
                <span>System Liga - prototyp bez bazy danych</span>
                <span>Gotowy do podmiany JSON na relacyjną bazę danych</span>
            </footer>
        </div>
    </body>
    </html>
    <?php
}
