<?php
require __DIR__ . '/includes/app.php';

$context = appContext();
$teams = $context['teams'];
$players = $context['players'];
$scorers = $context['scorers'];
$goalsByPlayer = [];
foreach ($scorers as $scorer) {
    $goalsByPlayer[(int) $scorer['playerId']] = (int) $scorer['goals'];
}

renderHeader('Zawodnicy', $context, 'Lista zawodnikow oraz klasyfikacja bramek.');
?>
<section class="player-layout">
    <article class="panel">
        <div class="panel-heading">
            <div>
                <p class="eyebrow">Player</p>
                <h2>Kadra ligi</h2>
            </div>
        </div>
        <div class="player-list">
            <?php foreach ($players as $player): ?>
                <div>
                    <span class="avatar"><?= h(substr($player['name'], 0, 1)) ?></span>
                    <span>
                        <strong><?= h($player['name']) ?></strong>
                        <small><?= h($teams[(int) $player['teamId']]['name']) ?>, <?= h($player['position']) ?></small>
                    </span>
                    <b><?= h($goalsByPlayer[(int) $player['id']] ?? 0) ?></b>
                </div>
            <?php endforeach; ?>
        </div>
    </article>

    <article class="panel">
        <div class="panel-heading">
            <div>
                <p class="eyebrow">Goal</p>
                <h2>Najlepsi strzelcy</h2>
            </div>
        </div>
        <ol class="rank-list">
            <?php foreach ($scorers as $scorer): ?>
                <li>
                    <span>
                        <strong><?= h($scorer['player']) ?></strong>
                        <small><?= h($scorer['team']) ?></small>
                    </span>
                    <b><?= h($scorer['goals']) ?></b>
                </li>
            <?php endforeach; ?>
        </ol>
    </article>
</section>
<?php renderFooter(); ?>
