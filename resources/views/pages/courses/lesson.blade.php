<?php
$enrollment = $course['enrollment'] ?? null;
$allLessons = [];
foreach ($course['modules'] as $moduleItem) {
    foreach ($moduleItem['lessons'] as $moduleLesson) {
        $allLessons[] = $moduleLesson;
    }
}
$nextLesson = null;
foreach ($allLessons as $index => $moduleLesson) {
    if ($moduleLesson['id'] === $lesson['id']) {
        $nextLesson = $allLessons[$index + 1] ?? null;
        break;
    }
}
?>
<section class="grid grid-sidebar">
    <aside class="card" style="padding: 24px;">
        <p class="section-kicker">Навигация по курсу</p>
        <h2 class="section-title section-title--small"><?= e($course['title']) ?></h2>
        <?php if ($enrollment): ?>
            <div style="margin-top: 14px;">
                <span class="<?= course_status_class((string) $enrollment['status']) ?>"><?= e(course_status_label((string) $enrollment['status'])) ?></span>
            </div>
        <?php endif; ?>
        <div class="card-stack" style="margin-top: 20px;">
            <?php foreach ($course['modules'] as $module): ?>
                <section>
                    <div class="section-kicker" style="margin-bottom: 10px;"><?= e($module['title']) ?></div>
                    <div class="card-stack">
                        <?php foreach ($module['lessons'] as $moduleLesson): ?>
                            <a href="<?= url('/courses/' . $course['slug'] . '/lessons/' . $moduleLesson['id']) ?>" class="nav-pill <?= $moduleLesson['id'] === $lesson['id'] ? 'is-active' : '' ?>">
                                <?= e($moduleLesson['title']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
    </aside>

    <div class="card-stack">
        <article class="card" style="padding: 28px;">
            <p class="section-kicker"><?= e($lesson['lesson_type'] === 'QUIZ' ? 'Проверка знаний' : 'Урок') ?></p>
            <h1 class="section-title section-title--small"><?= e($lesson['title']) ?></h1>
            <p class="section-text"><?= e($lesson['description']) ?></p>
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

        <div class="actions-row">
            <a href="<?= url('/courses/' . $course['slug']) ?>" class="btn btn-ghost">Назад к курсу</a>
            <?php if ($nextLesson): ?>
                <a href="<?= url('/courses/' . $course['slug'] . '/lessons/' . $nextLesson['id']) ?>" class="btn btn-primary">Следующий урок</a>
            <?php endif; ?>
        </div>
    </div>
</section>
