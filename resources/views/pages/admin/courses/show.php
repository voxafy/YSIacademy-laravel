<section class="section-header">
    <div>
        <p class="section-kicker">Редактор курса</p>
        <h1 class="section-title"><?= e($course['title']) ?></h1>
        <p class="section-text">Структура, статус публикации, модули и быстрый переход в уроки.</p>
    </div>
    <div class="actions-row">
        <a href="<?= url('/admin/courses') ?>" class="btn btn-ghost">К списку курсов</a>
    </div>
</section>

<section class="grid grid-split">
    <div class="card" style="padding: 28px;">
        <div class="section-header"><div><p class="section-kicker">Параметры курса</p><h2 class="section-title section-title--small">Основные данные</h2></div></div>
        <form action="<?= url('/admin/courses/' . $course['id']) ?>" method="post" class="form-grid">
            <?= csrf_field() ?>
            <label class="field"><span class="field__label">Название</span><input class="input" type="text" name="title" value="<?= e($course['title']) ?>" required></label>
            <label class="field"><span class="field__label">Подзаголовок</span><input class="input" type="text" name="subtitle" value="<?= e($course['subtitle']) ?>"></label>
            <label class="field"><span class="field__label">Краткое описание</span><textarea class="textarea" name="short_description"><?= e($course['short_description']) ?></textarea></label>
            <label class="field"><span class="field__label">Полное описание</span><textarea class="textarea" name="description"><?= e($course['description']) ?></textarea></label>
            <label class="field"><span class="field__label">Целевая аудитория</span><input class="input" type="text" name="target_audience" value="<?= e($course['target_audience']) ?>"></label>
            <label class="field"><span class="field__label">Статус</span><select class="select" name="status"><?php foreach (['DRAFT','PUBLISHED','TEMPLATE','ARCHIVED'] as $status): ?><option value="<?= $status ?>" <?= $course['status'] === $status ? 'selected' : '' ?>><?= e($status) ?></option><?php endforeach; ?></select></label>
            <button class="btn btn-primary" type="submit">Сохранить курс</button>
        </form>
    </div>

    <div class="card" style="padding: 28px;">
        <div class="section-header"><div><p class="section-kicker">Новый модуль</p><h2 class="section-title section-title--small">Добавить модуль</h2></div></div>
        <form action="<?= url('/admin/courses/' . $course['id'] . '/modules') ?>" method="post" class="form-grid">
            <?= csrf_field() ?>
            <label class="field"><span class="field__label">Название модуля</span><input class="input" type="text" name="title" required></label>
            <label class="field"><span class="field__label">Описание</span><textarea class="textarea" name="description" required></textarea></label>
            <button class="btn btn-primary" type="submit">Добавить модуль</button>
        </form>
    </div>
</section>

<section class="card" style="padding: 28px; margin-top: 22px;">
    <div class="section-header"><div><p class="section-kicker">Структура курса</p><h2 class="section-title section-title--small">Модули и уроки</h2></div></div>
    <div class="card-stack">
        <?php foreach ($course['modules'] as $module): ?>
            <article class="course-item">
                <div class="section-header">
                    <div>
                        <h3 style="margin: 0; font-size: 1.25rem; color: var(--navy);"><?= e($module['title']) ?></h3>
                        <p class="section-text"><?= e($module['description']) ?></p>
                    </div>
                    <form action="<?= url('/admin/modules/' . $module['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Удалить модуль и все уроки?');">
                        <?= csrf_field() ?>
                        <button class="btn btn-danger btn-sm" type="submit">Удалить модуль</button>
                    </form>
                </div>

                <form action="<?= url('/admin/modules/' . $module['id'] . '/lessons') ?>" method="post" class="form-grid form-grid-3" style="margin-top: 16px;">
                    <?= csrf_field() ?>
                    <label class="field"><span class="field__label">Название урока</span><input class="input" type="text" name="title" required></label>
                    <label class="field"><span class="field__label">Описание</span><input class="input" type="text" name="description" required></label>
                    <label class="field"><span class="field__label">Тип урока</span><select class="select" name="lesson_type"><option value="TEXT">Текстовый</option><option value="VIDEO">Видео</option><option value="MIXED">Смешанный</option><option value="QUIZ">Тестовый</option></select></label>
                    <div style="grid-column: 1 / -1;"><button class="btn btn-ghost" type="submit">Добавить урок</button></div>
                </form>

                <div class="card-stack" style="margin-top: 16px;">
                    <?php foreach ($module['lessons'] as $lesson): ?>
                        <a href="<?= url('/admin/lessons/' . $lesson['id']) ?>" class="list-item">
                            <strong><?= e($lesson['title']) ?></strong>
                            <div class="muted"><?= e($lesson['lesson_type']) ?></div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
