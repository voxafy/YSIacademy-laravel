<section class="section-header admin-page-head">
    <div>
        <p class="section-kicker">Медиатека</p>
        <h1 class="section-title">Файлы, видео и материалы</h1>
        <p class="section-text">Единая библиотека материалов для уроков и курсов. Здесь удобно проверить, что уже загружено, где используется файл и что можно безопасно удалить.</p>
    </div>
</section>

<section class="card course-editor-panel">
    <div class="section-header">
        <div>
            <p class="section-kicker">Библиотека</p>
            <h2 class="section-title section-title--small">Все материалы</h2>
        </div>
        <div class="actions-row">
            <input class="input input--search" type="search" placeholder="Найти по названию, типу или курсу" data-table-search="media-table">
        </div>
    </div>

    <div class="table-wrap">
        <table id="media-table" class="table">
            <thead>
                <tr>
                    <th>Материал</th>
                    <th>Тип</th>
                    <th>Размер</th>
                    <th>Где используется</th>
                    <th>Курс</th>
                    <th>Загружен</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($media as $asset): ?>
                    <?php
                    $usageTitle = '';
                    if (!empty($asset['video_lesson_title'])) {
                        $usageTitle = 'Видео урока: ' . $asset['video_lesson_title'];
                    } elseif (!empty($asset['attachment_lesson_title'])) {
                        $usageTitle = 'Файл урока: ' . $asset['attachment_lesson_title'];
                    }
                    ?>
                    <tr>
                        <td data-col="title">
                            <strong><?= e($asset['original_name']) ?></strong>
                            <div class="table-subline"><?= e((string) ($asset['mime_type'] ?: 'Файл')) ?></div>
                        </td>
                        <td data-col="kind"><?= e((string) $asset['kind']) ?></td>
                        <td data-col="size"><?= e(format_bytes((int) ($asset['size_bytes'] ?? 0))) ?></td>
                        <td data-col="usage">
                            <?= e($usageTitle !== '' ? $usageTitle : 'Пока не используется в уроках') ?>
                        </td>
                        <td data-col="course"><?= e((string) ($asset['course_title'] ?: 'Без привязки')) ?></td>
                        <td data-col="uploader"><?= e((string) ($asset['uploader_name'] ?: 'Система')) ?></td>
                        <td>
                            <div class="actions-row">
                                <a href="<?= media_url((string) $asset['id']) ?>" class="btn btn-ghost btn-sm" target="_blank" rel="noreferrer">Открыть</a>
                                <?php if (empty($asset['is_in_use'])): ?>
                                    <form action="<?= url('/admin/media/' . $asset['id'] . '/delete') ?>" method="post" onsubmit="return confirm('Удалить файл из медиатеки?');">
                                        <?= csrf_field() ?>
                                        <button class="btn btn-danger btn-sm" type="submit">Удалить</button>
                                    </form>
                                <?php else: ?>
                                    <span class="badge badge-info">Используется</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
