<section class="section-header">
    <div>
        <p class="section-kicker">Профиль пользователя</p>
        <h1 class="section-title"><?= e($target['full_name']) ?></h1>
    </div>
    <div class="actions-row">
        <a href="<?= url('/admin/users') ?>" class="btn btn-ghost">К списку пользователей</a>
    </div>
</section>

<section class="card" style="padding: 28px;">
    <form action="<?= url('/admin/users/' . $target['id']) ?>" method="post" class="form-grid form-grid-3">
        <?= csrf_field() ?>
        <label class="field"><span class="field__label">ФИО</span><input class="input" type="text" name="full_name" value="<?= e($target['full_name']) ?>" required></label>
        <label class="field"><span class="field__label">Email</span><input class="input" type="email" name="email" value="<?= e($target['email']) ?>" required></label>
        <label class="field"><span class="field__label">Телефон</span><input class="input" type="text" name="phone" value="<?= e($target['phone']) ?>"></label>
        <label class="field"><span class="field__label">Должность</span><input class="input" type="text" name="title" value="<?= e($target['title']) ?>"></label>
        <label class="field"><span class="field__label">Роль</span><select class="select" name="role_id" required><?php foreach ($roles as $role): ?><option value="<?= e($role['id']) ?>" <?= $target['role_id'] === $role['id'] ? 'selected' : '' ?>><?= e($role['name']) ?></option><?php endforeach; ?></select></label>
        <label class="field"><span class="field__label">Статус</span><select class="select" name="approval_status"><option value="ACTIVE" <?= $target['approval_status'] === 'ACTIVE' ? 'selected' : '' ?>>Активен</option><option value="PENDING" <?= $target['approval_status'] === 'PENDING' ? 'selected' : '' ?>>Ожидает</option><option value="SUSPENDED" <?= $target['approval_status'] === 'SUSPENDED' ? 'selected' : '' ?>>Отключен</option></select></label>
        <label class="field"><span class="field__label">Город</span><select class="select" name="city_id"><option value="">Без города</option><?php foreach ($options['cities'] as $city): ?><option value="<?= e($city['id']) ?>" <?= (($target['city_id'] ?? '') === $city['id']) ? 'selected' : '' ?>><?= e($city['name']) ?></option><?php endforeach; ?></select></label>
        <label class="field"><span class="field__label">Подразделение</span><select class="select" name="department_id"><option value="">Без подразделения</option><?php foreach ($options['departments'] as $department): ?><option value="<?= e($department['id']) ?>" <?= (($target['department_id'] ?? '') === $department['id']) ? 'selected' : '' ?>><?= e($department['name']) ?></option><?php endforeach; ?></select></label>
        <label class="field"><span class="field__label">Руководитель</span><select class="select" name="supervisor_id"><option value="">Без руководителя</option><?php foreach ($options['supervisors'] as $supervisor): ?><option value="<?= e($supervisor['id']) ?>" <?= (($target['supervisor_id'] ?? '') === $supervisor['id']) ? 'selected' : '' ?>><?= e($supervisor['full_name']) ?></option><?php endforeach; ?></select></label>
        <label class="field" style="grid-column: 1 / -1;"><span class="field__label">О себе</span><textarea class="textarea" name="bio"><?= e($target['bio']) ?></textarea></label>
        <label class="field" style="grid-column: 1 / -1;"><span class="field__label">Новый пароль</span><input class="input" type="password" name="password"></label>
        <div style="grid-column: 1 / -1;"><button class="btn btn-primary" type="submit">Сохранить изменения</button></div>
    </form>
</section>
