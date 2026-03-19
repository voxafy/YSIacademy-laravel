<section class="hero-card is-brand hero-card">
    <div class="section-header">
        <div>
            <p class="section-kicker" style="color: rgba(219,234,254,0.9);">Корпоративная академия</p>
            <h1 class="section-title" style="color:#fff;">Обучение работе в amoCRM, Allio и регламентам ЮСИ</h1>
            <p class="section-text" style="color: rgba(239,246,255,0.92); max-width: 880px;">
                Единая корпоративная среда для онбординга, тестирования, контроля прогресса
                и управленческих решений по доступу сотрудников к рабочим системам.
            </p>
        </div>
        <div class="hero-actions">
            <a href="<?= url('/courses') ?>" class="btn btn-primary">Открыть каталог курсов</a>
            <?php if (!$user): ?>
                <a href="<?= url('/login') ?>" class="btn btn-ghost">Войти</a>
            <?php else: ?>
                <a href="<?= url(role_home((string) $user['role_key'])) ?>" class="btn btn-ghost">Открыть кабинет</a>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="grid grid-3" style="margin-top: 22px;">
    <article class="card stat-card">
        <div class="stat-card__label">Направления</div>
        <div class="stat-card__value">7</div>
        <p class="section-text">Вводный блок, amoCRM, колл-центр, прямой и партнерский отделы, Allio, антифрод.</p>
    </article>
    <article class="card stat-card">
        <div class="stat-card__label">Роли</div>
        <div class="stat-card__value">3</div>
        <p class="section-text">Администратор, руководитель и стажер работают в одном связанном сценарии.</p>
    </article>
    <article class="card stat-card">
        <div class="stat-card__label">Формат</div>
        <div class="stat-card__value">24/7</div>
        <p class="section-text">Видео, материалы, тесты, решения руководителя и контроль результатов в одном интерфейсе.</p>
    </article>
</section>

<section class="card" style="margin-top: 22px; padding: 28px;">
    <div class="section-header">
        <div>
            <p class="section-kicker">Каталог</p>
            <h2 class="section-title section-title--small">Актуальные обучающие программы</h2>
        </div>
        <a href="<?= url('/courses') ?>" class="btn btn-ghost">Все курсы</a>
    </div>
    <div class="grid grid-3">
        <?php foreach ($courses as $course): ?>
            <article class="course-item">
                <p class="section-kicker"><?= e($course['category']['title']) ?></p>
                <h3 style="margin: 10px 0 0; font-size: 1.3rem; color: var(--navy);"><?= e($course['title']) ?></h3>
                <p class="section-text"><?= e($course['short_description']) ?></p>
                <div class="actions-row" style="margin-top: 18px;">
                    <a href="<?= url('/courses/' . $course['slug']) ?>" class="btn btn-ghost btn-sm">Открыть курс</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
