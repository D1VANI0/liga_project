<?php
require __DIR__ . '/includes/app.php';

$context = appContext();
$teams = $context['teams'];
$selectedOpponentId = isset($_GET['opponent']) && isset($teams[(int) $_GET['opponent']]) ? (int) $_GET['opponent'] : (int) array_key_first($teams);
$bestAgainstTeam = findBestPlayerAgainstTeam($selectedOpponentId);

renderHeader('Raporty', $context, 'Analiza wyników, bramek i formy zawodników.');
?>
<section class="report-grid">
    <article class="panel report-card">
        <div class="panel-heading">
            <div>
                <p class="eyebrow">Raport</p>
                <h2>Najlepszy zawodnik przeciw drużynie</h2>
            </div>
        </div>
        <form class="stack-form" method="get">
            <label>Drużyna
                <select name="opponent">
                    <?php foreach ($teams as $team): ?>
                        <option value="<?= h($team['id']) ?>" <?= (int) $team['id'] === $selectedOpponentId ? 'selected' : '' ?>>
                            <?= h($team['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <button type="submit">Pokaż raport</button>
        </form>
        <div class="spotlight">
            <?php if ($bestAgainstTeam !== null): ?>
                <span>Najlepszy wynik</span>
                <strong><?= h($bestAgainstTeam['player']) ?></strong>
                <p><?= h($bestAgainstTeam['team']) ?>, <?= h($bestAgainstTeam['goals']) ?> bramki przeciw <?= h($teams[$selectedOpponentId]['name']) ?></p>
            <?php else: ?>
                <span>Brak danych</span>
                <strong>Nie ma jeszcze bramek</strong>
                <p>Wybierz inną drużynę albo dodaj bramki w panelu administratora.</p>
            <?php endif; ?>
        </div>
    </article>

    <article class="panel report-card">
        <div class="panel-heading">
            <div>
                <p class="eyebrow">Podsumowanie</p>
                <h2>Stan rozgrywek</h2>
            </div>
        </div>
        <ul class="check-list">
            <li><?= h(count($context['teams'])) ?> drużyn w lidze</li>
            <li><?= h(count($context['players'])) ?> zawodników w kadrach</li>
            <li><?= h(count($context['playedGames'])) ?> rozegranych meczów</li>
            <li><?= h(count($context['upcomingGames'])) ?> meczów w terminarzu</li>
            <li><?= h(count($context['goals'])) ?> zapisanych bramek</li>
        </ul>
    </article>
</section>
<?php renderFooter(); ?>
