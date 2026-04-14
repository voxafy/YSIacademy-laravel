<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$adminId = (string) (DB::table('users')
    ->join('roles', 'roles.id', '=', 'users.role_id')
    ->where('roles.key', 'ADMIN')
    ->orderBy('users.full_name')
    ->value('users.id') ?? '');

$leaderId = (string) (DB::table('users')
    ->join('roles', 'roles.id', '=', 'users.role_id')
    ->where('roles.key', 'LEADER')
    ->orderBy('users.full_name')
    ->value('users.id') ?? '');

$studentId = (string) (DB::table('users')
    ->join('roles', 'roles.id', '=', 'users.role_id')
    ->where('roles.key', 'STUDENT')
    ->orderBy('users.full_name')
    ->value('users.id') ?? '');

$teamUserId = (string) (DB::table('users')
    ->join('roles', 'roles.id', '=', 'users.role_id')
    ->where('roles.key', 'STUDENT')
    ->when($leaderId !== '', static function ($query) use ($leaderId) {
        $query->where('users.supervisor_id', $leaderId);
    })
    ->orderBy('users.full_name')
    ->value('users.id') ?? $studentId);

$firstPublishedCourseSlug = (string) (DB::table('courses')
    ->where('status', 'PUBLISHED')
    ->whereRaw('COALESCE(is_template, 0) = 0')
    ->orderBy('title')
    ->value('slug') ?? '');

$lesson = DB::table('lessons')
    ->join('modules', 'modules.id', '=', 'lessons.module_id')
    ->join('courses', 'courses.id', '=', 'modules.course_id')
    ->where('courses.status', 'PUBLISHED')
    ->select('courses.slug as course_slug', 'lessons.id as lesson_id')
    ->orderBy('courses.title')
    ->orderBy('modules.sort_order')
    ->orderBy('lessons.sort_order')
    ->first();

$firstKnowledgeSlug = (string) (DB::table('knowledge_articles')
    ->where('status', 'PUBLISHED')
    ->orderBy('sort_order')
    ->value('slug') ?? '');

$context = [
    'base_url' => env('APP_URL', 'http://127.0.0.1:8000'),
    'guest' => [
        'course_slug' => $firstPublishedCourseSlug,
        'lesson' => [
            'course_slug' => (string) ($lesson->course_slug ?? ''),
            'lesson_id' => (string) ($lesson->lesson_id ?? ''),
        ],
        'knowledge_slug' => $firstKnowledgeSlug,
    ],
    'admin' => [
        'email' => 'admin@demo.local',
        'password' => 'demo12345',
        'course_id' => (string) (DB::table('courses')->orderBy('title')->value('id') ?? ''),
        'lesson_id' => (string) (DB::table('lessons')->orderBy('title')->value('id') ?? ''),
        'knowledge_article_id' => (string) (DB::table('knowledge_articles')->where('status', 'PUBLISHED')->orderBy('sort_order')->value('id') ?? ''),
        'user_id' => $studentId !== '' ? $studentId : $adminId,
        'result_user_id' => $studentId,
        'course_slug' => $firstPublishedCourseSlug,
        'knowledge_slug' => $firstKnowledgeSlug,
    ],
    'leader' => [
        'email' => 'leader@demo.local',
        'password' => 'demo12345',
        'team_user_id' => $teamUserId,
        'course_slug' => $firstPublishedCourseSlug,
        'knowledge_slug' => $firstKnowledgeSlug,
    ],
    'student' => [
        'email' => 'student1@demo.local',
        'password' => 'demo12345',
        'course_slug' => (string) ((DB::table('courses')
            ->join('enrollments', 'enrollments.course_id', '=', 'courses.id')
            ->join('users', 'users.id', '=', 'enrollments.user_id')
            ->where('users.email', 'student1@demo.local')
            ->where('courses.status', 'PUBLISHED')
            ->orderBy('courses.title')
            ->value('courses.slug')) ?? $firstPublishedCourseSlug),
        'lesson' => DB::table('lessons')
            ->join('modules', 'modules.id', '=', 'lessons.module_id')
            ->join('courses', 'courses.id', '=', 'modules.course_id')
            ->join('enrollments', 'enrollments.course_id', '=', 'courses.id')
            ->join('users', 'users.id', '=', 'enrollments.user_id')
            ->where('users.email', 'student1@demo.local')
            ->select('courses.slug as course_slug', 'lessons.id as lesson_id')
            ->orderBy('courses.title')
            ->orderBy('modules.sort_order')
            ->orderBy('lessons.sort_order')
            ->first(),
        'knowledge_slug' => $firstKnowledgeSlug,
    ],
];

echo json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
