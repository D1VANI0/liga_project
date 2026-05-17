<?php
require __DIR__ . '/includes/app.php';

$context = appContext();
$topScorers = array_slice($context['scorers'], 0, 10);

renderHeader('Zawodnicy', $context, 'Pierwsza dziesiątka najlepszych strzelców ligi.');
?>
<section class="panel scorers-panel">
    <div class="panel-heading">
        <div>
            <p class="eyebrow">Bramki</p>
            <h2>Najlepsi strzelcy</h2>
        </div>
        <strong>TOP 10</strong>
    </div>

    <?php if ($topScorers === []): ?>
        <p class="empty-note">Nie ma jeszcze zapisanych bramek.</p>
    <?php else: ?>
        <ol class="rank-list top-scorers-list">
            <?php foreach ($topScorers as $scorer): ?>
                <li>
                    <span>
                        <strong><?= h($scorer['player']) ?></strong>
                        <small><?= h($scorer['team']) ?></small>
                    </span>
                    <b><?= h($scorer['goals']) ?></b>
                </li>
            <?php endforeach; ?>
        </ol>
    <?php endif; ?>
</section>
<?php renderFooter(); ?>
