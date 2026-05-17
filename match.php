<?php
require __DIR__ . '/includes/app.php';

$context = appContext();
$teams = $context['teams'];
$players = $context['players'];
$locations = $context['locations'];
$goals = $context['goals'];
$gameId = max(0, (int) ($_GET['id'] ?? 0));
$game = null;

foreach ($context['games'] as $candidate) {
    if ((int) $candidate['id'] === $gameId) {
        $game = $candidate;
        break;
    }
}

if ($game === null) {
    http_response_code(404);
    renderHeader('Nie znaleziono meczu', $context, 'Nie ma meczu o podanym identyfikatorze.');
    ?>
    <section class="panel">
        <div class="panel-heading">
            <div>
                <p class="eyebrow">Błąd</p>
                <h2>Mecz nie istnieje</h2>
            </div>
            <a href="matches.php">Wróć do meczów</a>
        </div>
    </section>
    <?php
    renderFooter();
    exit;
}

$home = $teams[(int) $game['homeTeamId']];
$visitor = $teams[(int) $game['visitorTeamId']];
$location = $locations[(int) $game['locationId']];
$played = $game['homeScore'] !== null && $game['visitorScore'] !== null;
$playerMap = [];

foreach ($players as $player) {
    $playerMap[(int) $player['id']] = $player;
}

$matchGoals = array_values(array_filter($goals, static fn (array $goal): bool => (int) $goal['gameId'] === (int) $game['id']));
usort($matchGoals, static fn (array $left, array $right): int => (int) $left['minute'] <=> (int) $right['minute']);

$homeGoals = array_values(array_filter($matchGoals, static fn (array $goal): bool => (int) $goal['teamId'] === (int) $home['id']));
$visitorGoals = array_values(array_filter($matchGoals, static fn (array $goal): bool => (int) $goal['teamId'] === (int) $visitor['id']));

renderHeader('Szczegóły meczu', $context, $home['name'] . ' kontra ' . $visitor['name']);
?>
<section class="match-hero">
    <div class="team-side" style="--team-color: <?= h($home['color'] ?? '#0f766e') ?>">
        <span><?= h(substr($home['name'], 0, 1)) ?></span>
        <h2><?= h($home['name']) ?></h2>
        <p><?= h($home['city']) ?></p>
    </div>

    <div class="match-scoreboard">
        <b class="<?= $played ? 'badge done' : 'badge pending' ?>"><?= $played ? 'Wynik' : 'Plan' ?></b>
        <strong><?= $played ? h($game['homeScore']) : '-' ?> : <?= $played ? h($game['visitorScore']) : '-' ?></strong>
        <span><?= h($game['date']) ?></span>
        <small><?= h($location['name']) ?>, <?= h($location['timezone']) ?></small>
    </div>

    <div class="team-side right" style="--team-color: <?= h($visitor['color'] ?? '#4f46e5') ?>">
        <span><?= h(substr($visitor['name'], 0, 1)) ?></span>
        <h2><?= h($visitor['name']) ?></h2>
        <p><?= h($visitor['city']) ?></p>
    </div>
</section>

<section class="match-detail-grid">
    <article class="panel">
        <div class="panel-heading">
            <div>
                <p class="eyebrow">Bramki</p>
                <h2><?= h($home['name']) ?></h2>
            </div>
            <strong><?= count($homeGoals) ?></strong>
        </div>
        <?php if ($homeGoals === []): ?>
            <p class="empty-note">Brak zapisanych bramek.</p>
        <?php else: ?>
            <ul class="goal-list">
                <?php foreach ($homeGoals as $goal): ?>
                    <?php $player = $playerMap[(int) $goal['playerId']] ?? ['name' => 'Nieznany zawodnik']; ?>
                    <li>
                        <span><?= h($goal['minute']) ?>'</span>
                        <strong><?= h($player['name']) ?></strong>
                        <small><?= h($goal['type']) ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </article>

    <article class="panel">
        <div class="panel-heading">
            <div>
                <p class="eyebrow">Bramki</p>
                <h2><?= h($visitor['name']) ?></h2>
            </div>
            <strong><?= count($visitorGoals) ?></strong>
        </div>
        <?php if ($visitorGoals === []): ?>
            <p class="empty-note">Brak zapisanych bramek.</p>
        <?php else: ?>
            <ul class="goal-list">
                <?php foreach ($visitorGoals as $goal): ?>
                    <?php $player = $playerMap[(int) $goal['playerId']] ?? ['name' => 'Nieznany zawodnik']; ?>
                    <li>
                        <span><?= h($goal['minute']) ?>'</span>
                        <strong><?= h($player['name']) ?></strong>
                        <small><?= h($goal['type']) ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </article>
</section>

<section class="panel">
    <div class="panel-heading">
        <div>
            <p class="eyebrow">Przebieg</p>
            <h2>Chronologia bramek</h2>
        </div>
        <a href="matches.php">Wszystkie mecze</a>
    </div>

    <?php if ($matchGoals === []): ?>
        <p class="empty-note"><?= $played ? 'Do tego wyniku nie przypisano jeszcze strzelców.' : 'Mecz jest w planie, więc strzelcy pojawią się po dodaniu wyniku.' ?></p>
    <?php else: ?>
        <ol class="timeline-list">
            <?php foreach ($matchGoals as $goal): ?>
                <?php
                $team = $teams[(int) $goal['teamId']] ?? ['name' => 'Nieznana drużyna'];
                $player = $playerMap[(int) $goal['playerId']] ?? ['name' => 'Nieznany zawodnik'];
                ?>
                <li>
                    <span><?= h($goal['minute']) ?>'</span>
                    <div>
                        <strong><?= h($player['name']) ?></strong>
                        <small><?= h($team['name']) ?>, <?= h($goal['type']) ?></small>
                    </div>
                </li>
            <?php endforeach; ?>
        </ol>
    <?php endif; ?>
</section>
<?php renderFooter(); ?>
