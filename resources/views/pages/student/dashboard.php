<?php
$inProgress = array_values(array_filter($dashboard['enrollments'], static fn (array $item): bool => $item['status'] === 'IN_PROGRESS'));
$completed = array_values(array_filter($dashboard['enrollments'], static fn (array $item): bool => in_array($item['status'], ['COMPLETED', 'SENT_TO_REVIEW', 'RECOMMENDED_FOR_ACCESS'], true)));
?>
<section class="section-header">
    <div>
        <p class="section-kicker">Личный кабинет</p>
        <h1 class="section-title">Кабинет стажера</h1>
        <p class="section-text">Назначенные курсы, прогресс, последние результаты тестов и рекомендации по обучению.</p>
    </div>
    <div class="actions-row">
        <a href="<?= url('/courses') ?>" class="btn btn-primary">Каталог курсов</a>
    </div>
</section>

<section class="grid grid-3">
    <article class="card stat-card"><div class="stat-card__label">Назначено курсов</div><div class="stat-card__value"><?= count($dashboard['enrollments']) ?></div></article>
    <article class="card stat-card"><div class="stat-card__label">В процессе</div><div class="stat-card__value"><?= count($inProgress) ?></div></article>
    <article class="card stat-card"><div class="stat-card__label">Завершено / отправлено</div><div class="stat-card__value"><?= count($completed) ?></div></article>
</section>

<section class="grid grid-split" style="margin-top: 22px;">
    <div class="card" style="padding: 28px;">
        <div class="section-header">
            <div>
                <p class="section-kicker">Мои курсы</p>
                <h2 class="section-title section-title--small">Назначенные программы</h2>
            </div>
        </div>
        <div class="card-stack">
            <?php foreach ($dashboard['enrollments'] as $enrollment): ?>
                <article class="course-item">
                    <div class="section-header">
                        <div>
                            <p class="section-kicker"><?= e($enrollment['course']['category']['title']) ?></p>
                            <h3 style="margin: 10px 0 0; font-size: 1.35rem; color: var(--navy);"><?= e($enrollment['course']['title']) ?></h3>
                        </div>
                        <span class="<?= course_status_class((string) $enrollment['status']) ?>">
                            <?= e(course_status_label((string) $enrollment['status'])) ?>
                        </span>
                    </div>
                    <p class="section-text"><?= e($enrollment['course']['short_description']) ?></p>
                    <div style="margin-top: 16px;">
                        <div class="muted" style="margin-bottom: 8px;">Прогресс: <?= e(format_percent((int) $enrollment['progress']['completion_percent'])) ?></div>
                        <div class="progress"><div class="progress__bar" style="width: <?= (int) $enrollment['progress']['completion_percent'] ?>%;"></div></div>
                    </div>
                    <div class="actions-row" style="margin-top: 18px;">
                        <a href="<?= url('/courses/' . $enrollment['course']['slug']) ?>" class="btn btn-ghost btn-sm">Открыть курс</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>

    <div>
        <article class="card dashboard-side-card">
            <p class="section-kicker">База знаний</p>
            <h2 class="section-title section-title--small">Регламенты, инструкции и FAQ</h2>
            <p class="section-text">Отдельный раздел для повседневной работы: документы, правила, инструкции, ответы на частые вопросы и внутренние стандарты ЮСИ без привязки к каталогу курсов.</p>
            <div class="course-metric-list">
                <div class="course-metric-list__item">
                    <span>Что внутри</span>
                    <strong>Документы и FAQ</strong>
                </div>
                <div class="course-metric-list__item">
                    <span>Для чего нужна</span>
                    <strong>Быстрый поиск ответов</strong>
                </div>
            </div>
            <div class="actions-row">
                <a href="<?= url('/knowledge-base') ?>" class="btn btn-primary">Открыть базу знаний</a>
            </div>
        </article>
    </div>
</section>
