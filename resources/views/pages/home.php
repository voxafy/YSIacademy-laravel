<section class="hero-card is-brand hero-card">
    <div class="section-header">
        <div>
            <p class="section-kicker" style="color: rgba(219,234,254,0.9);">Сервис обучения ЮСИ</p>
            <h1 class="section-title" style="color:#fff;">СтройТех для сотрудников ЮСИ</h1>
            <p class="section-text" style="color: rgba(239,246,255,0.92); max-width: 880px;">
                СтройТех объединяет онбординг, обучающие программы, проверку знаний, материалы и контроль прогресса
                по стандартам ЮСИ. Сервис помогает быстрее вводить сотрудников в процессы ЮСИ по amoCRM, Allio и
                внутренним регламентам, а руководителям и администраторам дает прозрачную картину обучения.
            </p>
        </div>
        <div class="hero-actions">
            <?php if (!$user): ?>
                <a href="<?= url('/login') ?>" class="btn btn-primary">Войти в систему</a>
                <a href="#about-platform" class="btn btn-ghost">О сервисе</a>
            <?php else: ?>
                <a href="<?= url('/courses') ?>" class="btn btn-primary">Открыть каталог курсов</a>
                <a href="<?= url(role_home((string) $user['role_key'])) ?>" class="btn btn-ghost">Открыть кабинет</a>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="grid grid-3" style="margin-top: 22px;">
    <article class="card stat-card">
        <div class="stat-card__label">Обучение</div>
        <div class="stat-card__value">24/7</div>
        <p class="section-text">Все программы, материалы и проверки знаний доступны в одном окне в любое удобное время.</p>
    </article>
    <article class="card stat-card">
        <div class="stat-card__label">Роли</div>
        <div class="stat-card__value">3</div>
        <p class="section-text">Администратор, руководитель и сотрудник работают в едином связанном сценарии обучения.</p>
    </article>
    <article class="card stat-card">
        <div class="stat-card__label">Контроль</div>
        <div class="stat-card__value">1</div>
        <p class="section-text">Одна платформа для маршрута сотрудника: от первого входа до итогового решения по результатам.</p>
    </article>
</section>

<?php if (!$user): ?>
    <section id="about-platform" class="grid grid-split" style="margin-top: 22px;">
        <article class="card" style="padding: 28px;">
            <p class="section-kicker">О сервисе</p>
            <h2 class="section-title section-title--small">Зачем ЮСИ нужен СтройТех</h2>
            <p class="section-text">
                Сервис помогает запускать единый стандарт обучения для новых и действующих сотрудников ЮСИ:
                назначать программы, собирать материалы, подтверждать прохождение и контролировать результат без
                ручной рутины и разрозненных таблиц.
            </p>
        </article>
        <article class="card" style="padding: 28px;">
            <p class="section-kicker">О компании</p>
            <h2 class="section-title section-title--small">ЮСИ и сервис СтройТех</h2>
            <p class="section-text">
                ЮСИ использует СтройТех как внутренний сервис обучения: здесь собраны регламенты, обязательные
                программы, инструкции и проверка знаний для подразделений, которые работают в amoCRM, Allio и
                сопутствующих процессах компании.
            </p>
        </article>
    </section>

    <section class="grid grid-3" style="margin-top: 22px;">
        <article class="card" style="padding: 24px;">
            <p class="section-kicker">Онбординг</p>
            <h2 class="section-title section-title--small">Быстрый старт</h2>
            <p class="section-text">Новые сотрудники получают понятный маршрут обучения и доступ к нужным материалам с первого дня.</p>
        </article>
        <article class="card" style="padding: 24px;">
            <p class="section-kicker">Знания</p>
            <h2 class="section-title section-title--small">Единые стандарты</h2>
            <p class="section-text">Материалы, уроки, видео и тесты собраны в одном месте и поддерживают единый стандарт работы команд.</p>
        </article>
        <article class="card" style="padding: 24px;">
            <p class="section-kicker">Прозрачность</p>
            <h2 class="section-title section-title--small">Контроль прогресса</h2>
            <p class="section-text">Руководители и администраторы видят статус прохождения, результаты и точки, где сотруднику нужна поддержка.</p>
        </article>
    </section>
<?php else: ?>
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
<?php endif; ?>
