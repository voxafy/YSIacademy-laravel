<?php
$richText = '';
$rulesBody = '';
$mistakesBody = '';
$selectedQuestionIds = array_map('strval', (array) ($lesson['selected_question_ids'] ?? []));

foreach ($lesson['blocks'] as $block) {
    if ($block['block_type'] === 'RICH_TEXT') {
        $richText = $block['body'];
    }
    if ($block['block_type'] === 'RULES') {
        $rulesBody = $block['body'];
    }
    if ($block['block_type'] === 'MISTAKES') {
        $mistakesBody = $block['body'];
    }
}
?>

<section class="section-header admin-page-head">
    <div>
        <p class="section-kicker">Редактор урока</p>
        <h1 class="section-title"><?= e($lesson['title']) ?></h1>
        <p class="section-text"><?= e($lesson['course_title']) ?> · <?= e($lesson['module_title']) ?></p>
    </div>
    <div class="actions-row">
        <a href="<?= url('/admin/courses/' . $lesson['course_id']) ?>" class="btn btn-ghost">Вернуться к курсу</a>
        <form action="<?= url('/admin/lessons/' . $lesson['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Удалить урок?');">
            <?= csrf_field() ?>
            <button class="btn btn-danger" type="submit">Удалить урок</button>
        </form>
    </div>
</section>

