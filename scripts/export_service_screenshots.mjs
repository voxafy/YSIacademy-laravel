import { execFileSync } from 'node:child_process';
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { chromium, devices } from 'playwright';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const repoRoot = path.resolve(__dirname, '..');
const timestamp = formatTimestamp(new Date());
const exportRoot = path.join(repoRoot, 'design-export', 'service-screenshots', timestamp);
const manifestPath = path.join(exportRoot, 'manifest.json');

const contextData = loadContext();
const baseUrl = (contextData.base_url || 'http://127.0.0.1:8000').replace(/\/$/, '');

const browser = await chromium.launch({ headless: true });
const manifest = [];

try {
    ensureDir(exportRoot);

    const deviceProfiles = [
        {
            key: 'desktop',
            createOptions: () => ({
                viewport: { width: 1440, height: 1400 },
                colorScheme: 'light',
            }),
        },
        {
            key: 'mobile',
            createOptions: () => ({
                ...devices['iPhone 13'],
                colorScheme: 'light',
            }),
        },
    ];

    for (const profile of deviceProfiles) {
        await captureRoleScreenshots('guest', profile, [
            shot('home', '/'),
            shot('login', '/login'),
            shot('register', '/register'),
            shot('catalog', '/courses'),
            shot('course', coursePath(contextData.guest.course_slug)),
        ]);

        await captureRoleScreenshots('student', profile, [
            shot('dashboard', '/student'),
            shot('profile', '/profile'),
            shot('catalog', '/courses'),
            shot('course', coursePath(contextData.student.course_slug)),
            shot('lesson', lessonPath(contextData.student.lesson)),
            shot('lesson-nav-open', lessonPath(contextData.student.lesson), {
                prepare: openLessonNav,
            }),
            shot('knowledge-base', '/knowledge-base'),
            shot('knowledge-base-assistant', '/knowledge-base', {
                prepare: askKnowledgeAssistant,
            }),
            shot('knowledge-article', knowledgePath(contextData.student.knowledge_slug)),
            shot('user-menu-open', '/student', {
                prepare: openUserMenu,
            }),
        ]);

        await captureRoleScreenshots('leader', profile, [
            shot('dashboard', '/leader'),
            shot('dashboard-create-panel', '/leader', {
                prepare: async (page) => {
                    await clickIfVisible(page, '[data-collapse-toggle="leader-create-panel"]');
                },
            }),
            shot('assignments', '/leader/assignments'),
            shot('team-card', `/leader/team/${contextData.leader.team_user_id}`),
            shot('team-edit', `/leader/team/${contextData.leader.team_user_id}/edit`),
            shot('catalog', '/courses'),
            shot('course', coursePath(contextData.leader.course_slug)),
            shot('knowledge-base', '/knowledge-base'),
            shot('knowledge-article', knowledgePath(contextData.leader.knowledge_slug)),
            shot('user-menu-open', '/leader', {
                prepare: openUserMenu,
            }),
        ]);

        await captureRoleScreenshots('admin', profile, [
            shot('dashboard', '/admin'),
            shot('course-categories', '/admin/course-categories'),
            shot('courses-index', '/admin/courses'),
            shot('course-editor', `/admin/courses/${contextData.admin.course_id}`),
            shot('lesson-editor', `/admin/lessons/${contextData.admin.lesson_id}`),
            shot('questions', '/admin/questions'),
            shot('media', '/admin/media'),
            shot('knowledge-index', '/admin/knowledge-base'),
            shot('knowledge-editor', `/admin/knowledge-base/articles/${contextData.admin.knowledge_article_id}`),
            shot('users-index', '/admin/users'),
            shot('users-create-panel', '/admin/users', {
                prepare: async (page) => {
                    await clickIfVisible(page, '[data-collapse-toggle="admin-user-create"]');
                },
            }),
            shot('user-editor', `/admin/users/${contextData.admin.user_id}`),
            shot('assignments', '/admin/assignments'),
            shot('results', '/admin/results'),
            shot('result-card', `/admin/results/${contextData.admin.result_user_id}`),
            shot('catalog', '/courses'),
            shot('course-public', coursePath(contextData.admin.course_slug)),
            shot('knowledge-base', '/knowledge-base'),
            shot('knowledge-article', knowledgePath(contextData.admin.knowledge_slug)),
            shot('user-menu-open', '/admin', {
                prepare: openUserMenu,
            }),
        ]);
    }

    fs.writeFileSync(manifestPath, JSON.stringify({
        created_at: new Date().toISOString(),
        base_url: baseUrl,
        export_root: exportRoot,
        screenshots_total: manifest.length,
        screenshots: manifest,
    }, null, 2));

    console.log(JSON.stringify({
        export_root: exportRoot,
        manifest: manifestPath,
        screenshots_total: manifest.length,
    }, null, 2));
} finally {
    await browser.close();
}

