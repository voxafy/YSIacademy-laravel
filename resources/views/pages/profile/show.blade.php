<section class="section-header">
    <div>
        <p class="section-kicker">Профиль</p>
        <h1 class="section-title">Настройки профиля</h1>
        <p class="section-text">Личные и организационные данные пользователя, включая город, подразделение и руководителя.</p>
    </div>
</section>

<section class="card" style="padding: 28px;">
    <form action="<?= url('/profile') ?>" method="post" class="form-grid form-grid-2">
        <?= csrf_field() ?>
        <label class="field">
            <span class="field__label">ФИО</span>
            <input class="input" type="text" name="full_name" value="<?= e($user['full_name']) ?>" required>
        </label>
        <label class="field">
            <span class="field__label">Email</span>
            <input class="input" type="email" name="email" value="<?= e($user['email']) ?>" required>
        </label>
        <label class="field">
            <span class="field__label">Телефон</span>
            <input class="input" type="text" name="phone" value="<?= e($user['phone']) ?>">
        </label>
        <label class="field">
            <span class="field__label">Должность</span>
            <input class="input" type="text" name="title" value="<?= e($user['title']) ?>">
        </label>
        <label class="field">
            <span class="field__label">Город</span>
            <select class="select" name="city_id">
                <option value="">Без города</option>
                <?php foreach ($options['cities'] as $city): ?>
                    <option value="<?= e($city['id']) ?>" <?= (($user['city_id'] ?? '') === $city['id']) ? 'selected' : '' ?>><?= e($city['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="field">
            <span class="field__label">Подразделение</span>
            <select class="select" name="department_id">
                <option value="">Без подразделения</option>
                <?php foreach ($options['departments'] as $department): ?>
                    <?php if (($department['slug'] ?? '') === 'administration' && ($user['role_key'] ?? '') !== 'ADMIN') continue; ?>
                    <option value="<?= e($department['id']) ?>" <?= (($user['department_id'] ?? '') === $department['id']) ? 'selected' : '' ?>><?= e($department['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="field">
            <span class="field__label">Руководитель</span>
            <select class="select" name="supervisor_id">
                <option value="">Без руководителя</option>
                <?php foreach ($options['supervisors'] as $supervisor): ?>
                    <option value="<?= e($supervisor['id']) ?>" <?= (($user['supervisor_id'] ?? '') === $supervisor['id']) ? 'selected' : '' ?>><?= e($supervisor['full_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="field" style="grid-column: 1 / -1;">
            <span class="field__label">О себе</span>
            <textarea class="textarea" name="bio"><?= e($user['bio']) ?></textarea>
        </label>
        <label class="field" style="grid-column: 1 / -1;">
            <span class="field__label">Новый пароль</span>
            <input class="input" type="password" name="password">
        </label>
        <div style="grid-column: 1 / -1;">
            <button class="btn btn-primary" type="submit">Сохранить профиль</button>
        </div>
    </form>
</section>
