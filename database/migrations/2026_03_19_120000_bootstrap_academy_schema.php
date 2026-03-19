<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $sql = file_get_contents(database_path('sql/schema_reference.sql'));

        if ($sql === false) {
            throw new RuntimeException('Schema reference file not found.');
        }

        $sql = preg_replace('/^\xEF\xBB\xBF/', '', $sql) ?? $sql;

        foreach ($this->splitStatements($sql) as $statement) {
            DB::unprepared($statement);
        }
    }

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        $tables = [
            'audit_logs',
            'platform_settings',
            'notifications',
            'supervisor_decisions',
            'attempts',
            'lesson_progress',
            'module_progress',
            'progress',
            'enrollments',
            'quiz_questions',
            'answer_options',
            'questions',
            'quizzes',
            'lesson_attachments',
            'lesson_videos',
            'media_assets',
            'lesson_blocks',
            'lessons',
            'modules',
            'course_departments',
            'course_cities',
            'courses',
            'course_categories',
            'auth_sessions',
            'users',
            'departments',
            'cities',
            'companies',
            'roles',
        ];

        foreach ($tables as $table) {
            DB::unprepared('DROP TABLE IF EXISTS ' . $table);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

    /**
     * @return array<int, string>
     */
    private function splitStatements(string $sql): array
    {
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
};
