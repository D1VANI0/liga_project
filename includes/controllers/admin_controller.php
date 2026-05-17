<?php
declare(strict_types=1);

function redirectWithMessage(string $message, string $target = 'admin.php'): never
{
    header('Location: ' . $target . '?message=' . rawurlencode($message));
    exit;
}

function handlePost(): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        return;
    }

    requireLogin('admin.php');

    $action = $_POST['action'] ?? '';

    if ($action === 'reset_demo') {
        resetDemoData();
        redirectWithMessage('Przywrócono dane demonstracyjne.');
    }

    if ($action === 'add_team') {
        addTeam(
            trim((string) $_POST['name']),
            trim((string) $_POST['city']),
            trim((string) $_POST['coach']),
            trim((string) ($_POST['color'] ?? '#0f766e')),
        );
        redirectWithMessage('Dodano drużynę.');
    }

    if ($action === 'add_player') {
        addPlayer(
            (int) $_POST['teamId'],
            trim((string) $_POST['name']),
            trim((string) $_POST['position']),
        );
        redirectWithMessage('Dodano zawodnika.');
    }

    if ($action === 'add_game') {
        addGame(
            trim((string) $_POST['date']),
            (int) $_POST['homeTeamId'],
            (int) $_POST['visitorTeamId'],
            (int) $_POST['locationId'],
        );
        redirectWithMessage('Dodano mecz do terminarza.');
    }

    if ($action === 'update_result') {
        updateGameResult(
            (int) $_POST['gameId'],
            (int) $_POST['homeScore'],
            (int) $_POST['visitorScore'],
        );
        redirectWithMessage('Zaktualizowano wynik meczu.');
    }

    if ($action === 'add_goal') {
        addGoal(
            (int) $_POST['gameId'],
            (int) $_POST['teamId'],
            (int) $_POST['playerId'],
            (int) $_POST['minute'],
            trim((string) $_POST['type']),
        );
        redirectWithMessage('Zarejestrowano bramkę.');
    }
}
