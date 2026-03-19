<?php
$overallProgress = average_progress(array_map(static fn (array $enrollment): int => (int) ($enrollment['completion_percent'] ?? 0), $employee['enrollments']));
$overallStatus = overall_status(array_map(static fn (array $enrollment): string => (string) $enrollment['status'], $employee['enrollments']));
$latestDecision = null;
foreach ($employee['enrollments'] as $enrollment) {
    if (!empty($enrollment['decisions'][0])) {
        $latestDecision = $enrollment['decisions'][0];
        break;
    }
}
?>
<section class="section-header">
    <div>
        <p class="section-kicker">Карточка сотрудника</p>
        <h1 class="section-title"><?= e($employee['full_name']) ?></h1>
        <p class="section-text"><?= e(($employee['department_name'] ?? 'Без подразделения') . ' · ' . ($employee['city_name'] ?? 'Без города')) ?></p>
    </div>
    <div class="actions-row">
        <a href="<?= url('/leader/team/' . $employee['id'] . '/edit') ?>" class="btn btn-ghost">Редактировать</a>
        <a href="<?= url('/leader') ?>" class="btn btn-primary">Вернуться к обзору</a>
    </div>
</section>

<section class="grid grid-3">
    <article class="card stat-card"><div class="stat-card__label">Общий прогресс</div><div class="stat-card__value"><?= e(format_percent($overallProgress)) ?></div></article>
    <article class="card stat-card"><div class="stat-card__label">Статус</div><div class="stat-card__value" style="font-size: 1.35rem;"><span class="<?= course_status_class($overallStatus) ?>"><?= e(course_status_label($overallStatus)) ?></span></div></article>
    <article class="card stat-card"><div class="stat-card__label">Решение</div><div class="stat-card__value" style="font-size: 1rem; line-height: 1.4;"><?= e($latestDecision ? decision_label((string) $latestDecision['decision']) : 'Решение не принято') ?></div></article>
</section>

<section class="grid grid-split" style="margin-top: 22px;">
    <div class="card" style="padding: 28px;">
        <div class="section-header">
            <div>
                <p class="section-kicker">Курсы</p>
                <h2 class="section-title section-title--small">Результаты по программам</h2>
            </div>
        </div>
        <div class="card-stack">
            <?php foreach ($employee['enrollments'] as $enrollment): ?>
                <article class="course-item">
                    <div class="section-header">
                        <div>
                            <h3 style="margin: 0; font-size: 1.25rem; color: var(--navy);"><?= e($enrollment['course_title']) ?></h3>
                            <p class="section-text">Назначен: <?= e(format_date((string) $enrollment['assigned_at'])) ?></p>
                        </div>
                        <span class="<?= course_status_class((string) $enrollment['status']) ?>"><?= e(course_status_label((string) $enrollment['status'])) ?></span>
                    </div>
                    <div style="margin-top: 16px;">
                        <div class="muted" style="margin-bottom: 8px;">Прогресс: <?= e(format_percent((int) ($enrollment['completion_percent'] ?? 0))) ?></div>
                        <div class="progress"><div class="progress__bar" style="width: <?= (int) ($enrollment['completion_percent'] ?? 0) ?>%;"></div></div>
                    </div>
                    <?php if (!empty($enrollment['attempts'])): ?>
                        <div class="card-stack" style="margin-top: 16px;">
                            <?php foreach (array_slice($enrollment['attempts'], 0, 3) as $attempt): ?>
                                <div class="list-item">
                                    <strong><?= e($attempt['quiz_title']) ?></strong>
                                    <div class="muted">Результат: <?= e(format_percent((float) $attempt['percentage'])) ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="card" style="padding: 28px;">
        <div class="section-header">
            <div>
                <p class="section-kicker">Решение руководителя</p>
                <h2 class="section-title section-title--small">Управленческий статус</h2>
            </div>
        </div>
        <?php foreach ($employee['enrollments'] as $enrollment): ?>
            <form action="<?= url('/leader/decisions/' . $enrollment['id']) ?>" method="post" class="form-grid" style="margin-bottom: 20px;">
                <?= csrf_field() ?>
                <div class="list-item">
                    <strong><?= e($enrollment['course_title']) ?></strong>
                </div>
                <label class="field">
                    <span class="field__label">Решение</span>
                    <select class="select" name="decision" required>
                        <option value="">Выберите решение</option>
                        <option value="RECOMMEND_ACCESS">Рекомендован к выдаче доступа</option>
                        <option value="RETRAIN">Нужна переподготовка</option>
                        <option value="REPEAT_TRAINING">Отправить на повторное обучение</option>
                    </select>
                </label>
                <label class="field">
                    <span class="field__label">Комментарий</span>
                    <textarea class="textarea" name="comment"></textarea>
                </label>
                <button class="btn btn-primary" type="submit">Сохранить решение</button>
            </form>
        <?php endforeach; ?>
    </div>
</section>
