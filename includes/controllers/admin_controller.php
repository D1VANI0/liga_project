<?php
declare(strict_types=1);

function redirectWithMessage(string $message, string $target = 'admin.php'): never
{
    $separator = str_contains($target, '?') ? '&' : '?';
    header('Location: ' . $target . $separator . 'message=' . rawurlencode($message));
    exit;
}

function handlePost(): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        return;
    }

    $target = sanitizeLocalPath((string) ($_POST['redirect'] ?? 'admin.php'));

    requireLogin($target);

    $action = $_POST['action'] ?? '';

    if ($action === 'reset_demo') {
        resetDemoData();
        redirectWithMessage('Przywrócono dane demonstracyjne.', $target);
    }

    if ($action === 'add_team') {
        addTeam(
            trim((string) $_POST['name']),
            trim((string) $_POST['city']),
            trim((string) $_POST['coach']),
            trim((string) ($_POST['color'] ?? '#0f766e')),
        );
        redirectWithMessage('Dodano drużynę.', $target);
    }

    if ($action === 'add_player') {
        addPlayer(
            (int) $_POST['teamId'],
            trim((string) $_POST['name']),
            trim((string) $_POST['position']),
        );
        redirectWithMessage('Dodano zawodnika.', $target);
    }

    if ($action === 'add_game') {
        addGame(
            trim((string) $_POST['date']),
            (int) $_POST['homeTeamId'],
            (int) $_POST['visitorTeamId'],
            (int) $_POST['locationId'],
        );
        redirectWithMessage('Dodano mecz do terminarza.', $target);
    }

    if ($action === 'update_result') {
        updateGameResult(
            (int) $_POST['gameId'],
            (int) $_POST['homeScore'],
            (int) $_POST['visitorScore'],
        );
        redirectWithMessage('Zaktualizowano wynik meczu.', $target);
    }

    if ($action === 'add_goal') {
        addGoal(
            (int) $_POST['gameId'],
            (int) $_POST['teamId'],
            (int) $_POST['playerId'],
            (int) $_POST['minute'],
            trim((string) $_POST['type']),
        );
        redirectWithMessage('Zarejestrowano bramkę.', $target);
    }
}
