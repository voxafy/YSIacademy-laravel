<?php
$article = $knowledge['article'];
$categories = $knowledge['categories'] ?? [];
$articleTypes = $knowledge['article_types'] ?? [];
$visibilityScopes = $knowledge['visibility_scopes'] ?? [];
$statuses = $knowledge['statuses'] ?? [];
?>

<section class="section-header">
    <div>
        <p class="section-kicker">База знаний</p>
        <h1 class="section-title"><?= e($article['title']) ?></h1>
        <p class="section-text">Редактирование материала справочника, который участвует в поиске по базе знаний и может быть использован в будущей интеграции с amoCRM.</p>
    </div>
    <div class="actions-row">
        <a href="<?= url('/admin/knowledge-base') ?>" class="btn btn-ghost">К списку материалов</a>
        <?php if ((string) ($article['status'] ?? '') === 'PUBLISHED'): ?>
            <a href="<?= url('/knowledge-base/' . $article['slug']) ?>" class="btn btn-primary">Открыть материал</a>
        <?php endif; ?>
    </div>
</section>

<section class="grid grid-split">
    <article class="card course-editor-panel">
        <div class="hero-actions" style="margin-bottom: 18px;">
            <span class="<?= knowledge_article_status_badge_class((string) $article['status']) ?>"><?= e(knowledge_article_status_label((string) $article['status'])) ?></span>
            <span class="badge badge-muted"><?= e(knowledge_article_type_label((string) $article['article_type'])) ?></span>
            <span class="badge badge-muted"><?= e(knowledge_visibility_label((string) $article['visibility_scope'])) ?></span>
            <?php if (!empty($article['is_featured'])): ?>
                <span class="badge badge-info">Рекомендован</span>
            <?php endif; ?>
        </div>

        <form action="<?= url('/admin/knowledge-base/articles/' . $article['id']) ?>" method="post" class="form-grid">
            <?= csrf_field() ?>
            <label class="field">
                <span class="field__label">Название</span>
                <input class="input" type="text" name="title" value="<?= e(old_or_value($article, 'title')) ?>" required>
            </label>
            <label class="field">
                <span class="field__label">Slug</span>
                <input class="input" type="text" name="slug" value="<?= e(old_or_value($article, 'slug')) ?>" required>
            </label>
            <div class="form-grid form-grid-3">
                <label class="field">
                    <span class="field__label">Раздел</span>
                    <select class="select" name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= e($category['id']) ?>" <?= (string) old('category_id', (string) $article['category_id']) === (string) $category['id'] ? 'selected' : '' ?>>
                                <?= e($category['title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="field">
                    <span class="field__label">Тип</span>
                    <select class="select" name="article_type">
                        <?php foreach ($articleTypes as $type): ?>
                            <option value="<?= e($type['value']) ?>" <?= (string) old('article_type', (string) $article['article_type']) === (string) $type['value'] ? 'selected' : '' ?>>
                                <?= e($type['label']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="field">
                    <span class="field__label">Видимость</span>
                    <select class="select" name="visibility_scope">
                        <?php foreach ($visibilityScopes as $scope): ?>
                            <option value="<?= e($scope['value']) ?>" <?= (string) old('visibility_scope', (string) $article['visibility_scope']) === (string) $scope['value'] ? 'selected' : '' ?>>
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
                            <option value="<?= e($status['value']) ?>" <?= (string) old('status', (string) $article['status']) === (string) $status['value'] ? 'selected' : '' ?>>
                                <?= e($status['label']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="field">
                    <span class="field__label">Минут на чтение</span>
                    <input class="input" type="number" name="estimated_minutes" value="<?= e((string) old('estimated_minutes', (string) ($article['estimated_minutes'] ?? 0))) ?>" min="0">
                </label>
                <label class="field">
                    <span class="field__label">Порядок сортировки</span>
                    <input class="input" type="number" name="sort_order" value="<?= e((string) old('sort_order', (string) ($article['sort_order'] ?? 0))) ?>">
                </label>
            </div>

            <label class="field">
                <span class="field__label">Краткое резюме</span>
                <textarea class="textarea" name="excerpt"><?= e((string) old('excerpt', (string) ($article['excerpt'] ?? ''))) ?></textarea>
            </label>
            <label class="field">
                <span class="field__label">Ключевые слова для помощника</span>
                <input class="input" type="text" name="search_keywords" value="<?= e((string) old('search_keywords', (string) ($article['search_keywords'] ?? ''))) ?>">
            </label>
            <label class="field">
                <span class="field__label">Основной текст</span>
                <textarea class="textarea" name="body" required><?= e((string) old('body', (string) ($article['body'] ?? ''))) ?></textarea>
            </label>
            <label class="field" style="display: flex; align-items: center; gap: 10px;">
                <input type="checkbox" name="is_featured" value="1" <?= old('is_featured', !empty($article['is_featured']) ? '1' : '') ? 'checked' : '' ?>>
                <span class="field__label" style="margin: 0;">Показывать в рекомендованных материалах</span>
            </label>
            <div class="actions-row">
                <button class="btn btn-primary" type="submit">Сохранить материал</button>
            </div>
        </form>
        <form action="<?= url('/admin/knowledge-base/articles/' . $article['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Удалить материал базы знаний?');" style="margin-top: 12px;">
            <?= csrf_field() ?>
            <button class="btn btn-danger" type="submit">Удалить материал</button>
        </form>
    </article>

    <article class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Как видит помощник</p>
                <h2 class="section-title section-title--small">Контекст материала</h2>
            </div>
        </div>
        <div class="card-stack">
            <article class="list-item">
                <p class="section-kicker">Раздел</p>
                <h3 class="employee-course-card__title"><?= e($article['category']['title'] ?? '') ?></h3>
                <p class="section-text"><?= e((string) ($article['category']['description'] ?? '')) ?></p>
            </article>
            <article class="list-item">
                <p class="section-kicker">Сигналы для поиска</p>
                <div class="kb-keywords">
                    <?php foreach ($article['keywords'] ?? [] as $keyword): ?>
                        <span class="kb-keyword"><?= e($keyword) ?></span>
                    <?php endforeach; ?>
                    <?php if (($article['keywords'] ?? []) === []): ?>
                        <span class="muted">Ключевые слова пока не заданы.</span>
                    <?php endif; ?>
                </div>
            </article>
            <article class="list-item">
                <p class="section-kicker">Резюме</p>
                <p class="section-text"><?= e((string) ($article['excerpt'] ?: 'Краткое резюме пока не заполнено.')) ?></p>
            </article>
            <article class="list-item">
                <p class="section-kicker">Публичная ссылка</p>
                <p class="section-text"><code><?= e(url('/knowledge-base/' . $article['slug'])) ?></code></p>
            </article>
        </div>
    </article>
</section>
