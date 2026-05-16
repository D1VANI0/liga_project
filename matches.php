<?php
require __DIR__ . '/includes/app.php';

$context = appContext();
$teams = $context['teams'];
$games = $context['games'];
$locations = $context['locations'];

renderHeader('Mecze', $context, 'Terminarz, lokalizacje oraz zapisane wyniki wszystkich spotkan.');
?>
<section class="match-page-grid">
    <?php foreach ($games as $game): ?>
        <?php
        $home = $teams[(int) $game['homeTeamId']];
        $visitor = $teams[(int) $game['visitorTeamId']];
        $location = $locations[(int) $game['locationId']];
        $played = $game['homeScore'] !== null && $game['visitorScore'] !== null;
        ?>
        <article class="fixture-card">
            <div class="fixture-top">
                <span><?= h($game['date']) ?></span>
                <b class="<?= $played ? 'badge done' : 'badge pending' ?>"><?= $played ? 'Wynik' : 'Plan' ?></b>
            </div>
            <div class="fixture-score">
                <strong><?= h($home['name']) ?></strong>
                <span><?= $played ? h($game['homeScore']) : '-' ?> : <?= $played ? h($game['visitorScore']) : '-' ?></span>
                <strong><?= h($visitor['name']) ?></strong>
            </div>
            <p><?= h($location['name']) ?>, <?= h($location['timezone']) ?></p>
        </article>
    <?php endforeach; ?>
</section>
<?php renderFooter(); ?>