async function captureRoleScreenshots(role, profile, shots) {
    const dir = path.join(exportRoot, profile.key, role);
    ensureDir(dir);

    const context = await browser.newContext(profile.createOptions());
    const page = await context.newPage();

    if (role !== 'guest') {
        await login(page, contextData[role].email, contextData[role].password);
    }

    for (const item of shots) {
        if (!item.path || item.path.includes('//undefined')) {
            continue;
        }

        const targetFile = path.join(dir, `${item.key}.png`);

        try {
            await page.goto(`${baseUrl}${item.path}`, { waitUntil: 'domcontentloaded' });
            await settle(page);

            if (item.prepare) {
                await item.prepare(page);
                await settle(page);
            }

            await page.screenshot({
                path: targetFile,
                fullPage: true,
                animations: 'disabled',
            });

            manifest.push({
                role,
                device: profile.key,
                key: item.key,
                path: item.path,
                file: path.relative(exportRoot, targetFile).replaceAll('\\', '/'),
            });
        } catch (error) {
            console.error(`[${role}/${profile.key}] ${item.key}: ${error.message}`);
        }
    }

    await context.close();
}

async function login(page, email, password) {
    await page.goto(`${baseUrl}/login`, { waitUntil: 'domcontentloaded' });
    await page.getByLabel('Email').fill(email);
    await page.getByLabel('Пароль').fill(password);
    await Promise.all([
        page.waitForURL((url) => !url.pathname.endsWith('/login'), { timeout: 15000 }),
        page.getByRole('button', { name: 'Войти' }).click(),
    ]);
    await settle(page);
}

async function settle(page) {
    await page.waitForLoadState('networkidle').catch(() => null);
    await page.waitForTimeout(350);
}

async function openUserMenu(page) {
    await clickIfVisible(page, '[data-user-menu-toggle]');
}

async function openLessonNav(page) {
    await clickIfVisible(page, '[data-lesson-nav-toggle]');
}

async function askKnowledgeAssistant(page) {
    const input = page.locator('[data-kb-assistant-input]');
    if (await input.count()) {
        await input.fill('как проверить дубль клиента');
        await page.getByRole('button', { name: /Найти ответ/i }).click();
        await page.waitForFunction(() => {
            const output = document.querySelector('[data-kb-assistant-output]');
            return output instanceof HTMLElement && !output.hidden;
        }, null, { timeout: 15000 }).catch(() => null);
    }
}

async function clickIfVisible(page, selector) {
    const locator = page.locator(selector).first();
    if (await locator.count()) {
        await locator.click();
    }
}

function shot(key, targetPath, options = {}) {
    return {
        key,
        path: targetPath,
        prepare: options.prepare ?? null,
    };
}

function coursePath(slug) {
    return slug ? `/courses/${slug}` : '';
}

function knowledgePath(slug) {
    return slug ? `/knowledge-base/${slug}` : '';
}

function lessonPath(lesson) {
    if (!lesson || !lesson.course_slug || !lesson.lesson_id) {
        return '';
    }

    return `/courses/${lesson.course_slug}/lessons/${lesson.lesson_id}`;
}

function ensureDir(target) {
    fs.mkdirSync(target, { recursive: true });
}

function loadContext() {
    const helperPath = path.join(repoRoot, 'scripts', 'screenshot_context.php');
    const output = execFileSync('C:\\xampp\\php\\php.exe', [helperPath], {
        cwd: repoRoot,
        encoding: 'utf8',
    }).replace(/^\uFEFF/, '').trim();

    return JSON.parse(output);
}

function formatTimestamp(date) {
    const pad = (value) => String(value).padStart(2, '0');
    return [
        date.getFullYear(),
        pad(date.getMonth() + 1),
        pad(date.getDate()),
        '-',
        pad(date.getHours()),
        pad(date.getMinutes()),
        pad(date.getSeconds()),
    ].join('');
}
