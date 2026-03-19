<?php
$richText = '';
$rulesBody = '';
$mistakesBody = '';
foreach ($lesson['blocks'] as $block) {
    if ($block['block_type'] === 'RICH_TEXT') $richText = $block['body'];
    if ($block['block_type'] === 'RULES') $rulesBody = $block['body'];
    if ($block['block_type'] === 'MISTAKES') $mistakesBody = $block['body'];
}
?>
<section class="section-header">
    <div>
        <p class="section-kicker">Редактор урока</p>
        <h1 class="section-title"><?= e($lesson['title']) ?></h1>
        <p class="section-text"><?= e($lesson['course_title']) ?> · <?= e($lesson['module_title']) ?></p>
    </div>
    <div class="actions-row">
        <a href="<?= url('/admin/courses/' . $lesson['course_id']) ?>" class="btn btn-ghost">Вернуться к курсу</a>
        <form action="<?= url('/admin/lessons/' . $lesson['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Удалить урок?');">
            <?= csrf_field() ?>
            <button class="btn btn-danger" type="submit">Удалить урок</button>
        </form>
    </div>
</section>

<section class="grid grid-split">
    <div class="card" style="padding: 28px;">
        <div class="section-header"><div><p class="section-kicker">Контент урока</p><h2 class="section-title section-title--small">Текст и блоки</h2></div></div>
        <form action="<?= url('/admin/lessons/' . $lesson['id']) ?>" method="post" class="form-grid">
            <?= csrf_field() ?>
            <label class="field"><span class="field__label">Название</span><input class="input" type="text" name="title" value="<?= e($lesson['title']) ?>" required></label>
            <label class="field"><span class="field__label">Описание</span><textarea class="textarea" name="description"><?= e($lesson['description']) ?></textarea></label>
            <label class="field"><span class="field__label">Тип урока</span><select class="select" name="lesson_type"><?php foreach (['TEXT','VIDEO','MIXED','QUIZ'] as $type): ?><option value="<?= $type ?>" <?= $lesson['lesson_type'] === $type ? 'selected' : '' ?>><?= e($type) ?></option><?php endforeach; ?></select></label>
            <label class="field"><span class="field__label">Основной материал</span><textarea class="textarea" name="body"><?= e($richText) ?></textarea></label>
            <label class="field"><span class="field__label">Блок правил</span><textarea class="textarea" name="rules_body"><?= e($rulesBody) ?></textarea></label>
            <label class="field"><span class="field__label">Типичные ошибки</span><textarea class="textarea" name="mistakes_body"><?= e($mistakesBody) ?></textarea></label>
            <button class="btn btn-primary" type="submit">Сохранить урок</button>
        </form>
    </div>

    <div class="card-stack">
        <article class="card" style="padding: 28px;">
            <div class="section-header"><div><p class="section-kicker">Видео</p><h2 class="section-title section-title--small">Видео-урок</h2></div></div>
            <?php if ($lesson['video']): ?>
                <div class="list-item" style="margin-bottom: 16px;">
                    <strong><?= e($lesson['video']['original_name']) ?></strong>
                    <div class="muted"><?= e((string) $lesson['video']['size_bytes']) ?> байт</div>
                </div>
                <form action="<?= url('/admin/lessons/' . $lesson['id'] . '/video/delete') ?>" method="post">
                    <?= csrf_field() ?>
                    <button class="btn btn-danger btn-sm" type="submit">Удалить видео</button>
                </form>
            <?php endif; ?>
            <form action="<?= url('/admin/lessons/' . $lesson['id'] . '/video') ?>" method="post" enctype="multipart/form-data" class="form-grid" style="margin-top: 16px;">
                <?= csrf_field() ?>
                <label class="field"><span class="field__label">Видео-файл</span><input class="input" type="file" name="video" accept="video/*"></label>
                <button class="btn btn-primary" type="submit">Загрузить / заменить видео</button>
            </form>
        </article>

        <article class="card" style="padding: 28px;">
            <div class="section-header"><div><p class="section-kicker">Материалы</p><h2 class="section-title section-title--small">Файлы урока</h2></div></div>
            <div class="card-stack">
                <?php foreach ($lesson['attachments'] as $attachment): ?>
                    <div class="list-item">
                        <strong><?= e($attachment['original_name']) ?></strong>
                        <form action="<?= url('/admin/lessons/' . $lesson['id'] . '/attachments/' . $attachment['asset_id'] . '/delete') ?>" method="post" style="margin-top: 10px;">
                            <?= csrf_field() ?>
                            <button class="btn btn-danger btn-sm" type="submit">Удалить</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
            <form action="<?= url('/admin/lessons/' . $lesson['id'] . '/attachments') ?>" method="post" enctype="multipart/form-data" class="form-grid" style="margin-top: 16px;">
                <?= csrf_field() ?>
                <label class="field"><span class="field__label">Файл</span><input class="input" type="file" name="attachment"></label>
                <button class="btn btn-primary" type="submit">Добавить файл</button>
            </form>
        </article>

        <article class="card" style="padding: 28px;">
            <div class="section-header"><div><p class="section-kicker">Тест</p><h2 class="section-title section-title--small">Сборка quiz-урока</h2></div></div>
            <form action="<?= url('/admin/lessons/' . $lesson['id'] . '/quiz') ?>" method="post" class="form-grid">
                <?= csrf_field() ?>
                <label class="field"><span class="field__label">Название теста</span><input class="input" type="text" name="title" value="<?= e($lesson['quiz']['title'] ?? ('Проверка: ' . $lesson['title'])) ?>"></label>
                <label class="field"><span class="field__label">Описание</span><textarea class="textarea" name="description"><?= e($lesson['quiz']['description'] ?? '') ?></textarea></label>
                <label class="field"><span class="field__label">Проходной балл</span><input class="input" type="number" name="pass_score" min="1" max="100" value="<?= e((string) ($lesson['quiz']['pass_score'] ?? 70)) ?>"></label>
                <label class="field"><span class="field__label">ID вопросов</span><textarea class="textarea" name="question_ids"><?php if (!empty($lesson['quiz']['questions'])): ?><?= e(implode("\n", array_map(static fn (array $item): string => (string) $item['question_id'], $lesson['quiz']['questions']))) ?><?php endif; ?></textarea></label>
                <button class="btn btn-primary" type="submit">Сохранить тест</button>
            </form>
        </article>
    </div>
</section>
