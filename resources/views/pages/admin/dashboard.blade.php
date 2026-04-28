<?php
ob_start();
?>
<a href="<?= url('/admin/courses') ?>" class="btn btn-primary">Редактор курсов</a>
<?php
$pageHeaderActionsHtml = ob_get_clean();
$pageHeaderKicker = 'Администратор';
$pageHeaderTitle = 'Обзор платформы';
$pageHeaderText = 'Следите за основными показателями платформы и быстро переходите к последним изменениям по курсам, пользователям и назначениям.';
$pageHeaderClass = '';
$pageHeaderTitleClass = '';
$pageHeaderTextClass = '';

$statItems = [
    ['label' => 'Пользователи', 'value' => (string) $dashboard['counts']['users']],
    ['label' => 'Курсы', 'value' => (string) $dashboard['counts']['courses']],
    ['label' => 'Назначения', 'value' => (string) $dashboard['counts']['enrollments']],
    ['label' => 'Медиа', 'value' => (string) $dashboard['counts']['media']],
];
?>

<div class="page-stack">
    <?php include resource_path('views/partials/ui/page-header.php'); ?>

    <?php
    $statGridClass = 'grid grid-4';
    include resource_path('views/partials/ui/stat-grid.php');
    ?>

    <section class="grid grid-3 section-space">
        <article class="card card-pad-md">
            <?php
            $pageHeaderKicker = 'Курсы';
            $pageHeaderTitle = 'Последние обновления';
            $pageHeaderText = 'Свежие изменения в маршрутах и учебных программах.';
            $pageHeaderTitleTag = 'h2';
            $pageHeaderTitleClass = 'section-title--small';
            $pageHeaderActionsHtml = '';
            include resource_path('views/partials/ui/page-header.php');
            ?>
            <div class="card-stack">
                <?php foreach ($dashboard['recent_courses'] as $course): ?>
                    <a class="list-item dashboard-link-card" href="<?= url('/admin/courses/' . $course['id']) ?>">
                        <strong><?= e($course['title']) ?></strong>
                        <div class="muted"><?= e($course['category_title']) ?> · <?= e((string) $course['modules_count']) ?> модулей</div>
                    </a>
                <?php endforeach; ?>
            </div>
        </article>

        <article class="card card-pad-md">
            <?php
            $pageHeaderKicker = 'Пользователи';
            $pageHeaderTitle = 'Новые профили';
            $pageHeaderText = 'Кого недавно добавили в систему и к каким ролям они относятся.';
            include resource_path('views/partials/ui/page-header.php');
            ?>
            <div class="card-stack">
                <?php foreach ($dashboard['recent_users'] as $row): ?>
                    <a class="list-item dashboard-link-card" href="<?= url('/admin/users/' . $row['id']) ?>">
                        <strong><?= e($row['full_name']) ?></strong>
                        <div class="muted"><?= e(role_label((string) $row['role_key'])) ?> · <?= e($row['city_name'] ?: 'Без города') ?></div>
                    </a>
                <?php endforeach; ?>
            </div>
        </article>

        <article class="card card-pad-md">
            <?php
            $pageHeaderKicker = 'Результаты';
            $pageHeaderTitle = 'Последние назначения';
            $pageHeaderText = 'Кому недавно назначили обучение и на каком этапе сейчас находится программа.';
            include resource_path('views/partials/ui/page-header.php');
            ?>
            <div class="card-stack">
                <?php foreach ($dashboard['results'] as $row): ?>
                    <div class="list-item dashboard-link-card">
                        <strong><?= e($row['full_name']) ?></strong>
                        <div class="muted"><?= e($row['course_title']) ?></div>
                        <div class="dashboard-link-card__status"><span class="<?= course_status_class((string) $row['status']) ?>"><?= e(course_status_label((string) $row['status'])) ?></span></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </article>
    </section>
</div>
