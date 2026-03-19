(function () {
    const root = document.documentElement;
    const themeToggles = Array.from(document.querySelectorAll('[data-theme-toggle]'));
    const header = document.querySelector('[data-hide-on-scroll]');
    const userMenus = Array.from(document.querySelectorAll('[data-user-menu]'));

    function readStoredTheme() {
        try {
            return window.localStorage.getItem('ysi_theme');
        } catch (error) {
            return null;
        }
    }

    function storeTheme(theme) {
        try {
            window.localStorage.setItem('ysi_theme', theme);
        } catch (error) {
            // Ignore private-mode storage restrictions.
        }

        document.cookie = 'ysi_theme=' + encodeURIComponent(theme) + '; path=/; max-age=31536000; SameSite=Lax';
    }

    function applyTheme(theme, persist) {
        root.classList.add('theme-switching');
        root.setAttribute('data-theme', theme);

        if (persist !== false) {
            storeTheme(theme);
        }

        window.setTimeout(function () {
            root.classList.remove('theme-switching');
        }, 240);
    }

    const initialTheme = readStoredTheme();
    if (initialTheme === 'dark' || initialTheme === 'light') {
        applyTheme(initialTheme, false);
    }

    themeToggles.forEach(function (themeToggle) {
        themeToggle.addEventListener('click', function () {
            const next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            applyTheme(next, true);
        });
    });

    userMenus.forEach(function (menu) {
        const toggle = menu.querySelector('[data-user-menu-toggle]');
        const panel = menu.querySelector('[data-user-menu-panel]');
        if (!toggle || !panel) {
            return;
        }

        toggle.addEventListener('click', function (event) {
            event.stopPropagation();
            const isExpanded = toggle.getAttribute('aria-expanded') === 'true';

            userMenus.forEach(function (otherMenu) {
                const otherToggle = otherMenu.querySelector('[data-user-menu-toggle]');
                const otherPanel = otherMenu.querySelector('[data-user-menu-panel]');
                if (otherToggle && otherPanel) {
                    otherToggle.setAttribute('aria-expanded', 'false');
                    otherPanel.hidden = true;
                }
            });

            toggle.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
            panel.hidden = isExpanded;
        });
    });

    document.addEventListener('click', function (event) {
        userMenus.forEach(function (menu) {
            if (menu.contains(event.target)) {
                return;
            }

            const toggle = menu.querySelector('[data-user-menu-toggle]');
            const panel = menu.querySelector('[data-user-menu-panel]');
            if (toggle && panel) {
                toggle.setAttribute('aria-expanded', 'false');
                panel.hidden = true;
            }
        });
    });

    let lastY = window.scrollY;
    if (header) {
        window.addEventListener('scroll', function () {
            const currentY = window.scrollY;
            const delta = Math.abs(currentY - lastY);
            if (currentY < 32) {
                header.classList.remove('is-hidden');
            } else if (delta > 10) {
                header.classList.toggle('is-hidden', currentY > lastY);
            }
            lastY = currentY;
        }, { passive: true });
    }

    document.querySelectorAll('[data-collapse-toggle]').forEach(function (button) {
        button.addEventListener('click', function () {
            const targetId = button.getAttribute('data-collapse-toggle');
            const panel = targetId ? document.getElementById(targetId) : null;
            if (!panel) {
                return;
            }

            const expanded = button.getAttribute('aria-expanded') === 'true';
            button.setAttribute('aria-expanded', expanded ? 'false' : 'true');
            panel.hidden = expanded;
        });
    });

    document.querySelectorAll('[data-table-search]').forEach(function (input) {
        input.addEventListener('input', function () {
            const targetId = input.getAttribute('data-table-search');
            const rows = targetId ? document.querySelectorAll('#' + targetId + ' tbody tr') : [];
            const query = String(input.value || '').toLowerCase();

            rows.forEach(function (row) {
                row.style.display = row.textContent.toLowerCase().indexOf(query) >= 0 ? '' : 'none';
            });
        });
    });

    document.querySelectorAll('[data-sort-table]').forEach(function (button) {
        button.addEventListener('click', function () {
            const tableId = button.getAttribute('data-sort-table');
            const table = tableId ? document.getElementById(tableId) : null;
            if (!table) {
                return;
            }

            const tbody = table.querySelector('tbody');
            if (!tbody) {
                return;
            }

            const rows = Array.from(tbody.querySelectorAll('tr'));
            const key = button.getAttribute('data-sort-key');
            const currentDir = button.getAttribute('data-sort-dir') === 'desc' ? 'desc' : 'asc';
            const nextDir = currentDir === 'asc' ? 'desc' : 'asc';
            button.setAttribute('data-sort-dir', nextDir);

            rows.sort(function (a, b) {
                const aCell = a.querySelector('[data-col="' + key + '"]');
                const bCell = b.querySelector('[data-col="' + key + '"]');
                const aValue = aCell ? aCell.textContent.trim() : '';
                const bValue = bCell ? bCell.textContent.trim() : '';
                const aNumber = parseFloat(aValue);
                const bNumber = parseFloat(bValue);
                const comparison = !Number.isNaN(aNumber) && !Number.isNaN(bNumber)
                    ? aNumber - bNumber
                    : aValue.localeCompare(bValue, 'ru');

                return nextDir === 'asc' ? comparison : comparison * -1;
            });

            rows.forEach(function (row) {
                tbody.appendChild(row);
            });
        });
    });
})();