<section class="grid grid-split admin-editor-layout">
    <article class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Основная часть</p>
                <h2 class="section-title section-title--small">Контент урока</h2>
                <p class="section-text">Соберите понятный урок: название, краткое описание и три смысловых блока, которые увидит сотрудник в интерфейсе.</p>
            </div>
        </div>

        <form action="<?= url('/admin/lessons/' . $lesson['id']) ?>" method="post" class="form-grid admin-form">
            <?= csrf_field() ?>

            <div class="form-grid form-grid-2">
                <label class="field">
                    <span class="field__label">Название</span>
                    <input class="input" type="text" name="title" value="<?= e($lesson['title']) ?>" required>
                </label>
                <label class="field">
                    <span class="field__label">Тип урока</span>
                    <select class="select" name="lesson_type">
                        <?php foreach (['TEXT', 'VIDEO', 'MIXED', 'QUIZ'] as $type): ?>
                            <option value="<?= $type ?>" <?= (string) $lesson['lesson_type'] === $type ? 'selected' : '' ?>>
                                <?= e(lesson_type_label($type)) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>

            <label class="field">
                <span class="field__label">Краткое описание</span>
                <textarea class="textarea" name="description" rows="3"><?= e((string) $lesson['description']) ?></textarea>
            </label>

            <label class="field">
                <span class="field__label">Основной материал</span>
                <textarea class="textarea textarea--xl" name="body" rows="10"><?= e((string) $richText) ?></textarea>
            </label>

            <div class="form-grid form-grid-2">
                <label class="field">
                    <span class="field__label">Правила и акценты</span>
                    <textarea class="textarea" name="rules_body" rows="7"><?= e((string) $rulesBody) ?></textarea>
                </label>
                <label class="field">
                    <span class="field__label">Типичные ошибки</span>
                    <textarea class="textarea" name="mistakes_body" rows="7"><?= e((string) $mistakesBody) ?></textarea>
                </label>
            </div>

            <button class="btn btn-primary" type="submit">Сохранить урок</button>
        </form>
    </article>

    <div class="card-stack">
        <article class="card course-editor-panel">
            <div class="section-header">
                <div>
                    <p class="section-kicker">Видео</p>
                    <h2 class="section-title section-title--small">Видео-материал урока</h2>
                </div>
            </div>

            <?php if ($lesson['video']): ?>
                <div class="media-library-item">
                    <div>
                        <strong><?= e($lesson['video']['original_name']) ?></strong>
                        <div class="media-library-item__meta">
                            <span><?= e((string) ($lesson['video']['mime_type'] ?: 'Видео')) ?></span>
                            <span><?= e(format_bytes((int) ($lesson['video']['size_bytes'] ?? 0))) ?></span>
                        </div>
                    </div>
                    <form action="<?= url('/admin/lessons/' . $lesson['id'] . '/video/delete') ?>" method="post">
                        <?= csrf_field() ?>
                        <button class="btn btn-danger btn-sm" type="submit">Удалить</button>
                    </form>
                </div>
            <?php endif; ?>

            <form action="<?= url('/admin/lessons/' . $lesson['id'] . '/video') ?>" method="post" enctype="multipart/form-data" class="form-grid media-upload-form">
                <?= csrf_field() ?>
                <label class="field">
                    <span class="field__label">Загрузить видео</span>
                    <input class="input" type="file" name="video" accept="video/*">
                </label>
                <button class="btn btn-primary" type="submit">Загрузить или заменить</button>
            </form>
        </article>

        <article class="card course-editor-panel">
            <div class="section-header">
                <div>
                    <p class="section-kicker">Файлы</p>
                    <h2 class="section-title section-title--small">Материалы для сотрудника</h2>
                </div>
            </div>

            <div class="card-stack">
                <?php foreach ($lesson['attachments'] as $attachment): ?>
                    <div class="media-library-item">
                        <div>
                            <strong><?= e($attachment['label'] ?: $attachment['original_name']) ?></strong>
                            <div class="media-library-item__meta">
                                <span><?= e((string) ($attachment['mime_type'] ?: 'Файл')) ?></span>
                                <span><?= e(format_bytes((int) ($attachment['size_bytes'] ?? 0))) ?></span>
                            </div>
                        </div>
                        <form action="<?= url('/admin/lessons/' . $lesson['id'] . '/attachments/' . $attachment['asset_id'] . '/delete') ?>" method="post">
                            <?= csrf_field() ?>
                            <button class="btn btn-danger btn-sm" type="submit">Удалить</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>

            <form action="<?= url('/admin/lessons/' . $lesson['id'] . '/attachments') ?>" method="post" enctype="multipart/form-data" class="form-grid media-upload-form">
                <?= csrf_field() ?>
                <label class="field">
                    <span class="field__label">Добавить файл</span>
                    <input class="input" type="file" name="attachment">
                </label>
                <button class="btn btn-primary" type="submit">Загрузить материал</button>
            </form>
        </article>

        <article class="card course-editor-panel">
            <div class="section-header">
                <div>
                    <p class="section-kicker">Тест</p>
                    <h2 class="section-title section-title--small">Проверка знаний</h2>
                    <p class="section-text">Выберите готовые вопросы из банка и соберите проверку без ручной работы с идентификаторами.</p>
                </div>
            </div>

            <form action="<?= url('/admin/lessons/' . $lesson['id'] . '/quiz') ?>" method="post" class="form-grid admin-form">
                <?= csrf_field() ?>
                <div class="form-grid form-grid-2">
                    <label class="field">
                        <span class="field__label">Название теста</span>
                        <input class="input" type="text" name="title" value="<?= e((string) ($lesson['quiz']['title'] ?? ('Проверка: ' . $lesson['title']))) ?>">
                    </label>
                    <label class="field">
                        <span class="field__label">Проходной балл</span>
                        <input class="input" type="number" name="pass_score" min="1" max="100" value="<?= e((string) ($lesson['quiz']['pass_score'] ?? 70)) ?>">
                    </label>
                </div>

                <label class="field">
                    <span class="field__label">Описание проверки</span>
                    <textarea class="textarea" name="description" rows="3"><?= e((string) ($lesson['quiz']['description'] ?? '')) ?></textarea>
                </label>

                <div class="question-picker">
                    <?php foreach ($questions as $question): ?>
                        <?php $isSelected = in_array((string) $question['id'], $selectedQuestionIds, true); ?>
                        <label class="question-picker__item <?= $isSelected ? 'is-selected' : '' ?>">
                            <input type="checkbox" name="question_ids[]" value="<?= e($question['id']) ?>" <?= $isSelected ? 'checked' : '' ?>>
                            <div class="question-picker__body">
                                <div class="hero-actions">
                                    <span class="badge badge-muted"><?= e(question_type_label((string) $question['question_type'])) ?></span>
                                    <span class="badge badge-info">Используется: <?= e((string) ($question['usage_count'] ?? 0)) ?></span>
                                </div>
                                <strong><?= e($question['prompt']) ?></strong>
                                <?php if (!empty($question['explanation'])): ?>
                                    <span><?= e($question['explanation']) ?></span>
                                <?php endif; ?>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>

                <button class="btn btn-primary" type="submit">Сохранить тест</button>
            </form>
        </article>
    </div>
</section>
