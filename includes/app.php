<?php
declare(strict_types=1);

const STORAGE_PATH = __DIR__ . '/../data/league.json';

function seedData(): array
{
    return [
        'league' => [
            'name' => 'Liga Akademicka',
            'season' => '2025/2026',
            'schedule' => 'Runda wiosenna',
        ],
        'teams' => [
            1 => ['id' => 1, 'name' => 'Azure United', 'city' => 'Warszawa', 'coach' => 'Anna Nowak', 'color' => '#0f766e'],
            2 => ['id' => 2, 'name' => 'Cloud Rangers', 'city' => 'Krakow', 'coach' => 'Piotr Zielinski', 'color' => '#7c3aed'],
            3 => ['id' => 3, 'name' => 'DevOps City', 'city' => 'Gdansk', 'coach' => 'Marta Lewandowska', 'color' => '#b45309'],
            4 => ['id' => 4, 'name' => 'Serverless FC', 'city' => 'Wroclaw', 'coach' => 'Tomasz Wolski', 'color' => '#be123c'],
        ],
        'players' => [
            ['id' => 1, 'teamId' => 1, 'name' => 'Marek Kowal', 'position' => 'Napastnik'],
            ['id' => 2, 'teamId' => 1, 'name' => 'Igor Malinowski', 'position' => 'Pomocnik'],
            ['id' => 3, 'teamId' => 2, 'name' => 'Adam Lis', 'position' => 'Napastnik'],
            ['id' => 4, 'teamId' => 2, 'name' => 'Pawel Krawczyk', 'position' => 'Obronca'],
            ['id' => 5, 'teamId' => 3, 'name' => 'Kamil Mazur', 'position' => 'Napastnik'],
            ['id' => 6, 'teamId' => 3, 'name' => 'Dawid Wrona', 'position' => 'Bramkarz'],
            ['id' => 7, 'teamId' => 4, 'name' => 'Lukasz Cichy', 'position' => 'Napastnik'],
            ['id' => 8, 'teamId' => 4, 'name' => 'Oskar Baran', 'position' => 'Pomocnik'],
        ],
        'locations' => [
            1 => ['id' => 1, 'name' => 'Stadion Miejski', 'timezone' => 'Europe/Warsaw'],
            2 => ['id' => 2, 'name' => 'Arena Poludnie', 'timezone' => 'Europe/Warsaw'],
            3 => ['id' => 3, 'name' => 'Boisko Akademickie', 'timezone' => 'Europe/Warsaw'],
        ],
        'games' => [
            ['id' => 1, 'name' => 'Mecz 1', 'date' => '2026-05-18 18:00', 'homeTeamId' => 1, 'visitorTeamId' => 2, 'locationId' => 1, 'homeScore' => 3, 'visitorScore' => 1],
            ['id' => 2, 'name' => 'Mecz 2', 'date' => '2026-05-19 19:30', 'homeTeamId' => 3, 'visitorTeamId' => 4, 'locationId' => 2, 'homeScore' => 2, 'visitorScore' => 2],
            ['id' => 3, 'name' => 'Mecz 3', 'date' => '2026-05-22 18:45', 'homeTeamId' => 1, 'visitorTeamId' => 3, 'locationId' => 3, 'homeScore' => 1, 'visitorScore' => 1],
            ['id' => 4, 'name' => 'Mecz 4', 'date' => '2026-05-23 17:00', 'homeTeamId' => 4, 'visitorTeamId' => 2, 'locationId' => 1, 'homeScore' => 0, 'visitorScore' => 2],
            ['id' => 5, 'name' => 'Mecz 5', 'date' => '2026-05-27 20:00', 'homeTeamId' => 2, 'visitorTeamId' => 3, 'locationId' => 2, 'homeScore' => null, 'visitorScore' => null],
        ],
        'goals' => [
            ['gameId' => 1, 'teamId' => 1, 'playerId' => 1, 'minute' => 12, 'type' => 'z gry'],
            ['gameId' => 1, 'teamId' => 1, 'playerId' => 2, 'minute' => 36, 'type' => 'z gry'],
            ['gameId' => 1, 'teamId' => 2, 'playerId' => 3, 'minute' => 51, 'type' => 'karny'],
            ['gameId' => 1, 'teamId' => 1, 'playerId' => 1, 'minute' => 78, 'type' => 'z gry'],
            ['gameId' => 2, 'teamId' => 3, 'playerId' => 5, 'minute' => 9, 'type' => 'z gry'],
            ['gameId' => 2, 'teamId' => 4, 'playerId' => 7, 'minute' => 44, 'type' => 'z gry'],
            ['gameId' => 2, 'teamId' => 4, 'playerId' => 8, 'minute' => 63, 'type' => 'rzut wolny'],
            ['gameId' => 2, 'teamId' => 3, 'playerId' => 5, 'minute' => 88, 'type' => 'z gry'],
            ['gameId' => 3, 'teamId' => 1, 'playerId' => 1, 'minute' => 31, 'type' => 'z gry'],
            ['gameId' => 3, 'teamId' => 3, 'playerId' => 5, 'minute' => 70, 'type' => 'z gry'],
            ['gameId' => 4, 'teamId' => 2, 'playerId' => 3, 'minute' => 22, 'type' => 'z gry'],
            ['gameId' => 4, 'teamId' => 2, 'playerId' => 3, 'minute' => 80, 'type' => 'z gry'],
        ],
    ];
}

