<?php $oldForm = flash_now('old_form', []); ?>
<section class="grid grid-split">
    <div class="hero-card is-brand hero-card">
        <p class="section-kicker" style="color: rgba(219,234,254,0.9);">Регистрация</p>
        <h1 class="section-title" style="color:#fff;">Создание профиля стажера</h1>
        <p class="section-text" style="color: rgba(239,246,255,0.92);">
            После регистрации сотрудник получает доступ к каталогу курсов, назначенным программам,
            урокам, тестам и собственному прогрессу.
        </p>
    </div>

    <div class="card" style="padding: 28px;">
        <div class="section-header">
            <div>
                <p class="section-kicker">Новый профиль</p>
                <h2 class="section-title section-title--small">Зарегистрироваться</h2>
            </div>
        </div>
        <form action="<?= url('/register') ?>" method="post" class="form-grid form-grid-2">
            <?= csrf_field() ?>
            <label class="field">
                <span class="field__label">ФИО</span>
                <input class="input" type="text" name="full_name" value="<?= e($oldForm['full_name'] ?? '') ?>" required>
            </label>
            <label class="field">
                <span class="field__label">Email</span>
                <input class="input" type="email" name="email" value="<?= e($oldForm['email'] ?? '') ?>" required>
            </label>
            <label class="field">
                <span class="field__label">Телефон</span>
                <input class="input" type="text" name="phone" value="<?= e($oldForm['phone'] ?? '') ?>">
            </label>
            <label class="field">
                <span class="field__label">Должность</span>
                <input class="input" type="text" name="title" value="<?= e($oldForm['title'] ?? '') ?>" required>
            </label>
            <label class="field">
                <span class="field__label">Город</span>
                <select class="select" name="city_id" required>
                    <option value="">Выберите город</option>
                    <?php foreach ($options['cities'] as $city): ?>
                        <option value="<?= e($city['id']) ?>" <?= (($oldForm['city_id'] ?? '') === $city['id']) ? 'selected' : '' ?>>
                            <?= e($city['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="field">
                <span class="field__label">Подразделение</span>
                <select class="select" name="department_id" required>
                    <option value="">Выберите подразделение</option>
                    <?php foreach ($options['departments'] as $department): ?>
                        <?php if (($department['slug'] ?? '') === 'administration') continue; ?>
                        <option value="<?= e($department['id']) ?>" <?= (($oldForm['department_id'] ?? '') === $department['id']) ? 'selected' : '' ?>>
                            <?= e($department['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="field">
                <span class="field__label">Руководитель</span>
                <select class="select" name="supervisor_id">
                    <option value="">Без руководителя</option>
                    <?php foreach ($options['supervisors'] as $supervisor): ?>
                        <option value="<?= e($supervisor['id']) ?>" <?= (($oldForm['supervisor_id'] ?? '') === $supervisor['id']) ? 'selected' : '' ?>>
                            <?= e($supervisor['full_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="field">
                <span class="field__label">Пароль</span>
                <input class="input" type="password" name="password" required>
            </label>
            <div style="grid-column: 1 / -1;">
                <button class="btn btn-primary btn-block" type="submit">Создать профиль</button>
            </div>
        </form>
    </div>
</section>
