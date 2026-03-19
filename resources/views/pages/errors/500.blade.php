<section class="hero-card card">
    <p class="section-kicker">Ошибка</p>
    <h1 class="section-title">Внутренняя ошибка сервера</h1>
    <p class="section-text"><?= e($message ?? 'Что-то пошло не так.') ?></p>
    <div class="hero-actions" style="margin-top: 24px;">
        <a href="<?= url('/') ?>" class="btn btn-primary">Вернуться на главную</a>
    </div>
</section>
