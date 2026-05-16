<?php
require __DIR__ . '/includes/app.php';

$context = appContext();
$teams = $context['teams'];
$players = $context['players'];
$standings = $context['standings'];
$standingByTeam = [];
foreach ($standings as $row) {
    $standingByTeam[(int) $row['teamId']] = $row;
}

renderHeader('Druzyny', $context, 'Karty druzyn z trenerami, miastami i podstawowymi statystykami.');
?>
<section class="team-grid">
    <?php foreach ($teams as $team): ?>
        <?php
        $teamPlayers = array_filter($players, static fn (array $player): bool => (int) $player['teamId'] === (int) $team['id']);
        $row = $standingByTeam[(int) $team['id']] ?? null;
        ?>
        <article class="team-card" style="--team-color: <?= h($team['color'] ?? '#0f766e') ?>">
            <div class="team-mark"><?= h(substr($team['name'], 0, 1)) ?></div>
            <div>
                <h2><?= h($team['name']) ?></h2>
                <p><?= h($team['city']) ?>, trener: <?= h($team['coach']) ?></p>
            </div>
            <dl>
                <div><dt>Punkty</dt><dd><?= h($row['points'] ?? 0) ?></dd></div>
                <div><dt>Mecze</dt><dd><?= h($row['played'] ?? 0) ?></dd></div>
                <div><dt>Zawodnicy</dt><dd><?= count($teamPlayers) ?></dd></div>
            </dl>
        </article>
    <?php endforeach; ?>
</section>
<?php renderFooter(); ?>
