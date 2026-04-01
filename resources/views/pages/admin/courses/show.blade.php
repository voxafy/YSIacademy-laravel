<?php
$moduleCount = count($course['modules']);
$lessonCount = array_sum(array_map(static fn (array $module): int => count($module['lessons'] ?? []), $course['modules']));
?>
<section class="section-header">
    <div>
        <p class="section-kicker">Редактор курса</p>
        <h1 class="section-title"><?= e($course['title']) ?></h1>
        <p class="section-text">Структура, статус публикации, модули и быстрый переход в уроки.</p>
    </div>
    <div class="actions-row">
        <a href="<?= url('/admin/courses') ?>" class="btn btn-ghost">К списку курсов</a>
    </div>
</section>

<section class="grid grid-split">
    <div class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Параметры курса</p>
                <h2 class="section-title section-title--small">Основные данные</h2>
            </div>
        </div>
        <div class="hero-actions" style="margin-bottom: 18px;">
            <span class="<?= publication_status_badge_class((string) $course['status']) ?>"><?= e(publication_status_label((string) $course['status'])) ?></span>
            <span class="badge badge-muted"><?= e((string) $moduleCount) ?> модулей</span>
            <span class="badge badge-muted"><?= e((string) $lessonCount) ?> уроков</span>
        </div>
        <form action="<?= url('/admin/courses/' . $course['id']) ?>" method="post" class="form-grid">
            <?= csrf_field() ?>
            <label class="field"><span class="field__label">Название</span><input class="input" type="text" name="title" value="<?= e($course['title']) ?>" required></label>
            <label class="field"><span class="field__label">Подзаголовок</span><input class="input" type="text" name="subtitle" value="<?= e($course['subtitle']) ?>"></label>
            <label class="field"><span class="field__label">Краткое описание</span><textarea class="textarea" name="short_description"><?= e($course['short_description']) ?></textarea></label>
            <label class="field"><span class="field__label">Полное описание</span><textarea class="textarea" name="description"><?= e($course['description']) ?></textarea></label>
            <label class="field"><span class="field__label">Целевая аудитория</span><input class="input" type="text" name="target_audience" value="<?= e($course['target_audience']) ?>"></label>
            <label class="field">
                <span class="field__label">Статус</span>
                <select class="select" name="status">
                    <?php foreach (['DRAFT','PUBLISHED','TEMPLATE','ARCHIVED'] as $status): ?>
                        <option value="<?= $status ?>" <?= $course['status'] === $status ? 'selected' : '' ?>><?= e(publication_status_label($status)) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <button class="btn btn-primary" type="submit">Сохранить курс</button>
        </form>
    </div>

    <div class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Новый модуль</p>
                <h2 class="section-title section-title--small">Добавить модуль</h2>
            </div>
        </div>
        <form action="<?= url('/admin/courses/' . $course['id'] . '/modules') ?>" method="post" class="form-grid">
            <?= csrf_field() ?>
            <label class="field"><span class="field__label">Название модуля</span><input class="input" type="text" name="title" required></label>
            <label class="field"><span class="field__label">Описание</span><textarea class="textarea" name="description" required></textarea></label>
            <button class="btn btn-primary" type="submit">Добавить модуль</button>
        </form>
    </div>
</section>

<section class="card course-structure-card course-structure-card--editor" style="margin-top: 22px;">
    <div class="course-structure-header">
        <div>
            <p class="section-kicker">Структура курса</p>
            <h2 class="section-title section-title--small">Модули и уроки</h2>
            <p class="section-text">Редактируйте модульную структуру в обновленном списке с быстрым переходом к урокам.</p>
        </div>
    </div>

    <div class="card-stack">
        <?php foreach ($course['modules'] as $moduleIndex => $module): ?>
            <article class="module-block module-block--editor">
                <div class="module-block__header">
                    <div>
                        <p class="module-block__index">Модуль <?= e((string) ($moduleIndex + 1)) ?></p>
                        <h3 class="module-block__title"><?= e($module['title']) ?></h3>
                        <p class="section-text"><?= e($module['description']) ?></p>
                    </div>
                    <div class="module-block__stats">
                        <span class="badge badge-muted"><?= e((string) count($module['lessons'])) ?> уроков</span>
                        <form action="<?= url('/admin/modules/' . $module['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Удалить модуль и все уроки?');">
                            <?= csrf_field() ?>
                            <button class="btn btn-danger btn-sm" type="submit">Удалить модуль</button>
                        </form>
                    </div>
                </div>

                <form action="<?= url('/admin/modules/' . $module['id'] . '/lessons') ?>" method="post" class="form-grid form-grid-3 module-block__create-lesson">
                    <?= csrf_field() ?>
                    <label class="field"><span class="field__label">Название урока</span><input class="input" type="text" name="title" required></label>
                    <label class="field"><span class="field__label">Описание</span><input class="input" type="text" name="description" required></label>
                    <label class="field">
                        <span class="field__label">Тип урока</span>
                        <select class="select" name="lesson_type">
                            <?php foreach (['TEXT','VIDEO','MIXED','QUIZ'] as $type): ?>
                                <option value="<?= $type ?>"><?= e(lesson_type_label($type)) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <div style="grid-column: 1 / -1;"><button class="btn btn-ghost" type="submit">Добавить урок</button></div>
                </form>

                <div class="module-block__lessons">
                    <?php foreach ($module['lessons'] as $lessonIndex => $lesson): ?>
                        <a href="<?= url('/admin/lessons/' . $lesson['id']) ?>" class="module-block__lesson module-block__lesson--editor">
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
</section>
