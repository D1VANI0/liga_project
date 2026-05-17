<?php
declare(strict_types=1);

function seedData(): array
{
    $teams = [
        1 => ['id' => 1, 'name' => 'Orzeł Warszawa', 'city' => 'Warszawa', 'coach' => 'Anna Nowak', 'color' => '#0f766e'],
        2 => ['id' => 2, 'name' => 'Wisła Kraków', 'city' => 'Kraków', 'coach' => 'Piotr Zieliński', 'color' => '#4f46e5'],
        3 => ['id' => 3, 'name' => 'Bałtyk Gdańsk', 'city' => 'Gdańsk', 'coach' => 'Marta Lewandowska', 'color' => '#d97706'],
        4 => ['id' => 4, 'name' => 'Śląsk Wrocław', 'city' => 'Wrocław', 'coach' => 'Tomasz Wolski', 'color' => '#be123c'],
        5 => ['id' => 5, 'name' => 'Warta Poznań', 'city' => 'Poznań', 'coach' => 'Ewa Zielona', 'color' => '#2563eb'],
        6 => ['id' => 6, 'name' => 'ŁKS Łódź', 'city' => 'Łódź', 'coach' => 'Michał Sadowski', 'color' => '#db2777'],
        7 => ['id' => 7, 'name' => 'Górnik Katowice', 'city' => 'Katowice', 'coach' => 'Karol Rutkowski', 'color' => '#16a34a'],
        8 => ['id' => 8, 'name' => 'Motor Lublin', 'city' => 'Lublin', 'coach' => 'Natalia Maj', 'color' => '#0891b2'],
        9 => ['id' => 9, 'name' => 'Pogoń Szczecin', 'city' => 'Szczecin', 'coach' => 'Robert Górski', 'color' => '#9333ea'],
        10 => ['id' => 10, 'name' => 'Jagiellonia Białystok', 'city' => 'Białystok', 'coach' => 'Kinga Urban', 'color' => '#ea580c'],
    ];

    $firstNames = [
        'Adam', 'Bartosz', 'Cezary', 'Dawid', 'Emil', 'Filip', 'Grzegorz', 'Hubert', 'Igor', 'Jakub', 'Kamil',
        'Łukasz', 'Marek', 'Norbert', 'Oskar', 'Patryk', 'Rafał', 'Szymon', 'Tomasz', 'Wiktor', 'Jan', 'Mateusz',
    ];
    $lastNames = [
        'Kowal', 'Lis', 'Mazur', 'Wrona', 'Baran', 'Cichy', 'Krawczyk', 'Malinowski', 'Nowicki', 'Pawlak',
        'Sikora', 'Wolski', 'Kaczmarek', 'Grabowski', 'Duda', 'Kubiak', 'Majewski', 'Rutkowski', 'Urban',
        'Górski', 'Zalewski', 'Sadowski',
    ];
    $positions = [
        'Bramkarz', 'Bramkarz',
        'Obrońca', 'Obrońca', 'Obrońca', 'Obrońca', 'Obrońca', 'Obrońca', 'Obrońca',
        'Pomocnik', 'Pomocnik', 'Pomocnik', 'Pomocnik', 'Pomocnik', 'Pomocnik', 'Pomocnik', 'Pomocnik',
        'Napastnik', 'Napastnik', 'Napastnik', 'Napastnik', 'Napastnik',
    ];

    $players = [];
    $playerId = 1;
    foreach ($teams as $teamId => $team) {
        for ($slot = 0; $slot < 22; $slot++) {
            $players[] = [
                'id' => $playerId,
                'teamId' => $teamId,
                'name' => $firstNames[$slot] . ' ' . $lastNames[($slot + $teamId - 1) % count($lastNames)],
                'position' => $positions[$slot],
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
        ['id' => 9, 'name' => 'Mecz 9', 'date' => '2026-05-27 19:30', 'homeTeamId' => 8, 'visitorTeamId' => 10, 'locationId' => 3, 'homeScore' => null, 'visitorScore' => null],
        ['id' => 10, 'name' => 'Mecz 10', 'date' => '2026-05-28 18:15', 'homeTeamId' => 7, 'visitorTeamId' => 9, 'locationId' => 1, 'homeScore' => null, 'visitorScore' => null],
    ];

    $goals = buildSeedGoals($games);

    return [
        'league' => [
            'name' => 'Liga Akademicka',
            'season' => '2025/2026',
            'schedule' => 'Runda wiosenna',
        ],
        'teams' => $teams,
        'players' => $players,
        'locations' => [
            1 => ['id' => 1, 'name' => 'Stadion Miejski', 'timezone' => 'Europe/Warsaw'],
            2 => ['id' => 2, 'name' => 'Arena Poludnie', 'timezone' => 'Europe/Warsaw'],
            3 => ['id' => 3, 'name' => 'Boisko Akademickie', 'timezone' => 'Europe/Warsaw'],
        ],
        'games' => $games,
        'goals' => $goals,
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
                'type' => $i === 1 ? 'rzut wolny' : 'z gry',
            ];
        }

        for ($i = 0; $i < (int) $game['visitorScore']; $i++) {
            $goals[] = [
                'gameId' => (int) $game['id'],
                'teamId' => (int) $game['visitorTeamId'],
                'playerId' => seedPlayerId((int) $game['visitorTeamId'], 18 + ($i % 5)),
                'minute' => $minutes[(int) $game['homeScore'] + $i % count($minutes)],
                'type' => $i === 0 ? 'z gry' : 'karny',
            ];
        }
    }

    return $goals;
}

