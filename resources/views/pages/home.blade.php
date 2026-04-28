<?php
$heroActionsHtml = '';
ob_start();
?>
<?php if (!$user): ?>
    <a href="<?= url('/login') ?>" class="btn btn-primary">Войти в систему</a>
    <a href="#about-platform" class="btn btn-ghost">О сервисе</a>
<?php else: ?>
    <a href="<?= url('/courses') ?>" class="btn btn-primary">Открыть каталог курсов</a>
    <a href="<?= url(role_home((string) $user['role_key'])) ?>" class="btn btn-ghost">Открыть кабинет</a>
<?php endif; ?>
<?php
$heroActionsHtml = ob_get_clean();

$pageHeaderKicker = 'Сервис обучения ЮСИ';
$pageHeaderTitle = 'СтройТех для сотрудников ЮСИ';
$pageHeaderText = 'СтройТех объединяет онбординг, обучающие программы, проверку знаний, материалы и контроль прогресса по стандартам ЮСИ. Сервис помогает быстрее вводить сотрудников в процессы компании и даёт прозрачную картину обучения.';
$pageHeaderClass = 'landing-hero__header';
$pageHeaderTitleClass = 'landing-hero__title';
$pageHeaderTextClass = 'landing-hero__text';
$pageHeaderActionsHtml = $heroActionsHtml;

$statItems = [
    ['label' => 'Обучение', 'value' => '24/7', 'meta' => 'Все программы, материалы и проверки знаний доступны в одном окне в любое удобное время.'],
    ['label' => 'Роли', 'value' => '3', 'meta' => 'Администратор, руководитель и сотрудник работают в одном связанном учебном сценарии.'],
    ['label' => 'Контроль', 'value' => '1', 'meta' => 'Одна платформа для маршрута сотрудника: от старта до итогового решения по обучению.'],
];
?>

<div class="page-stack">
    <section class="hero-card is-brand landing-hero">
        <?php include resource_path('views/partials/ui/page-header.php'); ?>
    </section>

    <?php
    $statGridClass = 'grid grid-3 landing-stats';
    include resource_path('views/partials/ui/stat-grid.php');
    ?>

    <?php if (!$user): ?>
        <section id="about-platform" class="grid grid-split section-space">
            <article class="card card-pad-lg overview-card">
                <?php
                $pageHeaderKicker = 'О сервисе';
                $pageHeaderTitle = 'Зачем ЮСИ нужен СтройТех';
                $pageHeaderText = 'Сервис помогает запускать единый стандарт обучения для новых и действующих сотрудников: назначать программы, собирать материалы, подтверждать прохождение и контролировать результат без ручной рутины и разрозненных таблиц.';
                $pageHeaderTitleTag = 'h2';
                $pageHeaderTitleClass = 'section-title--small';
                $pageHeaderTextClass = '';
                $pageHeaderActionsHtml = '';
                $pageHeaderClass = 'section-header--tight';
                include resource_path('views/partials/ui/page-header.php');
                ?>
            </article>

            <article class="card card-pad-lg overview-card">
                <?php
                $pageHeaderKicker = 'О компании';
                $pageHeaderTitle = 'ЮСИ и сервис СтройТех';
                $pageHeaderText = 'ЮСИ использует СтройТех как внутренний сервис обучения: здесь собраны регламенты, обязательные программы, инструкции и проверки знаний для подразделений, которые работают в amoCRM, Allio и связанных процессах.';
                include resource_path('views/partials/ui/page-header.php');
                ?>
            </article>
        </section>

        <section class="grid grid-3 section-space">
            <article class="card card-pad-md overview-card">
                <?php
                $pageHeaderKicker = 'Онбординг';
                $pageHeaderTitle = 'Быстрый старт';
                $pageHeaderText = 'Новые сотрудники получают понятный маршрут обучения и доступ к нужным материалам с первого дня.';
                include resource_path('views/partials/ui/page-header.php');
                ?>
            </article>
            <article class="card card-pad-md overview-card">
                <?php
                $pageHeaderKicker = 'Знания';
                $pageHeaderTitle = 'Единые стандарты';
                $pageHeaderText = 'Материалы, уроки, видео и тесты собраны в одном месте и поддерживают единый стандарт работы команд.';
                include resource_path('views/partials/ui/page-header.php');
                ?>
            </article>
            <article class="card card-pad-md overview-card">
                <?php
                $pageHeaderKicker = 'Прозрачность';
                $pageHeaderTitle = 'Контроль прогресса';
                $pageHeaderText = 'Руководители и администраторы видят статус прохождения, результаты и точки, где сотруднику нужна поддержка.';
                include resource_path('views/partials/ui/page-header.php');
                ?>
            </article>
        </section>
    <?php else: ?>
        <section class="card card-pad-lg section-space">
            <?php
            ob_start();
            ?>
            <a href="<?= url('/courses') ?>" class="btn btn-ghost">Все курсы</a>
            <?php
            $pageHeaderActionsHtml = ob_get_clean();
            $pageHeaderKicker = 'Каталог';
            $pageHeaderTitle = 'Актуальные обучающие программы';
            $pageHeaderText = 'Ниже собраны опубликованные маршруты, которые уже готовы к прохождению или повторному открытию.';
            $pageHeaderTitleTag = 'h2';
            $pageHeaderTitleClass = 'section-title--small';
            $pageHeaderTextClass = '';
            $pageHeaderClass = '';
            include resource_path('views/partials/ui/page-header.php');
            ?>

            <div class="grid grid-3">
                <?php foreach ($courses as $course): ?>
                    <article class="course-item dashboard-course-card">
                        <div class="dashboard-course-card__top">
                            <p class="section-kicker"><?= e($course['category']['title']) ?></p>
                            <h3 class="dashboard-course-card__title"><?= e($course['title']) ?></h3>
                            <p class="section-text dashboard-course-card__text"><?= e((string) $course['short_description']) ?></p>
                        </div>
                        <div class="actions-row dashboard-course-card__actions">
                            <a href="<?= url('/courses/' . $course['slug']) ?>" class="btn btn-ghost btn-sm">Открыть курс</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</div>
