<?php
$filters = $knowledgeBase['filters'] ?? [];
$selectedType = (string) ($filters['type'] ?? '');
$selectedCategory = (string) ($filters['category'] ?? '');
$searchQuery = (string) ($filters['q'] ?? '');
$hasFilters = $searchQuery !== '' || $selectedType !== '' || $selectedCategory !== '';
$articles = $knowledgeBase['articles'] ?? [];
$featuredArticles = $knowledgeBase['featured'] ?? [];
$faqArticles = $knowledgeBase['faq'] ?? [];
$categories = $knowledgeBase['categories'] ?? [];
$articleTypes = $knowledgeBase['types'] ?? [];
$isAdmin = (($user['role_key'] ?? '') === 'ADMIN');
$activeArticle = null;

if (!$hasFilters) {
    $activeArticle = $featuredArticles[0] ?? $articles[0] ?? null;
}

$navigationCategories = [];
foreach ($categories as $category) {
    $categoryArticles = array_values(array_filter(
        $articles,
        static fn (array $article): bool => ($article['category']['slug'] ?? '') === ($category['slug'] ?? ''),
    ));

    if ($categoryArticles === []) {
        continue;
    }

    $navigationCategories[] = array_merge($category, [
        'articles' => $categoryArticles,
    ]);
}
?>

<section class="section-header kb-help-header">
    <div>
        <p class="section-kicker">База знаний</p>
        <h1 class="section-title section-title--small">Содержание справки</h1>
        <p class="section-text">Централизованная база знаний ЮСИ в формате справочного центра: слева разделы и статьи, в центре материалы, справа быстрые опорные ссылки по текущему контексту.</p>
    </div>
    <?php if ($isAdmin): ?>
        <div class="actions-row">
            <a href="<?= url('/admin/knowledge-base') ?>" class="btn btn-ghost">Редактор справки</a>
        </div>
    <?php endif; ?>
</section>

