<?php
$stats = $knowledge['stats'] ?? [];
$categories = $knowledge['categories'] ?? [];
$articles = $knowledge['articles'] ?? [];
$articleTypes = $knowledge['article_types'] ?? [];
$visibilityScopes = $knowledge['visibility_scopes'] ?? [];
$statuses = $knowledge['statuses'] ?? [];
?>

<section class="section-header">
    <div>
        <p class="section-kicker">База знаний</p>
        <h1 class="section-title">Редактор справочника и источника для помощника</h1>
        <p class="section-text">Администратор управляет разделами и материалами базы знаний отдельно от курсов. Помощник использует статьи справочника вместе с опубликованными уроками, чтобы сотрудники быстрее находили ответы во время работы.</p>
    </div>
    <div class="actions-row">
        <a href="<?= url('/knowledge-base') ?>" class="btn btn-ghost">Открыть базу знаний</a>
    </div>
</section>

<section class="grid grid-4 knowledge-admin-metrics">
    <article class="card stat-card">
        <div class="stat-card__label">Разделов</div>
        <div class="stat-card__value"><?= e((string) ($stats['categories_total'] ?? 0)) ?></div>
        <div class="stat-card__meta">Структура справочника и тематические блоки.</div>
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
        <div class="stat-card__label">Источников уроков</div>
        <div class="stat-card__value"><?= e((string) ($stats['lesson_sources_total'] ?? 0)) ?></div>
        <div class="stat-card__meta">Опубликованные уроки, которые тоже участвуют в поиске помощника.</div>
    </article>
</section>

