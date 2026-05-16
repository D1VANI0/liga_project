<?php
declare(strict_types=1);

function redirectWithMessage(string $message, string $target = 'admin.php'): never
{
    header('Location: ' . $target . '?message=' . rawurlencode($message));
    exit;
}

function handlePost(array &$data): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

    requireLogin('admin.php');

    $action = $_POST['action'] ?? '';

    if ($action === 'reset_demo') {
        $data = seedData();
        saveData($data);
        redirectWithMessage('Przywrócono dane demonstracyjne.');
    }

    if ($action === 'add_team') {
        $id = nextId($data['teams']);
        $data['teams'][$id] = [
            'id' => $id,
            'name' => trim((string) $_POST['name']),
            'city' => trim((string) $_POST['city']),
            'coach' => trim((string) $_POST['coach']),
            'color' => trim((string) ($_POST['color'] ?? '#0f766e')),
        ];
        saveData($data);
        redirectWithMessage('Dodano drużynę.');
    }

    if ($action === 'add_player') {
        $data['players'][] = [
            'id' => nextId($data['players']),
            'teamId' => (int) $_POST['teamId'],
            'name' => trim((string) $_POST['name']),
            'position' => trim((string) $_POST['position']),
        ];
        saveData($data);
        redirectWithMessage('Dodano zawodnika.');
    }

    if ($action === 'add_game') {
        $id = nextId($data['games']);
        $data['games'][] = [
            'id' => $id,
            'name' => 'Mecz ' . $id,
            'date' => trim((string) $_POST['date']),
            'homeTeamId' => (int) $_POST['homeTeamId'],
            'visitorTeamId' => (int) $_POST['visitorTeamId'],
            'locationId' => (int) $_POST['locationId'],
            'homeScore' => null,
            'visitorScore' => null,
        ];
        saveData($data);
        redirectWithMessage('Dodano mecz do terminarza.');
    }

    if ($action === 'update_result') {
        foreach ($data['games'] as &$game) {
            if ($game['id'] === (int) $_POST['gameId']) {
                $game['homeScore'] = max(0, (int) $_POST['homeScore']);
                $game['visitorScore'] = max(0, (int) $_POST['visitorScore']);
                break;
            }
        }
        unset($game);
        saveData($data);
        redirectWithMessage('Zaktualizowano wynik meczu.');
    }

    if ($action === 'add_goal') {
        $data['goals'][] = [
            'gameId' => (int) $_POST['gameId'],
            'teamId' => (int) $_POST['teamId'],
            'playerId' => (int) $_POST['playerId'],
            'minute' => max(1, min(130, (int) $_POST['minute'])),
            'type' => trim((string) $_POST['type']),
        ];
        saveData($data);
        redirectWithMessage('Zarejestrowano bramkę.');
    }
}
