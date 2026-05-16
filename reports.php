<?php
require __DIR__ . '/includes/app.php';

$context = appContext();
$teams = $context['teams'];
$selectedOpponentId = isset($_GET['opponent']) && isset($teams[(int) $_GET['opponent']]) ? (int) $_GET['opponent'] : (int) array_key_first($teams);
$bestAgainstTeam = findBestPlayerAgainstTeam($context['players'], $teams, $context['games'], $context['goals'], $selectedOpponentId);

renderHeader('Raporty', $context, 'Widoki analityczne potrzebne w wymaganiach systemu Liga.');
?>
<section class="report-grid">
    <article class="panel report-card">
        <div class="panel-heading">
            <div>
                <p class="eyebrow">Raport</p>
                <h2>Najlepszy zawodnik przeciw druzynie</h2>
            </div>
        </div>
        <form class="stack-form" method="get">
            <label>Druzyna
                <select name="opponent">
                    <?php foreach ($teams as $team): ?>
                        <option value="<?= h($team['id']) ?>" <?= (int) $team['id'] === $selectedOpponentId ? 'selected' : '' ?>>
                            <?= h($team['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <button type="submit">Pokaz raport</button>
        </form>
        <div class="spotlight">
            <?php if ($bestAgainstTeam !== null): ?>
                <span>Najlepszy wynik</span>
                <strong><?= h($bestAgainstTeam['player']) ?></strong>
                <p><?= h($bestAgainstTeam['team']) ?>, <?= h($bestAgainstTeam['goals']) ?> bramki przeciw <?= h($teams[$selectedOpponentId]['name']) ?></p>
            <?php else: ?>
                <span>Brak danych</span>
                <strong>Nie ma jeszcze bramek</strong>
                <p>Wybierz inna druzyne albo dodaj bramki w panelu administratora.</p>
            <?php endif; ?>
        </div>
    </article>

    <article class="panel report-card">
        <div class="panel-heading">
            <div>
                <p class="eyebrow">Cloud</p>
                <h2>Gotowosc do Azure</h2>
            </div>
        </div>
        <ul class="check-list">
            <li>Oddzielona logika danych w `includes/app.php`</li>
            <li>Wiele widokow zamiast jednej dlugiej strony</li>
            <li>Warstwa JSON gotowa do podmiany na SQL</li>
            <li>Interfejs administracyjny dla operacji systemowych</li>
        </ul>
    </article>
</section>
<?php renderFooter(); ?>
