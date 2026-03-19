<?php
/** @var string $content */
$pageTitle = $title ?? config('app.name');
$currentUser = current_user();
$flashSuccess = session('success');
$flashError = session('error');
$theme = request()->cookie('ysi_theme', 'light');
$cssVersion = @filemtime(public_path('build/css/app.css')) ?: time();
$jsVersion = @filemtime(public_path('build/js/app.js')) ?: time();
?>
<!DOCTYPE html>
<html lang="ru" data-theme="<?= e($theme === 'dark' ? 'dark' : 'light') ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> | <?= e(config('app.name')) ?></title>
    <link rel="stylesheet" href="<?= asset_url('css/app.css') ?>?v=<?= e((string) $cssVersion) ?>">
</head>
<body>
    <?php include resource_path('views/partials/header.php'); ?>

    <main class="page-shell">
        <div class="container">
            <?php if ($flashSuccess || $flashError): ?>
                <div class="flash-stack">
                    <?php if ($flashSuccess): ?>
                        <div class="flash flash-success"><?= e($flashSuccess) ?></div>
                    <?php endif; ?>
                    <?php if ($flashError): ?>
                        <div class="flash flash-error"><?= e($flashError) ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?= $content ?>
        </div>
    </main>

    <script src="<?= asset_url('js/app.js') ?>?v=<?= e((string) $jsVersion) ?>"></script>
</body>
</html>
