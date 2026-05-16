<?php
require __DIR__ . '/includes/app.php';

requireLogin('admin.php');

$context = appContext();
$teams = $context['teams'];
$players = $context['players'];
$games = $context['games'];
$locations = $context['locations'];

renderHeader('Administracja', $context, 'Operacje administratora: drużyny, zawodnicy, mecze, wyniki i bramki.');
?>
<section class="admin-actions">
    <form class="action-card" method="post">
        <input type="hidden" name="action" value="add_team">
        <h2>Dodaj drużynę</h2>
        <label>Nazwa <input name="name" required maxlength="80" placeholder="np. Orzeł FC"></label>
        <label>Miasto <input name="city" required maxlength="80" placeholder="np. Poznań"></label>
        <label>Trener <input name="coach" required maxlength="80" placeholder="np. Jan Kowalski"></label>
        <label>Kolor <input type="color" name="color" value="#0f766e"></label>
        <button type="submit">Dodaj drużynę</button>
    </form>

    <form class="action-card" method="post">
        <input type="hidden" name="action" value="add_player">
        <h2>Dodaj zawodnika</h2>
        <label>Drużyna
            <select name="teamId" required>
                <?php foreach ($teams as $team): ?>
                    <option value="<?= h($team['id']) ?>"><?= h($team['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Imię i nazwisko <input name="name" required maxlength="80" placeholder="np. Adam Nowy"></label>
        <label>Pozycja <input name="position" required maxlength="40" placeholder="np. Pomocnik"></label>
        <button type="submit">Dodaj zawodnika</button>
    </form>

    <form class="action-card" method="post">
        <input type="hidden" name="action" value="add_game">
        <h2>Dodaj mecz</h2>
        <label>Data <input name="date" required maxlength="40" placeholder="2026-06-01 18:00"></label>
        <label>Gospodarz
            <select name="homeTeamId" required>
                <?php foreach ($teams as $team): ?>
                    <option value="<?= h($team['id']) ?>"><?= h($team['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Gość
            <select name="visitorTeamId" required>
                <?php foreach ($teams as $team): ?>
                    <option value="<?= h($team['id']) ?>"><?= h($team['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Lokalizacja
            <select name="locationId" required>
                <?php foreach ($locations as $location): ?>
                    <option value="<?= h($location['id']) ?>"><?= h($location['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button type="submit">Dodaj mecz</button>
    </form>

    <form class="action-card" method="post">
        <input type="hidden" name="action" value="update_result">
        <h2>Wpisz wynik</h2>
        <label>Mecz
            <select name="gameId" required>
                <?php foreach ($games as $game): ?>
                    <option value="<?= h($game['id']) ?>">
                        <?= h($teams[(int) $game['homeTeamId']]['name']) ?> - <?= h($teams[(int) $game['visitorTeamId']]['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <div class="two-fields">
            <label>Gospodarz <input type="number" name="homeScore" min="0" value="0" required></label>
            <label>Gość <input type="number" name="visitorScore" min="0" value="0" required></label>
        </div>
        <button type="submit">Zapisz wynik</button>
    </form>

    <form class="action-card wide-action" method="post">
        <input type="hidden" name="action" value="add_goal">
        <h2>Zarejestruj bramkę</h2>
        <label>Mecz
            <select name="gameId" required>
                <?php foreach ($games as $game): ?>
                    <option value="<?= h($game['id']) ?>">
                        <?= h($teams[(int) $game['homeTeamId']]['name']) ?> - <?= h($teams[(int) $game['visitorTeamId']]['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Drużyna
            <select name="teamId" required>
                <?php foreach ($teams as $team): ?>
                    <option value="<?= h($team['id']) ?>"><?= h($team['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Zawodnik
            <select name="playerId" required>
                <?php foreach ($players as $player): ?>
                    <option value="<?= h($player['id']) ?>">
                        <?= h($player['name']) ?>, <?= h($teams[(int) $player['teamId']]['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Minuta <input type="number" name="minute" min="1" max="130" value="45" required></label>
        <label>Typ <input name="type" required maxlength="40" value="z gry"></label>
        <button type="submit">Zapisz bramkę</button>
    </form>

    <form class="action-card danger-card" method="post">
        <input type="hidden" name="action" value="reset_demo">
        <h2>Reset danych</h2>
        <p>Przywraca przykładowe dane projektu i usuwa zmiany zapisane w JSON.</p>
        <button type="submit">Przywróć dane</button>
    </form>
</section>
<?php renderFooter(); ?>
