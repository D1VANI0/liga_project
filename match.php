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
$returnPath = 'match.php?id=' . (int) $game['id'];
$playerMap = [];
$matchPlayers = [];

foreach ($players as $player) {
    $playerMap[(int) $player['id']] = $player;

    if ((int) $player['teamId'] === (int) $home['id'] || (int) $player['teamId'] === (int) $visitor['id']) {
        $matchPlayers[] = $player;
    }
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

<?php if (isLoggedIn()): ?>
    <section class="match-admin-panel">
        <form class="action-card" method="post">
            <input type="hidden" name="action" value="update_result">
            <input type="hidden" name="redirect" value="<?= h($returnPath) ?>">
            <input type="hidden" name="gameId" value="<?= h($game['id']) ?>">
            <h2><?= $played ? 'Zmień wynik' : 'Wpisz wynik' ?></h2>
            <div class="two-fields">
                <label><?= h($home['name']) ?> <input type="number" name="homeScore" min="0" value="<?= h($game['homeScore'] ?? 0) ?>" required></label>
                <label><?= h($visitor['name']) ?> <input type="number" name="visitorScore" min="0" value="<?= h($game['visitorScore'] ?? 0) ?>" required></label>
            </div>
            <button type="submit">Zapisz wynik</button>
        </form>

        <?php if ($played): ?>
            <form class="action-card" method="post">
                <input type="hidden" name="action" value="add_goal">
                <input type="hidden" name="redirect" value="<?= h($returnPath) ?>">
                <input type="hidden" name="gameId" value="<?= h($game['id']) ?>">
                <h2>Dodaj bramkę</h2>
                <label>Drużyna
                    <select name="teamId" required>
                        <option value="<?= h($home['id']) ?>"><?= h($home['name']) ?></option>
                        <option value="<?= h($visitor['id']) ?>"><?= h($visitor['name']) ?></option>
                    </select>
                </label>
                <label>Zawodnik
                    <select name="playerId" required>
                        <?php foreach ($matchPlayers as $player): ?>
                            <option value="<?= h($player['id']) ?>">
                                <?= h($player['name']) ?>, <?= h($teams[(int) $player['teamId']]['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <div class="two-fields">
                    <label>Minuta <input type="number" name="minute" min="1" max="130" value="45" required></label>
                    <label>Typ <input name="type" required maxlength="40" value="z gry"></label>
                </div>
                <button type="submit">Zapisz bramkę</button>
            </form>
        <?php else: ?>
            <article class="action-card muted-card">
                <h2>Bramki po wyniku</h2>
                <p>Najpierw wpisz wynik meczu. Po zapisaniu pojawi się formularz dodawania strzelców.</p>
            </article>
        <?php endif; ?>
    </section>
<?php else: ?>
    <section class="panel">
        <div class="panel-heading">
            <div>
                <p class="eyebrow">Edycja</p>
                <h2>Chcesz dodać dane do meczu?</h2>
            </div>
            <a href="login.php?next=<?= h(rawurlencode($returnPath)) ?>">Zaloguj admina</a>
        </div>
    </section>
<?php endif; ?>

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
