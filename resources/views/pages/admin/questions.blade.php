<section class="section-header">
    <div>
        <p class="section-kicker">Банк вопросов</p>
        <h1 class="section-title">Конструктор проверочных вопросов</h1>
        <p class="section-text">Вопросы можно переиспользовать в quiz-уроках и итоговых тестах.</p>
    </div>
</section>

<section class="grid grid-split">
    <div class="card" style="padding: 28px;">
        <div class="section-header"><div><p class="section-kicker">Новый вопрос</p><h2 class="section-title section-title--small">Создать вопрос</h2></div></div>
        <form action="<?= url('/admin/questions') ?>" method="post" class="form-grid">
            <?= csrf_field() ?>
            <label class="field"><span class="field__label">Формулировка</span><textarea class="textarea" name="prompt" required></textarea></label>
            <label class="field"><span class="field__label">Тип вопроса</span><select class="select" name="question_type"><option value="SINGLE">Один правильный</option><option value="MULTIPLE">Несколько правильных</option><option value="BOOLEAN">Верно / неверно</option><option value="CASE">Кейсовый</option></select></label>
            <label class="field"><span class="field__label">Пояснение</span><textarea class="textarea" name="explanation"></textarea></label>
            <label class="field"><span class="field__label">Варианты ответа (по одному в строке)</span><textarea class="textarea" name="options" required></textarea></label>
            <label class="field"><span class="field__label">Номера правильных вариантов через запятую</span><input class="input" type="text" name="correct_indexes" placeholder="1,3"></label>
            <button class="btn btn-primary" type="submit">Сохранить вопрос</button>
        </form>
    </div>
    <div class="card" style="padding: 28px;">
        <div class="section-header"><div><p class="section-kicker">Существующие вопросы</p><h2 class="section-title section-title--small">Библиотека</h2></div></div>
        <div class="card-stack">
            <?php foreach ($questions as $question): ?>
                <article class="course-item">
                    <strong><?= e($question['prompt']) ?></strong>
                    <div class="muted" style="margin-top: 6px;">ID: <?= e($question['id']) ?> · <?= e($question['question_type']) ?></div>
                    <div class="card-stack" style="margin-top: 12px;">
                        <?php foreach ($question['options'] as $option): ?>
                            <div class="list-item"><?= e($option['label']) ?><?= (int) $option['is_correct'] === 1 ? ' · правильный' : '' ?></div>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
