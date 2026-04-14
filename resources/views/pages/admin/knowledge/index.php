<?php
$stats = $knowledge['stats'] ?? [];
$categories = $knowledge['categories'] ?? [];
$articles = $knowledge['articles'] ?? [];
$articleTypes = $knowledge['article_types'] ?? [];
$visibilityScopes = $knowledge['visibility_scopes'] ?? [];
$statuses = $knowledge['statuses'] ?? [];

$publishedArticles = array_values(array_filter(
    $articles,
    static fn (array $article): bool => (string) ($article['status'] ?? '') === 'PUBLISHED',
));
$draftArticles = array_values(array_filter(
    $articles,
    static fn (array $article): bool => (string) ($article['status'] ?? '') !== 'PUBLISHED',
));
?>

<section class="section-header admin-page-head">
    <div>
        <p class="section-kicker">База знаний</p>
        <h1 class="section-title">Редактор справочника</h1>
        <p class="section-text">Управляйте разделами и материалами базы знаний как единым контентным продуктом: от структуры и статьи до публикации и выдачи сотрудникам.</p>
    </div>
    <div class="actions-row">
        <a href="<?= url('/knowledge-base') ?>" class="btn btn-ghost">Открыть справочник</a>
    </div>
</section>

<section class="grid grid-4 knowledge-admin-metrics">
    <article class="card stat-card">
        <div class="stat-card__label">Разделов</div>
        <div class="stat-card__value"><?= e((string) ($stats['categories_total'] ?? 0)) ?></div>
        <div class="stat-card__meta">Тематические блоки и оглавление справочника.</div>
    </article>
    <article class="card stat-card">
        <div class="stat-card__label">Материалов</div>
        <div class="stat-card__value"><?= e((string) ($stats['articles_total'] ?? 0)) ?></div>
        <div class="stat-card__meta">Статьи, инструкции, правила и FAQ.</div>
    </article>
    <article class="card stat-card">
        <div class="stat-card__label">Опубликовано</div>
        <div class="stat-card__value"><?= e((string) ($stats['published_total'] ?? 0)) ?></div>
        <div class="stat-card__meta">Доступно сотрудникам и руководителям.</div>
    </article>
    <article class="card stat-card">
        <div class="stat-card__label">Материалов из уроков</div>
        <div class="stat-card__value"><?= e((string) ($stats['lesson_sources_total'] ?? 0)) ?></div>
        <div class="stat-card__meta">Дополняют справочник и помогают находить ответы по работе.</div>
    </article>
</section>

