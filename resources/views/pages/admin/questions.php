<section class="section-header admin-page-head">
    <div>
        <p class="section-kicker">Банк вопросов</p>
        <h1 class="section-title">Проверочные вопросы и тесты</h1>
        <p class="section-text">Создавайте единый банк вопросов для уроков и итоговых проверок. Список ниже помогает быстро найти и обновить нужный материал.</p>
    </div>
</section>

<section class="grid grid-split admin-editor-layout">
    <article class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Новый вопрос</p>
                <h2 class="section-title section-title--small">Добавить в банк</h2>
            </div>
        </div>

        <form action="<?= url('/admin/questions') ?>" method="post" class="form-grid admin-form">
            <?= csrf_field() ?>
            <label class="field">
                <span class="field__label">Формулировка вопроса</span>
                <textarea class="textarea" name="prompt" rows="4" required></textarea>
            </label>
            <div class="form-grid form-grid-2">
                <label class="field">
                    <span class="field__label">Тип вопроса</span>
                    <select class="select" name="question_type">
                        <option value="SINGLE">Один верный ответ</option>
                        <option value="MULTIPLE">Несколько верных ответов</option>
                        <option value="BOOLEAN">Верно / неверно</option>
                        <option value="CASE">Кейс</option>
                    </select>
                </label>
                <label class="field">
                    <span class="field__label">Тема</span>
                    <input class="input" type="text" name="topic" value="manual" placeholder="Например: amoCRM">
                </label>
            </div>
            <label class="field">
                <span class="field__label">Варианты ответа</span>
                <textarea class="textarea" name="options" rows="6" placeholder="Каждый вариант с новой строки" required></textarea>
            </label>
            <label class="field">
                <span class="field__label">Номера правильных вариантов</span>
                <input class="input" type="text" name="correct_indexes" placeholder="Например: 1 или 1,3">
            </label>
            <label class="field">
                <span class="field__label">Пояснение после ответа</span>
                <textarea class="textarea" name="explanation" rows="4"></textarea>
            </label>
            <button class="btn btn-primary" type="submit">Сохранить вопрос</button>
        </form>
    </article>

    <article class="card course-editor-panel">
        <div class="section-header">
            <div>
                <p class="section-kicker">Библиотека</p>
                <h2 class="section-title section-title--small">Все вопросы</h2>
            </div>
            <div class="actions-row">
                <input class="input input--search" type="search" placeholder="Найти по формулировке или теме" data-table-search="questions-table">
            </div>
        </div>

        <div class="table-wrap">
            <table id="questions-table" class="table">
                <thead>
                    <tr>
                        <th>Вопрос</th>
                        <th>Тип</th>
                        <th>Варианты</th>
                        <th>Использование</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($questions as $index => $question): ?>
                        <?php
                        $optionsValue = implode("\n", array_map(static fn (array $option): string => (string) $option['label'], $question['options'] ?? []));
                        $correctIndexes = [];
                        foreach (($question['options'] ?? []) as $optionIndex => $option) {
                            if ((int) ($option['is_correct'] ?? 0) === 1) {
                                $correctIndexes[] = $optionIndex;
                            }
                        }
                        ?>
                        <tr>
                            <td data-col="prompt">
                                <strong><?= e($question['prompt']) ?></strong>
                                <div class="table-subline"><?= e((string) ($question['topic'] ?: 'manual')) ?></div>
                            </td>
                            <td data-col="type"><?= e(question_type_label((string) $question['question_type'])) ?></td>
                            <td data-col="options"><?= e((string) count($question['options'] ?? [])) ?></td>
                            <td data-col="usage"><?= e((string) ($question['usage_count'] ?? 0)) ?></td>
                            <td>
                                <button type="button" class="btn btn-ghost btn-sm" data-collapse-toggle="question-editor-<?= e((string) $index) ?>" aria-expanded="false">Редактировать</button>
                            </td>
                        </tr>
                        <tr id="question-editor-<?= e((string) $index) ?>" hidden>
                            <td colspan="5">
                                <form action="<?= url('/admin/questions/' . $question['id']) ?>" method="post" class="form-grid admin-form admin-inline-form">
                                    <?= csrf_field() ?>
                                    <div class="form-grid form-grid-2">
                                        <label class="field">
                                            <span class="field__label">Тип вопроса</span>
                                            <select class="select" name="question_type">
                                                <?php foreach (['SINGLE', 'MULTIPLE', 'BOOLEAN', 'CASE'] as $type): ?>
                                                    <option value="<?= $type ?>" <?= (string) $question['question_type'] === $type ? 'selected' : '' ?>>
                                                        <?= e(question_type_label($type)) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                        <label class="field">
                                            <span class="field__label">Тема</span>
                                            <input class="input" type="text" name="topic" value="<?= e((string) ($question['topic'] ?: 'manual')) ?>">
                                        </label>
                                    </div>

                                    <label class="field">
                                        <span class="field__label">Формулировка</span>
                                        <textarea class="textarea" name="prompt" rows="4" required><?= e($question['prompt']) ?></textarea>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Варианты ответа</span>
                                        <textarea class="textarea" name="options" rows="6" required><?= e($optionsValue) ?></textarea>
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Номера правильных вариантов</span>
                                        <input class="input" type="text" name="correct_indexes" value="<?= e(implode(',', array_map(static fn (int $value): string => (string) ($value + 1), $correctIndexes))) ?>">
                                    </label>

                                    <label class="field">
                                        <span class="field__label">Пояснение</span>
                                        <textarea class="textarea" name="explanation" rows="4"><?= e((string) $question['explanation']) ?></textarea>
                                    </label>

                                    <div class="actions-row">
                                        <button class="btn btn-primary btn-sm" type="submit">Сохранить</button>
                                    </div>
                                </form>
                                <form action="<?= url('/admin/questions/' . $question['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Удалить вопрос из банка?');">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-danger btn-sm" type="submit">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </article>
</section>
