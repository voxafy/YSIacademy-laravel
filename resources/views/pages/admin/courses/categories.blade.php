<section class="section-header admin-page-head">
    <div>
        <p class="section-kicker">Категории курсов</p>
        <h1 class="section-title">Структура каталога</h1>
        <p class="section-text">Категории помогают аккуратно группировать программы в публичном каталоге и в редакторе. Здесь можно управлять порядком и описанием каждой группы.</p>
    </div>
    <div class="actions-row">
        <a href="<?= url('/admin/courses') ?>" class="btn btn-ghost">Вернуться к курсам</a>
    </div>
</section>

<section class="grid grid-split admin-editor-layout">
    <article class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Новая категория</p>
                <h2 class="section-title section-title--small">Добавить раздел каталога</h2>
            </div>
        </div>

        <form action="<?= url('/admin/course-categories') ?>" method="post" class="form-grid admin-form">
            <?= csrf_field() ?>
            <label class="field">
                <span class="field__label">Название</span>
                <input class="input" type="text" name="title" required>
            </label>
            <label class="field">
                <span class="field__label">Описание</span>
                <textarea class="textarea" name="description" rows="4"></textarea>
            </label>
            <details class="editor-advanced">
                <summary>Расширенные настройки</summary>
                <div class="editor-advanced__body form-grid form-grid-2">
                    <label class="field">
                        <span class="field__label">Адрес категории</span>
                        <input class="input" type="text" name="slug">
                    </label>
                    <label class="field">
                        <span class="field__label">Порядок</span>
                        <input class="input" type="number" name="sort_order" value="0">
                    </label>
                </div>
            </details>
            <button class="btn btn-primary" type="submit">Создать категорию</button>
        </form>
    </article>

    <article class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Существующие категории</p>
                <h2 class="section-title section-title--small">Все группы каталога</h2>
            </div>
        </div>

        <div class="card-stack">
            <?php foreach ($categories as $category): ?>
                <article class="course-item course-item--admin">
                    <form action="<?= url('/admin/course-categories/' . $category['id']) ?>" method="post" class="form-grid admin-form">
                        <?= csrf_field() ?>
                        <div class="form-grid form-grid-2">
                            <label class="field">
                                <span class="field__label">Название</span>
                                <input class="input" type="text" name="title" value="<?= e($category['title']) ?>" required>
                            </label>
                            <label class="field">
                                <span class="field__label">Описание</span>
                                <input class="input" type="text" name="description" value="<?= e((string) ($category['description'] ?? '')) ?>">
                            </label>
                        </div>

                        <details class="editor-advanced">
                            <summary>Расширенные настройки</summary>
                            <div class="editor-advanced__body form-grid form-grid-2">
                                <label class="field">
                                    <span class="field__label">Адрес категории</span>
                                    <input class="input" type="text" name="slug" value="<?= e($category['slug']) ?>">
                                </label>
                                <label class="field">
                                    <span class="field__label">Порядок</span>
                                    <input class="input" type="number" name="sort_order" value="<?= e((string) ($category['sort_order'] ?? 0)) ?>">
                                </label>
                            </div>
                        </details>

                        <div class="hero-actions">
                            <span class="badge badge-muted"><?= e((string) ($category['courses_count'] ?? 0)) ?> курсов</span>
                            <span class="badge badge-info"><?= e((string) ($category['published_count'] ?? 0)) ?> опубликовано</span>
                        </div>

                        <div class="actions-row">
                            <button class="btn btn-primary btn-sm" type="submit">Сохранить</button>
                        </div>
                    </form>
                    <form action="<?= url('/admin/course-categories/' . $category['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Удалить категорию?');">
                        <?= csrf_field() ?>
                        <button class="btn btn-danger btn-sm" type="submit">Удалить</button>
                    </form>
                </article>
            <?php endforeach; ?>
        </div>
    </article>
</section>
