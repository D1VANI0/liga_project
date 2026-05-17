<?php
require __DIR__ . '/includes/app.php';

$context = appContext();
$teams = $context['teams'];
$selectedOpponentId = isset($_GET['opponent']) && isset($teams[(int) $_GET['opponent']]) ? (int) $_GET['opponent'] : (int) array_key_first($teams);
$bestAgainstTeam = findBestPlayerAgainstTeam($selectedOpponentId);

renderHeader('Raporty', $context, 'Widoki analityczne potrzebne w wymaganiach systemu Liga.');
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
                <p class="eyebrow">Chmura</p>
                <h2>Gotowość do wdrożenia</h2>
            </div>
        </div>
        <ul class="check-list">
            <li>Model danych zapisany w Supabase PostgreSQL</li>
            <li>Kontrolery dla aplikacji, administracji i logowania</li>
            <li>Wspólny układ w warstwie widoku</li>
            <li>Logowanie administratora przez sesję PHP</li>
            <li>Tabele aplikacji z prefiksem `app_` w Supabase</li>
        </ul>
    </article>
</section>
<?php renderFooter(); ?>
