<?php
declare(strict_types=1);

const STORAGE_PATH = __DIR__ . '/../../data/league.json';

function pl(string $value): string
{
    return html_entity_decode($value, ENT_QUOTES, 'UTF-8');
}

function seedData(): array
{
    $teams = [
        1 => ['id' => 1, 'name' => pl('Orze&#322; Warszawa'), 'city' => 'Warszawa', 'coach' => 'Anna Nowak', 'color' => '#0f766e'],
        2 => ['id' => 2, 'name' => pl('Wis&#322;a Krak&#243;w'), 'city' => pl('Krak&#243;w'), 'coach' => pl('Piotr Zieli&#324;ski'), 'color' => '#4f46e5'],
        3 => ['id' => 3, 'name' => pl('Ba&#322;tyk Gda&#324;sk'), 'city' => pl('Gda&#324;sk'), 'coach' => 'Marta Lewandowska', 'color' => '#d97706'],
        4 => ['id' => 4, 'name' => pl('&#346;l&#261;sk Wroc&#322;aw'), 'city' => pl('Wroc&#322;aw'), 'coach' => 'Tomasz Wolski', 'color' => '#be123c'],
        5 => ['id' => 5, 'name' => pl('Warta Pozna&#324;'), 'city' => pl('Pozna&#324;'), 'coach' => 'Ewa Zielona', 'color' => '#2563eb'],
        6 => ['id' => 6, 'name' => pl('&#321;KS &#321;&#243;d&#378;'), 'city' => pl('&#321;&#243;d&#378;'), 'coach' => pl('Micha&#322; Sadowski'), 'color' => '#db2777'],
        7 => ['id' => 7, 'name' => pl('G&#243;rnik Katowice'), 'city' => 'Katowice', 'coach' => 'Karol Rutkowski', 'color' => '#16a34a'],
        8 => ['id' => 8, 'name' => 'Motor Lublin', 'city' => 'Lublin', 'coach' => 'Natalia Maj', 'color' => '#0891b2'],
        9 => ['id' => 9, 'name' => pl('Pogo&#324; Szczecin'), 'city' => 'Szczecin', 'coach' => pl('Robert G&#243;rski'), 'color' => '#9333ea'],
        10 => ['id' => 10, 'name' => pl('Jagiellonia Bia&#322;ystok'), 'city' => pl('Bia&#322;ystok'), 'coach' => 'Kinga Urban', 'color' => '#ea580c']
    ];

    $firstNames = [
        'Adam', 'Bartosz', 'Cezary', 'Dawid', 'Emil', 'Filip', 'Grzegorz', 'Hubert', 'Igor', 'Jakub', 'Kamil',
        pl('&#321;ukasz'), 'Marek', 'Norbert', 'Oskar', 'Patryk', pl('Rafa&#322;'), 'Szymon', 'Tomasz', 'Wiktor', 'Jan', 'Mateusz'
    ];
    $lastNames = [
        'Kowal', 'Lis', 'Mazur', 'Wrona', 'Baran', 'Cichy', 'Krawczyk', 'Malinowski', 'Nowicki', 'Pawlak',
        'Sikora', 'Wolski', 'Kaczmarek', 'Grabowski', 'Duda', 'Kubiak', 'Majewski', 'Rutkowski', 'Urban',
        pl('G&#243;rski'), 'Zalewski', 'Sadowski'
    ];
    $positions = [
        'Bramkarz', 'Bramkarz',
        pl('Obro&#324;ca'), pl('Obro&#324;ca'), pl('Obro&#324;ca'), pl('Obro&#324;ca'), pl('Obro&#324;ca'), pl('Obro&#324;ca'), pl('Obro&#324;ca'),
        'Pomocnik', 'Pomocnik', 'Pomocnik', 'Pomocnik', 'Pomocnik', 'Pomocnik', 'Pomocnik', 'Pomocnik',
        'Napastnik', 'Napastnik', 'Napastnik', 'Napastnik', 'Napastnik'
    ];

    $players = [];
    $playerId = 1;
    foreach ($teams as $teamId => $team) {
        for ($slot = 0; $slot < 22; $slot++) {
            $players[] = [
                'id' => $playerId,
                'teamId' => $teamId,
                'name' => $firstNames[$slot] . ' ' . $lastNames[($slot + $teamId - 1) % count($lastNames)],
                'position' => $positions[$slot]
            ];
            $playerId++;
        }
    }

    $games = [
        ['id' => 1, 'name' => 'Mecz 1', 'date' => '2026-05-18 18:00', 'homeTeamId' => 1, 'visitorTeamId' => 2, 'locationId' => 1, 'homeScore' => 3, 'visitorScore' => 1],
        ['id' => 2, 'name' => 'Mecz 2', 'date' => '2026-05-19 19:30', 'homeTeamId' => 3, 'visitorTeamId' => 4, 'locationId' => 2, 'homeScore' => 2, 'visitorScore' => 2],
        ['id' => 3, 'name' => 'Mecz 3', 'date' => '2026-05-20 18:45', 'homeTeamId' => 5, 'visitorTeamId' => 6, 'locationId' => 3, 'homeScore' => 1, 'visitorScore' => 0],
        ['id' => 4, 'name' => 'Mecz 4', 'date' => '2026-05-21 17:00', 'homeTeamId' => 7, 'visitorTeamId' => 8, 'locationId' => 1, 'homeScore' => 2, 'visitorScore' => 3],
        ['id' => 5, 'name' => 'Mecz 5', 'date' => '2026-05-22 20:00', 'homeTeamId' => 9, 'visitorTeamId' => 10, 'locationId' => 2, 'homeScore' => 0, 'visitorScore' => 2],
        ['id' => 6, 'name' => 'Mecz 6', 'date' => '2026-05-24 18:00', 'homeTeamId' => 1, 'visitorTeamId' => 3, 'locationId' => 3, 'homeScore' => 1, 'visitorScore' => 1],
        ['id' => 7, 'name' => 'Mecz 7', 'date' => '2026-05-25 18:30', 'homeTeamId' => 2, 'visitorTeamId' => 5, 'locationId' => 1, 'homeScore' => 2, 'visitorScore' => 0],
        ['id' => 8, 'name' => 'Mecz 8', 'date' => '2026-05-26 19:00', 'homeTeamId' => 4, 'visitorTeamId' => 6, 'locationId' => 2, 'homeScore' => 1, 'visitorScore' => 3],
        ['id' => 9, 'name' => 'Mecz 9', 'date' => '2026-05-27 19:30', 'homeTeamId' => 8, 'visitorTeamId' => 10, 'locationId' => 3, 'homeScore' => 2, 'visitorScore' => 2],
        ['id' => 10, 'name' => 'Mecz 10', 'date' => '2026-05-28 18:15', 'homeTeamId' => 7, 'visitorTeamId' => 9, 'locationId' => 1, 'homeScore' => 1, 'visitorScore' => 4],
        ['id' => 11, 'name' => 'Mecz 11', 'date' => '2026-05-30 18:00', 'homeTeamId' => 1, 'visitorTeamId' => 4, 'locationId' => 2, 'homeScore' => 2, 'visitorScore' => 0],
        ['id' => 12, 'name' => 'Mecz 12', 'date' => '2026-05-31 16:30', 'homeTeamId' => 2, 'visitorTeamId' => 6, 'locationId' => 3, 'homeScore' => 1, 'visitorScore' => 1],
        ['id' => 13, 'name' => 'Mecz 13', 'date' => '2026-06-01 19:00', 'homeTeamId' => 3, 'visitorTeamId' => 8, 'locationId' => 1, 'homeScore' => 0, 'visitorScore' => 2],
        ['id' => 14, 'name' => 'Mecz 14', 'date' => '2026-06-02 18:30', 'homeTeamId' => 5, 'visitorTeamId' => 9, 'locationId' => 2, 'homeScore' => 3, 'visitorScore' => 2],
        ['id' => 15, 'name' => 'Mecz 15', 'date' => '2026-06-03 20:00', 'homeTeamId' => 10, 'visitorTeamId' => 7, 'locationId' => 3, 'homeScore' => 2, 'visitorScore' => 1],
        ['id' => 16, 'name' => 'Mecz 16', 'date' => '2026-06-05 18:00', 'homeTeamId' => 6, 'visitorTeamId' => 1, 'locationId' => 1, 'homeScore' => 0, 'visitorScore' => 3],
        ['id' => 17, 'name' => 'Mecz 17', 'date' => '2026-06-06 17:30', 'homeTeamId' => 4, 'visitorTeamId' => 2, 'locationId' => 2, 'homeScore' => 1, 'visitorScore' => 2],
        ['id' => 18, 'name' => 'Mecz 18', 'date' => '2026-06-07 18:45', 'homeTeamId' => 8, 'visitorTeamId' => 5, 'locationId' => 3, 'homeScore' => 2, 'visitorScore' => 0],
        ['id' => 19, 'name' => 'Mecz 19', 'date' => '2026-06-08 19:15', 'homeTeamId' => 9, 'visitorTeamId' => 3, 'locationId' => 1, 'homeScore' => 1, 'visitorScore' => 1],
        ['id' => 20, 'name' => 'Mecz 20', 'date' => '2026-06-09 20:00', 'homeTeamId' => 10, 'visitorTeamId' => 1, 'locationId' => 2, 'homeScore' => 2, 'visitorScore' => 2],
        ['id' => 21, 'name' => 'Mecz 21', 'date' => '2026-06-11 18:00', 'homeTeamId' => 2, 'visitorTeamId' => 8, 'locationId' => 3, 'homeScore' => 3, 'visitorScore' => 0],
        ['id' => 22, 'name' => 'Mecz 22', 'date' => '2026-06-12 19:00', 'homeTeamId' => 3, 'visitorTeamId' => 7, 'locationId' => 1, 'homeScore' => 2, 'visitorScore' => 1],
        ['id' => 23, 'name' => 'Mecz 23', 'date' => '2026-06-13 16:00', 'homeTeamId' => 4, 'visitorTeamId' => 9, 'locationId' => 2, 'homeScore' => 0, 'visitorScore' => 0],
        ['id' => 24, 'name' => 'Mecz 24', 'date' => '2026-06-14 18:30', 'homeTeamId' => 5, 'visitorTeamId' => 10, 'locationId' => 3, 'homeScore' => 1, 'visitorScore' => 3],
        ['id' => 25, 'name' => 'Mecz 25', 'date' => '2026-06-15 20:00', 'homeTeamId' => 6, 'visitorTeamId' => 7, 'locationId' => 1, 'homeScore' => 2, 'visitorScore' => 2],
        ['id' => 26, 'name' => 'Mecz 26', 'date' => '2026-06-18 18:00', 'homeTeamId' => 1, 'visitorTeamId' => 5, 'locationId' => 2, 'homeScore' => null, 'visitorScore' => null],
        ['id' => 27, 'name' => 'Mecz 27', 'date' => '2026-06-19 19:30', 'homeTeamId' => 2, 'visitorTeamId' => 9, 'locationId' => 3, 'homeScore' => null, 'visitorScore' => null],
        ['id' => 28, 'name' => 'Mecz 28', 'date' => '2026-06-20 17:00', 'homeTeamId' => 3, 'visitorTeamId' => 10, 'locationId' => 1, 'homeScore' => null, 'visitorScore' => null],
        ['id' => 29, 'name' => 'Mecz 29', 'date' => '2026-06-21 18:30', 'homeTeamId' => 4, 'visitorTeamId' => 8, 'locationId' => 2, 'homeScore' => null, 'visitorScore' => null],
        ['id' => 30, 'name' => 'Mecz 30', 'date' => '2026-06-22 20:00', 'homeTeamId' => 6, 'visitorTeamId' => 10, 'locationId' => 3, 'homeScore' => null, 'visitorScore' => null]
    ];

    return [
        'league' => [
            'name' => 'Liga Akademicka',
            'season' => '2025/2026',
            'schedule' => 'Runda wiosenna'
        ],
        'teams' => $teams,
        'players' => $players,
        'locations' => [
            1 => ['id' => 1, 'name' => 'Stadion Miejski', 'timezone' => 'Europe/Warsaw'],
            2 => ['id' => 2, 'name' => pl('Arena Po&#322;udnie'), 'timezone' => 'Europe/Warsaw'],
            3 => ['id' => 3, 'name' => 'Boisko Akademickie', 'timezone' => 'Europe/Warsaw']
        ],
        'games' => $games,
        'goals' => buildSeedGoals($games)
    ];
}

