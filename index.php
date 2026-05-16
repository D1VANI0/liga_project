<?php
require __DIR__ . '/includes/app.php';

$context = appContext();
$teams = $context['teams'];
$games = $context['games'];
$locations = $context['locations'];
$standings = $context['standings'];
$scorers = $context['scorers'];
$playedGames = $context['playedGames'];
$upcomingGames = $context['upcomingGames'];

renderHeader('Panel ligi', $context, 'Najważniejsze informacje o rozgrywkach, wynikach i aktywności systemu.');
?>
<section class="hero-board">
    <article class="hero-card">
        <p class="eyebrow">Najlepsza drużyna</p>
        <h2><?= h($context['bestTeam']['team'] ?? '-') ?></h2>
        <p><?= h($context['bestTeam']['points'] ?? 0) ?> pkt, <?= h($context['bestTeam']['played'] ?? 0) ?> rozegrane mecze</p>
    </article>
    <article class="hero-card accent">
        <p class="eyebrow">Najlepszy zawodnik</p>
        <h2><?= h($context['bestPlayer']['player'] ?? '-') ?></h2>
        <p><?= h($context['bestPlayer']['goals'] ?? 0) ?> bramki, <?= h($context['bestPlayer']['team'] ?? '-') ?></p>
    </article>
</section>

<section class="metric-grid">
    <article class="metric-card">
        <span>Drużyny</span>
        <strong><?= count($teams) ?></strong>
    </article>
    <article class="metric-card">
        <span>Zawodnicy</span>
        <strong><?= count($context['players']) ?></strong>
    </article>
    <article class="metric-card">
        <span>Rozegrane mecze</span>
        <strong><?= count($playedGames) ?></strong>
    </article>
    <article class="metric-card">
        <span>Nadchodzące mecze</span>
        <strong><?= count($upcomingGames) ?></strong>
    </article>
</section>

<section class="dashboard-grid">
    <article class="panel">
        <div class="panel-heading">
            <div>
                <p class="eyebrow">Czołówka</p>
                <h2>Tabela</h2>
            </div>
            <a href="standings.php">Pełna tabela</a>
        </div>
        <div class="mini-table">
            <?php foreach (array_slice($standings, 0, 4) as $index => $row): ?>
                <div>
                    <span><?= $index + 1 ?></span>
                    <strong><?= h($row['team']) ?></strong>
                    <b><?= h($row['points']) ?> pkt</b>
                </div>
            <?php endforeach; ?>
        </div>
    </article>

    <article class="panel">
        <div class="panel-heading">
            <div>
                <p class="eyebrow">Strzelcy</p>
                <h2>Forma zawodników</h2>
            </div>
            <a href="players.php">Zawodnicy</a>
        </div>
        <ol class="rank-list">
            <?php foreach (array_slice($scorers, 0, 4) as $scorer): ?>
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

<section class="panel">
    <div class="panel-heading">
        <div>
            <p class="eyebrow">Terminarz</p>
            <h2>Najbliższe mecze</h2>
        </div>
        <a href="matches.php">Wszystkie mecze</a>
    </div>
    <div class="match-strip">
        <?php foreach (array_slice($games, 0, 3) as $game): ?>
            <article class="match-card">
                <span><?= h($game['date']) ?>, <?= h($locations[(int) $game['locationId']]['name']) ?></span>
                <div>
                    <strong><?= h($teams[(int) $game['homeTeamId']]['name']) ?></strong>
                    <b><?= $game['homeScore'] === null ? '-' : h($game['homeScore']) ?> : <?= $game['visitorScore'] === null ? '-' : h($game['visitorScore']) ?></b>
                    <strong><?= h($teams[(int) $game['visitorTeamId']]['name']) ?></strong>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php renderFooter(); ?>
