<?php
declare(strict_types=1);

const STORAGE_PATH = __DIR__ . '/../../data/league.json';

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