function buildSeedGoals(array $games): array
{
    $goals = [];
    $minutes = [8, 17, 29, 38, 51, 64, 73, 84];

    foreach ($games as $game) {
        if ($game['homeScore'] === null || $game['visitorScore'] === null) {
            continue;
        }

        for ($i = 0; $i < (int) $game['homeScore']; $i++) {
            $goals[] = [
                'gameId' => (int) $game['id'],
                'teamId' => (int) $game['homeTeamId'],
                'playerId' => seedPlayerId((int) $game['homeTeamId'], 18 + ($i % 5)),
                'minute' => $minutes[$i % count($minutes)],
                'type' => $i === 1 ? 'rzut wolny' : 'z gry'
            ];
        }

        for ($i = 0; $i < (int) $game['visitorScore']; $i++) {
            $goals[] = [
                'gameId' => (int) $game['id'],
                'teamId' => (int) $game['visitorTeamId'],
                'playerId' => seedPlayerId((int) $game['visitorTeamId'], 18 + ($i % 5)),
                'minute' => $minutes[((int) $game['homeScore'] + $i) % count($minutes)],
                'type' => $i === 0 ? 'z gry' : 'karny'
            ];
        }
    }

    return $goals;
}

function seedPlayerId(int $teamId, int $squadNumber): int
{
    return (($teamId - 1) * 22) + $squadNumber;
}

