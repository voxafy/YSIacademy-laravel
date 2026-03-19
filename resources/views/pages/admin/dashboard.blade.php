<section class="section-header">
    <div>
        <p class="section-kicker">Администратор</p>
        <h1 class="section-title">Обзор платформы</h1>
        <p class="section-text">Сводка по пользователям, курсам, назначениям и последним изменениям в академии.</p>
    </div>
    <div class="actions-row">
        <a href="<?= url('/admin/courses') ?>" class="btn btn-primary">Редактор курсов</a>
    </div>
</section>

<section class="grid grid-4">
    <article class="card stat-card"><div class="stat-card__label">Пользователи</div><div class="stat-card__value"><?= e((string) $dashboard['counts']['users']) ?></div></article>
    <article class="card stat-card"><div class="stat-card__label">Курсы</div><div class="stat-card__value"><?= e((string) $dashboard['counts']['courses']) ?></div></article>
    <article class="card stat-card"><div class="stat-card__label">Назначения</div><div class="stat-card__value"><?= e((string) $dashboard['counts']['enrollments']) ?></div></article>
    <article class="card stat-card"><div class="stat-card__label">Медиа</div><div class="stat-card__value"><?= e((string) $dashboard['counts']['media']) ?></div></article>
</section>

<section class="grid grid-3" style="margin-top: 22px;">
    <article class="card" style="padding: 24px;">
        <div class="section-header"><div><p class="section-kicker">Курсы</p><h2 class="section-title section-title--small">Последние обновления</h2></div></div>
        <div class="card-stack">
            <?php foreach ($dashboard['recent_courses'] as $course): ?>
                <a class="list-item" href="<?= url('/admin/courses/' . $course['id']) ?>">
                    <strong><?= e($course['title']) ?></strong>
                    <div class="muted"><?= e($course['category_title']) ?> · <?= e((string) $course['modules_count']) ?> модулей</div>
                </a>
            <?php endforeach; ?>
        </div>
    </article>
    <article class="card" style="padding: 24px;">
        <div class="section-header"><div><p class="section-kicker">Пользователи</p><h2 class="section-title section-title--small">Новые профили</h2></div></div>
        <div class="card-stack">
            <?php foreach ($dashboard['recent_users'] as $row): ?>
                <a class="list-item" href="<?= url('/admin/users/' . $row['id']) ?>">
                    <strong><?= e($row['full_name']) ?></strong>
                    <div class="muted"><?= e(role_label((string) $row['role_key'])) ?> · <?= e($row['city_name'] ?: 'Без города') ?></div>
                </a>
            <?php endforeach; ?>
        </div>
    </article>
    <article class="card" style="padding: 24px;">
        <div class="section-header"><div><p class="section-kicker">Результаты</p><h2 class="section-title section-title--small">Последние назначения</h2></div></div>
        <div class="card-stack">
            <?php foreach ($dashboard['results'] as $row): ?>
                <div class="list-item">
                    <strong><?= e($row['full_name']) ?></strong>
                    <div class="muted"><?= e($row['course_title']) ?></div>
                    <div style="margin-top: 8px;"><span class="<?= course_status_class((string) $row['status']) ?>"><?= e(course_status_label((string) $row['status'])) ?></span></div>
                </div>
            <?php endforeach; ?>
        </div>
    </article>
</section>
