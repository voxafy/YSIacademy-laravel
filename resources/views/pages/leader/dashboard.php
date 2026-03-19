<?php
$allEnrollments = [];
foreach ($team as $member) {
    foreach ($member['enrollments'] as $enrollment) {
        $allEnrollments[] = $enrollment;
    }
}
$ready = array_values(array_filter($allEnrollments, static fn (array $item): bool => $item['status'] === 'RECOMMENDED_FOR_ACCESS'));
$strongProgress = array_values(array_filter($members, static fn (array $member): bool => $member['overall_progress'] >= 80));
?>
<section class="section-header">
    <div>
        <p class="section-kicker">Руководитель</p>
        <h1 class="section-title">Обзор команды</h1>
        <p class="section-text">Общий прогресс сотрудников, назначения курсов и быстрый переход в карточку каждого стажера.</p>
    </div>
    <div class="actions-row">
        <a href="<?= url('/leader/assignments') ?>" class="btn btn-primary">Назначения курсов</a>
    </div>
</section>

<section class="grid grid-4">
    <article class="card stat-card"><div class="stat-card__label">Сотрудников в команде</div><div class="stat-card__value"><?= count($members) ?></div></article>
    <article class="card stat-card"><div class="stat-card__label">Всего назначений</div><div class="stat-card__value"><?= count($allEnrollments) ?></div></article>
    <article class="card stat-card"><div class="stat-card__label">Рекомендованы к доступу</div><div class="stat-card__value"><?= count($ready) ?></div></article>
    <article class="card stat-card"><div class="stat-card__label">Прогресс 80%+</div><div class="stat-card__value"><?= count($strongProgress) ?></div></article>
</section>

<section class="card" style="padding: 28px; margin-top: 22px;">
    <div class="collapse-header">
        <div>
            <p class="section-kicker">Новый стажер</p>
            <h2 class="section-title section-title--small">Добавление сотрудника в команду</h2>
        </div>
        <button class="btn btn-primary" type="button" data-collapse-toggle="leader-create-panel" aria-expanded="false">Добавить стажера</button>
    </div>
    <div id="leader-create-panel" class="collapse-panel" hidden style="margin-top: 20px;">
        <form action="<?= url('/leader/trainees') ?>" method="post" class="form-grid form-grid-3">
            <?= csrf_field() ?>
            <label class="field"><span class="field__label">ФИО</span><input class="input" type="text" name="full_name" required></label>
            <label class="field"><span class="field__label">Email</span><input class="input" type="email" name="email" required></label>
            <label class="field"><span class="field__label">Телефон</span><input class="input" type="text" name="phone"></label>
            <label class="field"><span class="field__label">Должность</span><input class="input" type="text" name="title" required></label>
            <label class="field">
                <span class="field__label">Город</span>
                <select class="select" name="city_id" required>
                    <option value="">Выберите город</option>
                    <?php foreach ($options['cities'] as $city): ?><option value="<?= e($city['id']) ?>"><?= e($city['name']) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label class="field">
                <span class="field__label">Подразделение</span>
                <select class="select" name="department_id" required>
                    <option value="">Выберите подразделение</option>
                    <?php foreach ($options['departments'] as $department): ?>
                        <?php if (($department['slug'] ?? '') === 'administration') continue; ?>
                        <option value="<?= e($department['id']) ?>"><?= e($department['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="field" style="grid-column: 1 / -1;"><span class="field__label">Пароль</span><input class="input" type="password" name="password" required></label>
            <div style="grid-column: 1 / -1;"><button class="btn btn-primary" type="submit">Сохранить стажера</button></div>
        </form>
    </div>
</section>

<section class="card" style="padding: 28px; margin-top: 22px;">
    <div class="table-toolbar">
        <div>
            <p class="section-kicker">Команда</p>
            <h2 class="section-title section-title--small">Сотрудники и общий прогресс</h2>
        </div>
        <input id="leader-team-search" class="input search-input" type="search" placeholder="Найти сотрудника" data-table-search="leader-team-table">
    </div>
    <div class="table-wrap">
        <table class="table" id="leader-team-table">
            <thead>
                <tr>
                    <th><button class="sort-button" type="button" data-sort-table="leader-team-table" data-sort-key="full_name" data-sort-dir="asc">Сотрудник</button></th>
                    <th><button class="sort-button" type="button" data-sort-table="leader-team-table" data-sort-key="city_name" data-sort-dir="asc">Город</button></th>
                    <th><button class="sort-button" type="button" data-sort-table="leader-team-table" data-sort-key="department_name" data-sort-dir="asc">Подразделение</button></th>
                    <th><button class="sort-button" type="button" data-sort-table="leader-team-table" data-sort-key="assigned_courses" data-sort-dir="asc">Курсы</button></th>
                    <th><button class="sort-button" type="button" data-sort-table="leader-team-table" data-sort-key="overall_progress" data-sort-dir="asc">Прогресс</button></th>
                    <th>Статус</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($members as $member): ?>
                    <tr>
                        <td data-col="full_name"><strong><?= e($member['full_name']) ?></strong></td>
                        <td data-col="city_name"><?= e($member['city_name']) ?></td>
                        <td data-col="department_name"><?= e($member['department_name']) ?></td>
                        <td data-col="assigned_courses"><?= e((string) $member['assigned_courses']) ?></td>
                        <td data-col="overall_progress">
                            <div class="muted" style="margin-bottom: 8px;"><?= e(format_percent($member['overall_progress'])) ?></div>
                            <div class="progress"><div class="progress__bar" style="width: <?= (int) $member['overall_progress'] ?>%;"></div></div>
                        </td>
                        <td><span class="<?= course_status_class((string) $member['overall_status']) ?>"><?= e(course_status_label((string) $member['overall_status'])) ?></span></td>
                        <td><a href="<?= url('/leader/team/' . $member['id']) ?>" class="btn btn-ghost btn-sm">Открыть карточку</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
