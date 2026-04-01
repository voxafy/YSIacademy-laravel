<section class="section-header">
    <div>
        <p class="section-kicker">Редактор курсов</p>
        <h1 class="section-title">Управление программами обучения</h1>
        <p class="section-text">Создание, копирование и публикация курсов с учетом категорий, городов и подразделений.</p>
    </div>
</section>

<section class="grid grid-split">
    <div class="card" style="padding: 28px;">
        <div class="section-header"><div><p class="section-kicker">Новый курс</p><h2 class="section-title section-title--small">Создать курс</h2></div></div>
        <form action="<?= url('/admin/courses') ?>" method="post" class="form-grid">
            <?= csrf_field() ?>
            <label class="field"><span class="field__label">Название курса</span><input class="input" type="text" name="title" required></label>
            <label class="field"><span class="field__label">Slug</span><input class="input" type="text" name="slug"></label>
            <label class="field">
                <span class="field__label">Категория</span>
                <select class="select" name="category_id" required>
                    <option value="">Выберите категорию</option>
                    <?php foreach ($resources['categories'] as $category): ?><option value="<?= e($category['id']) ?>"><?= e($category['title']) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label class="field"><span class="field__label">Целевая аудитория</span><input class="input" type="text" name="target_audience"></label>
            <label class="field"><span class="field__label">Город</span><select class="select" name="city_id"><option value="">Без ограничения</option><?php foreach ($options['cities'] as $city): ?><option value="<?= e($city['id']) ?>"><?= e($city['name']) ?></option><?php endforeach; ?></select></label>
            <label class="field"><span class="field__label">Подразделение</span><select class="select" name="department_id"><option value="">Без ограничения</option><?php foreach ($options['departments'] as $department): ?><option value="<?= e($department['id']) ?>"><?= e($department['name']) ?></option><?php endforeach; ?></select></label>
            <label class="field"><span class="field__label">Описание</span><textarea class="textarea" name="description"></textarea></label>
            <button class="btn btn-primary" type="submit">Создать курс</button>
        </form>
    </div>

    <div class="card" style="padding: 28px;">
        <div class="section-header"><div><p class="section-kicker">Существующие курсы</p><h2 class="section-title section-title--small">Список программ</h2></div></div>
        <div class="card-stack">
            <?php foreach ($resources['courses'] as $course): ?>
                <article class="course-item">
                    <div class="section-header">
                        <div>
                            <p class="section-kicker"><?= e($course['category']['title']) ?></p>
                            <h3 style="margin: 10px 0 0; font-size: 1.3rem; color: var(--navy);"><?= e($course['title']) ?></h3>
                            <p class="section-text"><?= count($course['modules']) ?> модулей</p>
                        </div>
                        <span class="<?= publication_status_badge_class((string) $course['status']) ?>"><?= e(publication_status_label((string) $course['status'])) ?></span>
                    </div>
                    <div class="actions-row">
                        <a href="<?= url('/admin/courses/' . $course['id']) ?>" class="btn btn-ghost btn-sm">Открыть</a>
                        <form action="<?= url('/admin/courses/' . $course['id'] . '/duplicate') ?>" method="post"><?= csrf_field() ?><button class="btn btn-primary btn-sm" type="submit">Копировать</button></form>
                        <form action="<?= url('/admin/courses/' . $course['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Удалить курс и связанные данные?');"><?= csrf_field() ?><button class="btn btn-danger btn-sm" type="submit">Удалить</button></form>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
