<?php
$article = $articleData['article'];
$related = $articleData['related'] ?? [];
$faq = $articleData['faq'] ?? [];
$categories = $knowledgeBase['categories'] ?? [];
$navigationArticles = $knowledgeBase['articles'] ?? [];
$navigationCategories = [];

foreach ($categories as $category) {
    $categoryArticles = array_values(array_filter(
        $navigationArticles,
        static fn (array $navArticle): bool => ($navArticle['category']['slug'] ?? '') === ($category['slug'] ?? ''),
    ));

    if ($categoryArticles === []) {
        continue;
    }

    $navigationCategories[] = array_merge($category, [
        'articles' => $categoryArticles,
    ]);
}

$articleSections = [];
if (!empty($article['excerpt'])) {
    $articleSections[] = ['href' => '#kb-article-lead', 'label' => 'Кратко о материале'];
}
$articleSections[] = ['href' => '#kb-article-body', 'label' => 'Основной материал'];
if (($article['keywords'] ?? []) !== []) {
    $articleSections[] = ['href' => '#kb-article-keywords', 'label' => 'Ключевые темы'];
}
if ($related !== []) {
    $articleSections[] = ['href' => '#kb-article-related', 'label' => 'Похожие материалы'];
}
if ($faq !== []) {
    $articleSections[] = ['href' => '#kb-article-faq', 'label' => 'Частые вопросы'];
}
?>

<section class="section-header kb-help-header">
    <div>
        <p class="section-kicker">База знаний</p>
        <h1 class="section-title section-title--small">Содержание справки</h1>
        <p class="section-text">Страница статьи оформлена как справочный центр: с навигацией по разделам, основной зоной чтения и правой колонкой быстрого перехода по материалу.</p>
    </div>
</section>

<section class="kb-help-shell kb-help-shell--article">
    <aside class="card kb-help-nav">
        <h2 class="kb-help-nav__title">Содержание справки</h2>
        <div class="kb-help-tree kb-help-tree--full">
            <?php foreach ($navigationCategories as $category): ?>
                <section class="kb-help-group">
                    <h3 class="kb-help-group__title"><?= e($category['title']) ?></h3>
                    <div class="kb-help-links">
                        <?php foreach ($category['articles'] as $navArticle): ?>
                            <a href="<?= url('/knowledge-base/' . $navArticle['slug']) ?>" class="kb-help-link <?= $navArticle['slug'] === $article['slug'] ? 'is-active' : '' ?>">
                                <span><?= e($navArticle['title']) ?></span>
                                <span class="kb-help-link__meta"><?= e(knowledge_article_type_label((string) $navArticle['article_type'])) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
    </aside>

    <div class="kb-help-main">
        <article class="card kb-help-article">
            <div class="kb-help-article__head">
                <div>
                    <div class="kb-article-card__badges">
                        <span class="<?= knowledge_article_type_badge_class((string) $article['article_type']) ?>">
                            <?= e(knowledge_article_type_label((string) $article['article_type'])) ?>
                        </span>
                        <span class="badge badge-muted"><?= e($article['category']['title']) ?></span>
                        <span class="badge badge-muted"><?= e(knowledge_visibility_label((string) $article['visibility_scope'])) ?></span>
                    </div>
                    <h2 class="kb-help-article__title"><?= e($article['title']) ?></h2>
                    <div class="kb-help-article__meta">
                        <span>Обновлено <?= e(format_date((string) $article['updated_at'])) ?></span>
                        <?php if (!empty($article['estimated_minutes'])): ?>
                            <span><?= e((string) $article['estimated_minutes']) ?> мин на чтение</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="kb-help-article__actions">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="window.print()">Печать статьи</button>
                    <a href="<?= url('/knowledge-base') ?>" class="btn btn-primary btn-sm">К содержанию справки</a>
                </div>
            </div>

            <?php if (!empty($article['excerpt'])): ?>
                <div id="kb-article-lead" class="kb-help-article__lead">
                    <?= e((string) $article['excerpt']) ?>
                </div>
            <?php endif; ?>

            <div id="kb-article-body" class="kb-help-article__prose kb-article-body">
                <?= markdown_html((string) $article['body']) ?>
            </div>

            <?php if (($article['keywords'] ?? []) !== []) : ?>
                <section id="kb-article-keywords" class="kb-help-article__section">
                    <h3 class="kb-help-article__section-title">Ключевые темы</h3>
                    <div class="kb-keywords">
                        <?php foreach ($article['keywords'] as $keyword): ?>
                            <span class="kb-keyword"><?= e($keyword) ?></span>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </article>

        <?php if ($related !== []) : ?>
            <article id="kb-article-related" class="card kb-side-card">
                <p class="section-kicker">Похожие материалы</p>
                <h2 class="section-title section-title--small">Что ещё посмотреть</h2>
                <div class="kb-link-list">
                    <?php foreach ($related as $item): ?>
                        <a href="<?= url('/knowledge-base/' . $item['slug']) ?>" class="kb-link-card">
                            <strong><?= e($item['title']) ?></strong>
                            <span><?= e(knowledge_article_type_label((string) $item['article_type'])) ?> · <?= e($item['category']['title']) ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </article>
        <?php endif; ?>

        <?php if ($faq !== []) : ?>
            <article id="kb-article-faq" class="card kb-side-card">
                <p class="section-kicker">FAQ</p>
                <h2 class="section-title section-title--small">Частые вопросы рядом по теме</h2>
                <div class="kb-link-list">
                    <?php foreach ($faq as $item): ?>
                        <a href="<?= url('/knowledge-base/' . $item['slug']) ?>" class="kb-link-card">
                            <strong><?= e($item['title']) ?></strong>
                            <span><?= e($item['category']['title']) ?> · FAQ</span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </article>
        <?php endif; ?>
    </div>

    <aside class="card kb-help-toc">
        <p class="section-kicker">В этой статье</p>
        <h2 class="kb-help-toc__title"><?= e($article['title']) ?></h2>
        <div class="kb-help-toc__list">
            <?php foreach ($articleSections as $section): ?>
                <a href="<?= e($section['href']) ?>" class="kb-help-toc__link"><?= e($section['label']) ?></a>
            <?php endforeach; ?>
        </div>
    </aside>
</section>
