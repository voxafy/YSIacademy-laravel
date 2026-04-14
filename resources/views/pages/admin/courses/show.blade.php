<?php
$moduleCount = count($course['modules']);
$lessonCount = array_sum(array_map(static fn (array $module): int => count($module['lessons'] ?? []), $course['modules']));
$selectedCityIds = array_map('strval', (array) ($course['city_ids'] ?? []));
$selectedDepartmentIds = array_map('strval', (array) ($course['department_ids'] ?? []));
?>

<section class="section-header admin-page-head">
    <div>
        <p class="section-kicker">Редактор курса</p>
        <h1 class="section-title"><?= e($course['title']) ?></h1>
        <p class="section-text">Настройте карточку курса, условия публикации и сам маршрут обучения. Всё, что увидит сотрудник, собирается здесь.</p>
    </div>
    <div class="actions-row">
        <a href="<?= url('/admin/courses') ?>" class="btn btn-ghost">К списку курсов</a>
    </div>
</section>

<section class="grid grid-split admin-editor-layout">
    <article class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Основные данные</p>
                <h2 class="section-title section-title--small">Карточка курса</h2>
            </div>
            <div class="hero-actions">
                <span class="<?= publication_status_badge_class((string) $course['status']) ?>"><?= e(publication_status_label((string) $course['status'])) ?></span>
                <span class="badge badge-muted"><?= e((string) $moduleCount) ?> модулей</span>
                <span class="badge badge-muted"><?= e((string) $lessonCount) ?> уроков</span>
            </div>
        </div>

        <form action="<?= url('/admin/courses/' . $course['id']) ?>" method="post" class="form-grid admin-form">
            <?= csrf_field() ?>

            <div class="admin-form-section">
                <h3 class="admin-form-section__title">Что увидит пользователь</h3>
                <div class="form-grid form-grid-2">
                    <label class="field">
                        <span class="field__label">Название</span>
                        <input class="input" type="text" name="title" value="<?= e($course['title']) ?>" required>
                    </label>
                    <label class="field">
                        <span class="field__label">Категория</span>
                        <select class="select" name="category_id" required>
                            <option value="">Выберите категорию</option>
                            <?php foreach ($resources['categories'] as $category): ?>
                                <option value="<?= e($category['id']) ?>" <?= (string) $course['category_id'] === (string) $category['id'] ? 'selected' : '' ?>>
                                    <?= e($category['title']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>

                <div class="form-grid form-grid-2">
                    <label class="field">
                        <span class="field__label">Подзаголовок</span>
                        <input class="input" type="text" name="subtitle" value="<?= e((string) $course['subtitle']) ?>">
                    </label>
                    <label class="field">
                        <span class="field__label">Аудитория</span>
                        <input class="input" type="text" name="target_audience" value="<?= e((string) $course['target_audience']) ?>">
                    </label>
                </div>

                <label class="field">
                    <span class="field__label">Краткое описание</span>
                    <textarea class="textarea" name="short_description" rows="3"><?= e((string) $course['short_description']) ?></textarea>
                </label>

                <label class="field">
                    <span class="field__label">Полное описание</span>
                    <textarea class="textarea" name="description" rows="8"><?= e((string) $course['description']) ?></textarea>
                </label>
            </div>

            <div class="admin-form-section">
                <h3 class="admin-form-section__title">Публикация и доступ</h3>
                <div class="form-grid form-grid-3">
                    <label class="field">
                        <span class="field__label">Статус</span>
                        <select class="select" name="status">
                            <?php foreach (['DRAFT', 'PUBLISHED', 'TEMPLATE', 'ARCHIVED'] as $status): ?>
                                <option value="<?= $status ?>" <?= (string) $course['status'] === $status ? 'selected' : '' ?>>
                                    <?= e(publication_status_label($status)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label class="field">
                        <span class="field__label">Длительность, минут</span>
                        <input class="input" type="number" name="estimated_minutes" min="0" value="<?= e((string) ($course['estimated_minutes'] ?? 0)) ?>">
                    </label>
                    <label class="field">
                        <span class="field__label">Проходной балл</span>
                        <input class="input" type="number" name="pass_score" min="1" max="100" value="<?= e((string) ($course['pass_score'] ?? 70)) ?>">
                    </label>
                </div>

                <div class="form-grid form-grid-2">
                    <label class="field">
                        <span class="field__label">Ограничение по городам</span>
                        <select class="select" name="city_ids[]" multiple size="5">
                            <?php foreach ($options['cities'] as $city): ?>
                                <option value="<?= e($city['id']) ?>" <?= in_array((string) $city['id'], $selectedCityIds, true) ? 'selected' : '' ?>>
                                    <?= e($city['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label class="field">
                        <span class="field__label">Ограничение по подразделениям</span>
                        <select class="select" name="department_ids[]" multiple size="5">
                            <?php foreach ($options['departments'] as $department): ?>
                                <option value="<?= e($department['id']) ?>" <?= in_array((string) $department['id'], $selectedDepartmentIds, true) ? 'selected' : '' ?>>
                                    <?= e($department['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
            </div>

            <details class="editor-advanced">
                <summary>Расширенные настройки</summary>
                <div class="editor-advanced__body form-grid">
                    <label class="field">
                        <span class="field__label">Адрес курса</span>
                        <input class="input" type="text" name="slug" value="<?= e((string) $course['slug']) ?>">
                    </label>
                </div>
            </details>

            <button class="btn btn-primary" type="submit">Сохранить курс</button>
        </form>
    </article>

    <article class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Структура курса</p>
                <h2 class="section-title section-title--small">Модули и уроки</h2>
                <p class="section-text">Редактируйте модуль, порядок и содержимое маршрута. Новый урок можно добавить прямо из карточки модуля.</p>
            </div>
        </div>

        <div class="card-stack">
            <?php foreach ($course['modules'] as $moduleIndex => $module): ?>
                <article class="module-block module-block--editor">
                    <form action="<?= url('/admin/modules/' . $module['id']) ?>" method="post" class="form-grid admin-form">
                        <?= csrf_field() ?>
                        <div class="module-block__header">
                            <div>
                                <p class="module-block__index">Модуль <?= e((string) ($moduleIndex + 1)) ?></p>
                                <h3 class="module-block__title"><?= e($module['title']) ?></h3>
                                <p class="section-text">Этот блок формирует отдельный этап маршрута и влияет на общий прогресс.</p>
                            </div>
                            <div class="hero-actions">
                                <span class="badge badge-muted"><?= e((string) count($module['lessons'])) ?> уроков</span>
                                <?php if (!empty($module['is_published'])): ?>
                                    <span class="badge badge-success">Опубликован</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Скрыт</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-grid form-grid-2">
                            <label class="field">
                                <span class="field__label">Название модуля</span>
                                <input class="input" type="text" name="title" value="<?= e((string) $module['title']) ?>" required>
                            </label>
                            <label class="field">
                                <span class="field__label">Порядок</span>
                                <input class="input" type="number" name="sort_order" min="1" value="<?= e((string) ($module['sort_order'] ?? ($moduleIndex + 1))) ?>">
                            </label>
                        </div>

                        <label class="field">
                            <span class="field__label">Описание модуля</span>
                            <textarea class="textarea" name="description" rows="4"><?= e((string) $module['description']) ?></textarea>
                        </label>

                        <div class="form-grid form-grid-3">
                            <label class="field">
                                <span class="field__label">Минут на модуль</span>
                                <input class="input" type="number" name="estimated_minutes" min="1" value="<?= e((string) ($module['estimated_minutes'] ?? 15)) ?>">
                            </label>
                            <label class="field">
                                <span class="field__label">Проходной балл</span>
                                <input class="input" type="number" name="pass_score" min="1" max="100" value="<?= e((string) ($module['pass_score'] ?? 70)) ?>">
                            </label>
                            <label class="field field--check">
                                <span class="field__label">Публикация</span>
                                <label class="checkbox-row">
                                    <input type="checkbox" name="is_published" value="1" <?= !empty($module['is_published']) ? 'checked' : '' ?>>
                                    <span>Показывать сотрудникам этот модуль</span>
                                </label>
                            </label>
                        </div>

                        <div class="actions-row">
                            <button class="btn btn-primary btn-sm" type="submit">Сохранить модуль</button>
                        </div>
                    </form>

                    <form action="<?= url('/admin/modules/' . $module['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Удалить модуль и все уроки внутри?');">
                        <?= csrf_field() ?>
                        <button class="btn btn-danger btn-sm" type="submit">Удалить модуль</button>
                    </form>

                    <div class="module-block__lessons">
                        <?php foreach ($module['lessons'] as $lessonIndex => $lesson): ?>
                            <a href="<?= url('/admin/lessons/' . $lesson['id']) ?>" class="module-block__lesson module-block__lesson--editor">
                                <span class="module-block__lesson-step"><?= e((string) ($moduleIndex + 1)) ?>.<?= e((string) ($lessonIndex + 1)) ?></span>
                                <div class="module-block__lesson-body">
                                    <strong><?= e($lesson['title']) ?></strong>
                                    <span class="muted"><?= e((string) ($lesson['description'] ?: 'Описание урока пока не добавлено.')) ?></span>
                                </div>
                                <span class="<?= lesson_type_badge_class((string) $lesson['lesson_type']) ?>"><?= e(lesson_type_label((string) $lesson['lesson_type'])) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>

                    <form action="<?= url('/admin/modules/' . $module['id'] . '/lessons') ?>" method="post" class="form-grid form-grid-3 module-block__create-lesson">
                        <?= csrf_field() ?>
                        <label class="field">
                            <span class="field__label">Название урока</span>
                            <input class="input" type="text" name="title" required>
                        </label>
                        <label class="field">
                            <span class="field__label">Описание</span>
                            <input class="input" type="text" name="description">
                        </label>
                        <label class="field">
                            <span class="field__label">Тип урока</span>
                            <select class="select" name="lesson_type">
                                <?php foreach (['TEXT', 'VIDEO', 'MIXED', 'QUIZ'] as $type): ?>
                                    <option value="<?= $type ?>"><?= e(lesson_type_label($type)) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <div style="grid-column: 1 / -1;">
                            <button class="btn btn-ghost" type="submit">Добавить урок в модуль</button>
                        </div>
                    </form>
                </article>
            <?php endforeach; ?>

            <article class="course-item course-item--placeholder">
                <div class="section-header">
                    <div>
                        <p class="section-kicker">Новый этап</p>
                        <h3 class="employee-course-card__title">Добавить модуль</h3>
                        <p class="section-text">Создайте следующий блок маршрута: после этого в него можно будет сразу заносить уроки.</p>
                    </div>
                </div>

                <form action="<?= url('/admin/courses/' . $course['id'] . '/modules') ?>" method="post" class="form-grid">
                    <?= csrf_field() ?>
                    <label class="field">
                        <span class="field__label">Название модуля</span>
                        <input class="input" type="text" name="title" required>
                    </label>
                    <label class="field">
                        <span class="field__label">Описание</span>
                        <textarea class="textarea" name="description" rows="4"></textarea>
                    </label>
                    <button class="btn btn-primary" type="submit">Добавить модуль</button>
                </form>
            </article>
        </div>
    </article>
</section>
