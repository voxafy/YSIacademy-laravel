<?php

declare(strict_types=1);

namespace App\Services;

use App\Support\LegacyDb;
use RuntimeException;

final class AcademyService
{
    public function __construct(
        private readonly LegacyDb $db,
    ) {
    }

    /**
     * @return array{cities: array<int, array<string, mixed>>, departments: array<int, array<string, mixed>>, supervisors: array<int, array<string, mixed>>}
     */
    public function getPlatformOptions(): array
    {
        return [
            'cities' => $this->db->fetchAll('SELECT * FROM cities ORDER BY name ASC'),
            'departments' => $this->db->fetchAll('SELECT * FROM departments ORDER BY name ASC'),
            'supervisors' => $this->db->fetchAll(
                "SELECT u.id, u.full_name 
                 FROM users u 
                 INNER JOIN roles r ON r.id = u.role_id 
                 WHERE r.`key` = 'LEADER'
                 ORDER BY u.full_name ASC"
            ),
        ];
    }

    /**
     * @param array<string, mixed>|null $user
     * @return array<int, array<string, mixed>>
     */
    public function getPublishedCourses(?array $user = null): array
    {
        $params = [];
        $where = [];

        if ($user === null) {
            $where[] = "c.status = 'PUBLISHED'";
        } elseif (($user['role_key'] ?? '') === 'ADMIN') {
            $where[] = '1=1';
        } elseif (($user['role_key'] ?? '') === 'LEADER') {
            $where[] = "c.status = 'PUBLISHED'";
        } else {
            $where[] = "c.status = 'PUBLISHED'";
            $where[] = '(NOT EXISTS (SELECT 1 FROM course_cities cc WHERE cc.course_id = c.id) OR EXISTS (SELECT 1 FROM course_cities cc WHERE cc.course_id = c.id AND cc.city_id = ?))';
            $where[] = '(NOT EXISTS (SELECT 1 FROM course_departments cd WHERE cd.course_id = c.id) OR EXISTS (SELECT 1 FROM course_departments cd WHERE cd.course_id = c.id AND cd.department_id = ?))';
            $params[] = $user['city_id'] ?? '';
            $params[] = $user['department_id'] ?? '';
        }

        $courses = $this->db->fetchAll(
            'SELECT c.*, cc.title AS category_title, cc.slug AS category_slug
             FROM courses c
             INNER JOIN course_categories cc ON cc.id = c.category_id
             WHERE ' . implode(' AND ', $where) . '
             ORDER BY cc.sort_order ASC, c.title ASC',
            $params,
        );

        if ($courses === []) {
            return [];
        }

        $courseIds = array_column($courses, 'id');
        $modules = $this->db->fetchAll(
            sprintf(
                'SELECT m.*, COALESCE(lesson_counts.lessons_count, 0) AS lessons_count
                 FROM modules m
                 LEFT JOIN (
                    SELECT l.module_id, COUNT(l.id) AS lessons_count
                    FROM lessons l
                    GROUP BY l.module_id
                 ) AS lesson_counts ON lesson_counts.module_id = m.id
                 WHERE m.course_id IN (%s)
                 ORDER BY m.sort_order ASC',
                $this->placeholders(count($courseIds)),
            ),
            $courseIds,
        );

        $moduleGroups = $this->groupBy($modules, 'course_id');
        $enrollmentMap = [];

        if ($user !== null && isset($user['id'])) {
            $enrollments = $this->db->fetchAll(
                sprintf(
                    "SELECT e.*, p.completion_percent, p.lessons_completed, p.lessons_total, p.modules_completed, p.modules_total
                     FROM enrollments e
                     LEFT JOIN progress p ON p.enrollment_id = e.id
                     WHERE e.user_id = ? AND e.course_id IN (%s)",
                    $this->placeholders(count($courseIds)),
                ),
                array_merge([(string) $user['id']], $courseIds),
            );

            foreach ($enrollments as $enrollment) {
                $enrollmentMap[(string) $enrollment['course_id']] = $enrollment;
            }
        }

        foreach ($courses as &$course) {
            $course['category'] = [
                'title' => $course['category_title'],
                'slug' => $course['category_slug'],
            ];
            $course['modules'] = $moduleGroups[(string) $course['id']] ?? [];
            $course['enrollment'] = $enrollmentMap[(string) $course['id']] ?? null;
        }
        unset($course);

        return $courses;
    }

