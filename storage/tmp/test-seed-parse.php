<?php
$sql = file_get_contents(__DIR__ . '/../../database/sql/seed_demo.sql');
$lines = preg_split("/\R/", $sql) ?: [];
$buffer = '';
$statements = [];
foreach ($lines as $line) {
    $trimmed = trim($line);
    if ($trimmed === '' || str_starts_with($trimmed, '--')) {
        continue;
    }
    $buffer .= $line . PHP_EOL;
    if (str_ends_with($trimmed, ';')) {
        $statements[] = trim($buffer);
        $buffer = '';
    }
}
require __DIR__ . '/../../vendor/autoload.php';
$app = require __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
try {
    Illuminate\Support\Facades\DB::unprepared('DELETE FROM roles');
    Illuminate\Support\Facades\DB::unprepared($statements[31]);
    Illuminate\Support\Facades\DB::unprepared($statements[32]);
    Illuminate\Support\Facades\DB::unprepared($statements[33]);
    echo 'OK';
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
    echo $statements[32];
}