function seedPlayerId(int $teamId, int $squadNumber): int
{
    return (($teamId - 1) * 22) + $squadNumber;
}

function loadData(): array
{
    ensureDatabaseReady();
    seedDatabaseIfEmpty();

    $league = dbRow('select name, season, schedule from leagues order by id limit 1');

    return [
        'league' => $league ?? seedData()['league'],
        'teams' => fetchTeams(),
        'players' => fetchPlayers(),
        'locations' => fetchLocations(),
        'games' => fetchGames(),
        'goals' => fetchGoals(),
    ];
}

function fetchTeams(): array
{
    $teams = [];

    foreach (dbRows('select id, name, city, coach, color from teams order by id') as $row) {
        $team = [
            'id' => (int) $row['id'],
            'name' => $row['name'],
            'city' => $row['city'],
            'coach' => $row['coach'],
            'color' => $row['color'],
        ];
        $teams[$team['id']] = $team;
    }

    return $teams;
}

function fetchPlayers(): array
{
    $players = [];

    foreach (dbRows('select id, team_id as "teamId", name, position from players order by team_id, id') as $row) {
        $players[] = [
            'id' => (int) $row['id'],
            'teamId' => (int) $row['teamId'],
            'name' => $row['name'],
            'position' => $row['position'],
        ];
    }

    return $players;
}

function fetchLocations(): array
{
    $locations = [];

    foreach (dbRows('select id, name, timezone from locations order by id') as $row) {
        $location = [
            'id' => (int) $row['id'],
            'name' => $row['name'],
            'timezone' => $row['timezone'],
        ];
        $locations[$location['id']] = $location;
    }

    return $locations;
}

function fetchGames(): array
{
    $games = [];

    $sql = <<<'SQL'
        select
            id,
            name,
            to_char(date, 'YYYY-MM-DD HH24:MI') as date,
            home_team_id as "homeTeamId",
            visitor_team_id as "visitorTeamId",
            location_id as "locationId",
            home_score as "homeScore",
            visitor_score as "visitorScore"
        from games
        order by date, id
    SQL;

    foreach (dbRows($sql) as $row) {
        $games[] = [
            'id' => (int) $row['id'],
            'name' => $row['name'],
            'date' => $row['date'],
            'homeTeamId' => (int) $row['homeTeamId'],
            'visitorTeamId' => (int) $row['visitorTeamId'],
            'locationId' => (int) $row['locationId'],
            'homeScore' => $row['homeScore'] === null ? null : (int) $row['homeScore'],
            'visitorScore' => $row['visitorScore'] === null ? null : (int) $row['visitorScore'],
        ];
    }

    return $games;
}

function fetchGoals(): array
{
    $goals = [];

    $sql = <<<'SQL'
        select
            game_id as "gameId",
            team_id as "teamId",
            player_id as "playerId",
            minute,
            type
        from goals
        order by game_id, minute, id
    SQL;

    foreach (dbRows($sql) as $row) {
        $goals[] = [
            'gameId' => (int) $row['gameId'],
            'teamId' => (int) $row['teamId'],
            'playerId' => (int) $row['playerId'],
            'minute' => (int) $row['minute'],
            'type' => $row['type'],
        ];
    }

    return $goals;
}

function addTeam(string $name, string $city, string $coach, string $color): void
{
    dbExecute(
        'insert into teams (name, city, coach, color) values (:name, :city, :coach, :color)',
        [
            'name' => $name,
            'city' => $city,
            'coach' => $coach,
            'color' => $color !== '' ? $color : '#0f766e',
        ],
    );
}

function addPlayer(int $teamId, string $name, string $position): void
{
    dbExecute(
        'insert into players (team_id, name, position) values (:team_id, :name, :position)',
        [
            'team_id' => $teamId,
            'name' => $name,
            'position' => $position,
        ],
    );
}

function addGame(string $date, int $homeTeamId, int $visitorTeamId, int $locationId): void
{
    $row = dbRow(
        'insert into games (name, date, home_team_id, visitor_team_id, location_id) values (:name, :date, :home_team_id, :visitor_team_id, :location_id) returning id',
        [
            'name' => 'Nowy mecz',
            'date' => $date,
            'home_team_id' => $homeTeamId,
            'visitor_team_id' => $visitorTeamId,
            'location_id' => $locationId,
        ],
    );

    $id = (int) ($row['id'] ?? 0);
    if ($id > 0) {
        dbExecute('update games set name = :name where id = :id', ['name' => 'Mecz ' . $id, 'id' => $id]);
    }
}

