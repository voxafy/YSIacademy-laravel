<?php
$emptyStateClass = trim((string) ($emptyStateClass ?? ''));
$emptyStateTitle = (string) ($emptyStateTitle ?? 'Пока пусто');
$emptyStateText = (string) ($emptyStateText ?? '');
$emptyStateActionsHtml = (string) ($emptyStateActionsHtml ?? '');
?>
<div class="kb-empty kb-empty--compact <?= e($emptyStateClass) ?>">
    <h3><?= e($emptyStateTitle) ?></h3>
    <?php if ($emptyStateText !== ''): ?>
        <p><?= e($emptyStateText) ?></p>
    <?php endif; ?>
    <?php if ($emptyStateActionsHtml !== ''): ?>
        <div class="hero-actions empty-state__actions">
            <?= $emptyStateActionsHtml ?>
        </div>
    <?php endif; ?>
</div>