    /**
     * @return array<string, mixed>
     */
    public function getCourseBySlugForUser(string $slug, ?string $userId = null): array
    {
        $course = $this->db->fetchOne(
            'SELECT c.*, cc.title AS category_title, cc.slug AS category_slug
             FROM courses c
             INNER JOIN course_categories cc ON cc.id = c.category_id
             WHERE c.slug = ?
             LIMIT 1',
            [$slug],
        );

        if ($course === null) {
            throw new RuntimeException('Course not found.');
        }

        $modules = $this->db->fetchAll(
            'SELECT * FROM modules WHERE course_id = ? ORDER BY sort_order ASC',
            [$course['id']],
        );
        $moduleIds = array_column($modules, 'id');
        $lessons = $moduleIds === []
            ? []
            : $this->db->fetchAll(
                sprintf(
                    'SELECT * FROM lessons WHERE module_id IN (%s) ORDER BY sort_order ASC',
                    $this->placeholders(count($moduleIds)),
                ),
                $moduleIds,
            );

        $lessonGroups = $this->groupBy($lessons, 'module_id');
        foreach ($modules as &$module) {
            $module['lessons'] = $lessonGroups[(string) $module['id']] ?? [];
        }
        unset($module);

        $course['category'] = [
            'title' => $course['category_title'],
            'slug' => $course['category_slug'],
        ];
        $course['modules'] = $modules;
        $course['enrollment'] = null;

        if ($userId !== null) {
            $enrollment = $this->db->fetchOne(
                'SELECT e.*, p.completion_percent, p.lessons_completed, p.lessons_total, p.modules_completed, p.modules_total,
                        p.status AS progress_status, p.last_lesson_id, p.last_activity_at, p.completed_at AS progress_completed_at
                 FROM enrollments e
                 LEFT JOIN progress p ON p.enrollment_id = e.id
                 WHERE e.user_id = ? AND e.course_id = ?
                 LIMIT 1',
                [$userId, $course['id']],
            );

            if ($enrollment !== null) {
                $moduleProgress = $this->db->fetchAll(
                    'SELECT * FROM module_progress WHERE enrollment_id = ?',
                    [$enrollment['id']],
                );
                $lessonProgress = $this->db->fetchAll(
                    'SELECT * FROM lesson_progress WHERE enrollment_id = ?',
                    [$enrollment['id']],
                );
                $latestDecision = $this->db->fetchOne(
                    'SELECT sd.*, u.full_name AS leader_name
                     FROM supervisor_decisions sd
                     INNER JOIN users u ON u.id = sd.leader_id
                     WHERE sd.enrollment_id = ?
                     ORDER BY sd.created_at DESC
                     LIMIT 1',
                    [$enrollment['id']],
                );

                $enrollment['module_progress'] = $moduleProgress;
                $enrollment['lesson_progress'] = $lessonProgress;
                $enrollment['latest_decision'] = $latestDecision;
                $course['enrollment'] = $enrollment;
            }
        }

        return $course;
    }

