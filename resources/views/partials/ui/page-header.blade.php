<?php
$pageHeaderClass = trim((string) ($pageHeaderClass ?? ''));
$pageHeaderTitleTag = (string) ($pageHeaderTitleTag ?? 'h1');
if (!in_array($pageHeaderTitleTag, ['h1', 'h2', 'h3'], true)) {
    $pageHeaderTitleTag = 'h1';
}
$pageHeaderTitleClass = trim((string) ($pageHeaderTitleClass ?? ''));
$pageHeaderTextClass = trim((string) ($pageHeaderTextClass ?? ''));
$pageHeaderActionsClass = trim((string) ($pageHeaderActionsClass ?? ''));
$pageHeaderActionsHtml = (string) ($pageHeaderActionsHtml ?? '');
?>
<section class="section-header <?= e($pageHeaderClass) ?>">
    <div class="page-header__content">
        <?php if (!empty($pageHeaderKicker)): ?>
            <p class="section-kicker"><?= e((string) $pageHeaderKicker) ?></p>
        <?php endif; ?>

        <<?= $pageHeaderTitleTag ?> class="section-title <?= e($pageHeaderTitleClass) ?>">
            <?= e((string) $pageHeaderTitle) ?>
        </<?= $pageHeaderTitleTag ?>>

        <?php if (!empty($pageHeaderText)): ?>
            <p class="section-text <?= e($pageHeaderTextClass) ?>"><?= e((string) $pageHeaderText) ?></p>
        <?php endif; ?>
    </div>

    <?php if ($pageHeaderActionsHtml !== ''): ?>
        <div class="actions-row <?= e($pageHeaderActionsClass) ?>">
            <?= $pageHeaderActionsHtml ?>
        </div>
    <?php endif; ?>
</section>
