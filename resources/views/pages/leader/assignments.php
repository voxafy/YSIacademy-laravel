<section class="section-header">
    <div>
        <p class="section-kicker">Назначения</p>
        <h1 class="section-title">Назначение курсов команде</h1>
        <p class="section-text">Выберите сотрудника своей команды и опубликовнный курс, чтобы добавить программу в его маршрут обучения.</p>
    </div>
    <div class="actions-row">
        <a href="<?= url('/leader') ?>" class="btn btn-ghost">Вернуться к обзору</a>
    </div>
</section>

<section class="grid grid-split">
    <div class="card" style="padding: 28px;">
        <div class="section-header">
            <div>
                <p class="section-kicker">Новая выдача</p>
                <h2 class="section-title section-title--small">Назначить курс</h2>
            </div>
        </div>
        <form action="<?= url('/leader/assignments') ?>" method="post" class="form-grid">
            <?= csrf_field() ?>
            <label class="field">
                <span class="field__label">Сотрудник</span>
                <select class="select" name="user_id" required>
                    <option value="">Выберите сотрудника</option>
                    <?php foreach ($team as $member): ?>
                        <option value="<?= e($member['id']) ?>"><?= e($member['full_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="field">
                <span class="field__label">Курс</span>
                <select class="select" name="course_id" required>
                    <option value="">Выберите курс</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?= e($course['id']) ?>"><?= e($course['title']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <button class="btn btn-primary" type="submit">Назначить курс</button>
        </form>
    </div>

    <div class="card" style="padding: 28px;">
        <div class="section-header">
            <div>
                <p class="section-kicker">Матрица команды</p>
                <h2 class="section-title section-title--small">Текущие назначения</h2>
            </div>
        </div>
        <div class="card-stack">
            <?php foreach ($team as $member): ?>
                <article class="course-item">
                    <strong><?= e($member['full_name']) ?></strong>
                    <div class="muted" style="margin-top: 6px;"><?= e(($member['department_name'] ?? 'Без подразделения') . ' · ' . ($member['city_name'] ?? 'Без города')) ?></div>
                    <div class="card-stack" style="margin-top: 12px;">
                        <?php foreach ($member['enrollments'] as $enrollment): ?>
                            <div class="list-item">
                                <strong><?= e($enrollment['course_title']) ?></strong>
                                <div style="margin-top: 8px;"><span class="<?= course_status_class((string) $enrollment['status']) ?>"><?= e(course_status_label((string) $enrollment['status'])) ?></span></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