    /**
     * @return array{course: array<string,mixed>, lesson: array<string,mixed>}|null
     */
    public function getLessonView(string $slug, string $lessonId, ?string $userId = null): ?array
    {
        $course = $this->getCourseBySlugForUser($slug, $userId);
        $lesson = null;

        foreach ($course['modules'] as $module) {
            foreach ($module['lessons'] as $moduleLesson) {
                if ($moduleLesson['id'] === $lessonId) {
                    $lesson = $moduleLesson;
                    break 2;
                }
            }
        }

        if ($lesson === null) {
            return null;
        }

        $fullLesson = $this->db->fetchOne(
            'SELECT l.*, m.title AS module_title, m.course_id, c.title AS course_title
             FROM lessons l
             INNER JOIN modules m ON m.id = l.module_id
             INNER JOIN courses c ON c.id = m.course_id
             WHERE l.id = ?
             LIMIT 1',
            [$lessonId],
        );

        if ($fullLesson === null) {
            return null;
        }

        $blocks = $this->db->fetchAll(
            'SELECT * FROM lesson_blocks WHERE lesson_id = ? ORDER BY sort_order ASC',
            [$lessonId],
        );

        $video = $this->db->fetchOne(
            'SELECT lv.*, ma.id AS asset_id, ma.original_name, ma.size_bytes, ma.duration_sec, ma.mime_type, ma.public_url
             FROM lesson_videos lv
             INNER JOIN media_assets ma ON ma.id = lv.media_asset_id
             WHERE lv.lesson_id = ?
             LIMIT 1',
            [$lessonId],
        );

        $attachments = $this->db->fetchAll(
            'SELECT la.*, ma.id AS asset_id, ma.original_name, ma.mime_type, ma.public_url, ma.size_bytes
             FROM lesson_attachments la
             INNER JOIN media_assets ma ON ma.id = la.asset_id
             WHERE la.lesson_id = ?
             ORDER BY la.sort_order ASC',
            [$lessonId],
        );

        $quiz = null;
        if (!empty($fullLesson['quiz_id'])) {
            $quiz = $this->getQuizById((string) $fullLesson['quiz_id']);
        }

        $fullLesson['blocks'] = $blocks;
        $fullLesson['video'] = $video;
        $fullLesson['attachments'] = $attachments;
        $fullLesson['quiz'] = $quiz;

        return [
            'course' => $course,
            'lesson' => $fullLesson,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getStudentDashboard(string $userId): array
    {
        $user = $this->db->fetchOne(
            'SELECT u.*, r.key AS role_key, r.name AS role_name, c.name AS city_name, d.name AS department_name, s.full_name AS supervisor_name
             FROM users u
             INNER JOIN roles r ON r.id = u.role_id
             LEFT JOIN cities c ON c.id = u.city_id
             LEFT JOIN departments d ON d.id = u.department_id
             LEFT JOIN users s ON s.id = u.supervisor_id
             WHERE u.id = ?
             LIMIT 1',
            [$userId],
        );

        if ($user === null) {
            throw new RuntimeException('User not found.');
        }

        $enrollments = $this->db->fetchAll(
            'SELECT e.*, c.slug AS course_slug, c.title AS course_title, c.short_description, cc.title AS category_title,
                    p.completion_percent, p.lessons_completed, p.lessons_total, p.modules_completed, p.modules_total
             FROM enrollments e
             INNER JOIN courses c ON c.id = e.course_id
             INNER JOIN course_categories cc ON cc.id = c.category_id
             LEFT JOIN progress p ON p.enrollment_id = e.id
             WHERE e.user_id = ?
             ORDER BY e.assigned_at DESC',
            [$userId],
        );

        foreach ($enrollments as &$enrollment) {
            $enrollment['course'] = [
                'slug' => $enrollment['course_slug'],
                'title' => $enrollment['course_title'],
                'short_description' => $enrollment['short_description'],
                'category' => [
                    'title' => $enrollment['category_title'],
                ],
            ];
            $enrollment['progress'] = [
                'completion_percent' => (int) ($enrollment['completion_percent'] ?? 0),
                'lessons_completed' => (int) ($enrollment['lessons_completed'] ?? 0),
                'lessons_total' => (int) ($enrollment['lessons_total'] ?? 0),
                'modules_completed' => (int) ($enrollment['modules_completed'] ?? 0),
                'modules_total' => (int) ($enrollment['modules_total'] ?? 0),
            ];
            $enrollment['latest_decision'] = $this->db->fetchOne(
                'SELECT sd.*, u.full_name AS leader_name
                 FROM supervisor_decisions sd
                 INNER JOIN users u ON u.id = sd.leader_id
                 WHERE sd.enrollment_id = ?
                 ORDER BY sd.created_at DESC
                 LIMIT 1',
                [$enrollment['id']],
            );
            $enrollment['latest_attempts'] = $this->db->fetchAll(
                'SELECT * FROM attempts WHERE enrollment_id = ? ORDER BY submitted_at DESC LIMIT 3',
                [$enrollment['id']],
            );
        }
        unset($enrollment);

        $notifications = $this->db->fetchAll(
            'SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 5',
            [$userId],
        );

        return [
            'user' => $user,
            'enrollments' => $enrollments,
            'notifications' => $notifications,
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getLeaderDashboard(string $leaderId): array
    {
        $team = $this->db->fetchAll(
            'SELECT u.*, c.name AS city_name, d.name AS department_name
             FROM users u
             LEFT JOIN cities c ON c.id = u.city_id
             LEFT JOIN departments d ON d.id = u.department_id
             WHERE u.supervisor_id = ?
             ORDER BY u.full_name ASC',
            [$leaderId],
        );

        foreach ($team as &$member) {
            $member['enrollments'] = $this->db->fetchAll(
                'SELECT e.*, co.title AS course_title, co.slug AS course_slug,
                        p.completion_percent, p.lessons_completed, p.lessons_total, p.modules_completed, p.modules_total
                 FROM enrollments e
                 INNER JOIN courses co ON co.id = e.course_id
                 LEFT JOIN progress p ON p.enrollment_id = e.id
                 WHERE e.user_id = ?
                 ORDER BY e.assigned_at DESC',
                [$member['id']],
            );

            foreach ($member['enrollments'] as &$enrollment) {
                $enrollment['latest_decision'] = $this->db->fetchOne(
                    'SELECT * FROM supervisor_decisions WHERE enrollment_id = ? ORDER BY created_at DESC LIMIT 1',
                    [$enrollment['id']],
                );
                $enrollment['latest_attempt'] = $this->db->fetchOne(
                    'SELECT * FROM attempts WHERE enrollment_id = ? ORDER BY submitted_at DESC LIMIT 1',
                    [$enrollment['id']],
                );
            }
            unset($enrollment);
        }
        unset($member);

        return $team;
    }

    /**
     * @return array<string, mixed>
     */
    public function getLeaderEmployeeDetail(string $employeeId, string $leaderId): array
    {
        $employee = $this->db->fetchOne(
            'SELECT u.*, c.name AS city_name, d.name AS department_name
             FROM users u
             LEFT JOIN cities c ON c.id = u.city_id
             LEFT JOIN departments d ON d.id = u.department_id
             WHERE u.id = ? AND u.supervisor_id = ?
             LIMIT 1',
            [$employeeId, $leaderId],
        );

        if ($employee === null) {
            throw new RuntimeException('Employee not found.');
        }

        $employee['enrollments'] = $this->fetchEmployeeEnrollments($employeeId);

        return $employee;
    }

    /**
     * @return array<string, mixed>
     */
    public function getAdminDashboard(): array
    {
        $counts = [
            'users' => (int) ($this->db->fetchOne('SELECT COUNT(*) AS total FROM users')['total'] ?? 0),
            'courses' => (int) ($this->db->fetchOne('SELECT COUNT(*) AS total FROM courses')['total'] ?? 0),
            'enrollments' => (int) ($this->db->fetchOne('SELECT COUNT(*) AS total FROM enrollments')['total'] ?? 0),
            'media' => (int) ($this->db->fetchOne('SELECT COUNT(*) AS total FROM media_assets')['total'] ?? 0),
        ];

        return [
            'counts' => $counts,
            'recent_courses' => $this->db->fetchAll(
                'SELECT c.*, cc.title AS category_title,
                        (SELECT COUNT(*) FROM modules m WHERE m.course_id = c.id) AS modules_count
                 FROM courses c
                 INNER JOIN course_categories cc ON cc.id = c.category_id
                 ORDER BY c.updated_at DESC
                 LIMIT 6'
            ),
            'recent_users' => $this->db->fetchAll(
                'SELECT u.*, r.key AS role_key, c.name AS city_name, d.name AS department_name
                 FROM users u
                 INNER JOIN roles r ON r.id = u.role_id
                 LEFT JOIN cities c ON c.id = u.city_id
                 LEFT JOIN departments d ON d.id = u.department_id
                 ORDER BY u.created_at DESC
                 LIMIT 6'
            ),
            'results' => $this->db->fetchAll(
                'SELECT e.*, u.full_name, c.title AS course_title, p.completion_percent
                 FROM enrollments e
                 INNER JOIN users u ON u.id = e.user_id
                 INNER JOIN courses c ON c.id = e.course_id
                 LEFT JOIN progress p ON p.enrollment_id = e.id
                 ORDER BY e.assigned_at DESC
                 LIMIT 8'
            ),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getAdminResources(): array
    {
        return [
            'users' => $this->db->fetchAll(
                'SELECT u.*, r.key AS role_key, r.name AS role_name,
                        c.name AS city_name, d.name AS department_name, s.full_name AS supervisor_name
                 FROM users u
                 INNER JOIN roles r ON r.id = u.role_id
                 LEFT JOIN cities c ON c.id = u.city_id
                 LEFT JOIN departments d ON d.id = u.department_id
                 LEFT JOIN users s ON s.id = u.supervisor_id
                 ORDER BY u.full_name ASC'
            ),
            'courses' => $this->getAdminCoursesList(),
            'categories' => $this->db->fetchAll('SELECT * FROM course_categories ORDER BY sort_order ASC'),
            'media' => $this->db->fetchAll('SELECT * FROM media_assets ORDER BY created_at DESC LIMIT 50'),
            'questions' => $this->getQuestionBank(),
            'enrollments' => $this->db->fetchAll(
                'SELECT e.*, u.full_name, r.key AS role_key, r.name AS role_name, c.title AS course_title, p.completion_percent
                 FROM enrollments e
                 INNER JOIN users u ON u.id = e.user_id
                 INNER JOIN roles r ON r.id = u.role_id
                 INNER JOIN courses c ON c.id = e.course_id
                 LEFT JOIN progress p ON p.enrollment_id = e.id
                 ORDER BY e.assigned_at DESC'
            ),
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAdminResultSummaries(): array
    {
        $users = $this->db->fetchAll(
            'SELECT DISTINCT u.id, u.full_name, c.name AS city_name, d.name AS department_name
             FROM users u
             INNER JOIN enrollments e ON e.user_id = u.id
             LEFT JOIN cities c ON c.id = u.city_id
             LEFT JOIN departments d ON d.id = u.department_id
             ORDER BY u.full_name ASC'
        );

        foreach ($users as &$user) {
            $user['enrollments'] = $this->db->fetchAll(
                'SELECT e.*, p.completion_percent
                 FROM enrollments e
                 LEFT JOIN progress p ON p.enrollment_id = e.id
                 WHERE e.user_id = ?
                 ORDER BY e.assigned_at DESC',
                [$user['id']],
            );

            $latestDecision = null;
            foreach ($user['enrollments'] as &$enrollment) {
                $decision = $this->db->fetchOne(
                    'SELECT * FROM supervisor_decisions WHERE enrollment_id = ? ORDER BY created_at DESC LIMIT 1',
                    [$enrollment['id']],
                );
                $enrollment['latest_decision'] = $decision;
                if ($latestDecision === null && $decision !== null) {
                    $latestDecision = $decision;
                }
            }
            unset($enrollment);
            $user['latest_decision'] = $latestDecision;
        }
        unset($user);

        return $users;
    }

    /**
     * @return array<string, mixed>
     */
    public function getAdminEmployeeResultDetail(string $userId): array
    {
        $employee = $this->db->fetchOne(
            'SELECT u.*, c.name AS city_name, d.name AS department_name, s.full_name AS supervisor_name
             FROM users u
             LEFT JOIN cities c ON c.id = u.city_id
             LEFT JOIN departments d ON d.id = u.department_id
             LEFT JOIN users s ON s.id = u.supervisor_id
             WHERE u.id = ?
             LIMIT 1',
            [$userId],
        );

        if ($employee === null) {
            throw new RuntimeException('Employee not found.');
        }

        $employee['enrollments'] = $this->fetchEmployeeEnrollments($userId);

        return $employee;
    }

    /**
     * @return array<string, mixed>
     */
    public function getUserById(string $userId): array
    {
        $user = $this->db->fetchOne(
            'SELECT u.*, r.key AS role_key, r.name AS role_name
             FROM users u
             INNER JOIN roles r ON r.id = u.role_id
             WHERE u.id = ?
             LIMIT 1',
            [$userId],
        );

        if ($user === null) {
            throw new RuntimeException('User not found.');
        }

        return $user;
    }

    /**
     * @return array<string, mixed>
     */
    public function getCourseEditorData(string $courseId): array
    {
        $course = $this->db->fetchOne('SELECT * FROM courses WHERE id = ? LIMIT 1', [$courseId]);
        if ($course === null) {
            throw new RuntimeException('Course not found.');
        }

        $modules = $this->db->fetchAll('SELECT * FROM modules WHERE course_id = ? ORDER BY sort_order ASC', [$courseId]);
        foreach ($modules as &$module) {
            $module['lessons'] = $this->db->fetchAll(
                'SELECT * FROM lessons WHERE module_id = ? ORDER BY sort_order ASC',
                [$module['id']],
            );
        }
        unset($module);

        $course['modules'] = $modules;

        return $course;
    }

    /**
     * @return array<string, mixed>
     */
    public function getLessonEditorData(string $lessonId): array
    {
        $lesson = $this->db->fetchOne(
            'SELECT l.*, m.title AS module_title, m.course_id, c.title AS course_title
             FROM lessons l
             INNER JOIN modules m ON m.id = l.module_id
             INNER JOIN courses c ON c.id = m.course_id
             WHERE l.id = ?
             LIMIT 1',
            [$lessonId],
        );

        if ($lesson === null) {
            throw new RuntimeException('Lesson not found.');
        }

        $lesson['blocks'] = $this->db->fetchAll(
            'SELECT * FROM lesson_blocks WHERE lesson_id = ? ORDER BY sort_order ASC',
            [$lessonId],
        );
        $lesson['video'] = $this->db->fetchOne(
            'SELECT lv.*, ma.id AS media_asset_id, ma.original_name, ma.size_bytes, ma.duration_sec
             FROM lesson_videos lv
             INNER JOIN media_assets ma ON ma.id = lv.media_asset_id
             WHERE lv.lesson_id = ?
             LIMIT 1',
            [$lessonId],
        );
        $lesson['attachments'] = $this->db->fetchAll(
            'SELECT la.*, ma.original_name, ma.size_bytes
             FROM lesson_attachments la
             INNER JOIN media_assets ma ON ma.id = la.asset_id
             WHERE la.lesson_id = ?
             ORDER BY la.sort_order ASC',
            [$lessonId],
        );
        $lesson['quiz'] = empty($lesson['quiz_id']) ? null : $this->getQuizById((string) $lesson['quiz_id']);

        return $lesson;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRoles(): array
    {
        return $this->db->fetchAll('SELECT * FROM roles ORDER BY name ASC');
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getQuestionBank(): array
    {
        $questions = $this->db->fetchAll('SELECT * FROM questions ORDER BY created_at DESC');
        foreach ($questions as &$question) {
            $question['options'] = $this->db->fetchAll(
                'SELECT * FROM answer_options WHERE question_id = ? ORDER BY sort_order ASC',
                [$question['id']],
            );
            $question['quiz_links'] = $this->db->fetchAll(
                'SELECT * FROM quiz_questions WHERE question_id = ?',
                [$question['id']],
            );
        }
        unset($question);

        return $questions;
    }

    /**
     * @return array<string, mixed>
     */
    public function getQuizById(string $quizId): array
    {
        $quiz = $this->db->fetchOne('SELECT * FROM quizzes WHERE id = ? LIMIT 1', [$quizId]);
        if ($quiz === null) {
            throw new RuntimeException('Quiz not found.');
        }

        $questions = $this->db->fetchAll(
            'SELECT qq.*, q.topic, q.prompt, q.question_type, q.explanation, q.meta_json
             FROM quiz_questions qq
             INNER JOIN questions q ON q.id = qq.question_id
             WHERE qq.quiz_id = ?
             ORDER BY qq.sort_order ASC',
            [$quizId],
        );

        foreach ($questions as &$item) {
            $item['options'] = $this->db->fetchAll(
                'SELECT * FROM answer_options WHERE question_id = ? ORDER BY sort_order ASC',
                [$item['question_id']],
            );
        }
        unset($item);

        $quiz['questions'] = $questions;

        return $quiz;
    }

    /**
     * @return array<string, mixed>
     */
    public function getQuizForAttempt(string $quizId): array
    {
        $quiz = $this->getQuizById($quizId);
        $relation = $this->db->fetchOne(
            'SELECT
                (SELECT id FROM courses WHERE final_quiz_id = ? LIMIT 1) AS final_course_id,
                (SELECT id FROM modules WHERE quiz_id = ? LIMIT 1) AS module_id,
                (SELECT id FROM lessons WHERE quiz_id = ? LIMIT 1) AS lesson_id',
            [$quizId, $quizId, $quizId],
        );

        $quiz['final_course_id'] = $relation['final_course_id'] ?? null;
        $quiz['module_id'] = $relation['module_id'] ?? null;
        $quiz['lesson_id'] = $relation['lesson_id'] ?? null;

        return $quiz;
    }

    private function getAdminCoursesList(): array
    {
        $courses = $this->db->fetchAll(
            'SELECT c.*, cc.title AS category_title
             FROM courses c
             INNER JOIN course_categories cc ON cc.id = c.category_id
             ORDER BY cc.sort_order ASC, c.title ASC'
        );

        foreach ($courses as &$course) {
            $modules = $this->db->fetchAll(
                'SELECT id, title, sort_order FROM modules WHERE course_id = ? ORDER BY sort_order ASC',
                [$course['id']],
            );
            $course['modules'] = $modules;
            $course['category'] = [
                'title' => $course['category_title'],
            ];
            $course['cities'] = $this->db->fetchAll(
                'SELECT cc.*, c.name FROM course_cities cc INNER JOIN cities c ON c.id = cc.city_id WHERE cc.course_id = ?',
                [$course['id']],
            );
            $course['departments'] = $this->db->fetchAll(
                'SELECT cd.*, d.name FROM course_departments cd INNER JOIN departments d ON d.id = cd.department_id WHERE cd.course_id = ?',
                [$course['id']],
            );
        }
        unset($course);

        return $courses;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function fetchEmployeeEnrollments(string $userId): array
    {
        $enrollments = $this->db->fetchAll(
            'SELECT e.*, c.title AS course_title, c.slug AS course_slug, c.id AS course_ref_id,
                    p.completion_percent, p.lessons_completed, p.lessons_total, p.modules_completed, p.modules_total,
                    p.last_activity_at
             FROM enrollments e
             INNER JOIN courses c ON c.id = e.course_id
             LEFT JOIN progress p ON p.enrollment_id = e.id
             WHERE e.user_id = ?
             ORDER BY e.assigned_at DESC',
            [$userId],
        );

        foreach ($enrollments as &$enrollment) {
            $enrollment['course_modules'] = $this->db->fetchAll(
                'SELECT * FROM modules WHERE course_id = ? ORDER BY sort_order ASC',
                [$enrollment['course_id']],
            );
            $enrollment['attempts'] = $this->db->fetchAll(
                'SELECT a.*, q.title AS quiz_title
                 FROM attempts a
                 INNER JOIN quizzes q ON q.id = a.quiz_id
                 WHERE a.enrollment_id = ?
                 ORDER BY a.submitted_at DESC',
                [$enrollment['id']],
            );
            $enrollment['decisions'] = $this->db->fetchAll(
                'SELECT sd.*, u.full_name AS leader_name
                 FROM supervisor_decisions sd
                 INNER JOIN users u ON u.id = sd.leader_id
                 WHERE sd.enrollment_id = ?
                 ORDER BY sd.created_at DESC',
                [$enrollment['id']],
            );
        }
        unset($enrollment);

        return $enrollments;
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     * @return array<string, array<int, array<string, mixed>>>
     */
    private function groupBy(array $rows, string $key): array
    {
        $grouped = [];
        foreach ($rows as $row) {
            $grouped[(string) $row[$key]][] = $row;
        }

        return $grouped;
    }

    private function placeholders(int $count): string
    {
        return implode(',', array_fill(0, $count, '?'));
    }
}