<section class="grid grid-split admin-editor-layout" style="margin-top: 22px;">
    <article class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Новый раздел</p>
                <h2 class="section-title section-title--small">Создать раздел базы знаний</h2>
            </div>
        </div>

        <form action="<?= url('/admin/knowledge-base/categories') ?>" method="post" class="form-grid admin-form">
            <?= csrf_field() ?>
            <label class="field">
                <span class="field__label">Название раздела</span>
                <input class="input" type="text" name="title" value="<?= e((string) old('title', '')) ?>" required>
            </label>
            <label class="field">
                <span class="field__label">Описание</span>
                <textarea class="textarea" name="description" rows="4"><?= e((string) old('description', '')) ?></textarea>
            </label>

            <details class="editor-advanced">
                <summary>Расширенные настройки</summary>
                <div class="editor-advanced__body form-grid form-grid-3">
                    <label class="field">
                        <span class="field__label">Адрес раздела</span>
                        <input class="input" type="text" name="slug" value="<?= e((string) old('slug', '')) ?>">
                    </label>
                    <label class="field">
                        <span class="field__label">Цвет акцента</span>
                        <input class="input" type="text" name="accent_color" value="<?= e((string) old('accent_color', '#4d98ff')) ?>" placeholder="#4d98ff">
                    </label>
                    <label class="field">
                        <span class="field__label">Порядок</span>
                        <input class="input" type="number" name="sort_order" value="<?= e((string) old('sort_order', '0')) ?>">
                    </label>
                </div>
            </details>

            <button class="btn btn-primary" type="submit">Создать раздел</button>
        </form>
    </article>

    <article class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Новый материал</p>
                <h2 class="section-title section-title--small">Добавить статью</h2>
                <p class="section-text">Сначала заполните понятную основу: раздел, название, краткое резюме и основной текст.</p>
            </div>
        </div>

        <form action="<?= url('/admin/knowledge-base/articles') ?>" method="post" class="form-grid admin-form">
            <?= csrf_field() ?>

            <label class="field">
                <span class="field__label">Название</span>
                <input class="input" type="text" name="title" value="<?= e((string) old('title', '')) ?>" required>
            </label>

            <div class="form-grid form-grid-3">
                <label class="field">
                    <span class="field__label">Раздел</span>
                    <select class="select" name="category_id" required>
                        <option value="">Выберите раздел</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= e($category['id']) ?>" <?= (string) old('category_id', '') === (string) $category['id'] ? 'selected' : '' ?>>
                                <?= e($category['title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="field">
                    <span class="field__label">Тип материала</span>
                    <select class="select" name="article_type">
                        <?php foreach ($articleTypes as $type): ?>
                            <option value="<?= e($type['value']) ?>" <?= (string) old('article_type', 'DOCUMENT') === (string) $type['value'] ? 'selected' : '' ?>>
                                <?= e($type['label']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="field">
                    <span class="field__label">Кому доступно</span>
                    <select class="select" name="visibility_scope">
                        <?php foreach ($visibilityScopes as $scope): ?>
                            <option value="<?= e($scope['value']) ?>" <?= (string) old('visibility_scope', 'ALL') === (string) $scope['value'] ? 'selected' : '' ?>>
                                <?= e($scope['label']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>

            <div class="form-grid form-grid-3">
                <label class="field">
                    <span class="field__label">Статус</span>
                    <select class="select" name="status">
                        <?php foreach ($statuses as $status): ?>
                            <option value="<?= e($status['value']) ?>" <?= (string) old('status', 'DRAFT') === (string) $status['value'] ? 'selected' : '' ?>>
                                <?= e($status['label']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="field">
                    <span class="field__label">Минут на чтение</span>
                    <input class="input" type="number" name="estimated_minutes" min="0" value="<?= e((string) old('estimated_minutes', '5')) ?>">
                </label>
                <label class="field field--check">
                    <span class="field__label">Рекомендовать</span>
                    <label class="checkbox-row">
                        <input type="checkbox" name="is_featured" value="1" <?= old('is_featured') ? 'checked' : '' ?>>
                        <span>Показывать в рекомендованных материалах</span>
                    </label>
                </label>
            </div>

            <label class="field">
                <span class="field__label">Краткое резюме</span>
                <textarea class="textarea" name="excerpt" rows="3"><?= e((string) old('excerpt', '')) ?></textarea>
            </label>

            <label class="field">
                <span class="field__label">Основной текст</span>
                <textarea class="textarea textarea--xl" name="body" rows="10" required><?= e((string) old('body', '')) ?></textarea>
            </label>

            <details class="editor-advanced">
                <summary>Расширенные настройки</summary>
                <div class="editor-advanced__body form-grid form-grid-3">
                    <label class="field">
                        <span class="field__label">Адрес статьи</span>
                        <input class="input" type="text" name="slug" value="<?= e((string) old('slug', '')) ?>">
                    </label>
                    <label class="field">
                        <span class="field__label">Ключевые слова для поиска</span>
                        <input class="input" type="text" name="search_keywords" value="<?= e((string) old('search_keywords', '')) ?>" placeholder="Например: дубли, звонок, лид">
                    </label>
                    <label class="field">
                        <span class="field__label">Порядок</span>
                        <input class="input" type="number" name="sort_order" value="<?= e((string) old('sort_order', '0')) ?>">
                    </label>
                </div>
            </details>

            <button class="btn btn-primary" type="submit">Создать материал</button>
        </form>
    </article>
</section>

<section class="grid grid-split admin-editor-layout" style="margin-top: 22px;">
    <article class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Разделы</p>
                <h2 class="section-title section-title--small">Структура справочника</h2>
            </div>
        </div>

        <div class="card-stack">
            <?php foreach ($categories as $category): ?>
                <article class="course-item course-item--admin">
                    <form action="<?= url('/admin/knowledge-base/categories/' . $category['id']) ?>" method="post" class="form-grid admin-form">
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
                            <div class="editor-advanced__body form-grid form-grid-3">
                                <label class="field">
                                    <span class="field__label">Адрес раздела</span>
                                    <input class="input" type="text" name="slug" value="<?= e($category['slug']) ?>">
                                </label>
                                <label class="field">
                                    <span class="field__label">Цвет акцента</span>
                                    <input class="input" type="text" name="accent_color" value="<?= e((string) ($category['accent_color'] ?? '#4d98ff')) ?>">
                                </label>
                                <label class="field">
                                    <span class="field__label">Порядок</span>
                                    <input class="input" type="number" name="sort_order" value="<?= e((string) ($category['sort_order'] ?? 0)) ?>">
                                </label>
                            </div>
                        </details>

                        <div class="hero-actions">
                            <span class="badge badge-muted"><?= e((string) ($category['articles_count'] ?? 0)) ?> материалов</span>
                            <span class="badge badge-info"><?= e((string) ($category['published_count'] ?? 0)) ?> опубликовано</span>
                        </div>

                        <div class="actions-row">
                            <button class="btn btn-primary btn-sm" type="submit">Сохранить раздел</button>
                        </div>
                    </form>
                    <form action="<?= url('/admin/knowledge-base/categories/' . $category['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Удалить раздел и все материалы внутри?');">
                        <?= csrf_field() ?>
                        <button class="btn btn-danger btn-sm" type="submit">Удалить</button>
                    </form>
                </article>
            <?php endforeach; ?>
        </div>
    </article>

    <article class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Материалы</p>
                <h2 class="section-title section-title--small">Опубликованные и черновые</h2>
            </div>
        </div>

        <?php foreach ([['title' => 'Опубликованные', 'items' => $publishedArticles], ['title' => 'Черновики', 'items' => $draftArticles]] as $group): ?>
            <div class="admin-content-group">
                <div class="section-header">
                    <div>
                        <p class="section-kicker"><?= e($group['title']) ?></p>
                    </div>
                    <span class="badge badge-muted"><?= e((string) count($group['items'])) ?></span>
                </div>

                <div class="card-stack">
                    <?php foreach ($group['items'] as $article): ?>
                        <article class="course-item course-item--admin">
                            <div class="section-header">
                                <div>
                                    <div class="hero-actions">
                                        <span class="badge badge-muted"><?= e($article['category']['title'] ?? '') ?></span>
                                        <span class="<?= knowledge_article_status_badge_class((string) $article['status']) ?>"><?= e(knowledge_article_status_label((string) $article['status'])) ?></span>
                                        <span class="badge badge-info"><?= e(knowledge_article_type_label((string) $article['article_type'])) ?></span>
                                    </div>
                                    <h3 class="employee-course-card__title"><?= e($article['title']) ?></h3>
                                    <p class="section-text"><?= e((string) ($article['excerpt'] ?: 'Краткое резюме пока не заполнено.')) ?></p>
                                </div>
                            </div>

                            <div class="actions-row">
                                <a href="<?= url('/admin/knowledge-base/articles/' . $article['id']) ?>" class="btn btn-primary btn-sm">Редактировать</a>
                                <?php if ((string) ($article['status'] ?? '') === 'PUBLISHED'): ?>
                                    <a href="<?= url('/knowledge-base/' . $article['slug']) ?>" class="btn btn-ghost btn-sm">Открыть</a>
                                <?php endif; ?>
                                <form action="<?= url('/admin/knowledge-base/articles/' . $article['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Удалить материал базы знаний?');">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-danger btn-sm" type="submit">Удалить</button>
                                </form>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </article>
</section>
