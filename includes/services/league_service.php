<?php
declare(strict_types=1);

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
            'form' => [],
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
            $standings[$homeId]['form'][] = 'W';
            $standings[$visitorId]['form'][] = 'L';
        } elseif ($homeScore < $visitorScore) {
            $standings[$visitorId]['wins']++;
            $standings[$homeId]['losses']++;
            $standings[$visitorId]['points'] += 3;
            $standings[$homeId]['form'][] = 'L';
            $standings[$visitorId]['form'][] = 'W';
        } else {
            $standings[$homeId]['draws']++;
            $standings[$visitorId]['draws']++;
            $standings[$homeId]['points']++;
            $standings[$visitorId]['points']++;
            $standings[$homeId]['form'][] = 'D';
            $standings[$visitorId]['form'][] = 'D';
        }
    }

    foreach ($standings as &$row) {
        $row['form'] = array_slice($row['form'], -5);
    }
    unset($row);

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
