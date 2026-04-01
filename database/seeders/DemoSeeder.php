<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $sql = file_get_contents(database_path('sql/seed_demo.sql'));

        if ($sql === false) {
            throw new \RuntimeException('Demo seed file not found.');
        }

        $sql = preg_replace('/^\xEF\xBB\xBF/', '', $sql) ?? $sql;

        foreach ($this->splitStatements($sql) as $statement) {
            DB::unprepared($statement);
        }
    }

    /**
     * @return array<int, string>
     */
    private function splitStatements(string $sql): array
    {
        // `\R` also matches raw 0x85 bytes, which can appear inside UTF-8 Cyrillic sequences.
        $lines = preg_split("/\r\n|\n|\r/", $sql) ?: [];
        $buffer = '';
        $statements = [];

        foreach ($lines as $line) {
            $trimmed = trim($line);

            if ($trimmed === '' || str_starts_with($trimmed, '--')) {
                continue;
            }

            $buffer .= $line . PHP_EOL;

            if (str_ends_with($trimmed, ';')) {
                $statement = trim($buffer);
                if ($statement !== '') {
                    $statements[] = $statement;
                }
                $buffer = '';
            }
        }

        $buffer = trim($buffer);
        if ($buffer !== '') {
            $statements[] = $buffer;
        }

        return $statements;
    }
}
