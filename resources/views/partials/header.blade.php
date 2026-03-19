<?php
$headerUser = current_user();
$navItems = nav_sections_for($headerUser);
?>
<header class="site-header" data-hide-on-scroll>
    <div class="container">
        <div class="site-header__bar">
            <div class="site-header__brand">
                <a href="<?= url('/') ?>" class="brand-pill">
                    <span class="brand-pill__meta">Академия</span>
                    <span class="brand-pill__divider"></span>
                    <span class="brand-pill__title">ЮСИ</span>
                </a>
            </div>

            <nav class="site-header__nav" aria-label="Основные разделы">
                <?php foreach ($navItems as $item): ?>
                    <a href="<?= url($item['href']) ?>" class="nav-pill <?= nav_item_is_active($item) ? 'is-active' : '' ?>">
                        <?= e($item['label']) ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <div class="site-header__actions">
                <button type="button" class="icon-button icon-button--theme" data-theme-toggle aria-label="Переключить тему">
                    <span class="theme-icon theme-icon--light">☀</span>
                    <span class="theme-icon theme-icon--dark">☾</span>
                </button>

                <?php if ($headerUser): ?>
                    <div class="user-menu" data-user-menu>
                        <button type="button" class="user-pill user-menu__toggle" data-user-menu-toggle aria-expanded="false">
                            <span class="user-pill__avatar"><?= e(initials((string) $headerUser['full_name'])) ?></span>
                            <span class="user-pill__body">
                                <span class="user-pill__name"><?= e($headerUser['full_name']) ?></span>
                                <span class="user-pill__role <?= role_text_class((string) $headerUser['role_key']) ?>">
                                    <?= e(role_label((string) $headerUser['role_key'])) ?>
                                </span>
                            </span>
                        </button>

                        <div class="user-menu__panel" hidden data-user-menu-panel>
                            <a href="<?= url('/profile') ?>" class="user-menu__item">Открыть профиль</a>
                            <form action="<?= url('/logout') ?>" method="post" class="user-menu__form">
                                <?= csrf_field() ?>
                                <button type="submit" class="user-menu__item user-menu__item--danger">Выйти из аккаунта</button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= url('/login') ?>" class="btn btn-ghost">Войти</a>
                    <a href="<?= url('/register') ?>" class="btn btn-primary">Зарегистрироваться</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
