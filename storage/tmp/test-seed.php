<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$sql = "INSERT INTO roles (`id`, `key`, `name`, `description`) VALUES ('testrole123456789012345678901234567890', 'TMP', 'Ученик', 'Проходит курсы и тесты.')";
try {
    Illuminate\Support\Facades\DB::unprepared("DELETE FROM roles WHERE `key` = 'TMP'");
    Illuminate\Support\Facades\DB::unprepared($sql);
    echo 'OK';
} catch (Throwable $e) {
    echo $e->getMessage();
}
