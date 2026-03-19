<section class="card" style="padding: 30px;">
    <div class="section-header">
        <div>
            <p class="section-kicker">Каталог курсов</p>
            <h1 class="section-title">Обучающие направления академии</h1>
            <p class="section-text">
                В каталоге собраны вводные, ролевые и контрольные программы по amoCRM,
                Allio и внутренним регламентам ЮСИ.
            </p>
        </div>
    </div>

    <div class="grid grid-2">
        <?php foreach ($courses as $course): ?>
            <?php $enrollment = $course['enrollment'] ?? null; ?>
            <article class="card" style="padding: 24px;">
                <div class="section-header">
                    <div>
                        <p class="section-kicker"><?= e($course['category']['title']) ?></p>
                        <h2 class="section-title section-title--small"><?= e($course['title']) ?></h2>
                    </div>
                    <?php if ($enrollment): ?>
                        <span class="<?= course_status_class((string) $enrollment['status']) ?>">
                            <?= e(course_status_label((string) $enrollment['status'])) ?>
                        </span>
                    <?php endif; ?>
                </div>
                <p class="section-text"><?= e($course['short_description']) ?></p>
                <?php if ($enrollment): ?>
                    <div style="margin-top: 16px;">
                        <div class="muted" style="margin-bottom: 8px;">Ваш прогресс: <?= e(format_percent((int) ($enrollment['completion_percent'] ?? 0))) ?></div>
                        <div class="progress"><div class="progress__bar" style="width: <?= (int) ($enrollment['completion_percent'] ?? 0) ?>%;"></div></div>
                    </div>
                <?php endif; ?>
                <div class="actions-row" style="margin-top: 18px;">
                    <a href="<?= url('/courses/' . $course['slug']) ?>" class="btn btn-ghost">Открыть курс</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
