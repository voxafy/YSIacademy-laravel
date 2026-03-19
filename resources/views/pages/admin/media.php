<section class="section-header">
    <div>
        <p class="section-kicker">Медиатека</p>
        <h1 class="section-title">Видео и материалы</h1>
        <p class="section-text">Все загруженные файлы, связанные с уроками и курсами академии.</p>
    </div>
</section>

<section class="card" style="padding: 28px;">
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Файл</th><th>Тип</th><th>Размер</th><th>Путь</th></tr></thead>
            <tbody>
                <?php foreach ($media as $asset): ?>
                    <tr>
                        <td><strong><?= e($asset['original_name']) ?></strong></td>
                        <td><?= e($asset['kind']) ?></td>
                        <td><?= e((string) $asset['size_bytes']) ?> байт</td>
                        <td><a href="<?= media_url((string) $asset['id']) ?>" target="_blank" rel="noreferrer"><?= e($asset['storage_path']) ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
