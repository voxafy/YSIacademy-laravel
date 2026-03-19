<section class="section-header">
    <div>
        <p class="section-kicker">Результаты</p>
        <h1 class="section-title">Сводка по сотрудникам</h1>
        <p class="section-text">Общий прогресс, последний статус и переход в детальную карточку результатов по каждому сотруднику.</p>
    </div>
</section>

<section class="card" style="padding: 28px;">
    <div class="table-toolbar">
        <div><p class="section-kicker">Сотрудники</p><h2 class="section-title section-title--small">Общий прогресс</h2></div>
        <input class="input search-input" type="search" placeholder="Найти сотрудника" data-table-search="admin-results-table">
    </div>
    <div class="table-wrap">
        <table class="table" id="admin-results-table">
            <thead><tr><th>Сотрудник</th><th>Город</th><th>Подразделение</th><th>Курсы</th><th>Прогресс</th><th>Решение</th><th>Действие</th></tr></thead>
            <tbody>
                <?php foreach ($summaries as $row): ?>
                    <?php
                    $progress = average_progress(array_map(static fn (array $item): int => (int) ($item['completion_percent'] ?? 0), $row['enrollments']));
                    $status = overall_status(array_map(static fn (array $item): string => (string) $item['status'], $row['enrollments']));
                    ?>
                    <tr>
                        <td><strong><?= e($row['full_name']) ?></strong></td>
                        <td><?= e($row['city_name'] ?: 'Без города') ?></td>
                        <td><?= e($row['department_name'] ?: 'Без подразделения') ?></td>
                        <td><?= e((string) count($row['enrollments'])) ?></td>
                        <td><?= e(format_percent($progress)) ?></td>
                        <td><span class="<?= course_status_class($status) ?>"><?= e($row['latest_decision'] ? decision_label((string) $row['latest_decision']['decision']) : course_status_label($status)) ?></span></td>
                        <td><a href="<?= url('/admin/results/' . $row['id']) ?>" class="btn btn-ghost btn-sm">Открыть карточку</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
