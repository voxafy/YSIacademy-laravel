<section class="section-header">
    <div>
        <p class="section-kicker">Назначения</p>
        <h1 class="section-title">Матрица курсов и сотрудников</h1>
        <p class="section-text">Назначайте программы стажерам и руководителям, отслеживайте статусы и прогресс.</p>
    </div>
</section>

<section class="grid grid-split">
    <div class="card" style="padding: 28px;">
        <div class="section-header"><div><p class="section-kicker">Новое назначение</p><h2 class="section-title section-title--small">Назначить курс</h2></div></div>
        <form action="<?= url('/admin/assignments') ?>" method="post" class="form-grid">
            <?= csrf_field() ?>
            <label class="field"><span class="field__label">Пользователь</span><select class="select" name="user_id" required><option value="">Выберите пользователя</option><?php foreach ($resources['users'] as $row): ?><option value="<?= e($row['id']) ?>"><?= e($row['full_name']) ?> · <?= e(role_label((string) $row['role_key'])) ?></option><?php endforeach; ?></select></label>
            <label class="field"><span class="field__label">Курс</span><select class="select" name="course_id" required><option value="">Выберите курс</option><?php foreach ($resources['courses'] as $course): ?><option value="<?= e($course['id']) ?>"><?= e($course['title']) ?></option><?php endforeach; ?></select></label>
            <button class="btn btn-primary" type="submit">Назначить курс</button>
        </form>
    </div>

    <div class="card" style="padding: 28px;">
        <div class="table-toolbar">
            <div><p class="section-kicker">Текущие назначения</p><h2 class="section-title section-title--small">Активная матрица</h2></div>
            <input class="input search-input" type="search" placeholder="Найти назначение" data-table-search="admin-assignments-table">
        </div>
        <div class="table-wrap">
            <table class="table" id="admin-assignments-table">
                <thead><tr><th>Сотрудник</th><th>Роль</th><th>Курс</th><th>Прогресс</th><th>Статус</th></tr></thead>
                <tbody>
                    <?php foreach ($resources['enrollments'] as $row): ?>
                        <tr>
                            <td><strong><?= e($row['full_name']) ?></strong></td>
                            <td><span class="<?= role_badge_class((string) $row['role_key']) ?>"><?= e(role_label((string) $row['role_key'])) ?></span></td>
                            <td><?= e($row['course_title']) ?></td>
                            <td><?= e(format_percent((int) ($row['completion_percent'] ?? 0))) ?></td>
                            <td><span class="<?= course_status_class((string) $row['status']) ?>"><?= e(course_status_label((string) $row['status'])) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
