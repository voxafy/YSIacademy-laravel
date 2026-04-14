<?php
$headerUser = current_user();
$navItems = nav_sections_for($headerUser);
$isAuthenticated = $headerUser !== null;
?>
<header class="site-header" data-hide-on-scroll>
    <div class="container">
        <div class="site-header__bar">
            <div class="site-header__brand">
                <a href="<?= url('/') ?>" class="brand-pill" aria-label="Онлайн университет ЮСИ СтройТех">
                    <span class="brand-pill__mark">СТ</span>
                    <span class="brand-pill__body">
                        <span class="brand-pill__meta">Онлайн университет ЮСИ</span>
                        <span class="brand-pill__title">СтройТех</span>
                    </span>
                </a>
            </div>

            <?php if ($navItems !== []): ?>
                <nav class="site-header__nav site-header__nav--desktop" aria-label="Основные разделы">
                    <?php foreach ($navItems as $item): ?>
                        <a href="<?= url($item['href']) ?>" class="nav-pill <?= nav_item_is_active($item) ? 'is-active' : '' ?>">
                            <?= e($item['label']) ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            <?php else: ?>
                <div class="site-header__nav site-header__nav--desktop site-header__nav--empty" aria-hidden="true"></div>
            <?php endif; ?>

            <div class="site-header__actions">
                <button type="button" class="icon-button icon-button--theme" data-theme-toggle aria-label="Переключить тему">
                    <span class="theme-icon theme-icon--light">☀</span>
                    <span class="theme-icon theme-icon--dark">☾</span>
                </button>

                <?php if ($isAuthenticated): ?>
                    <div class="user-menu site-header__desktop-user" data-user-menu>
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
                    <a href="<?= url('/login') ?>" class="btn btn-ghost site-header__desktop-link">Войти</a>
                    <a href="<?= url('/register') ?>" class="btn btn-primary site-header__desktop-link">Зарегистрироваться</a>
                <?php endif; ?>

                <?php if ($navItems !== [] || !$isAuthenticated): ?>
                    <button type="button" class="icon-button site-header__menu-toggle" data-mobile-nav-toggle aria-expanded="false" aria-controls="mobile-nav-panel" aria-label="Открыть меню">
                        ☰
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="mobile-nav-backdrop" hidden data-mobile-nav-backdrop></div>
    <div class="mobile-nav-panel" id="mobile-nav-panel" hidden data-mobile-nav-panel>
        <div class="mobile-nav-panel__header">
            <span class="section-kicker">Навигация</span>
            <button type="button" class="mobile-nav-panel__close" data-mobile-nav-close aria-label="Закрыть меню">×</button>
        </div>

        <?php if ($navItems !== []): ?>
            <nav class="mobile-nav-panel__nav" aria-label="Мобильная навигация">
                <?php foreach ($navItems as $item): ?>
                    <a href="<?= url($item['href']) ?>" class="mobile-nav-link <?= nav_item_is_active($item) ? 'is-active' : '' ?>">
                        <span><?= e($item['label']) ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
        <?php endif; ?>

        <div class="mobile-nav-panel__footer">
            <?php if ($isAuthenticated): ?>
                <div class="mobile-nav-user">
                    <span class="user-pill__avatar"><?= e(initials((string) $headerUser['full_name'])) ?></span>
                    <div class="mobile-nav-user__body">
                        <strong><?= e($headerUser['full_name']) ?></strong>
                        <span class="<?= role_text_class((string) $headerUser['role_key']) ?>">
                            <?= e(role_label((string) $headerUser['role_key'])) ?>
                        </span>
                    </div>
                </div>
                <div class="mobile-nav-panel__actions">
                    <a href="<?= url('/profile') ?>" class="btn btn-ghost">Профиль</a>
                    <form action="<?= url('/logout') ?>" method="post">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-primary">Выйти</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="mobile-nav-panel__actions">
                    <a href="<?= url('/login') ?>" class="btn btn-ghost">Войти</a>
                    <a href="<?= url('/register') ?>" class="btn btn-primary">Зарегистрироваться</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>