<section class="kb-help-shell">
    <aside class="card kb-help-nav">
        <h2 class="kb-help-nav__title">Содержание справки</h2>

        <form action="<?= url('/knowledge-base') ?>" method="get" class="kb-help-search">
            <label class="field">
                <span class="field__label">Поиск</span>
                <input class="input" type="search" name="q" value="<?= e($searchQuery) ?>" placeholder="Найдите статью или правило">
            </label>
            <label class="field">
                <span class="field__label">Тип материала</span>
                <select class="select" name="type">
                    <option value="">Все типы</option>
                    <?php foreach ($articleTypes as $type): ?>
                        <option value="<?= e($type['value']) ?>" <?= $selectedType === $type['value'] ? 'selected' : '' ?>>
                            <?= e($type['label']) ?> (<?= e((string) $type['count']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="field">
                <span class="field__label">Раздел</span>
                <select class="select" name="category">
                    <option value="">Все разделы</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= e($category['slug']) ?>" <?= $selectedCategory === $category['slug'] ? 'selected' : '' ?>>
                            <?= e($category['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <div class="kb-help-search__actions">
                <button type="submit" class="btn btn-primary btn-sm">Найти</button>
                <?php if ($hasFilters): ?>
                    <a href="<?= url('/knowledge-base') ?>" class="btn btn-ghost btn-sm">Сбросить</a>
                <?php endif; ?>
            </div>
        </form>

        <div class="kb-help-tree">
            <?php foreach ($navigationCategories as $category): ?>
                <section class="kb-help-group">
                    <h3 class="kb-help-group__title"><?= e($category['title']) ?></h3>
                    <div class="kb-help-links">
                        <?php foreach ($category['articles'] as $article): ?>
                            <?php
                            $isActive = $activeArticle !== null && $activeArticle['slug'] === $article['slug'];
                            ?>
                            <a href="<?= url('/knowledge-base/' . $article['slug']) ?>" class="kb-help-link <?= $isActive ? 'is-active' : '' ?>">
                                <span><?= e($article['title']) ?></span>
                                <span class="kb-help-link__meta"><?= e(knowledge_article_type_label((string) $article['article_type'])) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
    </aside>

    <div class="kb-help-main">
        <article class="card kb-assistant" data-kb-assistant data-endpoint="<?= e(url('/knowledge-base/assistant/search')) ?>">
            <div class="section-header">
                <div>
                    <p class="section-kicker">Помощник</p>
                    <h2 class="section-title section-title--small">Найти ответ по статьям и урокам</h2>
                    <p class="section-text">Задайте рабочий вопрос обычной фразой. Помощник ищет сразу по справочнику, инструкциям, правилам, FAQ и опубликованным учебным материалам.</p>
                </div>
            </div>
            <form class="kb-assistant__form" data-kb-assistant-form>
                <label class="field">
                    <span class="field__label">Вопрос</span>
                    <input class="input" type="search" name="q" data-kb-assistant-input placeholder="Например: как проверить дубль клиента или что фиксировать после звонка">
                </label>
                <div class="kb-help-search__actions">
                    <button type="submit" class="btn btn-primary btn-sm">Найти ответ</button>
                </div>
            </form>
            <div class="kb-assistant__hint">Поиск готов как для сотрудников внутри сервиса, так и для будущей интеграции базы знаний в amoCRM.</div>
            <div class="kb-assistant__output" hidden data-kb-assistant-output>
                <div class="kb-assistant__answer" data-kb-assistant-answer></div>
                <div class="kb-assistant__results" data-kb-assistant-results></div>
            </div>
        </article>

        <?php if ($hasFilters): ?>
            <article class="card kb-help-article">
                <div class="kb-help-article__head">
                    <div>
                        <p class="section-kicker">Результаты поиска</p>
                        <h2 class="kb-help-article__title">Найдено <?= e((string) count($articles)) ?> материалов</h2>
                    </div>
                </div>

                <?php if ($articles === []): ?>
                    <div class="kb-empty kb-empty--compact">
                        <h3>По запросу ничего не найдено</h3>
                        <p>Попробуйте изменить поисковую фразу, снять часть фильтров или перейти к полному содержанию справки.</p>
                    </div>
                <?php else: ?>
                    <div class="kb-help-results">
                        <?php foreach ($articles as $article): ?>
                            <a href="<?= url('/knowledge-base/' . $article['slug']) ?>" class="card kb-article-card" style="--kb-accent: <?= e((string) ($article['category']['accent_color'] ?? '#4d98ff')) ?>;">
                                <div class="kb-article-card__top">
                                    <div class="kb-article-card__badges">
                                        <span class="<?= knowledge_article_type_badge_class((string) $article['article_type']) ?>">
                                            <?= e(knowledge_article_type_label((string) $article['article_type'])) ?>
                                        </span>
                                        <span class="badge badge-muted"><?= e($article['category']['title']) ?></span>
                                    </div>
                                    <span class="kb-article-card__meta"><?= e(format_date((string) $article['updated_at'])) ?></span>
                                </div>
                                <h3 class="kb-article-card__title"><?= e($article['title']) ?></h3>
                                <p class="kb-article-card__excerpt"><?= e((string) ($article['excerpt'] ?: 'Материал без краткого описания.')) ?></p>
                                <div class="kb-article-card__footer">
                                    <span><?= e(knowledge_visibility_label((string) $article['visibility_scope'])) ?></span>
                                    <span><?= e((string) ($article['estimated_minutes'] ?? 0)) ?> мин</span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>
        <?php elseif ($activeArticle !== null): ?>
            <article class="card kb-help-article">
                <div class="kb-help-article__head">
                    <div>
                        <div class="kb-article-card__badges">
                            <span class="<?= knowledge_article_type_badge_class((string) $activeArticle['article_type']) ?>">
                                <?= e(knowledge_article_type_label((string) $activeArticle['article_type'])) ?>
                            </span>
                            <span class="badge badge-muted"><?= e($activeArticle['category']['title']) ?></span>
                        </div>
                        <h2 class="kb-help-article__title"><?= e($activeArticle['title']) ?></h2>
                    </div>
                    <div class="kb-help-article__actions">
                        <button type="button" class="btn btn-ghost btn-sm" onclick="window.print()">Печать статьи</button>
                        <a href="<?= url('/knowledge-base/' . $activeArticle['slug']) ?>" class="btn btn-primary btn-sm">Открыть статью</a>
                    </div>
                </div>

                <?php if (!empty($activeArticle['excerpt'])): ?>
                    <div id="kb-article-lead" class="kb-help-article__lead">
                        <?= e((string) $activeArticle['excerpt']) ?>
                    </div>
                <?php endif; ?>

                <div id="kb-article-body" class="kb-help-article__prose kb-article-body">
                    <?= markdown_html((string) $activeArticle['body']) ?>
                </div>
            </article>

            <?php
            $moreFeatured = array_values(array_filter(
                $featuredArticles,
                static fn (array $article): bool => $article['slug'] !== ($activeArticle['slug'] ?? ''),
            ));
            ?>
            <?php if ($moreFeatured !== []): ?>
                <article id="kb-article-featured" class="card kb-side-card">
                    <p class="section-kicker">Ещё важно</p>
                    <h2 class="section-title section-title--small">Рекомендуемые материалы</h2>
                    <div class="kb-link-list">
                        <?php foreach (array_slice($moreFeatured, 0, 4) as $article): ?>
                            <a href="<?= url('/knowledge-base/' . $article['slug']) ?>" class="kb-link-card">
                                <strong><?= e($article['title']) ?></strong>
                                <span><?= e($article['category']['title']) ?> · <?= e(knowledge_article_type_label((string) $article['article_type'])) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endif; ?>
        <?php else: ?>
            <article class="card kb-help-article">
                <div class="kb-empty kb-empty--compact">
                    <h3>База знаний пока пуста</h3>
                    <p>После публикации материалов здесь появятся статьи, инструкции и ответы на частые вопросы.</p>
                </div>
            </article>
        <?php endif; ?>
    </div>

    <aside class="card kb-help-toc">
        <?php if ($activeArticle !== null && !$hasFilters): ?>
            <p class="section-kicker">В этой статье</p>
            <h2 class="kb-help-toc__title"><?= e($activeArticle['title']) ?></h2>
            <div class="kb-help-toc__list">
                <?php if (!empty($activeArticle['excerpt'])): ?>
                    <a href="#kb-article-lead" class="kb-help-toc__link">Кратко о материале</a>
                <?php endif; ?>
                <a href="#kb-article-body" class="kb-help-toc__link">Основной материал</a>
                <?php if (($moreFeatured ?? []) !== []): ?>
                    <a href="#kb-article-featured" class="kb-help-toc__link">Рекомендуемые материалы</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p class="section-kicker">Быстрый доступ</p>
            <h2 class="kb-help-toc__title">Популярные статьи</h2>
        <?php endif; ?>

        <div class="kb-link-list">
            <?php foreach (array_slice($featuredArticles !== [] ? $featuredArticles : $faqArticles, 0, 5) as $article): ?>
                <a href="<?= url('/knowledge-base/' . $article['slug']) ?>" class="kb-link-card">
                    <strong><?= e($article['title']) ?></strong>
                    <span><?= e($article['category']['title']) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </aside>
</section>
