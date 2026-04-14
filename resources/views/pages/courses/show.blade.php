<?php
$enrollment = $course['enrollment'] ?? null;
$canEditCourse = in_array((string) ($user['role_key'] ?? ''), ['ADMIN', 'LEADER'], true);
$moduleCount = count($course['modules']);
$allLessons = [];
$lessonProgressMap = [];

foreach (($enrollment['lesson_progress'] ?? []) as $progressItem) {
    $lessonProgressMap[(string) $progressItem['lesson_id']] = $progressItem;
}

foreach ($course['modules'] as $moduleIndex => $module) {
    foreach ($module['lessons'] as $lessonIndex => $moduleLesson) {
        $moduleLesson['_module_index'] = $moduleIndex + 1;
        $moduleLesson['_lesson_index'] = $lessonIndex + 1;
        $allLessons[] = $moduleLesson;
    }
}

$lessonCount = count($allLessons);
$firstLesson = $allLessons[0] ?? null;
$lastLessonId = (string) ($enrollment['last_lesson_id'] ?? '');
$progressPercent = (int) ($enrollment['completion_percent'] ?? 0);
$primaryCta = null;
$secondaryCta = null;
$nextLesson = null;

foreach ($allLessons as $moduleLesson) {
    $progress = $lessonProgressMap[(string) $moduleLesson['id']] ?? null;
    if ((int) ($progress['is_completed'] ?? 0) !== 1) {
        $nextLesson = $moduleLesson;
        break;
    }
}

if (!$user) {
    $primaryCta = [
        'href' => url('/login'),
        'label' => 'Войти, чтобы начать',
        'class' => 'btn btn-primary',
    ];
} elseif ($enrollment && $nextLesson) {
    $primaryCta = [
        'href' => url('/courses/' . $course['slug'] . '/lessons/' . $nextLesson['id']),
        'label' => 'Продолжить обучение',
        'class' => 'btn btn-primary',
    ];
} elseif ($enrollment && $firstLesson) {
    $primaryCta = [
        'href' => url('/courses/' . $course['slug'] . '/lessons/' . $firstLesson['id']),
        'label' => ((string) ($enrollment['status'] ?? '')) === 'COMPLETED' ? 'Повторить курс' : 'Открыть маршрут',
        'class' => 'btn btn-primary',
    ];
} elseif ($firstLesson && (($user['role_key'] ?? '') !== 'STUDENT')) {
    $primaryCta = [
        'href' => url('/courses/' . $course['slug'] . '/lessons/' . $firstLesson['id']),
        'label' => 'Открыть маршрут',
        'class' => 'btn btn-primary',
    ];
}

if ($canEditCourse) {
    $secondaryCta = [
        'href' => url('/admin/courses/' . $course['id']),
        'label' => 'Редактировать курс',
    ];
}
?>

