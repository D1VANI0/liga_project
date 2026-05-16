<?php
require __DIR__ . '/includes/app.php';

$context = appContext();
$standings = $context['standings'];

renderHeader('Tabela ligowa', $context, 'Ranking druzyn liczony automatycznie na podstawie wynikow spotkan.');
?>
<section class="panel league-table-panel">
    <div class="panel-heading">
        <div>
            <p class="eyebrow"><?= h($context['league']['season']) ?></p>
            <h2>Klasyfikacja generalna</h2>
        </div>
    </div>
    <div class="table-wrap league-table-wrap">
        <table class="league-table">
            <thead>
                <tr>
                    <th>Pos</th>
                    <th>Club</th>
                    <th>P</th>
                    <th>W</th>
                    <th>D</th>
                    <th>L</th>
                    <th>GF</th>
                    <th>GA</th>
                    <th>GD</th>
                    <th>Pts</th>
                    <th>Form</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($standings as $index => $row): ?>
                    <tr>
                        <td><span class="place"><?= $index + 1 ?></span></td>
                        <td><strong><?= h($row['team']) ?></strong></td>
                        <td><?= h($row['played']) ?></td>
                        <td><?= h($row['wins']) ?></td>
                        <td><?= h($row['draws']) ?></td>
                        <td><?= h($row['losses']) ?></td>
                        <td><?= h($row['goalsScored']) ?></td>
                        <td><?= h($row['goalsConceded']) ?></td>
                        <td><?= h($row['goalsScored'] - $row['goalsConceded']) ?></td>
                        <td><strong><?= h($row['points']) ?></strong></td>
                        <td>
                            <span class="form-dots" aria-label="Forma">
                                <?php foreach ($row['form'] as $result): ?>
                                    <span class="form-dot <?= h(strtolower($result)) ?>" title="<?= h($result) ?>"></span>
                                <?php endforeach; ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="table-meta">
        <span>Tip: na mobile przesun tabele poziomo, zeby zobaczyc wszystkie kolumny.</span>
        <span><?= count($standings) ?> druzyny</span>
    </div>
</section>
<?php renderFooter(); ?>
