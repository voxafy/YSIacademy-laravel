<?php
$overallProgress = average_progress(array_map(static fn (array $item): int => (int) ($item['completion_percent'] ?? 0), $employee['enrollments']));
$overallStatus = overall_status(array_map(static fn (array $item): string => (string) $item['status'], $employee['enrollments']));
?>
<section class="section-header">
    <div>
        <p class="section-kicker">Результаты сотрудника</p>
        <h1 class="section-title"><?= e($employee['full_name']) ?></h1>
        <p class="section-text"><?= e(($employee['department_name'] ?? 'Без подразделения') . ' · ' . ($employee['city_name'] ?? 'Без города')) ?></p>
    </div>
    <div class="actions-row"><a href="<?= url('/admin/results') ?>" class="btn btn-ghost">К сводке</a></div>
</section>

<section class="grid grid-3">
    <article class="card stat-card"><div class="stat-card__label">Общий прогресс</div><div class="stat-card__value"><?= e(format_percent($overallProgress)) ?></div></article>
    <article class="card stat-card"><div class="stat-card__label">Статус</div><div class="stat-card__value" style="font-size: 1.2rem;"><span class="<?= course_status_class($overallStatus) ?>"><?= e(course_status_label($overallStatus)) ?></span></div></article>
    <article class="card stat-card"><div class="stat-card__label">Руководитель</div><div class="stat-card__value" style="font-size: 1.2rem;"><?= e($employee['supervisor_name'] ?: 'Не назначен') ?></div></article>
</section>

<section class="card" style="padding: 28px; margin-top: 22px;">
    <div class="card-stack">
        <?php foreach ($employee['enrollments'] as $enrollment): ?>
            <article class="course-item">
                <div class="section-header">
                    <div>
                        <h3 style="margin: 0; font-size: 1.3rem; color: var(--navy);"><?= e($enrollment['course_title']) ?></h3>
                        <p class="section-text">Прогресс: <?= e(format_percent((int) ($enrollment['completion_percent'] ?? 0))) ?></p>
                    </div>
                    <span class="<?= course_status_class((string) $enrollment['status']) ?>"><?= e(course_status_label((string) $enrollment['status'])) ?></span>
                </div>
                <?php if (!empty($enrollment['attempts'])): ?>
                    <div class="card-stack" style="margin-top: 16px;">
                        <?php foreach (array_slice($enrollment['attempts'], 0, 5) as $attempt): ?>
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
</section>