<section class="course-page-shell">
    <div class="course-page-shell__topbar">
        <a href="<?= url('/courses') ?>" class="btn btn-ghost btn-sm">← Назад к каталогу</a>
        <?php if ($secondaryCta): ?>
            <a href="<?= $secondaryCta['href'] ?>" class="btn btn-ghost btn-sm"><?= e($secondaryCta['label']) ?></a>
        <?php endif; ?>
    </div>

    <section class="hero-card is-brand course-hero course-hero--enhanced">
        <div class="course-hero__content">
            <div>
                <p class="section-kicker course-hero__kicker"><?= e($course['category']['title']) ?></p>
                <h1 class="section-title course-hero__title"><?= e($course['title']) ?></h1>
                <p class="section-text course-hero__text"><?= e((string) ($course['description'] ?: $course['short_description'])) ?></p>

                <div class="course-hero__badges">
                    <span class="badge badge-cyan"><?= e((string) $moduleCount) ?> модулей</span>
                    <span class="badge badge-info"><?= e((string) $lessonCount) ?> уроков</span>
                    <?php if (!empty($course['estimated_minutes'])): ?>
                        <span class="badge badge-muted"><?= e((string) $course['estimated_minutes']) ?> мин</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card course-hero__panel course-hero__panel--rich">
                <?php if ($enrollment): ?>
                    <div class="course-hero__status-line">
                        <span class="<?= course_status_class((string) $enrollment['status']) ?>">
                            <?= e(course_status_label((string) $enrollment['status'])) ?>
                        </span>
                        <span class="badge badge-muted">Прогресс <?= e(format_percent($progressPercent)) ?></span>
                    </div>

                    <div class="course-hero__progress">
                        <div class="course-hero__progress-label">Маршрут обучения</div>
                        <div class="progress"><div class="progress__bar" style="width: <?= $progressPercent ?>%;"></div></div>
                    </div>

                    <div class="course-hero__summary-grid">
                        <div class="course-hero__summary-card">
                            <span>Модули</span>
                            <strong><?= e((string) ($enrollment['modules_completed'] ?? 0)) ?>/<?= e((string) ($enrollment['modules_total'] ?? 0)) ?></strong>
                        </div>
                        <div class="course-hero__summary-card">
                            <span>Уроки</span>
                            <strong><?= e((string) ($enrollment['lessons_completed'] ?? 0)) ?>/<?= e((string) ($enrollment['lessons_total'] ?? 0)) ?></strong>
                        </div>
                        <div class="course-hero__summary-card">
                            <span>Следующий шаг</span>
                            <strong><?= e($nextLesson['title'] ?? ($firstLesson['title'] ?? 'Маршрут пройден')) ?></strong>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="course-hero__summary-grid">
                        <div class="course-hero__summary-card">
                            <span>Формат</span>
                            <strong>Маршрут, материалы и проверки</strong>
                        </div>
                        <div class="course-hero__summary-card">
                            <span>Аудитория</span>
                            <strong><?= e((string) ($course['target_audience'] ?: 'Сотрудники ЮСИ')) ?></strong>
                        </div>
                        <div class="course-hero__summary-card">
                            <span>Старт</span>
                            <strong><?= $user ? 'После назначения курса' : 'После входа в систему' ?></strong>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($primaryCta): ?>
                    <div class="course-hero__actions">
                        <a href="<?= $primaryCta['href'] ?>" class="<?= $primaryCta['class'] ?>"><?= e($primaryCta['label']) ?></a>
                        <a href="#course-route" class="btn btn-ghost">Посмотреть маршрут</a>
                    </div>
                <?php else: ?>
                    <p class="course-hero__notice">Курс откроется после назначения сотруднику или публикации для вашей роли.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section id="course-route" class="card course-route-card">
        <div class="course-route-card__head">
            <div>
                <p class="section-kicker">Маршрут обучения</p>
                <h2 class="section-title section-title--small">Структура курса</h2>
                <p class="section-text">Выберите удобный режим: визуальная карта шагов или компактный список модулей и уроков.</p>
            </div>
            <div class="course-route-card__controls">
                <div class="segmented-toggle" data-view-group="course-structure">
                    <button type="button" class="segmented-toggle__item is-active" data-view-toggle="map">Картой</button>
                    <button type="button" class="segmented-toggle__item" data-view-toggle="list">Списком</button>
                </div>
            </div>
        </div>

        <div class="course-route-legend">
            <span class="course-route-legend__item"><i class="course-route-legend__dot course-route-legend__dot--default"></i> Доступный шаг</span>
            <span class="course-route-legend__item"><i class="course-route-legend__dot course-route-legend__dot--current"></i> Текущий фокус</span>
            <span class="course-route-legend__item"><i class="course-route-legend__dot course-route-legend__dot--done"></i> Пройдено</span>
            <span class="course-route-legend__item"><i class="course-route-legend__dot course-route-legend__dot--quiz"></i> Проверка знаний</span>
        </div>

        <div class="course-route-view" data-view-panel="map" data-view-group="course-structure">
            <div class="module-map">
                <?php foreach ($course['modules'] as $moduleIndex => $module): ?>
                    <div class="module-map__column">
                        <article class="module-map__module">
                            <p class="section-kicker">Модуль <?= e((string) ($moduleIndex + 1)) ?></p>
                            <h3 class="module-map__title"><?= e($module['title']) ?></h3>
                            <p class="section-text"><?= e((string) ($module['description'] ?: 'Описание модуля появится после наполнения контентом.')) ?></p>
                        </article>

                        <div class="module-map__track">
                            <?php foreach ($module['lessons'] as $lessonIndex => $moduleLesson): ?>
                                <?php
                                $lessonProgress = $lessonProgressMap[(string) $moduleLesson['id']] ?? null;
                                $isCompleted = (int) ($lessonProgress['is_completed'] ?? 0) === 1;
                                $isCurrent = !$isCompleted && $nextLesson && $nextLesson['id'] === $moduleLesson['id'];
                                $nodeClasses = ['module-node'];

                                $nodeClasses[] = match ((string) $moduleLesson['lesson_type']) {
                                    'QUIZ' => 'module-node--quiz',
                                    'VIDEO' => 'module-node--video',
                                    default => 'module-node--mixed',
                                };

                                if ($isCompleted) {
                                    $nodeClasses[] = 'module-node--done';
                                } elseif ($isCurrent) {
                                    $nodeClasses[] = 'module-node--current';
                                }
                                ?>
                                <a href="<?= url('/courses/' . $course['slug'] . '/lessons/' . $moduleLesson['id']) ?>" class="<?= implode(' ', $nodeClasses) ?>">
                                    <span class="module-node__step"><?= e((string) ($moduleIndex + 1)) ?>.<?= e((string) ($lessonIndex + 1)) ?></span>
                                    <strong class="module-node__title"><?= e($moduleLesson['title']) ?></strong>
                                    <span class="module-node__meta"><?= e(lesson_type_label((string) $moduleLesson['lesson_type'])) ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="course-route-view" data-view-panel="list" data-view-group="course-structure" hidden>
            <div class="card-stack">
                <?php foreach ($course['modules'] as $moduleIndex => $module): ?>
                    <?php
                    $moduleHasCurrent = false;
                    foreach ($module['lessons'] as $moduleLesson) {
                        if ($nextLesson && $nextLesson['id'] === $moduleLesson['id']) {
                            $moduleHasCurrent = true;
                            break;
                        }
                    }
                    ?>
                    <details class="module-block module-block--collapsible" <?= $moduleHasCurrent || $moduleIndex === 0 ? 'open' : '' ?>>
                        <summary class="module-block__summary">
                            <div>
                                <p class="module-block__index">Модуль <?= e((string) ($moduleIndex + 1)) ?></p>
                                <h3 class="module-block__title"><?= e($module['title']) ?></h3>
                                <p class="section-text"><?= e((string) ($module['description'] ?: 'Описание модуля появится после наполнения контентом.')) ?></p>
                            </div>
                            <span class="badge badge-muted"><?= e((string) count($module['lessons'])) ?> уроков</span>
                        </summary>

                        <div class="module-block__lessons">
                            <?php foreach ($module['lessons'] as $lessonIndex => $moduleLesson): ?>
                                <?php
                                $lessonProgress = $lessonProgressMap[(string) $moduleLesson['id']] ?? null;
                                $isCompleted = (int) ($lessonProgress['is_completed'] ?? 0) === 1;
                                $isCurrent = !$isCompleted && $nextLesson && $nextLesson['id'] === $moduleLesson['id'];
                                ?>
                                <a href="<?= url('/courses/' . $course['slug'] . '/lessons/' . $moduleLesson['id']) ?>" class="module-block__lesson <?= $isCurrent ? 'is-active' : '' ?> <?= $isCompleted ? 'is-complete' : '' ?>">
                                    <span class="module-block__lesson-step"><?= e((string) ($moduleIndex + 1)) ?>.<?= e((string) ($lessonIndex + 1)) ?></span>
                                    <div class="module-block__lesson-body">
                                        <strong><?= e($moduleLesson['title']) ?></strong>
                                        <span class="muted"><?= e(lesson_type_label((string) $moduleLesson['lesson_type'])) ?></span>
                                    </div>
                                    <?php if ($isCompleted): ?>
                                        <span class="badge badge-success">Пройдено</span>
                                    <?php elseif ($isCurrent): ?>
                                        <span class="badge badge-info">Следующий шаг</span>
                                    <?php else: ?>
                                        <span class="<?= lesson_type_badge_class((string) $moduleLesson['lesson_type']) ?>"><?= e(lesson_type_label((string) $moduleLesson['lesson_type'])) ?></span>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</section>
