<?php
require __DIR__ . '/../../vendor/autoload.php';
$app = require __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$sql = file_get_contents(__DIR__ . '/../../database/sql/seed_demo.sql');
$sql = preg_replace('/^\xEF\xBB\xBF/', '', $sql) ?? $sql;
$lines = preg_split("/\R/", $sql) ?: [];
$buffer = '';
$statements = [];
foreach ($lines as $line) {
  $trimmed = trim($line);
  if ($trimmed === '' || str_starts_with($trimmed, '--')) continue;
  $buffer .= $line . PHP_EOL;
  if (str_ends_with($trimmed, ';')) { $statements[] = trim($buffer); $buffer = ''; }
}
Illuminate\Support\Facades\DB::unprepared('DELETE FROM roles');
$result = Illuminate\Support\Facades\DB::unprepared($statements[43]);
$count = Illuminate\Support\Facades\DB::select('SELECT COUNT(*) AS c FROM roles');
var_dump($result, $count);
