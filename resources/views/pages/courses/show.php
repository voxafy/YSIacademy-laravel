<?php
$enrollment = $course['enrollment'] ?? null;
$firstLesson = $course['modules'][0]['lessons'][0] ?? null;
$canEditCourse = in_array((string) ($user['role_key'] ?? ''), ['ADMIN', 'LEADER'], true);
$moduleCount = count($course['modules']);
$lessonCount = array_sum(array_map(static fn (array $module): int => count($module['lessons'] ?? []), $course['modules']));
?>
<section class="hero-card is-brand course-hero">
    <div class="course-hero__content">
        <div>
            <p class="section-kicker course-hero__kicker"><?= e($course['category']['title']) ?></p>
            <h1 class="section-title course-hero__title"><?= e($course['title']) ?></h1>
            <p class="section-text course-hero__text"><?= e($course['description']) ?></p>
            <div class="hero-actions">
                <span class="badge badge-cyan"><?= e((string) $moduleCount) ?> модулей</span>
                <span class="badge badge-info"><?= e((string) $lessonCount) ?> уроков</span>
            </div>
        </div>

        <div class="card course-hero__panel">
            <?php if ($enrollment): ?>
                <span class="<?= course_status_class((string) $enrollment['status']) ?>"><?= e(course_status_label((string) $enrollment['status'])) ?></span>
                <div class="course-hero__progress">
                    <div class="course-hero__progress-label">Ваш прогресс: <?= e(format_percent((int) ($enrollment['completion_percent'] ?? 0))) ?></div>
                    <div class="progress"><div class="progress__bar" style="width: <?= (int) ($enrollment['completion_percent'] ?? 0) ?>%;"></div></div>
                </div>
                <div class="course-hero__metrics">
                    <span>Модули <?= e((string) ($enrollment['modules_completed'] ?? 0)) ?>/<?= e((string) ($enrollment['modules_total'] ?? 0)) ?></span>
                    <span>Уроки <?= e((string) ($enrollment['lessons_completed'] ?? 0)) ?>/<?= e((string) ($enrollment['lessons_total'] ?? 0)) ?></span>
                </div>
            <?php else: ?>
                <p class="section-text">Курс станет доступен после назначения или публикации для вашей роли.</p>
            <?php endif; ?>
            <div class="actions-row" style="margin-top: 18px;">
                <?php if ($firstLesson): ?>
                    <a href="<?= url('/courses/' . $course['slug'] . '/lessons/' . $firstLesson['id']) ?>" class="btn btn-primary">Открыть первый урок</a>
                <?php endif; ?>
                <?php if ($canEditCourse): ?>
                    <a href="<?= url('/admin/courses/' . $course['id']) ?>" class="btn btn-ghost">Редактировать</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="course-structure-layout" style="margin-top: 22px;">
    <div class="card course-structure-card">
        <div class="course-structure-header">
            <div>
                <p class="section-kicker">Структура</p>
                <h2 class="section-title section-title--small">Маршрут обучения</h2>
                <p class="section-text">Обновленный список модулей и уроков с быстрым переходом к нужному материалу.</p>
            </div>
        </div>

        <div class="card-stack">
            <?php foreach ($course['modules'] as $moduleIndex => $module): ?>
                <article class="module-block">
                    <div class="module-block__header">
                        <div>
                            <p class="module-block__index">Модуль <?= e((string) ($moduleIndex + 1)) ?></p>
                            <h3 class="module-block__title"><?= e($module['title']) ?></h3>
                            <p class="section-text"><?= e($module['description']) ?></p>
                        </div>
                        <div class="module-block__stats">
                            <span class="badge badge-muted"><?= e((string) count($module['lessons'])) ?> уроков</span>
                        </div>
                    </div>
                    <div class="module-block__lessons">
                        <?php foreach ($module['lessons'] as $lessonIndex => $lesson): ?>
                            <a href="<?= url('/courses/' . $course['slug'] . '/lessons/' . $lesson['id']) ?>" class="module-block__lesson">
                                <span class="module-block__lesson-step"><?= e((string) ($moduleIndex + 1)) ?>.<?= e((string) ($lessonIndex + 1)) ?></span>
                                <div class="module-block__lesson-body">
                                    <strong><?= e($lesson['title']) ?></strong>
                                    <span class="muted"><?= e(lesson_type_label((string) $lesson['lesson_type'])) ?></span>
                                </div>
                                <span class="<?= lesson_type_badge_class((string) $lesson['lesson_type']) ?>"><?= e(lesson_type_label((string) $lesson['lesson_type'])) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