function databaseConfigured(): bool
{
    return appConfig('SUPABASE_DB_DSN') !== null
        && appConfig('SUPABASE_DB_USER') !== null
        && appConfig('SUPABASE_DB_PASSWORD') !== null;
}

function database(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $pdo = new PDO(
        (string) appConfig('SUPABASE_DB_DSN'),
        (string) appConfig('SUPABASE_DB_USER'),
        (string) appConfig('SUPABASE_DB_PASSWORD'),
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    return $pdo;
}

function ensureDatabaseSchema(PDO $pdo): void
{
    static $ready = false;

    if ($ready) {
        return;
    }

    foreach (databaseSchemaStatements() as $statement) {
        $pdo->exec($statement);
    }

    $ready = true;
}

function databaseSchemaStatements(): array
{
    return [
        'create table if not exists app_league_settings (id integer primary key default 1, name text not null, season text not null, schedule text not null, constraint app_league_settings_single_row check (id = 1))',
        'create table if not exists app_teams (id integer primary key, name text not null, city text not null, coach text not null, color text not null)',
        'create table if not exists app_players (id integer primary key, team_id integer not null references app_teams(id) on delete cascade, name text not null, position text not null)',
        'create table if not exists app_locations (id integer primary key, name text not null, timezone text not null)',
        'create table if not exists app_games (id integer primary key, name text not null, game_date text not null, home_team_id integer not null references app_teams(id) on delete cascade, visitor_team_id integer not null references app_teams(id) on delete cascade, location_id integer not null references app_locations(id) on delete cascade, home_score integer null, visitor_score integer null)',
        'create table if not exists app_goals (id bigserial primary key, game_id integer not null references app_games(id) on delete cascade, team_id integer not null references app_teams(id) on delete cascade, player_id integer not null references app_players(id) on delete cascade, minute integer not null, type text not null)'
    ];
}

function loadData(): array
{
    if (databaseConfigured()) {
        return loadDataFromDatabase(database());
    }

    $seed = seedData();
    if (!is_file(STORAGE_PATH)) {
        saveDataToJson($seed);

        return $seed;
    }

    $decoded = json_decode((string) file_get_contents(STORAGE_PATH), true);

    return is_array($decoded) ? array_replace_recursive($seed, $decoded) : $seed;
}

function loadDataFromDatabase(PDO $pdo): array
{
    ensureDatabaseSchema($pdo);

    if ((int) $pdo->query('select count(*) from app_league_settings')->fetchColumn() === 0) {
        saveDataToDatabase($pdo, seedData());
    }

    $league = $pdo->query('select name, season, schedule from app_league_settings where id = 1')->fetch() ?: seedData()['league'];

    return [
        'league' => $league,
        'teams' => fetchTableMap($pdo, 'app_teams'),
        'players' => fetchPlayers($pdo),
        'locations' => fetchTableMap($pdo, 'app_locations'),
        'games' => fetchGames($pdo),
        'goals' => fetchGoals($pdo)
    ];
}

function fetchTableMap(PDO $pdo, string $table): array
{
    $items = [];
    foreach ($pdo->query("select * from {$table} order by id") as $row) {
        $row['id'] = (int) $row['id'];
        $items[$row['id']] = $row;
    }

    return $items;
}

function fetchPlayers(PDO $pdo): array
{
    $players = [];
    foreach ($pdo->query('select id, team_id, name, position from app_players order by team_id, id') as $row) {
        $players[] = [
            'id' => (int) $row['id'],
            'teamId' => (int) $row['team_id'],
            'name' => $row['name'],
            'position' => $row['position']
        ];
    }

    return $players;
}

function fetchGames(PDO $pdo): array
{
    $games = [];
    $sql = 'select id, name, game_date, home_team_id, visitor_team_id, location_id, home_score, visitor_score from app_games order by game_date, id';

    foreach ($pdo->query($sql) as $row) {
        $games[] = [
            'id' => (int) $row['id'],
            'name' => $row['name'],
            'date' => $row['game_date'],
            'homeTeamId' => (int) $row['home_team_id'],
            'visitorTeamId' => (int) $row['visitor_team_id'],
            'locationId' => (int) $row['location_id'],
            'homeScore' => $row['home_score'] === null ? null : (int) $row['home_score'],
            'visitorScore' => $row['visitor_score'] === null ? null : (int) $row['visitor_score']
        ];
    }

    return $games;
}

function fetchGoals(PDO $pdo): array
{
    $goals = [];
    foreach ($pdo->query('select game_id, team_id, player_id, minute, type from app_goals order by game_id, minute, id') as $row) {
        $goals[] = [
            'gameId' => (int) $row['game_id'],
            'teamId' => (int) $row['team_id'],
            'playerId' => (int) $row['player_id'],
            'minute' => (int) $row['minute'],
            'type' => $row['type']
        ];
    }

    return $goals;
}

function saveData(array $data): void
{
    if (databaseConfigured()) {
        saveDataToDatabase(database(), $data);

        return;
    }

    saveDataToJson($data);
}

function saveDataToJson(array $data): void
{
    $directory = dirname(STORAGE_PATH);
    if (!is_dir($directory)) {
        mkdir($directory, 0775, true);
    }

    file_put_contents(STORAGE_PATH, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function saveDataToDatabase(PDO $pdo, array $data): void
{
    ensureDatabaseSchema($pdo);
    $pdo->beginTransaction();

    try {
        $pdo->exec('delete from app_goals');
        $pdo->exec('delete from app_games');
        $pdo->exec('delete from app_players');
        $pdo->exec('delete from app_locations');
        $pdo->exec('delete from app_teams');
        $pdo->exec('delete from app_league_settings');

        $statement = $pdo->prepare('insert into app_league_settings (id, name, season, schedule) values (1, :name, :season, :schedule)');
        $statement->execute($data['league']);

        $statement = $pdo->prepare('insert into app_teams (id, name, city, coach, color) values (:id, :name, :city, :coach, :color)');
        foreach ($data['teams'] as $team) {
            $statement->execute([
                'id' => (int) $team['id'],
                'name' => $team['name'],
                'city' => $team['city'],
                'coach' => $team['coach'],
                'color' => $team['color'] ?? '#0f766e'
            ]);
        }

        $statement = $pdo->prepare('insert into app_locations (id, name, timezone) values (:id, :name, :timezone)');
        foreach ($data['locations'] as $location) {
            $statement->execute($location);
        }

        $statement = $pdo->prepare('insert into app_players (id, team_id, name, position) values (:id, :teamId, :name, :position)');
        foreach ($data['players'] as $player) {
            $statement->execute($player);
        }

        $statement = $pdo->prepare('insert into app_games (id, name, game_date, home_team_id, visitor_team_id, location_id, home_score, visitor_score) values (:id, :name, :date, :homeTeamId, :visitorTeamId, :locationId, :homeScore, :visitorScore)');
        foreach ($data['games'] as $game) {
            $statement->execute($game);
        }

        $statement = $pdo->prepare('insert into app_goals (game_id, team_id, player_id, minute, type) values (:gameId, :teamId, :playerId, :minute, :type)');
        foreach ($data['goals'] as $goal) {
            $statement->execute($goal);
        }

        $pdo->commit();
    } catch (Throwable $exception) {
        $pdo->rollBack();
        throw $exception;
    }
}

function nextId(array $items): int
{
    $ids = array_column($items, 'id');

    return $ids === [] ? 1 : max($ids) + 1;
}

function addTeam(string $name, string $city, string $coach, string $color): void
{
    $data = loadData();
    $id = nextId($data['teams']);
    $data['teams'][$id] = [
        'id' => $id,
        'name' => $name,
        'city' => $city,
        'coach' => $coach,
        'color' => $color !== '' ? $color : '#0f766e'
    ];
    saveData($data);
}

function addPlayer(int $teamId, string $name, string $position): void
{
    $data = loadData();
    $data['players'][] = [
        'id' => nextId($data['players']),
        'teamId' => $teamId,
        'name' => $name,
        'position' => $position
    ];
    saveData($data);
}

function addGame(string $date, int $homeTeamId, int $visitorTeamId, int $locationId): void
{
    $data = loadData();
    $id = nextId($data['games']);
    $data['games'][] = [
        'id' => $id,
        'name' => 'Mecz ' . $id,
        'date' => $date,
        'homeTeamId' => $homeTeamId,
        'visitorTeamId' => $visitorTeamId,
        'locationId' => $locationId,
        'homeScore' => null,
        'visitorScore' => null
    ];
    saveData($data);
}

function updateGameResult(int $gameId, int $homeScore, int $visitorScore): void
{
    $data = loadData();
    foreach ($data['games'] as &$game) {
        if ((int) $game['id'] === $gameId) {
            $game['homeScore'] = max(0, $homeScore);
            $game['visitorScore'] = max(0, $visitorScore);
            break;
        }
    }
    unset($game);
    saveData($data);
}

function addGoal(int $gameId, int $teamId, int $playerId, int $minute, string $type): void
{
    $data = loadData();
    $data['goals'][] = [
        'gameId' => $gameId,
        'teamId' => $teamId,
        'playerId' => $playerId,
        'minute' => max(1, min(130, $minute)),
        'type' => $type
    ];
    saveData($data);
}

function resetDemoData(): void
{
    saveData(seedData());
}
