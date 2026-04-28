<?php
$inProgress = array_values(array_filter($dashboard['enrollments'], static fn (array $item): bool => $item['status'] === 'IN_PROGRESS'));
$completed = array_values(array_filter($dashboard['enrollments'], static fn (array $item): bool => in_array($item['status'], ['COMPLETED', 'SENT_TO_REVIEW', 'RECOMMENDED_FOR_ACCESS'], true)));

ob_start();
?>
<a href="<?= url('/courses') ?>" class="btn btn-primary">Каталог курсов</a>
<?php
$pageHeaderActionsHtml = ob_get_clean();
$pageHeaderKicker = 'Личный кабинет';
$pageHeaderTitle = 'Кабинет стажера';
$pageHeaderText = 'Назначенные курсы, прогресс и быстрый доступ к справочным материалам для повседневной работы.';
$pageHeaderClass = '';
$pageHeaderTitleClass = '';
$pageHeaderTextClass = '';

$statItems = [
    ['label' => 'Назначено курсов', 'value' => (string) count($dashboard['enrollments'])],
    ['label' => 'В процессе', 'value' => (string) count($inProgress)],
    ['label' => 'Завершено / отправлено', 'value' => (string) count($completed)],
];
?>

<div class="page-stack">
    <?php include resource_path('views/partials/ui/page-header.php'); ?>

    <?php
    $statGridClass = 'grid grid-3';
    include resource_path('views/partials/ui/stat-grid.php');
    ?>

    <section class="dashboard-layout section-space">
        <div class="card card-pad-lg">
            <?php
            $pageHeaderKicker = 'Мои курсы';
            $pageHeaderTitle = 'Назначенные программы';
            $pageHeaderText = 'Возвращайтесь к текущему шагу, отслеживайте прогресс и открывайте нужную программу без лишних переходов.';
            $pageHeaderTitleTag = 'h2';
            $pageHeaderTitleClass = 'section-title--small';
            $pageHeaderActionsHtml = '';
            include resource_path('views/partials/ui/page-header.php');
            ?>

            <div class="card-stack">
                <?php if ($dashboard['enrollments'] === []): ?>
                    <?php
                    $emptyStateTitle = 'Курсы пока не назначены';
                    $emptyStateText = 'Как только появятся новые программы, они будут доступны здесь вместе с прогрессом и быстрым переходом к следующему шагу.';
                    $emptyStateActionsHtml = '<a href="' . e(url('/courses')) . '" class="btn btn-primary btn-sm">Открыть каталог</a>';
                    include resource_path('views/partials/ui/empty-state.php');
                    ?>
                <?php endif; ?>

                <?php foreach ($dashboard['enrollments'] as $enrollment): ?>
                    <?php $progress = (int) $enrollment['progress']['completion_percent']; ?>
                    <article class="course-item dashboard-course-card">
                        <div class="dashboard-course-card__top">
                            <div class="dashboard-course-card__eyebrow">
                                <p class="section-kicker"><?= e($enrollment['course']['category']['title']) ?></p>
                                <span class="<?= course_status_class((string) $enrollment['status']) ?>">
                                    <?= e(course_status_label((string) $enrollment['status'])) ?>
                                </span>
                            </div>
                            <h3 class="dashboard-course-card__title"><?= e($enrollment['course']['title']) ?></h3>
                            <p class="section-text dashboard-course-card__text"><?= e((string) $enrollment['course']['short_description']) ?></p>
                        </div>

                        <div class="dashboard-course-card__progress">
                            <div class="dashboard-course-card__progress-head">
                                <span>Прогресс</span>
                                <strong><?= e(format_percent($progress)) ?></strong>
                            </div>
                            <div class="progress"><div class="progress__bar" style="width: <?= $progress ?>%;"></div></div>
                        </div>

                        <div class="dashboard-course-card__footer">
                            <a href="<?= url('/courses/' . $enrollment['course']['slug']) ?>" class="btn btn-ghost btn-sm">Открыть курс</a>
                            <span class="dashboard-course-card__meta">
                                <?= e((string) ($enrollment['progress']['completion_percent'] ?? 0)) ?>% · <?= e((string) ($enrollment['status_label'] ?? course_status_label((string) $enrollment['status']))) ?>
                            </span>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="dashboard-side-stack">
            <article class="card dashboard-side-card">
                <?php
                $pageHeaderKicker = 'База знаний';
                $pageHeaderTitle = 'Регламенты, инструкции и FAQ';
                $pageHeaderText = 'Отдельный справочник для повседневной работы: документы, правила, инструкции и ответы на частые вопросы.';
                $pageHeaderActionsHtml = '';
                include resource_path('views/partials/ui/page-header.php');
                ?>
                <div class="course-metric-list">
                    <div class="course-metric-list__item">
                        <span>Что внутри</span>
                        <strong>Документы и FAQ</strong>
                    </div>
                    <div class="course-metric-list__item">
                        <span>Для чего нужна</span>
                        <strong>Быстрый поиск ответов</strong>
                    </div>
                </div>
                <div class="actions-row">
                    <a href="<?= url('/knowledge-base') ?>" class="btn btn-primary">Открыть базу знаний</a>
                </div>
            </article>
        </div>
    </section>
</div>
