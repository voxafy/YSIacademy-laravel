(function () {
    const root = document.documentElement;
    const themeToggles = Array.from(document.querySelectorAll('[data-theme-toggle]'));
    const header = document.querySelector('[data-hide-on-scroll]');
    const userMenus = Array.from(document.querySelectorAll('[data-user-menu]'));
    const mobileNavPanel = document.querySelector('[data-mobile-nav-panel]');
    const mobileNavBackdrop = document.querySelector('[data-mobile-nav-backdrop]');
    const mobileNavToggles = Array.from(document.querySelectorAll('[data-mobile-nav-toggle]'));
    const mobileNavClosers = Array.from(document.querySelectorAll('[data-mobile-nav-close]'));

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

    function setMobileNavOpen(isOpen) {
        if (!mobileNavPanel) {
            return;
        }

        mobileNavPanel.hidden = !isOpen;
        if (mobileNavBackdrop) {
            mobileNavBackdrop.hidden = !isOpen;
        }

        document.body.classList.toggle('mobile-nav-open', isOpen);
        mobileNavToggles.forEach(function (toggle) {
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    mobileNavToggles.forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            const isOpen = toggle.getAttribute('aria-expanded') === 'true';
            setMobileNavOpen(!isOpen);
        });
    });

    mobileNavClosers.forEach(function (button) {
        button.addEventListener('click', function () {
            setMobileNavOpen(false);
        });
    });

    if (mobileNavBackdrop) {
        mobileNavBackdrop.addEventListener('click', function () {
            setMobileNavOpen(false);
        });
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && mobileNavPanel && !mobileNavPanel.hidden) {
            setMobileNavOpen(false);
        }
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

    function escapeHtml(value) {
        return String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    document.querySelectorAll('[data-kb-assistant]').forEach(function (shell) {
        const endpoint = shell.getAttribute('data-endpoint');
        const form = shell.querySelector('[data-kb-assistant-form]');
        const input = shell.querySelector('[data-kb-assistant-input]');
        const output = shell.querySelector('[data-kb-assistant-output]');
        const answer = shell.querySelector('[data-kb-assistant-answer]');
        const results = shell.querySelector('[data-kb-assistant-results]');

        if (!endpoint || !form || !input || !output || !answer || !results) {
            return;
        }

        function renderMessage(title, text, isError) {
            output.hidden = false;
            answer.innerHTML =
                '<div class="kb-assistant__answer-card' + (isError ? ' is-error' : '') + '">' +
                    '<strong>' + escapeHtml(title) + '</strong>' +
                    '<p>' + escapeHtml(text) + '</p>' +
                '</div>';
            results.innerHTML = '';
        }

        function renderResponse(data) {
            const answerData = data && data.answer ? data.answer : {};
            const items = Array.isArray(data && data.results) ? data.results : [];

            output.hidden = false;
            answer.innerHTML =
                '<div class="kb-assistant__answer-card">' +
                    '<strong>' + escapeHtml(answerData.lead || 'Ответ найден') + '</strong>' +
                    '<p>' + escapeHtml(answerData.summary || '') + '</p>' +
                    '<span>' + escapeHtml(answerData.next_steps || '') + '</span>' +
                '</div>';

            if (items.length === 0) {
                results.innerHTML = '';
                return;
            }

            results.innerHTML = items.map(function (item) {
                return '' +
                    '<a class="kb-assistant__result" href="' + escapeHtml(item.href || '#') + '">' +
                        '<div class="kb-assistant__result-top">' +
                            '<span class="badge badge-muted">' + escapeHtml(item.source_label || 'Источник') + '</span>' +
                            '<span class="badge badge-info">' + escapeHtml(item.badge || '') + '</span>' +
                        '</div>' +
                        '<strong>' + escapeHtml(item.title || '') + '</strong>' +
                        '<p>' + escapeHtml(item.snippet || '') + '</p>' +
                        '<span>' + escapeHtml(item.context || '') + '</span>' +
                    '</a>';
            }).join('');
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            const query = String(input.value || '').trim();

            if (!query) {
                renderMessage('Нужно задать вопрос', 'Введите фразу, по которой помощник сможет найти релевантные материалы.', true);
                return;
            }

            renderMessage('Поиск ответа…', 'Помощник просматривает статьи справочника и опубликованные уроки.', false);

            fetch(endpoint + '?q=' + encodeURIComponent(query), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
            })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('request_failed');
                    }

                    return response.json();
                })
                .then(renderResponse)
                .catch(function () {
                    renderMessage('Помощник временно недоступен', 'Не удалось получить ответ. Попробуйте повторить запрос или воспользуйтесь обычным поиском по справке.', true);
                });
        });
    });

    document.querySelectorAll('[data-lesson-nav]').forEach(function (shell) {
        const toggles = Array.from(shell.querySelectorAll('[data-lesson-nav-toggle]'));
        const closers = Array.from(shell.querySelectorAll('[data-lesson-nav-close]'));
        const panel = shell.querySelector('[data-lesson-nav-panel]');
        const backdrop = shell.querySelector('[data-lesson-nav-backdrop]');
        const animationDuration = 280;
        let closeTimer = null;

        if (!panel || toggles.length === 0) {
            return;
        }

        function setOpen(isOpen) {
            if (closeTimer !== null) {
                window.clearTimeout(closeTimer);
                closeTimer = null;
            }

            if (isOpen) {
                panel.hidden = false;

                if (backdrop) {
                    backdrop.hidden = false;
                }

                window.requestAnimationFrame(function () {
                    shell.classList.add('is-open');
                });
            } else {
                shell.classList.remove('is-open');

                closeTimer = window.setTimeout(function () {
                    panel.hidden = true;

                    if (backdrop) {
                        backdrop.hidden = true;
                    }
                }, animationDuration);
            }


            toggles.forEach(function (toggle) {
                toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });

            document.body.classList.toggle('lesson-nav-open', isOpen);
        }

        toggles.forEach(function (toggle) {
            toggle.addEventListener('click', function () {
                setOpen(!shell.classList.contains('is-open'));
            });
        });

        closers.forEach(function (button) {
            button.addEventListener('click', function () {
                setOpen(false);
            });
        });

        if (backdrop) {
            backdrop.addEventListener('click', function () {
                setOpen(false);
            });
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && shell.classList.contains('is-open')) {
                setOpen(false);
            }
        });

        shell.classList.remove('is-open');
        panel.hidden = true;

        if (backdrop) {
            backdrop.hidden = true;
        }

        toggles.forEach(function (toggle) {
            toggle.setAttribute('aria-expanded', 'false');
        });

        document.body.classList.remove('lesson-nav-open');
    });

    document.querySelectorAll('[data-view-group]').forEach(function (group) {
        const groupName = group.getAttribute('data-view-group');
        const buttons = Array.from(group.querySelectorAll('[data-view-toggle]'));
        const panels = Array.from(document.querySelectorAll('[data-view-panel][data-view-group="' + groupName + '"]'));

        if (buttons.length === 0 || panels.length === 0) {
            return;
        }

        function activate(view) {
            buttons.forEach(function (button) {
                button.classList.toggle('is-active', button.getAttribute('data-view-toggle') === view);
            });

            panels.forEach(function (panel) {
                panel.hidden = panel.getAttribute('data-view-panel') !== view;
            });
        }

        buttons.forEach(function (button) {
            button.addEventListener('click', function () {
                activate(button.getAttribute('data-view-toggle'));
            });
        });

        const defaultButton = buttons.find(function (button) {
            return button.classList.contains('is-active');
        }) || buttons[0];

        activate(defaultButton.getAttribute('data-view-toggle'));
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