function updateGameResult(int $gameId, int $homeScore, int $visitorScore): void
{
    dbExecute(
        'update games set home_score = :home_score, visitor_score = :visitor_score where id = :id',
        [
            'id' => $gameId,
            'home_score' => max(0, $homeScore),
            'visitor_score' => max(0, $visitorScore),
        ],
    );
}

function addGoal(int $gameId, int $teamId, int $playerId, int $minute, string $type): void
{
    dbExecute(
        'insert into goals (game_id, team_id, player_id, minute, type) values (:game_id, :team_id, :player_id, :minute, :type)',
        [
            'game_id' => $gameId,
            'team_id' => $teamId,
            'player_id' => $playerId,
            'minute' => max(1, min(130, $minute)),
            'type' => $type,
        ],
    );
}

function resetDemoData(): void
{
    ensureDatabaseReady();

    $seed = seedData();
    $pdo = db();
    $pdo->beginTransaction();

    try {
        $pdo->exec('truncate table goals, games, players, teams, locations, leagues restart identity cascade');

        dbExecute(
            'insert into leagues (id, name, season, schedule) values (1, :name, :season, :schedule)',
            $seed['league'],
        );

        foreach ($seed['teams'] as $team) {
            dbExecute(
                'insert into teams (id, name, city, coach, color) values (:id, :name, :city, :coach, :color)',
                $team,
            );
        }

        foreach ($seed['locations'] as $location) {
            dbExecute(
                'insert into locations (id, name, timezone) values (:id, :name, :timezone)',
                $location,
            );
        }

        foreach ($seed['players'] as $player) {
            dbExecute(
                'insert into players (id, team_id, name, position) values (:id, :teamId, :name, :position)',
                $player,
            );
        }

        foreach ($seed['games'] as $game) {
            dbExecute(
                'insert into games (id, name, date, home_team_id, visitor_team_id, location_id, home_score, visitor_score) values (:id, :name, :date, :homeTeamId, :visitorTeamId, :locationId, :homeScore, :visitorScore)',
                $game,
            );
        }

        foreach ($seed['goals'] as $goal) {
            addGoal((int) $goal['gameId'], (int) $goal['teamId'], (int) $goal['playerId'], (int) $goal['minute'], $goal['type']);
        }

        syncIdentitySequences();
        $pdo->commit();
    } catch (Throwable $exception) {
        $pdo->rollBack();
        throw $exception;
    }
}

function syncIdentitySequences(): void
{
    foreach (['leagues', 'teams', 'locations', 'players', 'games', 'goals'] as $table) {
        db()->exec(
            "select setval(pg_get_serial_sequence('{$table}', 'id'), coalesce((select max(id) from {$table}), 1), true)",
        );
    }
}

function ensureDatabaseReady(): void
{
    $requiredTables = ['leagues', 'teams', 'locations', 'players', 'games', 'goals'];
    $placeholders = implode(', ', array_fill(0, count($requiredTables), '?'));
    $rows = dbRows(
        "select table_name from information_schema.tables where table_schema = 'public' and table_name in ($placeholders)",
        $requiredTables,
    );
    $existingTables = array_column($rows, 'table_name');
    $missingTables = array_values(array_diff($requiredTables, $existingTables));

    if ($missingTables !== []) {
        throw new RuntimeException('Brakuje tabel w Supabase: ' . implode(', ', $missingTables) . '. Uruchom SQL z pliku database/schema.sql.');
    }

    $requiredViews = ['standings_view', 'scorers_view'];
    $viewPlaceholders = implode(', ', array_fill(0, count($requiredViews), '?'));
    $viewRows = dbRows(
        "select table_name from information_schema.views where table_schema = 'public' and table_name in ($viewPlaceholders)",
        $requiredViews,
    );
    $existingViews = array_column($viewRows, 'table_name');
    $missingViews = array_values(array_diff($requiredViews, $existingViews));

    if ($missingViews !== []) {
        throw new RuntimeException('Brakuje widoków w Supabase: ' . implode(', ', $missingViews) . '. Uruchom SQL z pliku database/schema.sql.');
    }

    $functionRow = dbRow(
        "select 1 from pg_proc p join pg_namespace n on n.oid = p.pronamespace where n.nspname = 'public' and p.proname = 'best_player_against_team' limit 1",
    );

    if ($functionRow === null) {
        throw new RuntimeException('Brakuje funkcji best_player_against_team w Supabase. Uruchom SQL z pliku database/schema.sql.');
    }
}

function seedDatabaseIfEmpty(): void
{
    $row = dbRow('select count(*) as count from leagues');
    if ((int) ($row['count'] ?? 0) === 0) {
        resetDemoData();
    }
}
