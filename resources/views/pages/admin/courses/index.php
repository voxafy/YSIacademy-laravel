<section class="section-header admin-page-head">
    <div>
        <p class="section-kicker">Редактор курсов</p>
        <h1 class="section-title">Управление программами обучения</h1>
        <p class="section-text">Создавайте аккуратные учебные маршруты, распределяйте их по категориям и сразу готовьте основу для дальнейшего наполнения.</p>
    </div>
    <div class="actions-row">
        <a href="<?= url('/admin/course-categories') ?>" class="btn btn-ghost">Категории курсов</a>
    </div>
</section>

<section class="grid grid-split admin-editor-layout">
    <article class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Новая программа</p>
                <h2 class="section-title section-title--small">Создать курс</h2>
                <p class="section-text">Сначала задайте основную информацию. Технические детали и ограничения можно уточнить в расширенных настройках.</p>
            </div>
        </div>

        <form action="<?= url('/admin/courses') ?>" method="post" class="form-grid admin-form">
            <?= csrf_field() ?>

            <div class="admin-form-section">
                <h3 class="admin-form-section__title">Основная информация</h3>
                <div class="form-grid form-grid-2">
                    <label class="field">
                        <span class="field__label">Название курса</span>
                        <input class="input" type="text" name="title" value="<?= e((string) old('title', '')) ?>" required>
                    </label>
                    <label class="field">
                        <span class="field__label">Категория</span>
                        <select class="select" name="category_id" required>
                            <option value="">Выберите категорию</option>
                            <?php foreach ($resources['categories'] as $category): ?>
                                <option value="<?= e($category['id']) ?>" <?= (string) old('category_id', '') === (string) $category['id'] ? 'selected' : '' ?>>
                                    <?= e($category['title']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>

                <label class="field">
                    <span class="field__label">Короткое описание</span>
                    <textarea class="textarea" name="short_description" rows="3"><?= e((string) old('short_description', '')) ?></textarea>
                </label>

                <label class="field">
                    <span class="field__label">Полное описание</span>
                    <textarea class="textarea" name="description" rows="6"><?= e((string) old('description', '')) ?></textarea>
                </label>
            </div>

            <div class="admin-form-section">
                <h3 class="admin-form-section__title">Параметры программы</h3>
                <div class="form-grid form-grid-3">
                    <label class="field">
                        <span class="field__label">Подзаголовок</span>
                        <input class="input" type="text" name="subtitle" value="<?= e((string) old('subtitle', '')) ?>" placeholder="Короткая суть или роль">
                    </label>
                    <label class="field">
                        <span class="field__label">Аудитория</span>
                        <input class="input" type="text" name="target_audience" value="<?= e((string) old('target_audience', '')) ?>" placeholder="Например: новые сотрудники ЮСИ">
                    </label>
                    <label class="field">
                        <span class="field__label">Проходной балл</span>
                        <input class="input" type="number" name="pass_score" min="1" max="100" value="<?= e((string) old('pass_score', '70')) ?>">
                    </label>
                </div>

                <label class="field">
                    <span class="field__label">Ориентировочная длительность, минут</span>
                    <input class="input" type="number" name="estimated_minutes" min="0" value="<?= e((string) old('estimated_minutes', '45')) ?>">
                </label>
            </div>

            <details class="editor-advanced">
                <summary>Расширенные настройки</summary>
                <div class="editor-advanced__body form-grid">
                    <label class="field">
                        <span class="field__label">Адрес курса</span>
                        <input class="input" type="text" name="slug" value="<?= e((string) old('slug', '')) ?>" placeholder="budet-sozdan-avtomaticheski">
                    </label>
                    <div class="form-grid form-grid-2">
                        <label class="field">
                            <span class="field__label">Ограничение по городам</span>
                            <select class="select" name="city_ids[]" multiple size="5">
                                <?php foreach ($options['cities'] as $city): ?>
                                    <option value="<?= e($city['id']) ?>" <?= in_array((string) $city['id'], array_map('strval', (array) old('city_ids', [])), true) ? 'selected' : '' ?>>
                                        <?= e($city['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <label class="field">
                            <span class="field__label">Ограничение по подразделениям</span>
                            <select class="select" name="department_ids[]" multiple size="5">
                                <?php foreach ($options['departments'] as $department): ?>
                                    <option value="<?= e($department['id']) ?>" <?= in_array((string) $department['id'], array_map('strval', (array) old('department_ids', [])), true) ? 'selected' : '' ?>>
                                        <?= e($department['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    </div>
                </div>
            </details>

            <button class="btn btn-primary" type="submit">Создать курс</button>
        </form>
    </article>

    <article class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Все программы</p>
                <h2 class="section-title section-title--small">Список курсов</h2>
                <p class="section-text">Здесь видно, что уже опубликовано, а что пока остаётся в черновиках для подготовки контента.</p>
            </div>
        </div>

        <div class="card-stack">
            <?php foreach ($resources['courses'] as $course): ?>
                <?php
                $moduleCount = count($course['modules'] ?? []);
                $lessonCount = array_sum(array_map(static fn (array $module): int => count($module['lessons'] ?? []), $course['modules'] ?? []));
                ?>
                <article class="course-item course-item--admin">
                    <div class="section-header">
                        <div>
                            <div class="hero-actions">
                                <span class="badge badge-muted"><?= e($course['category']['title']) ?></span>
                                <span class="<?= publication_status_badge_class((string) $course['status']) ?>"><?= e(publication_status_label((string) $course['status'])) ?></span>
                            </div>
                            <h3 class="employee-course-card__title"><?= e($course['title']) ?></h3>
                            <p class="section-text"><?= e((string) ($course['short_description'] ?: 'Краткое описание пока не заполнено.')) ?></p>
                        </div>
                    </div>

                    <div class="course-item__meta-grid">
                        <div class="course-item__meta-cell">
                            <span>Модули</span>
                            <strong><?= e((string) $moduleCount) ?></strong>
                        </div>
                        <div class="course-item__meta-cell">
                            <span>Уроки</span>
                            <strong><?= e((string) $lessonCount) ?></strong>
                        </div>
                        <div class="course-item__meta-cell">
                            <span>Для кого</span>
                            <strong><?= e((string) ($course['target_audience'] ?: 'Не указано')) ?></strong>
                        </div>
                    </div>

                    <div class="actions-row">
                        <a href="<?= url('/admin/courses/' . $course['id']) ?>" class="btn btn-primary btn-sm">Открыть редактор</a>
                        <form action="<?= url('/admin/courses/' . $course['id'] . '/duplicate') ?>" method="post">
                            <?= csrf_field() ?>
                            <button class="btn btn-ghost btn-sm" type="submit">Сделать копию</button>
                        </form>
                        <form action="<?= url('/admin/courses/' . $course['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Удалить курс и его структуру?');">
                            <?= csrf_field() ?>
                            <button class="btn btn-danger btn-sm" type="submit">Удалить</button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </article>
</section>
