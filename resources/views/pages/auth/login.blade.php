<?php $oldForm = flash_now('old_form', []); ?>
<section class="grid grid-split">
    <div class="hero-card is-brand hero-card">
        <p class="section-kicker" style="color: rgba(219,234,254,0.9);">Доступ в систему</p>
        <h1 class="section-title" style="color:#fff;">Вход в корпоративную академию</h1>
        <p class="section-text" style="color: rgba(239,246,255,0.92);">
            Используйте корпоративную учетную запись, чтобы продолжить обучение,
            открыть курсы и перейти в кабинет по вашей роли.
        </p>
    </div>

    <div class="card" style="padding: 28px;">
        <div class="section-header">
            <div>
                <p class="section-kicker">Авторизация</p>
                <h2 class="section-title section-title--small">Войти</h2>
            </div>
        </div>
        <form action="<?= url('/login') ?>" method="post" class="form-grid">
            <?= csrf_field() ?>
            <label class="field">
                <span class="field__label">Email</span>
                <input class="input" type="email" name="email" value="<?= e($oldForm['email'] ?? '') ?>" required>
            </label>
            <label class="field">
                <span class="field__label">Пароль</span>
                <input class="input" type="password" name="password" required>
            </label>
            <button class="btn btn-primary btn-block" type="submit">Войти</button>
        </form>
        <p class="section-text">Нет учетной записи? <a href="<?= url('/register') ?>" style="color: var(--brand); font-weight: 700;">Зарегистрироваться</a></p>
    </div>
</section>
