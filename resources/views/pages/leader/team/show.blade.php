<?php
$summary = $employee['training_summary'] ?? [
    'overall_completion_percent' => average_progress(array_map(static fn (array $enrollment): int => (int) ($enrollment['completion_percent'] ?? 0), $employee['enrollments'])),
    'overall_status' => overall_status(array_map(static fn (array $enrollment): string => (string) $enrollment['status'], $employee['enrollments'])),
    'modules_completed' => 0,
    'modules_total' => 0,
    'lessons_completed' => 0,
    'lessons_total' => 0,
    'courses_total' => count($employee['enrollments']),
    'completed_courses' => 0,
    'latest_decision' => null,
    'decision_anchor_enrollment_id' => $employee['enrollments'][0]['id'] ?? null,
];
$latestDecision = $employee['latest_decision'] ?? ($summary['latest_decision'] ?? null);
$decisionAnchorEnrollmentId = $employee['decision_anchor_enrollment_id'] ?? ($summary['decision_anchor_enrollment_id'] ?? null);
$selectedDecision = old('decision', (string) ($latestDecision['decision'] ?? ''));
$decisionComment = old('comment', (string) ($latestDecision['comment'] ?? ''));
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

<section class="grid grid-3 employee-overview-grid">
    <article class="card stat-card stat-card--progress">
        <div class="stat-card__label">Общий прогресс обучения</div>
        <div class="stat-card__value"><?= e(format_percent((int) $summary['overall_completion_percent'])) ?></div>
        <div class="stat-card__meta">
            Модули: <?= e((string) $summary['modules_completed']) ?>/<?= e((string) $summary['modules_total']) ?>
            · Уроки: <?= e((string) $summary['lessons_completed']) ?>/<?= e((string) $summary['lessons_total']) ?>
        </div>
    </article>
    <article class="card stat-card">
        <div class="stat-card__label">Статус обучения</div>
        <div class="stat-card__value" style="font-size: 1.35rem;">
            <span class="<?= course_status_class((string) $summary['overall_status']) ?>"><?= e(course_status_label((string) $summary['overall_status'])) ?></span>
        </div>
        <div class="stat-card__meta">Курсов завершено: <?= e((string) $summary['completed_courses']) ?>/<?= e((string) $summary['courses_total']) ?></div>
    </article>
    <article class="card stat-card">
        <div class="stat-card__label">Управленческое решение</div>
        <div class="stat-card__value" style="font-size: 1rem; line-height: 1.4;">
            <?= e($latestDecision ? decision_label((string) $latestDecision['decision']) : 'Решение не принято') ?>
        </div>
        <div class="stat-card__meta">
            <?= e($latestDecision ? ('Обновлено: ' . format_datetime((string) $latestDecision['created_at'])) : 'Единое решение по всей траектории сотрудника') ?>
        </div>
    </article>
</section>

<section class="grid grid-split employee-review-grid" style="margin-top: 22px;">
    <div class="card employee-review-card">
        <div class="section-header">
            <div>
                <p class="section-kicker">Курсы</p>
                <h2 class="section-title section-title--small">Результаты по программам</h2>
            </div>
        </div>
        <div class="card-stack">
            <?php foreach ($employee['enrollments'] as $courseIndex => $enrollment): ?>
                <article class="course-item employee-course-card">
                    <div class="section-header">
                        <div>
                            <p class="section-kicker">Программа <?= e((string) ($courseIndex + 1)) ?></p>
                            <h3 class="employee-course-card__title"><?= e($enrollment['course_title']) ?></h3>
                        </div>
                        <span class="<?= course_status_class((string) $enrollment['status']) ?>"><?= e(course_status_label((string) $enrollment['status'])) ?></span>
                    </div>

                    <div class="employee-course-card__meta">
                        <span class="muted">Назначен: <?= e(format_date((string) $enrollment['assigned_at'])) ?></span>
                        <span class="muted">Активность: <?= e(format_datetime((string) ($enrollment['last_activity_at'] ?? ''))) ?></span>
                    </div>

                    <div style="margin-top: 16px;">
                        <div class="employee-course-card__progress-head">
                            <span>Прогресс: <?= e(format_percent((int) ($enrollment['completion_percent'] ?? 0))) ?></span>
                            <span>Модули <?= e((string) ($enrollment['modules_completed'] ?? 0)) ?>/<?= e((string) ($enrollment['modules_total'] ?? 0)) ?></span>
                            <span>Уроки <?= e((string) ($enrollment['lessons_completed'] ?? 0)) ?>/<?= e((string) ($enrollment['lessons_total'] ?? 0)) ?></span>
                        </div>
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

    <div class="card employee-decision-card">
        <div class="section-header">
            <div>
                <p class="section-kicker">Решение руководителя</p>
                <h2 class="section-title section-title--small">Единый итог по сотруднику</h2>
                <p class="section-text">Форма сохраняет одно итоговое решение по всей траектории обучения, а не по каждому курсу отдельно.</p>
            </div>
        </div>

        <div class="list-item employee-decision-card__summary">
            <strong>Общая траектория обучения</strong>
            <div class="muted">
                В программе: <?= e((string) $summary['courses_total']) ?> курсов
                · Модули: <?= e((string) $summary['modules_completed']) ?>/<?= e((string) $summary['modules_total']) ?>
                · Уроки: <?= e((string) $summary['lessons_completed']) ?>/<?= e((string) $summary['lessons_total']) ?>
            </div>
        </div>

        <?php if ($latestDecision): ?>
            <div class="employee-decision-card__history">
                Последнее решение: <?= e(decision_label((string) $latestDecision['decision'])) ?>
                <?php if (!empty($latestDecision['leader_name'])): ?>
                    · <?= e((string) $latestDecision['leader_name']) ?>
                <?php endif; ?>
                · <?= e(format_datetime((string) $latestDecision['created_at'])) ?>
            </div>
        <?php endif; ?>

        <?php if ($decisionAnchorEnrollmentId): ?>
            <form action="<?= url('/leader/decisions/' . $decisionAnchorEnrollmentId) ?>" method="post" class="form-grid employee-decision-card__form">
                <?= csrf_field() ?>
                <label class="field">
                    <span class="field__label">Решение</span>
                    <select class="select" name="decision" required>
                        <option value="">Выберите решение</option>
                        <option value="RECOMMEND_ACCESS" <?= $selectedDecision === 'RECOMMEND_ACCESS' ? 'selected' : '' ?>>Рекомендован к выдаче доступа</option>
                        <option value="RETRAIN" <?= $selectedDecision === 'RETRAIN' ? 'selected' : '' ?>>Нужна переподготовка</option>
                        <option value="REPEAT_TRAINING" <?= $selectedDecision === 'REPEAT_TRAINING' ? 'selected' : '' ?>>Отправить на повторное обучение</option>
                    </select>
                </label>
                <label class="field">
                    <span class="field__label">Комментарий</span>
                    <textarea class="textarea" name="comment"><?= e($decisionComment) ?></textarea>
                </label>
                <button class="btn btn-primary" type="submit">Сохранить решение</button>
            </form>
        <?php else: ?>
            <div class="list-item">
                <strong>Нет активной траектории</strong>
                <div class="muted">Сначала назначьте сотруднику хотя бы один курс, чтобы сохранить итоговое решение.</div>
            </div>
        <?php endif; ?>
    </div>
</section>
