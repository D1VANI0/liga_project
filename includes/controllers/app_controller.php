<?php
declare(strict_types=1);

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
        'currentUser' => currentUser(),
    ];
}
