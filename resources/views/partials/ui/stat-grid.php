<?php
$statGridClass = trim((string) ($statGridClass ?? 'grid grid-3'));
$statItems = is_array($statItems ?? null) ? $statItems : [];
?>
<section class="<?= e($statGridClass) ?>">
    <?php foreach ($statItems as $statItem): ?>
        <article class="card stat-card <?= e((string) ($statItem['class'] ?? '')) ?>">
            <div class="stat-card__label"><?= e((string) ($statItem['label'] ?? '')) ?></div>
            <div class="stat-card__value <?= !empty($statItem['value_html']) ? 'stat-card__value--rich' : '' ?>">
                <?php if (!empty($statItem['value_html'])): ?>
                    <?= $statItem['value_html'] ?>
                <?php else: ?>
                    <?= e((string) ($statItem['value'] ?? '')) ?>
                <?php endif; ?>
            </div>
            <?php if (!empty($statItem['meta'])): ?>
                <div class="stat-card__meta"><?= e((string) $statItem['meta']) ?></div>
            <?php endif; ?>
        </article>
    <?php endforeach; ?>
</section>
