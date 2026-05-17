<?php
declare(strict_types=1);

function appContext(): array
{
    handlePost();

    $data = loadData();
    $standings = loadStandings();
    $scorers = loadScorers();
    $playedGames = array_values(array_filter($data['games'], static fn (array $game): bool => $game['homeScore'] !== null && $game['visitorScore'] !== null));
    $upcomingGames = array_values(array_filter($data['games'], static fn (array $game): bool => $game['homeScore'] === null || $game['visitorScore'] === null));
    $sortByDate = static fn (array $left, array $right): int => strcmp((string) $left['date'], (string) $right['date']);

    usort($playedGames, $sortByDate);
    usort($upcomingGames, $sortByDate);
    $orderedGames = array_merge($playedGames, $upcomingGames);

    return [
        'data' => $data,
        'league' => $data['league'],
        'teams' => $data['teams'],
        'players' => $data['players'],
        'locations' => $data['locations'],
        'games' => $orderedGames,
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