<section class="grid grid-split" style="margin-top: 22px;">
    <article class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Новый раздел</p>
                <h2 class="section-title section-title--small">Создать раздел справки</h2>
            </div>
        </div>
        <form action="<?= url('/admin/knowledge-base/categories') ?>" method="post" class="form-grid">
            <?= csrf_field() ?>
            <label class="field">
                <span class="field__label">Название раздела</span>
                <input class="input" type="text" name="title" value="<?= e((string) old('title', '')) ?>" required>
            </label>
            <label class="field">
                <span class="field__label">Slug</span>
                <input class="input" type="text" name="slug" value="<?= e((string) old('slug', '')) ?>" placeholder="service-and-access">
            </label>
            <label class="field">
                <span class="field__label">Акцентный цвет</span>
                <input class="input" type="text" name="accent_color" value="<?= e((string) old('accent_color', '#4d98ff')) ?>" placeholder="#4d98ff">
            </label>
            <label class="field">
                <span class="field__label">Порядок сортировки</span>
                <input class="input" type="number" name="sort_order" value="<?= e((string) old('sort_order', '0')) ?>">
            </label>
            <label class="field">
                <span class="field__label">Описание</span>
                <textarea class="textarea" name="description"><?= e((string) old('description', '')) ?></textarea>
            </label>
            <button class="btn btn-primary" type="submit">Создать раздел</button>
        </form>
    </article>

    <article class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Новый материал</p>
                <h2 class="section-title section-title--small">Добавить статью или FAQ</h2>
            </div>
        </div>
        <form action="<?= url('/admin/knowledge-base/articles') ?>" method="post" class="form-grid">
            <?= csrf_field() ?>
            <label class="field">
                <span class="field__label">Название</span>
                <input class="input" type="text" name="title" value="<?= e((string) old('title', '')) ?>" required>
            </label>
            <label class="field">
                <span class="field__label">Slug</span>
                <input class="input" type="text" name="slug" value="<?= e((string) old('slug', '')) ?>">
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
                    <span class="field__label">Тип</span>
                    <select class="select" name="article_type">
                        <?php foreach ($articleTypes as $type): ?>
                            <option value="<?= e($type['value']) ?>" <?= (string) old('article_type', 'DOCUMENT') === (string) $type['value'] ? 'selected' : '' ?>>
                                <?= e($type['label']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="field">
                    <span class="field__label">Видимость</span>
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
                    <input class="input" type="number" name="estimated_minutes" value="<?= e((string) old('estimated_minutes', '5')) ?>" min="0">
                </label>
                <label class="field">
                    <span class="field__label">Порядок сортировки</span>
                    <input class="input" type="number" name="sort_order" value="<?= e((string) old('sort_order', '0')) ?>">
                </label>
            </div>
            <label class="field">
                <span class="field__label">Краткое резюме</span>
                <textarea class="textarea" name="excerpt"><?= e((string) old('excerpt', '')) ?></textarea>
            </label>
            <label class="field">
                <span class="field__label">Ключевые слова для помощника</span>
                <input class="input" type="text" name="search_keywords" value="<?= e((string) old('search_keywords', '')) ?>" placeholder="amoCRM, дубли, задача, клиент">
            </label>
            <label class="field">
                <span class="field__label">Основной текст</span>
                <textarea class="textarea" name="body" required><?= e((string) old('body', '')) ?></textarea>
            </label>
            <label class="field" style="display: flex; align-items: center; gap: 10px;">
                <input type="checkbox" name="is_featured" value="1" <?= old('is_featured') ? 'checked' : '' ?>>
                <span class="field__label" style="margin: 0;">Показывать в рекомендованных материалах</span>
            </label>
            <button class="btn btn-primary" type="submit">Создать материал</button>
        </form>
    </article>
</section>

<section class="grid grid-split" style="margin-top: 22px;">
    <article class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Разделы</p>
                <h2 class="section-title section-title--small">Структура справочника</h2>
            </div>
        </div>
        <div class="card-stack">
            <?php foreach ($categories as $category): ?>
                <article class="list-item">
                    <form action="<?= url('/admin/knowledge-base/categories/' . $category['id']) ?>" method="post" class="form-grid">
                        <?= csrf_field() ?>
                        <div class="form-grid form-grid-2">
                            <label class="field">
                                <span class="field__label">Название</span>
                                <input class="input" type="text" name="title" value="<?= e($category['title']) ?>" required>
                            </label>
                            <label class="field">
                                <span class="field__label">Slug</span>
                                <input class="input" type="text" name="slug" value="<?= e($category['slug']) ?>" required>
                            </label>
                        </div>
                        <div class="form-grid form-grid-2">
                            <label class="field">
                                <span class="field__label">Акцентный цвет</span>
                                <input class="input" type="text" name="accent_color" value="<?= e((string) ($category['accent_color'] ?? '')) ?>">
                            </label>
                            <label class="field">
                                <span class="field__label">Сортировка</span>
                                <input class="input" type="number" name="sort_order" value="<?= e((string) ($category['sort_order'] ?? 0)) ?>">
                            </label>
                        </div>
                        <label class="field">
                            <span class="field__label">Описание</span>
                            <textarea class="textarea" name="description"><?= e((string) ($category['description'] ?? '')) ?></textarea>
                        </label>
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
                <h2 class="section-title section-title--small">Статьи, правила и FAQ</h2>
            </div>
        </div>
        <div class="card-stack">
            <?php foreach ($articles as $article): ?>
                <article class="list-item">
                    <div class="section-header">
                        <div>
                            <p class="section-kicker"><?= e($article['category']['title'] ?? '') ?></p>
                            <h3 class="employee-course-card__title"><?= e($article['title']) ?></h3>
                            <div class="employee-course-card__meta">
                                <span><?= e(knowledge_article_type_label((string) $article['article_type'])) ?></span>
                                <span><?= e(knowledge_visibility_label((string) $article['visibility_scope'])) ?></span>
                                <span><?= e(format_date((string) $article['updated_at'])) ?></span>
                            </div>
                        </div>
                        <div class="hero-actions">
                            <span class="<?= knowledge_article_status_badge_class((string) $article['status']) ?>"><?= e(knowledge_article_status_label((string) $article['status'])) ?></span>
                            <?php if (!empty($article['is_featured'])): ?>
                                <span class="badge badge-info">Рекомендован</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if (!empty($article['excerpt'])): ?>
                        <p class="section-text"><?= e((string) $article['excerpt']) ?></p>
                    <?php endif; ?>
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
    </article>
</section>

<section class="card dashboard-side-card" style="margin-top: 22px;">
    <div class="section-header">
        <div>
            <p class="section-kicker">Помощник и amoCRM</p>
            <h2 class="section-title section-title--small">Как сервис будет отдавать ответы</h2>
        </div>
    </div>
    <div class="course-metric-list">
        <div class="course-metric-list__item">
            <span>JSON endpoint для помощника</span>
            <strong><code>/knowledge-base/assistant/search?q=...</code></strong>
        </div>
        <div class="course-metric-list__item">
            <span>Что ищется сейчас</span>
            <strong>Статьи справочника + опубликованные уроки</strong>
        </div>
        <div class="course-metric-list__item">
            <span>Зачем это нужно</span>
            <strong>Единый источник ответов для сервиса и будущей интеграции в amoCRM</strong>
        </div>
    </div>
</section>
