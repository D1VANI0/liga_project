<?php
require __DIR__ . '/includes/app.php';

$context = appContext();
$standings = $context['standings'];

renderHeader('Tabela ligowa', $context, 'Ranking druzyn liczony automatycznie na podstawie wynikow spotkan.');
?>
<section class="panel">
    <div class="panel-heading">
        <div>
            <p class="eyebrow">TeamStanding</p>
            <h2>Klasyfikacja generalna</h2>
        </div>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Druzyna</th>
                    <th>M</th>
                    <th>W</th>
                    <th>R</th>
                    <th>P</th>
                    <th>B+</th>
                    <th>B-</th>
                    <th>+/-</th>
                    <th>Pkt</th>
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
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php renderFooter(); ?>
