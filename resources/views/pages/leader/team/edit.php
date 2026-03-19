<section class="section-header">
    <div>
        <p class="section-kicker">Редактирование</p>
        <h1 class="section-title">Профиль сотрудника</h1>
    </div>
    <div class="actions-row">
        <a href="<?= url('/leader/team/' . $employee['id']) ?>" class="btn btn-ghost">Назад к карточке</a>
    </div>
</section>

<section class="card" style="padding: 28px;">
    <form action="<?= url('/leader/team/' . $employee['id'] . '/edit') ?>" method="post" class="form-grid form-grid-2">
        <?= csrf_field() ?>
        <label class="field"><span class="field__label">ФИО</span><input class="input" type="text" name="full_name" value="<?= e($employee['full_name']) ?>" required></label>
        <label class="field"><span class="field__label">Email</span><input class="input" type="email" name="email" value="<?= e($employee['email']) ?>" required></label>
        <label class="field"><span class="field__label">Телефон</span><input class="input" type="text" name="phone" value="<?= e($employee['phone']) ?>"></label>
        <label class="field"><span class="field__label">Должность</span><input class="input" type="text" name="title" value="<?= e($employee['title']) ?>" required></label>
        <label class="field">
            <span class="field__label">Город</span>
            <select class="select" name="city_id" required>
                <option value="">Выберите город</option>
                <?php foreach ($options['cities'] as $city): ?><option value="<?= e($city['id']) ?>" <?= (($employee['city_id'] ?? '') === $city['id']) ? 'selected' : '' ?>><?= e($city['name']) ?></option><?php endforeach; ?>
            </select>
        </label>
        <label class="field">
            <span class="field__label">Подразделение</span>
            <select class="select" name="department_id" required>
                <option value="">Выберите подразделение</option>
                <?php foreach ($options['departments'] as $department): ?>
                    <?php if (($department['slug'] ?? '') === 'administration') continue; ?>
                    <option value="<?= e($department['id']) ?>" <?= (($employee['department_id'] ?? '') === $department['id']) ? 'selected' : '' ?>><?= e($department['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="field" style="grid-column: 1 / -1;"><span class="field__label">Новый пароль</span><input class="input" type="password" name="password"></label>
        <div style="grid-column: 1 / -1;"><button class="btn btn-primary" type="submit">Сохранить изменения</button></div>
    </form>
</section>
