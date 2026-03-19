<?php
$enrollment = $course['enrollment'] ?? null;
$firstLesson = $course['modules'][0]['lessons'][0] ?? null;
?>
<section class="hero-card is-brand hero-card">
    <div class="section-header">
        <div>
            <p class="section-kicker" style="color: rgba(219,234,254,0.9);"><?= e($course['category']['title']) ?></p>
            <h1 class="section-title" style="color:#fff;"><?= e($course['title']) ?></h1>
            <p class="section-text" style="color: rgba(239,246,255,0.92);"><?= e($course['description']) ?></p>
        </div>
        <div class="card" style="padding: 22px; min-width: 300px;">
            <?php if ($enrollment): ?>
                <span class="<?= course_status_class((string) $enrollment['status']) ?>"><?= e(course_status_label((string) $enrollment['status'])) ?></span>
                <div style="margin-top: 14px;">
                    <div class="muted" style="margin-bottom: 8px;">Ваш прогресс: <?= e(format_percent((int) ($enrollment['completion_percent'] ?? 0))) ?></div>
                    <div class="progress"><div class="progress__bar" style="width: <?= (int) ($enrollment['completion_percent'] ?? 0) ?>%;"></div></div>
                </div>
            <?php else: ?>
                <p class="section-text">Курс станет доступен после назначения или публикации для вашей роли.</p>
            <?php endif; ?>
            <div class="actions-row" style="margin-top: 18px;">
                <?php if ($firstLesson): ?>
                    <a href="<?= url('/courses/' . $course['slug'] . '/lessons/' . $firstLesson['id']) ?>" class="btn btn-primary">Открыть первый урок</a>
                <?php endif; ?>
                <?php if (($user['role_key'] ?? '') === 'ADMIN'): ?>
                    <a href="<?= url('/admin/courses/' . $course['id']) ?>" class="btn btn-ghost">Редактировать</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="grid grid-split" style="margin-top: 22px;">
    <div class="card" style="padding: 28px;">
        <div class="section-header">
            <div>
                <p class="section-kicker">Структура</p>
                <h2 class="section-title section-title--small">Модули и уроки</h2>
            </div>
        </div>
        <div class="card-stack">
            <?php foreach ($course['modules'] as $index => $module): ?>
                <article class="course-item">
                    <p class="section-kicker">Модуль <?= $index + 1 ?></p>
                    <h3 style="margin: 10px 0 0; font-size: 1.35rem; color: var(--navy);"><?= e($module['title']) ?></h3>
                    <p class="section-text"><?= e($module['description']) ?></p>
                    <div class="card-stack" style="margin-top: 16px;">
                        <?php foreach ($module['lessons'] as $lesson): ?>
                            <a href="<?= url('/courses/' . $course['slug'] . '/lessons/' . $lesson['id']) ?>" class="list-item">
                                <strong><?= e($lesson['title']) ?></strong>
                                <div class="muted"><?= e($lesson['lesson_type'] === 'QUIZ' ? 'Тест' : 'Урок') ?></div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="card-stack">
        <article class="card" style="padding: 28px;">
            <p class="section-kicker">Аудитория</p>
            <h2 class="section-title section-title--small">Для кого курс</h2>
            <p class="section-text"><?= e($course['target_audience']) ?></p>
        </article>
        <article class="card" style="padding: 28px;">
            <p class="section-kicker">Результат</p>
            <h2 class="section-title section-title--small">Что вы получите</h2>
            <div class="markdown">
                <p>Осмысленные уроки на основе реальных регламентов.</p>
                <p>Проверочные тесты по каждому модулю и итоговый статус по курсу.</p>
                <p>Решение руководителя по результату прохождения.</p>
            </div>
        </article>
    </div>
</section>
