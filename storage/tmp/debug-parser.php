<?php
$sql = file_get_contents(__DIR__ . '/../../database/sql/seed_demo.sql');
$sql = preg_replace('/^\xEF\xBB\xBF/', '', $sql) ?? $sql;
$lines = preg_split("/\R/", $sql) ?: [];
$buffer = '';
$statements = [];
foreach ($lines as $line) {
    $trimmed = trim($line);
    if ($trimmed === '' || str_starts_with($trimmed, '--')) continue;
    $buffer .= $line . PHP_EOL;
    if (str_ends_with($trimmed, ';')) {
        $statements[] = trim($buffer);
        $buffer = '';
    }
}
echo 'Statements: ' . count($statements) . PHP_EOL;
foreach ($statements as $idx => $statement) {
    if (str_contains($statement, 'INSERT INTO `roles`') || str_contains($statement, 'INSERT INTO `users`') || str_contains($statement, 'INSERT INTO `courses`')) {
        echo 'MATCH ' . $idx . ': ' . substr($statement, 0, 120) . PHP_EOL;
    }
}
