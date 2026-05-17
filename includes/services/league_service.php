<?php
declare(strict_types=1);

function loadStandings(): array
{
    $rows = dbRows('select * from standings_view order by points desc, goals_scored - goals_conceded desc, goals_scored desc, team asc');
    $standings = [];

    foreach ($rows as $row) {
        $standings[] = [
            'teamId' => (int) $row['team_id'],
            'team' => $row['team'],
            'played' => (int) $row['played'],
            'wins' => (int) $row['wins'],
            'draws' => (int) $row['draws'],
            'losses' => (int) $row['losses'],
            'goalsScored' => (int) $row['goals_scored'],
            'goalsConceded' => (int) $row['goals_conceded'],
            'points' => (int) $row['points'],
            'form' => json_decode((string) $row['form'], true) ?: [],
        ];
    }

    return $standings;
}

function loadScorers(): array
{
    $rows = dbRows('select * from scorers_view order by goals desc, player asc');
    $scorers = [];

    foreach ($rows as $row) {
        $scorers[] = [
            'playerId' => (int) $row['player_id'],
            'player' => $row['player'],
            'team' => $row['team'],
            'goals' => (int) $row['goals'],
        ];
    }

    return $scorers;
}

function findBestPlayerAgainstTeam(int $opponentId): ?array
{
    $row = dbRow('select * from best_player_against_team(:opponent_id) limit 1', [
        'opponent_id' => $opponentId,
    ]);

    if ($row === null) {
        return null;
    }

    return [
        'player' => $row['player'],
        'team' => $row['team'],
        'goals' => (int) $row['goals'],
    ];
}
