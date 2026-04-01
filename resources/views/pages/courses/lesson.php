<?php
$enrollment = $course['enrollment'] ?? null;
$allLessons = [];
foreach ($course['modules'] as $moduleItem) {
    foreach ($moduleItem['lessons'] as $moduleLesson) {
        $allLessons[] = $moduleLesson;
    }
}
$nextLesson = null;
$previousLesson = null;
$currentLessonNumber = 1;
foreach ($allLessons as $index => $moduleLesson) {
    if ($moduleLesson['id'] === $lesson['id']) {
        $previousLesson = $allLessons[$index - 1] ?? null;
        $nextLesson = $allLessons[$index + 1] ?? null;
        $currentLessonNumber = $index + 1;
        break;
    }
}
$totalLessons = count($allLessons);
$courseProgress = $enrollment
    ? (int) ($enrollment['completion_percent'] ?? 0)
    : (int) round(($currentLessonNumber / max(1, $totalLessons)) * 100);
?>
<section class="grid lesson-layout">
    <aside class="lesson-sidebar-shell" data-lesson-nav>
        <div class="card lesson-sidebar-compact">
            <button type="button" class="lesson-sidebar-compact__toggle" data-lesson-nav-toggle aria-expanded="false" aria-controls="lesson-nav-panel">
                <span class="lesson-sidebar-compact__toggle-icon">&gt;</span>
            </button>
            <div class="lesson-sidebar-compact__summary">
                <span class="lesson-sidebar-compact__label">Прогресс</span>
                <strong class="lesson-sidebar-compact__value"><?= e(format_percent($courseProgress)) ?></strong>
                <span class="lesson-sidebar-compact__meta">Шаг <?= e((string) $currentLessonNumber) ?>/<?= e((string) $totalLessons) ?></span>
            </div>
            <div class="progress lesson-sidebar-compact__progress"><div class="progress__bar" style="width: <?= $courseProgress ?>%;"></div></div>
        </div>

        <div class="lesson-sidebar-backdrop" hidden data-lesson-nav-backdrop></div>

        <div class="card lesson-sidebar-panel" id="lesson-nav-panel" hidden data-lesson-nav-panel>
            <div class="lesson-sidebar-panel__header">
                <div class="lesson-sidebar-panel__intro">
                    <p class="section-kicker">Навигация по курсу</p>
                    <h2 class="lesson-sidebar-panel__course"><?= e($course['title']) ?></h2>
                    <p class="lesson-sidebar-panel__meta">Шаг <?= e((string) $currentLessonNumber) ?> из <?= e((string) $totalLessons) ?></p>
                </div>
                <button type="button" class="lesson-sidebar-panel__close" data-lesson-nav-close aria-label="Свернуть навигацию">&lt;</button>
            </div>

            <div class="lesson-sidebar-panel__summary">
                <?php if ($enrollment): ?>
                    <div class="lesson-sidebar__status">
                        <span class="<?= course_status_class((string) $enrollment['status']) ?>"><?= e(course_status_label((string) $enrollment['status'])) ?></span>
                    </div>
                <?php endif; ?>
                <div class="lesson-sidebar-panel__progress">
                    <div class="progress"><div class="progress__bar" style="width: <?= $courseProgress ?>%;"></div></div>
                    <div class="lesson-sidebar-panel__progress-meta">
                        <?php if ($enrollment): ?>
                            Модули <?= e((string) ($enrollment['modules_completed'] ?? 0)) ?>/<?= e((string) ($enrollment['modules_total'] ?? 0)) ?>
                            · Уроки <?= e((string) ($enrollment['lessons_completed'] ?? 0)) ?>/<?= e((string) ($enrollment['lessons_total'] ?? 0)) ?>
                        <?php else: ?>
                            Сейчас открыт шаг <?= e((string) $currentLessonNumber) ?> из <?= e((string) $totalLessons) ?>
                        <?php endif; ?>
                    </div>
                </div>
                <a href="<?= url('/courses/' . $course['slug']) ?>" class="btn btn-ghost btn-sm lesson-sidebar__back">К программе курса</a>
            </div>

            <div class="lesson-nav-groups">
                <?php foreach ($course['modules'] as $moduleIndex => $module): ?>
                    <section class="lesson-nav-group">
                        <div class="lesson-nav-group__header">
                            <div class="lesson-nav-group__index">Модуль <?= $moduleIndex + 1 ?></div>
                            <h3 class="lesson-nav-group__title"><?= e($module['title']) ?></h3>
                            <p class="lesson-nav-group__meta"><?= e((string) count($module['lessons'])) ?> уроков</p>
                        </div>
                        <div class="lesson-nav-list">
                            <?php foreach ($module['lessons'] as $lessonIndex => $moduleLesson): ?>
                                <a href="<?= url('/courses/' . $course['slug'] . '/lessons/' . $moduleLesson['id']) ?>" class="lesson-nav-item <?= $moduleLesson['id'] === $lesson['id'] ? 'is-active' : '' ?>">
                                    <span class="lesson-nav-item__step"><?= e((string) ($moduleIndex + 1)) ?>.<?= e((string) ($lessonIndex + 1)) ?></span>
                                    <span class="lesson-nav-item__body">
                                        <span class="lesson-nav-item__type"><?= e(lesson_type_label((string) $moduleLesson['lesson_type'])) ?></span>
                                        <span class="lesson-nav-item__title"><?= e($moduleLesson['title']) ?></span>
                                    </span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
        </div>
    </aside>

    <div class="card-stack lesson-content">
        <article class="card" style="padding: 28px;">
            <p class="section-kicker"><?= e($lesson['lesson_type'] === 'QUIZ' ? 'Проверка знаний' : 'Урок') ?></p>
            <h1 class="section-title section-title--small"><?= e($lesson['title']) ?></h1>
            <p class="section-text"><?= e($lesson['description']) ?></p>
            <div class="lesson-meta-row">
                <span class="badge badge-muted">Шаг <?= e((string) $currentLessonNumber) ?> из <?= e((string) $totalLessons) ?></span>
            </div>
        </article>

        <?php if ($lesson['video']): ?>
            <article class="card content-block">
                <video class="video-frame" controls src="<?= media_url((string) $lesson['video']['asset_id']) ?>"></video>
            </article>
        <?php endif; ?>

        <?php if ($lesson['lesson_type'] === 'QUIZ' && $lesson['quiz']): ?>
            <article class="card content-block">
                <div class="section-header">
                    <div>
                        <p class="section-kicker">Тест</p>
                        <h2 class="section-title section-title--small"><?= e($lesson['quiz']['title']) ?></h2>
                    </div>
                </div>
                <form action="<?= url('/quizzes/' . $lesson['quiz']['id'] . '/submit') ?>" method="post" class="form-grid">
                    <?= csrf_field() ?>
                    <div class="list-item">
                        Проходной балл: <strong><?= e((string) $lesson['quiz']['pass_score']) ?>%</strong>
                    </div>
                    <?php foreach ($lesson['quiz']['questions'] as $question): ?>
                        <section class="course-item">
                            <p class="section-kicker">Вопрос <?= e((string) $question['sort_order']) ?></p>
                            <h3 style="margin: 10px 0 0; font-size: 1.2rem;"><?= e($question['prompt']) ?></h3>
                            <div class="card-stack" style="margin-top: 16px;">
                                <?php if (in_array($question['question_type'], ['SINGLE', 'BOOLEAN', 'CASE'], true)): ?>
                                    <?php foreach ($question['options'] as $option): ?>
                                        <label class="list-item">
                                            <input type="radio" name="question-<?= e($question['question_id']) ?>" value="<?= e($option['id']) ?>">
                                            <?= e($option['label']) ?>
                                        </label>
                                    <?php endforeach; ?>
                                <?php elseif ($question['question_type'] === 'MULTIPLE'): ?>
                                    <?php foreach ($question['options'] as $option): ?>
                                        <label class="list-item">
                                            <input type="checkbox" name="question-<?= e($question['question_id']) ?>[]" value="<?= e($option['id']) ?>">
                                            <?= e($option['label']) ?>
                                        </label>
                                    <?php endforeach; ?>
                                <?php elseif ($question['question_type'] === 'MATCHING'): ?>
                                    <?php foreach ($question['options'] as $option): ?>
                                        <label class="field">
                                            <span class="field__label"><?= e($option['label']) ?></span>
                                            <input class="input" type="text" name="question-<?= e($question['question_id']) ?>-<?= e($option['id']) ?>" placeholder="Введите соответствие">
                                        </label>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </section>
                    <?php endforeach; ?>
                    <button class="btn btn-primary" type="submit">Отправить ответы</button>
                </form>
            </article>
        <?php else: ?>
            <?php foreach ($lesson['blocks'] as $block): ?>
                <?php if (trim((string) ($block['body'] ?? '')) === '' && trim((string) ($block['title'] ?? '')) === '') continue; ?>
                <article class="card content-block">
                    <?php if (!empty($block['title'])): ?>
                        <h2 class="section-title section-title--small"><?= e($block['title']) ?></h2>
                    <?php endif; ?>
                    <div class="markdown"><?= markdown_html((string) $block['body']) ?></div>
                </article>
            <?php endforeach; ?>

            <?php if (!empty($lesson['attachments'])): ?>
                <article class="card content-block">
                    <h2 class="section-title section-title--small">Материалы</h2>
                    <div class="grid grid-2">
                        <?php foreach ($lesson['attachments'] as $attachment): ?>
                            <a href="<?= media_url((string) $attachment['asset_id']) ?>" class="list-item" target="_blank" rel="noreferrer">
                                <?= e($attachment['label'] ?: $attachment['original_name']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endif; ?>

            <?php if (($user['role_key'] ?? '') === 'STUDENT'): ?>
                <form action="<?= url('/lessons/' . $lesson['id'] . '/complete') ?>" method="post" class="card content-block">
                    <?= csrf_field() ?>
                    <div class="section-header">
                        <div>
                            <h2 class="section-title section-title--small">Завершение урока</h2>
                            <p class="section-text">После изучения материала отметьте урок как пройденный.</p>
                        </div>
                        <button class="btn btn-primary" type="submit">Урок пройден</button>
                    </div>
                </form>
            <?php endif; ?>
        <?php endif; ?>

        <div class="actions-row actions-row--lesson">
            <?php if ($previousLesson): ?>
                <a href="<?= url('/courses/' . $course['slug'] . '/lessons/' . $previousLesson['id']) ?>" class="btn btn-ghost">Предыдущий урок</a>
            <?php endif; ?>
            <a href="<?= url('/courses/' . $course['slug']) ?>" class="btn btn-ghost">Назад к курсу</a>
            <?php if ($nextLesson): ?>
                <a href="<?= url('/courses/' . $course['slug'] . '/lessons/' . $nextLesson['id']) ?>" class="btn btn-primary">Следующий урок</a>
            <?php endif; ?>
        </div>
    </div>
</section>
