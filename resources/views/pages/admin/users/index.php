<?php
$oldForm = flash_now('old_form', []);
?>
<section class="section-header">
    <div>
        <p class="section-kicker">Пользователи</p>
        <h1 class="section-title">Управление профилями</h1>
        <p class="section-text">Список ролей, городов, подразделений и руководителей с поиском и сортировкой.</p>
    </div>
</section>

<section class="card" style="padding: 28px;">
    <div class="collapse-header">
        <div>
            <p class="section-kicker">Новый пользователь</p>
            <h2 class="section-title section-title--small">Создать профиль</h2>
        </div>
        <button class="btn btn-primary" type="button" data-collapse-toggle="admin-user-create" aria-expanded="false">Добавить пользователя</button>
    </div>
    <div id="admin-user-create" class="collapse-panel" hidden style="margin-top: 20px;">
        <form action="<?= url('/admin/users') ?>" method="post" class="form-grid form-grid-3">
            <?= csrf_field() ?>
            <label class="field"><span class="field__label">ФИО</span><input class="input" type="text" name="full_name" value="<?= e($oldForm['full_name'] ?? '') ?>" required></label>
            <label class="field"><span class="field__label">Email</span><input class="input" type="email" name="email" value="<?= e($oldForm['email'] ?? '') ?>" required></label>
            <label class="field"><span class="field__label">Телефон</span><input class="input" type="text" name="phone" value="<?= e($oldForm['phone'] ?? '') ?>"></label>
            <label class="field"><span class="field__label">Должность</span><input class="input" type="text" name="title" value="<?= e($oldForm['title'] ?? '') ?>"></label>
            <label class="field">
                <span class="field__label">Роль</span>
                <select class="select" name="role_id" required>
                    <option value="">Выберите роль</option>
                    <?php foreach ($roles as $role): ?><option value="<?= e($role['id']) ?>"><?= e($role['name']) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label class="field">
                <span class="field__label">Статус</span>
                <select class="select" name="approval_status">
                    <option value="ACTIVE">Активен</option>
                    <option value="PENDING">Ожидает активации</option>
                    <option value="SUSPENDED">Отключен</option>
                </select>
            </label>
            <label class="field">
                <span class="field__label">Город</span>
                <select class="select" name="city_id"><option value="">Без города</option><?php foreach ($options['cities'] as $city): ?><option value="<?= e($city['id']) ?>"><?= e($city['name']) ?></option><?php endforeach; ?></select>
            </label>
            <label class="field">
                <span class="field__label">Подразделение</span>
                <select class="select" name="department_id"><option value="">Без подразделения</option><?php foreach ($options['departments'] as $department): ?><option value="<?= e($department['id']) ?>"><?= e($department['name']) ?></option><?php endforeach; ?></select>
            </label>
            <label class="field">
                <span class="field__label">Руководитель</span>
                <select class="select" name="supervisor_id"><option value="">Без руководителя</option><?php foreach ($options['supervisors'] as $supervisor): ?><option value="<?= e($supervisor['id']) ?>"><?= e($supervisor['full_name']) ?></option><?php endforeach; ?></select>
            </label>
            <label class="field" style="grid-column: 1 / -1;"><span class="field__label">Пароль</span><input class="input" type="password" name="password" required></label>
            <div style="grid-column: 1 / -1;"><button class="btn btn-primary" type="submit">Создать пользователя</button></div>
        </form>
    </div>
</section>

<section class="card" style="padding: 28px; margin-top: 22px;">
    <div class="table-toolbar">
        <div>
            <p class="section-kicker">Список</p>
            <h2 class="section-title section-title--small">Все пользователи</h2>
        </div>
        <input class="input search-input" type="search" placeholder="Найти пользователя" data-table-search="admin-users-table">
    </div>
    <div class="table-wrap">
        <table class="table" id="admin-users-table">
            <thead>
                <tr>
                    <th><button class="sort-button" type="button" data-sort-table="admin-users-table" data-sort-key="full_name" data-sort-dir="asc">ФИО</button></th>
                    <th><button class="sort-button" type="button" data-sort-table="admin-users-table" data-sort-key="role" data-sort-dir="asc">Роль</button></th>
                    <th><button class="sort-button" type="button" data-sort-table="admin-users-table" data-sort-key="city" data-sort-dir="asc">Город</button></th>
                    <th><button class="sort-button" type="button" data-sort-table="admin-users-table" data-sort-key="department" data-sort-dir="asc">Подразделение</button></th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resources['users'] as $row): ?>
                    <tr>
                        <td data-col="full_name"><strong><?= e($row['full_name']) ?></strong><div class="muted"><?= e($row['email']) ?></div></td>
                        <td data-col="role"><span class="<?= role_badge_class((string) $row['role_key']) ?>"><?= e(role_label((string) $row['role_key'])) ?></span></td>
                        <td data-col="city"><?= e($row['city_name'] ?: 'Без города') ?></td>
                        <td data-col="department"><?= e($row['department_name'] ?: 'Без подразделения') ?></td>
                        <td><a href="<?= url('/admin/users/' . $row['id']) ?>" class="btn btn-ghost btn-sm">Открыть</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
