<?php $oldForm = flash_now('old_form', []); ?>
<?php
$pageHeaderKicker = 'Доступ в систему';
$pageHeaderTitle = 'Вход в СтройТех';
$pageHeaderText = 'Используйте корпоративную учётную запись, чтобы продолжить обучение, открыть курсы ЮСИ и перейти в кабинет по вашей роли.';
$pageHeaderClass = 'landing-hero__header';
$pageHeaderTitleClass = 'landing-hero__title';
$pageHeaderTextClass = 'landing-hero__text';
$pageHeaderActionsHtml = '';
?>

<section class="auth-shell">
    <div class="hero-card is-brand landing-hero auth-hero">
        <?php include resource_path('views/partials/ui/page-header.php'); ?>
    </div>

    <div class="card card-pad-lg auth-card">
        <?php
        $pageHeaderKicker = 'Авторизация';
        $pageHeaderTitle = 'Войти';
        $pageHeaderText = 'Введите рабочий email и пароль, чтобы открыть назначенные программы и базу знаний.';
        $pageHeaderTitleTag = 'h2';
        $pageHeaderTitleClass = 'section-title--small';
        $pageHeaderTextClass = '';
        include resource_path('views/partials/ui/page-header.php');
        ?>
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
        <p class="section-text auth-card__footnote">Нет учётной записи? <a href="<?= url('/register') ?>" class="inline-link">Зарегистрироваться</a></p>
    </div>
</section>
