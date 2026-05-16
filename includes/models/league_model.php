<?php
declare(strict_types=1);

const STORAGE_PATH = __DIR__ . '/../../data/league.json';

function seedData(): array
{
    $teams = [
        1 => ['id' => 1, 'name' => 'Azure United', 'city' => 'Warszawa', 'coach' => 'Anna Nowak', 'color' => '#0f766e'],
        2 => ['id' => 2, 'name' => 'Cloud Rangers', 'city' => 'Krakow', 'coach' => 'Piotr Zielinski', 'color' => '#4f46e5'],
        3 => ['id' => 3, 'name' => 'DevOps City', 'city' => 'Gdansk', 'coach' => 'Marta Lewandowska', 'color' => '#d97706'],
        4 => ['id' => 4, 'name' => 'Serverless FC', 'city' => 'Wroclaw', 'coach' => 'Tomasz Wolski', 'color' => '#be123c'],
        5 => ['id' => 5, 'name' => 'Data Miners', 'city' => 'Poznan', 'coach' => 'Ewa Zielona', 'color' => '#2563eb'],
        6 => ['id' => 6, 'name' => 'Frontend Stars', 'city' => 'Lodz', 'coach' => 'Michal Sadowski', 'color' => '#db2777'],
        7 => ['id' => 7, 'name' => 'Backend Wolves', 'city' => 'Katowice', 'coach' => 'Karol Rutkowski', 'color' => '#16a34a'],
        8 => ['id' => 8, 'name' => 'API Titans', 'city' => 'Lublin', 'coach' => 'Natalia Maj', 'color' => '#0891b2'],
        9 => ['id' => 9, 'name' => 'Script Rovers', 'city' => 'Szczecin', 'coach' => 'Robert Gorski', 'color' => '#9333ea'],
        10 => ['id' => 10, 'name' => 'Pixel Athletic', 'city' => 'Bialystok', 'coach' => 'Kinga Urban', 'color' => '#ea580c'],
    ];

    $firstNames = [
        'Adam', 'Bartosz', 'Cezary', 'Dawid', 'Emil', 'Filip', 'Grzegorz', 'Hubert', 'Igor', 'Jakub', 'Kamil',
        'Lukasz', 'Marek', 'Norbert', 'Oskar', 'Patryk', 'Rafal', 'Szymon', 'Tomasz', 'Wiktor', 'Jan', 'Mateusz',
    ];
    $lastNames = [
        'Kowal', 'Lis', 'Mazur', 'Wrona', 'Baran', 'Cichy', 'Krawczyk', 'Malinowski', 'Nowicki', 'Pawlak',
        'Sikora', 'Wolski', 'Kaczmarek', 'Grabowski', 'Duda', 'Kubiak', 'Majewski', 'Rutkowski', 'Urban',
        'Gorski', 'Zalewski', 'Sadowski',
    ];
    $positions = [
        'Bramkarz', 'Bramkarz',
        'Obronca', 'Obronca', 'Obronca', 'Obronca', 'Obronca', 'Obronca', 'Obronca',
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
