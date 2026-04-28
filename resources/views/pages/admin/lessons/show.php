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

ob_start();
?>
<a href="<?= url('/admin/courses/' . $lesson['course_id']) ?>" class="btn btn-ghost">Вернуться к курсу</a>
<form action="<?= url('/admin/lessons/' . $lesson['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Удалить урок?');">
    <?= csrf_field() ?>
    <button class="btn btn-danger" type="submit">Удалить урок</button>
</form>
<?php
$pageHeaderActionsHtml = ob_get_clean();
$pageHeaderKicker = 'Редактор урока';
$pageHeaderTitle = $lesson['title'];
$pageHeaderText = $lesson['course_title'] . ' · ' . $lesson['module_title'];
$pageHeaderClass = 'admin-page-head';
$pageHeaderTitleClass = '';
$pageHeaderTextClass = '';
?>

<div class="page-stack">
    <?php include resource_path('views/partials/ui/page-header.php'); ?>

    <section class="grid grid-split admin-editor-layout">
        <article class="card course-editor-panel">
            <?php
            $pageHeaderKicker = 'Основная часть';
            $pageHeaderTitle = 'Контент урока';
            $pageHeaderText = 'Соберите понятный урок: название, краткое описание и смысловые блоки, которые сотрудник увидит в рабочем интерфейсе.';
            $pageHeaderTitleTag = 'h2';
            $pageHeaderTitleClass = 'section-title--small';
            $pageHeaderActionsHtml = '';
            include resource_path('views/partials/ui/page-header.php');
            ?>

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
                <?php
                $pageHeaderKicker = 'Видео';
                $pageHeaderTitle = 'Видео-материал урока';
                $pageHeaderText = 'Добавьте ролик к уроку или замените текущий файл без переходов в отдельную медиатеку.';
                include resource_path('views/partials/ui/page-header.php');
                ?>

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
                    <div class="field">
                        <span class="field__label">Загрузить видео</span>
                        <label class="file-input" data-file-input>
                            <input class="file-input__native" type="file" name="video" accept="video/*" data-file-input-native>
                            <span class="file-input__button">Выбрать файл</span>
                            <span class="file-input__name" data-file-input-name>Файл пока не выбран</span>
                        </label>
                    </div>
                    <button class="btn btn-primary" type="submit">Загрузить или заменить</button>
                </form>
            </article>

            <article class="card course-editor-panel">
                <?php
                $pageHeaderKicker = 'Файлы';
                $pageHeaderTitle = 'Материалы для сотрудника';
                $pageHeaderText = 'Прикрепляйте инструкции, чек-листы и дополнительные документы, которые помогут пройти урок до конца.';
                include resource_path('views/partials/ui/page-header.php');
                ?>

                <?php if ($lesson['attachments'] === []): ?>
                    <?php
                    $emptyStateTitle = 'Материалы пока не добавлены';
                    $emptyStateText = 'Здесь появятся файлы, которые можно открыть прямо из урока: регламенты, чек-листы и сопроводительные документы.';
                    $emptyStateActionsHtml = '';
                    include resource_path('views/partials/ui/empty-state.php');
                    ?>
                <?php else: ?>
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
                <?php endif; ?>

                <form action="<?= url('/admin/lessons/' . $lesson['id'] . '/attachments') ?>" method="post" enctype="multipart/form-data" class="form-grid media-upload-form">
                    <?= csrf_field() ?>
                    <div class="field">
                        <span class="field__label">Добавить файл</span>
                        <label class="file-input" data-file-input>
                            <input class="file-input__native" type="file" name="attachment" data-file-input-native>
                            <span class="file-input__button">Выбрать файл</span>
                            <span class="file-input__name" data-file-input-name>Файл пока не выбран</span>
                        </label>
                    </div>
                    <button class="btn btn-primary" type="submit">Загрузить материал</button>
                </form>
            </article>

            <article class="card course-editor-panel">
                <?php
                $pageHeaderKicker = 'Тест';
                $pageHeaderTitle = 'Проверка знаний';
                $pageHeaderText = 'Выберите готовые вопросы из банка и соберите проверку без ручной работы с идентификаторами.';
                include resource_path('views/partials/ui/page-header.php');
                ?>

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
</div>
