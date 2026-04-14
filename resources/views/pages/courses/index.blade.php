<?php
$courseGroups = [];
$assignedCount = 0;
$inProgressCount = 0;
$completedCount = 0;

foreach ($courses as $course) {
    $categoryKey = (string) ($course['category']['slug'] ?? 'catalog');
    if (!isset($courseGroups[$categoryKey])) {
        $courseGroups[$categoryKey] = [
            'title' => (string) ($course['category']['title'] ?? 'Программы'),
            'slug' => $categoryKey,
            'items' => [],
        ];
    }

    $courseGroups[$categoryKey]['items'][] = $course;

    if (!empty($course['enrollment'])) {
        $assignedCount++;
        $status = (string) ($course['enrollment']['status'] ?? '');
        if ($status === 'COMPLETED') {
            $completedCount++;
        } elseif ($status !== 'NOT_STARTED') {
            $inProgressCount++;
        }
    }
}

$groupList = array_values($courseGroups);
$catalogDescription = $user
    ? 'Назначенные программы, обязательное обучение и ролевые маршруты собраны в одном каталоге.'
    : 'Открытые учебные программы ЮСИ: онбординг, ролевые маршруты и контрольные блоки по рабочим процессам.';
?>

<section class="catalog-hero hero-card is-brand">
    <div class="catalog-hero__content">
        <div class="catalog-hero__copy">
            <p class="section-kicker catalog-hero__kicker">Каталог курсов</p>
            <h1 class="section-title catalog-hero__title">Обучающие программы СтройТех</h1>
            <p class="section-text catalog-hero__text"><?= e($catalogDescription) ?></p>

            <?php if ($groupList !== []): ?>
                <div class="catalog-hero__chips">
                    <?php foreach ($groupList as $group): ?>
                        <a href="#catalog-group-<?= e($group['slug']) ?>" class="badge badge-muted catalog-chip">
                            <?= e($group['title']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="catalog-hero__stats">
            <article class="catalog-stat">
                <span class="catalog-stat__label">Программ в каталоге</span>
                <strong class="catalog-stat__value"><?= e((string) count($courses)) ?></strong>
                <span class="catalog-stat__meta">Аккуратная витрина без черновиков и шаблонов.</span>
            </article>
            <article class="catalog-stat">
                <span class="catalog-stat__label"><?= $user ? 'Назначено вам' : 'Категорий' ?></span>
                <strong class="catalog-stat__value"><?= e((string) ($user ? $assignedCount : count($groupList))) ?></strong>
                <span class="catalog-stat__meta"><?= $user ? 'Все активные программы и обязательные блоки.' : 'Маршруты сгруппированы по рабочим направлениям.' ?></span>
            </article>
            <article class="catalog-stat">
                <span class="catalog-stat__label"><?= $user ? 'В процессе' : 'Готово к старту' ?></span>
                <strong class="catalog-stat__value"><?= e((string) ($user ? $inProgressCount : count($courses))) ?></strong>
                <span class="catalog-stat__meta"><?= $user ? 'Можно быстро вернуться к текущему шагу.' : 'Каждая программа оформлена как цельный учебный маршрут.' ?></span>
            </article>
            <?php if ($user): ?>
                <article class="catalog-stat">
                    <span class="catalog-stat__label">Завершено</span>
                    <strong class="catalog-stat__value"><?= e((string) $completedCount) ?></strong>
                    <span class="catalog-stat__meta">История прохождения и повторного открытия сохраняется.</span>
                </article>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if ($courses === []): ?>
    <section class="card catalog-empty">
        <div class="kb-empty kb-empty--compact">
            <h3>Каталог пока пуст</h3>
            <p>После публикации программ здесь появятся готовые маршруты обучения для сотрудников, руководителей и администраторов.</p>
        </div>
    </section>
<?php else: ?>
    <section class="catalog-groups">
        <?php foreach ($groupList as $group): ?>
            <section id="catalog-group-<?= e($group['slug']) ?>" class="catalog-group">
                <div class="section-header catalog-group__header">
                    <div>
                        <p class="section-kicker">Категория</p>
                        <h2 class="section-title section-title--small"><?= e($group['title']) ?></h2>
                        <p class="section-text">Программы с единым контекстом и понятным следующим шагом.</p>
                    </div>
                    <span class="badge badge-muted"><?= e((string) count($group['items'])) ?> <?= count($group['items']) === 1 ? 'программа' : 'программы' ?></span>
                </div>

                <div class="catalog-grid">
                    <?php foreach ($group['items'] as $course): ?>
                        <?php
                        $enrollment = $course['enrollment'] ?? null;
                        $moduleCount = count($course['modules'] ?? []);
                        $lessonCount = array_sum(array_map(
                            static fn (array $module): int => (int) ($module['lessons_count'] ?? count($module['lessons'] ?? [])),
                            $course['modules'] ?? [],
                        ));
                        $progress = (int) ($enrollment['completion_percent'] ?? 0);
                        $status = (string) ($enrollment['status'] ?? '');
                        $ctaLabel = 'Открыть программу';

                        if ($enrollment) {
                            $ctaLabel = match ($status) {
                                'COMPLETED' => 'Повторить курс',
                                'NOT_STARTED' => 'Начать обучение',
                                default => 'Продолжить обучение',
                            };
                        } elseif (!$user) {
                            $ctaLabel = 'Посмотреть программу';
                        }
                        ?>
                        <article class="card catalog-card">
                            <div class="catalog-card__top">
                                <div class="catalog-card__eyebrow">
                                    <span class="badge badge-muted"><?= e($course['category']['title']) ?></span>
                                    <?php if ($enrollment): ?>
                                        <span class="<?= course_status_class($status) ?>"><?= e(course_status_label($status)) ?></span>
                                    <?php endif; ?>
                                </div>
                                <h3 class="catalog-card__title"><?= e($course['title']) ?></h3>
                                <p class="catalog-card__description"><?= e((string) ($course['short_description'] ?: 'Краткое описание будет добавлено позже.')) ?></p>
                            </div>

                            <div class="catalog-card__metrics">
                                <div class="catalog-card__metric">
                                    <span>Модули</span>
                                    <strong><?= e((string) $moduleCount) ?></strong>
                                </div>
                                <div class="catalog-card__metric">
                                    <span>Уроки</span>
                                    <strong><?= e((string) $lessonCount) ?></strong>
                                </div>
                                <?php if ($enrollment): ?>
                                    <div class="catalog-card__metric">
                                        <span>Прогресс</span>
                                        <strong><?= e(format_percent($progress)) ?></strong>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if ($enrollment): ?>
                                <div class="catalog-card__progress">
                                    <div class="catalog-card__progress-head">
                                        <span>Ваш прогресс</span>
                                        <strong><?= e(format_percent($progress)) ?></strong>
                                    </div>
                                    <div class="progress"><div class="progress__bar" style="width: <?= $progress ?>%;"></div></div>
                                </div>
                            <?php endif; ?>

                            <div class="catalog-card__footer">
                                <a href="<?= url('/courses/' . $course['slug']) ?>" class="btn btn-primary"><?= e($ctaLabel) ?></a>
                                <?php if ($enrollment): ?>
                                    <span class="catalog-card__footer-meta">
                                        <?= e((string) ($enrollment['lessons_completed'] ?? 0)) ?>/<?= e((string) ($enrollment['lessons_total'] ?? 0)) ?> уроков
                                    </span>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