function h(string|int|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function saveData(array $data): void
{
    $directory = dirname(STORAGE_PATH);
    if (!is_dir($directory)) {
        mkdir($directory, 0775, true);
    }

    file_put_contents(STORAGE_PATH, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function loadData(): array
{
    $seed = seedData();
    if (!is_file(STORAGE_PATH)) {
        saveData($seed);

        return $seed;
    }

    $decoded = json_decode((string) file_get_contents(STORAGE_PATH), true);

    return is_array($decoded) ? array_replace_recursive($seed, $decoded) : $seed;
}

function nextId(array $items): int
{
    $ids = array_column($items, 'id');

    return $ids === [] ? 1 : max($ids) + 1;
}

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

    $action = $_POST['action'] ?? '';

    if ($action === 'reset_demo') {
        $data = seedData();
        saveData($data);
        redirectWithMessage('Przywrocono dane demonstracyjne.');
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
        redirectWithMessage('Dodano druzyne.');
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
        redirectWithMessage('Zarejestrowano bramke.');
    }
}

function buildStandings(array $teams, array $games): array
{
    $standings = [];

    foreach ($teams as $team) {
        $standings[(int) $team['id']] = [
            'teamId' => (int) $team['id'],
            'team' => $team['name'],
            'played' => 0,
            'wins' => 0,
            'draws' => 0,
            'losses' => 0,
            'goalsScored' => 0,
            'goalsConceded' => 0,
            'points' => 0,
        ];
    }

    foreach ($games as $game) {
        if ($game['homeScore'] === null || $game['visitorScore'] === null) {
            continue;
        }

        $homeId = (int) $game['homeTeamId'];
        $visitorId = (int) $game['visitorTeamId'];
        $homeScore = (int) $game['homeScore'];
        $visitorScore = (int) $game['visitorScore'];

        $standings[$homeId]['played']++;
        $standings[$visitorId]['played']++;
        $standings[$homeId]['goalsScored'] += $homeScore;
        $standings[$homeId]['goalsConceded'] += $visitorScore;
        $standings[$visitorId]['goalsScored'] += $visitorScore;
        $standings[$visitorId]['goalsConceded'] += $homeScore;

        if ($homeScore > $visitorScore) {
            $standings[$homeId]['wins']++;
            $standings[$visitorId]['losses']++;
            $standings[$homeId]['points'] += 3;
        } elseif ($homeScore < $visitorScore) {
            $standings[$visitorId]['wins']++;
            $standings[$homeId]['losses']++;
            $standings[$visitorId]['points'] += 3;
        } else {
            $standings[$homeId]['draws']++;
            $standings[$visitorId]['draws']++;
            $standings[$homeId]['points']++;
            $standings[$visitorId]['points']++;
        }
    }

    usort($standings, static function (array $a, array $b): int {
        $goalDiffA = $a['goalsScored'] - $a['goalsConceded'];
        $goalDiffB = $b['goalsScored'] - $b['goalsConceded'];

        return [$b['points'], $goalDiffB, $b['goalsScored'], $a['team']]
            <=> [$a['points'], $goalDiffA, $a['goalsScored'], $b['team']];
    });

    return $standings;
}

function buildScorers(array $players, array $teams, array $goals): array
{
    $playerMap = [];
    foreach ($players as $player) {
        $playerMap[(int) $player['id']] = $player;
    }

    $scorers = [];
    foreach ($goals as $goal) {
        $playerId = (int) $goal['playerId'];
        if (!isset($playerMap[$playerId])) {
            continue;
        }

        if (!isset($scorers[$playerId])) {
            $player = $playerMap[$playerId];
            $team = $teams[(int) $player['teamId']] ?? ['name' => 'Brak druzyny'];
            $scorers[$playerId] = [
                'playerId' => $playerId,
                'player' => $player['name'],
                'team' => $team['name'],
                'goals' => 0,
            ];
        }
        $scorers[$playerId]['goals']++;
    }

    usort($scorers, static fn (array $a, array $b): int => [$b['goals'], $a['player']] <=> [$a['goals'], $b['player']]);

    return $scorers;
}

function findBestPlayerAgainstTeam(array $players, array $teams, array $games, array $goals, int $opponentId): ?array
{
    $playerMap = [];
    foreach ($players as $player) {
        $playerMap[(int) $player['id']] = $player;
    }

    $gameMap = [];
    foreach ($games as $game) {
        $gameMap[(int) $game['id']] = $game;
    }

    $result = [];
    foreach ($goals as $goal) {
        $game = $gameMap[(int) $goal['gameId']] ?? null;
        if ($game === null) {
            continue;
        }

        $againstSelectedTeam = (int) $game['homeTeamId'] === $opponentId || (int) $game['visitorTeamId'] === $opponentId;
        $ownGoalForSelectedTeam = (int) $goal['teamId'] === $opponentId;

        if (!$againstSelectedTeam || $ownGoalForSelectedTeam) {
            continue;
        }

        $playerId = (int) $goal['playerId'];
        if (!isset($playerMap[$playerId])) {
            continue;
        }

        if (!isset($result[$playerId])) {
            $player = $playerMap[$playerId];
            $team = $teams[(int) $player['teamId']] ?? ['name' => 'Brak druzyny'];
            $result[$playerId] = [
                'player' => $player['name'],
                'team' => $team['name'],
                'goals' => 0,
            ];
        }
        $result[$playerId]['goals']++;
    }

    if ($result === []) {
        return null;
    }

    usort($result, static fn (array $a, array $b): int => [$b['goals'], $a['player']] <=> [$a['goals'], $b['player']]);

    return $result[0];
}

function appContext(): array
{
    $data = loadData();
    handlePost($data);

    $standings = buildStandings($data['teams'], $data['games']);
    $scorers = buildScorers($data['players'], $data['teams'], $data['goals']);
    $playedGames = array_values(array_filter($data['games'], static fn (array $game): bool => $game['homeScore'] !== null && $game['visitorScore'] !== null));
    $upcomingGames = array_values(array_filter($data['games'], static fn (array $game): bool => $game['homeScore'] === null || $game['visitorScore'] === null));

    return [
        'data' => $data,
        'league' => $data['league'],
        'teams' => $data['teams'],
        'players' => $data['players'],
        'locations' => $data['locations'],
        'games' => $data['games'],
        'goals' => $data['goals'],
        'standings' => $standings,
        'scorers' => $scorers,
        'bestTeam' => $standings[0] ?? null,
        'bestPlayer' => $scorers[0] ?? null,
        'playedGames' => $playedGames,
        'upcomingGames' => $upcomingGames,
        'flash' => isset($_GET['message']) ? (string) $_GET['message'] : null,
    ];
}

function isActive(string $file): string
{
    return basename((string) $_SERVER['SCRIPT_NAME']) === $file ? 'active' : '';
}

function renderHeader(string $title, array $context, string $subtitle = ''): void
{
    $league = $context['league'];
    $subtitle = $subtitle !== '' ? $subtitle : 'Panel SaaS przygotowany pod wdrozenie w Azure';
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
            <nav class="main-nav" aria-label="Glowne">
                <a class="<?= isActive('index.php') ?>" href="index.php">Panel</a>
                <a class="<?= isActive('standings.php') ?>" href="standings.php">Tabela</a>
                <a class="<?= isActive('matches.php') ?>" href="matches.php">Mecze</a>
                <a class="<?= isActive('teams.php') ?>" href="teams.php">Druzyny</a>
                <a class="<?= isActive('players.php') ?>" href="players.php">Zawodnicy</a>
                <a class="<?= isActive('reports.php') ?>" href="reports.php">Raporty</a>
                <a class="<?= isActive('admin.php') ?>" href="admin.php">Admin</a>
            </nav>
            <div class="deploy-card">
                <span>Cloud target</span>
                <strong>Azure App Service</strong>
                <small>JSON teraz, SQL pozniej</small>
            </div>
        </aside>
        <div class="shell">
            <header class="page-header">
                <div>
                    <p class="eyebrow"><?= h($league['schedule']) ?></p>
                    <h1><?= h($title) ?></h1>
                    <p><?= h($subtitle) ?></p>
                </div>
                <a class="primary-link" href="admin.php">Zarzadzaj liga</a>
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
                <span>Gotowy do podmiany JSON na relacyjna baze w Azure</span>
            </footer>
        </div>
    </body>
    </html>
    <?php
}
