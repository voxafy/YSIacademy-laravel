<?php

declare(strict_types=1);

namespace App\Services;

use App\Support\LegacyDb;
use RuntimeException;

final class AcademyWriteService
{
    public function __construct(
        private readonly LegacyDb $db,
    ) {
    }

    public function createUser(array $actor, array $data): string
    {
        $role = $this->requireRoleById((string) ($data['role_id'] ?? ''));
        if ($role['key'] === 'ADMIN' && ($actor['role_key'] ?? '') !== 'ADMIN') {
            throw new RuntimeException('Только администратор может создавать нового администратора.');
        }

        $fullName = trim((string) ($data['full_name'] ?? ''));
        $email = mb_strtolower(trim((string) ($data['email'] ?? '')));
        $password = trim((string) ($data['password'] ?? ''));

        if ($fullName === '' || $email === '' || $password === '') {
            throw new RuntimeException('Заполните обязательные поля нового пользователя.');
        }

        if ($this->emailExists($email)) {
            throw new RuntimeException('Пользователь с таким email уже существует.');
        }

        $this->assertDepartmentAllowedForRole($data['department_id'] ?? null, (string) $role['key']);

        $userId = str_id();
        $this->db->execute(
            'INSERT INTO users (
                id, email, full_name, phone, title, password_hash, approval_status,
                role_id, company_id, city_id, department_id, supervisor_id, bio, created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())',
            [
                $userId,
                $email,
                $fullName,
                $this->nullable($data['phone'] ?? null),
                $this->nullable($data['title'] ?? null),
                password_hash($password, PASSWORD_DEFAULT),
                $data['approval_status'] ?? 'ACTIVE',
                $role['id'],
                $actor['company_id'] ?? null,
                $this->nullable($data['city_id'] ?? null),
                $this->nullable($data['department_id'] ?? null),
                $this->nullable($data['supervisor_id'] ?? null),
                $this->nullable($data['bio'] ?? null),
            ]
        );

        $this->audit($actor['id'] ?? null, 'user.created', 'user', $userId, [
            'role_key' => $role['key'],
            'email' => $email,
        ]);

        return $userId;
    }

    public function updateUserAsAdmin(string $userId, array $data, ?string $actorId = null): void
    {
        $role = $this->requireRoleById((string) ($data['role_id'] ?? ''));
        $fullName = trim((string) ($data['full_name'] ?? ''));
        $email = mb_strtolower(trim((string) ($data['email'] ?? '')));

        if ($fullName === '' || $email === '') {
            throw new RuntimeException('Заполните обязательные поля профиля.');
        }

        if ($this->emailExists($email, $userId)) {
            throw new RuntimeException('Пользователь с таким email уже существует.');
        }

        $this->assertDepartmentAllowedForRole($data['department_id'] ?? null, (string) $role['key']);

        $params = [
            $email,
            $fullName,
            $this->nullable($data['phone'] ?? null),
            $this->nullable($data['title'] ?? null),
            $data['approval_status'] ?? 'ACTIVE',
            $role['id'],
            $this->nullable($data['city_id'] ?? null),
            $this->nullable($data['department_id'] ?? null),
            $this->nullable($data['supervisor_id'] ?? null),
            $this->nullable($data['bio'] ?? null),
        ];

        $sql = 'UPDATE users
                SET email = ?, full_name = ?, phone = ?, title = ?, approval_status = ?,
                    role_id = ?, city_id = ?, department_id = ?, supervisor_id = ?, bio = ?, updated_at = NOW()';

        $password = trim((string) ($data['password'] ?? ''));
        if ($password !== '') {
            $sql .= ', password_hash = ?';
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }

        $sql .= ' WHERE id = ?';
        $params[] = $userId;

        $this->db->execute($sql, $params);
        $this->audit($actorId, 'user.updated', 'user', $userId, ['role_key' => $role['key']]);
    }

    public function updateOwnProfile(string $userId, array $data): void
    {
        $current = $this->db->fetchOne(
            'SELECT u.id, r.key AS role_key
             FROM users u
             INNER JOIN roles r ON r.id = u.role_id
             WHERE u.id = ?
             LIMIT 1',
            [$userId],
        );

        if ($current === null) {
            throw new RuntimeException('Пользователь не найден.');
        }

        $fullName = trim((string) ($data['full_name'] ?? ''));
        $email = mb_strtolower(trim((string) ($data['email'] ?? '')));

        if ($fullName === '' || $email === '') {
            throw new RuntimeException('Заполните ФИО и email.');
        }

        if ($this->emailExists($email, $userId)) {
            throw new RuntimeException('Пользователь с таким email уже существует.');
        }

        $this->assertDepartmentAllowedForRole($data['department_id'] ?? null, (string) $current['role_key']);

        $params = [
            $email,
            $fullName,
            $this->nullable($data['phone'] ?? null),
            $this->nullable($data['title'] ?? null),
            $this->nullable($data['bio'] ?? null),
            $this->nullable($data['city_id'] ?? null),
            $this->nullable($data['department_id'] ?? null),
            $this->nullable($data['supervisor_id'] ?? null),
        ];

        $sql = 'UPDATE users
                SET email = ?, full_name = ?, phone = ?, title = ?, bio = ?,
                    city_id = ?, department_id = ?, supervisor_id = ?, updated_at = NOW()';

        $password = trim((string) ($data['password'] ?? ''));
        if ($password !== '') {
            $sql .= ', password_hash = ?';
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }

        $sql .= ' WHERE id = ?';
        $params[] = $userId;

        $this->db->execute($sql, $params);
        $this->audit($userId, 'profile.updated', 'user', $userId, []);
    }

    public function createLeaderTrainee(string $leaderId, array $data): string
    {
        $leader = $this->db->fetchOne('SELECT * FROM users WHERE id = ? LIMIT 1', [$leaderId]);
        if ($leader === null) {
            throw new RuntimeException('Руководитель не найден.');
        }

        $studentRole = $this->requireRoleByKey('STUDENT');
        $fullName = trim((string) ($data['full_name'] ?? ''));
        $email = mb_strtolower(trim((string) ($data['email'] ?? '')));
        $password = trim((string) ($data['password'] ?? ''));
        $title = trim((string) ($data['title'] ?? ''));

        if ($fullName === '' || $email === '' || $password === '' || $title === '' || empty($data['city_id']) || empty($data['department_id'])) {
            throw new RuntimeException('Заполните данные нового сотрудника.');
        }

        if ($this->emailExists($email)) {
            throw new RuntimeException('Пользователь с таким email уже существует.');
        }

        $this->assertDepartmentAllowedForRole($data['department_id'] ?? null, 'STUDENT');

        $userId = str_id();
        $this->db->execute(
            'INSERT INTO users (
                id, email, full_name, phone, title, password_hash, approval_status,
                role_id, company_id, city_id, department_id, supervisor_id, created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())',
            [
                $userId,
                $email,
                $fullName,
                $this->nullable($data['phone'] ?? null),
                $title,
                password_hash($password, PASSWORD_DEFAULT),
                'ACTIVE',
                $studentRole['id'],
                $leader['company_id'] ?? null,
                $data['city_id'],
                $data['department_id'],
                $leaderId,
            ]
        );

        $this->audit($leaderId, 'leader.trainee.created', 'user', $userId, ['email' => $email]);

        return $userId;
    }

    public function registerStudent(array $data): string
    {
        $studentRole = $this->requireRoleByKey('STUDENT');
        $company = $this->db->fetchOne('SELECT * FROM companies ORDER BY created_at ASC LIMIT 1');
        if ($company === null) {
            throw new RuntimeException('Система не готова к регистрации. Сначала импортируйте demo-данные.');
        }

        $fullName = trim((string) ($data['full_name'] ?? ''));
        $email = mb_strtolower(trim((string) ($data['email'] ?? '')));
        $password = trim((string) ($data['password'] ?? ''));
        $title = trim((string) ($data['title'] ?? ''));

        if ($fullName === '' || $email === '' || $password === '' || $title === '' || empty($data['city_id']) || empty($data['department_id'])) {
            throw new RuntimeException('Заполните обязательные поля регистрации.');
        }

        if ($this->emailExists($email)) {
            throw new RuntimeException('Пользователь с таким email уже существует.');
        }

        $this->assertDepartmentAllowedForRole($data['department_id'] ?? null, 'STUDENT');

        $userId = str_id();
        $this->db->execute(
            'INSERT INTO users (
                id, email, full_name, phone, title, password_hash, approval_status,
                role_id, company_id, city_id, department_id, supervisor_id, created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())',
            [
                $userId,
                $email,
                $fullName,
                $this->nullable($data['phone'] ?? null),
                $title,
                password_hash($password, PASSWORD_DEFAULT),
                'ACTIVE',
                $studentRole['id'],
                $company['id'],
                $data['city_id'],
                $data['department_id'],
                $this->nullable($data['supervisor_id'] ?? null),
            ]
        );

        return $userId;
    }

    public function updateLeaderEmployee(string $leaderId, string $userId, array $data): void
    {
        $employee = $this->db->fetchOne(
            'SELECT id FROM users WHERE id = ? AND supervisor_id = ? LIMIT 1',
            [$userId, $leaderId],
        );

        if ($employee === null) {
            throw new RuntimeException('Сотрудник не найден в вашей команде.');
        }

        $fullName = trim((string) ($data['full_name'] ?? ''));
        $email = mb_strtolower(trim((string) ($data['email'] ?? '')));
        $title = trim((string) ($data['title'] ?? ''));
        if ($fullName === '' || $email === '' || $title === '' || empty($data['city_id']) || empty($data['department_id'])) {
            throw new RuntimeException('Заполните обязательные поля профиля сотрудника.');
        }

        if ($this->emailExists($email, $userId)) {
            throw new RuntimeException('Пользователь с таким email уже существует.');
        }

        $this->assertDepartmentAllowedForRole($data['department_id'] ?? null, 'STUDENT');

        $params = [
            $email,
            $fullName,
            $this->nullable($data['phone'] ?? null),
            $title,
            $data['city_id'],
            $data['department_id'],
        ];

        $sql = 'UPDATE users
                SET email = ?, full_name = ?, phone = ?, title = ?, city_id = ?, department_id = ?, updated_at = NOW()';

        $password = trim((string) ($data['password'] ?? ''));
        if ($password !== '') {
            $sql .= ', password_hash = ?';
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }

        $sql .= ' WHERE id = ? AND supervisor_id = ?';
        $params[] = $userId;
        $params[] = $leaderId;

        $this->db->execute($sql, $params);
        $this->audit($leaderId, 'leader.employee.updated', 'user', $userId, []);
    }

    public function createCourse(string $adminId, array $data): string
    {
        $admin = $this->db->fetchOne('SELECT * FROM users WHERE id = ? LIMIT 1', [$adminId]);
        if ($admin === null) {
            throw new RuntimeException('Администратор не найден.');
        }

        $title = trim((string) ($data['title'] ?? ''));
        $slug = trim((string) ($data['slug'] ?? ''));
        $categoryId = trim((string) ($data['category_id'] ?? ''));
        $description = trim((string) ($data['description'] ?? ''));
        $targetAudience = trim((string) ($data['target_audience'] ?? ''));

        if ($title === '' || $categoryId === '') {
            throw new RuntimeException('Недостаточно данных для создания курса.');
        }

        $slug = $slug !== '' ? $slug : to_slug($title);
        if ($this->db->fetchOne('SELECT id FROM courses WHERE slug = ? LIMIT 1', [$slug]) !== null) {
            throw new RuntimeException('Курс с таким slug уже существует.');
        }

        $courseId = str_id();
        $this->db->execute(
            'INSERT INTO courses (
                id, slug, title, subtitle, short_description, description, hero_title, hero_description,
                target_audience, accent_color, dark_accent_color, status, is_template, estimated_minutes,
                pass_score, category_id, company_id, created_by_id, created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?, ?, ?, ?, ?, NOW(), NOW())',
            [
                $courseId,
                $slug,
                $title,
                $targetAudience !== '' ? $targetAudience : 'Новый курс',
                $description !== '' ? $description : 'Новый курс без краткого описания.',
                $description !== '' ? $description : 'Заполните описание курса через редактор.',
                $title,
                $description !== '' ? $description : 'Новый курс создан в редакторе.',
                $targetAudience !== '' ? $targetAudience : 'Сотрудники клиента',
                '#1264f2',
                '#0b1d44',
                'DRAFT',
                70,
                $categoryId,
                $admin['company_id'] ?? null,
                $adminId,
            ]
        );

        if (!empty($data['city_id'])) {
            $this->db->execute(
                'INSERT INTO course_cities (id, course_id, city_id) VALUES (?, ?, ?)',
                [str_id(), $courseId, $data['city_id']],
            );
        }

        if (!empty($data['department_id'])) {
            $this->db->execute(
                'INSERT INTO course_departments (id, course_id, department_id) VALUES (?, ?, ?)',
                [str_id(), $courseId, $data['department_id']],
            );
        }

        $this->audit($adminId, 'course.created', 'course', $courseId, ['title' => $title]);

        return $courseId;
    }

    public function duplicateCourse(string $courseId, array $source): string
    {
        $finalQuizId = $this->cloneQuiz($source['final_quiz_id'] ?? null);
        $newCourseId = str_id();
        $slug = (string) $source['slug'] . '-' . time();

        $this->db->execute(
            'INSERT INTO courses (
                id, slug, title, subtitle, short_description, description, hero_title, hero_description,
                target_audience, accent_color, dark_accent_color, status, is_template, estimated_minutes,
                pass_score, category_id, company_id, created_by_id, final_quiz_id, template_source_id, created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())',
            [
                $newCourseId,
                $slug,
                $source['title'] . ' (копия)',
                $source['subtitle'],
                $source['short_description'],
                $source['description'],
                $source['hero_title'],
                $source['hero_description'],
                $source['target_audience'],
                $source['accent_color'],
                $source['dark_accent_color'],
                'DRAFT',
                $source['is_template'],
                $source['estimated_minutes'],
                $source['pass_score'],
                $source['category_id'],
                $source['company_id'],
                $source['created_by_id'],
                $finalQuizId,
                $source['id'],
            ]
        );

        foreach ($source['cities'] as $city) {
            $this->db->execute(
                'INSERT INTO course_cities (id, course_id, city_id) VALUES (?, ?, ?)',
                [str_id(), $newCourseId, $city['city_id']],
            );
        }

        foreach ($source['departments'] as $department) {
            $this->db->execute(
                'INSERT INTO course_departments (id, course_id, department_id) VALUES (?, ?, ?)',
                [str_id(), $newCourseId, $department['department_id']],
            );
        }

        foreach ($source['modules'] as $module) {
            $newModuleId = str_id();
            $this->db->execute(
                'INSERT INTO modules (
                    id, course_id, title, description, summary, sort_order, estimated_minutes, pass_score, is_published, created_at, updated_at
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())',
                [
                    $newModuleId,
                    $newCourseId,
                    $module['title'],
                    $module['description'],
                    $module['summary'],
                    $module['sort_order'],
                    $module['estimated_minutes'],
                    $module['pass_score'],
                    $module['is_published'],
                ]
            );

            foreach ($module['lessons'] as $lesson) {
                $lessonBlocks = $this->db->fetchAll(
                    'SELECT * FROM lesson_blocks WHERE lesson_id = ? ORDER BY sort_order ASC',
                    [$lesson['id']],
                );
                $newLessonId = str_id();
                $this->db->execute(
                    'INSERT INTO lessons (
                        id, module_id, title, slug, description, summary, sort_order, lesson_type,
                        estimated_minutes, is_required, created_at, updated_at
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())',
                    [
                        $newLessonId,
                        $newModuleId,
                        $lesson['title'],
                        (string) $lesson['slug'] . '-' . time(),
                        $lesson['description'],
                        $lesson['summary'],
                        $lesson['sort_order'],
                        $lesson['lesson_type'],
                        $lesson['estimated_minutes'],
                        $lesson['is_required'],
                    ]
                );

                foreach ($lessonBlocks as $block) {
                    $this->db->execute(
                        'INSERT INTO lesson_blocks (id, lesson_id, block_type, title, body, payload, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)',
                        [str_id(), $newLessonId, $block['block_type'], $block['title'], $block['body'], $block['payload'], $block['sort_order']],
                    );
                }
            }
        }

        return $newCourseId;
    }

    public function deleteCourse(string $courseId, array $course): void
    {
        $moduleQuizIds = $this->db->fetchAll(
            'SELECT quiz_id FROM modules WHERE course_id = ? AND quiz_id IS NOT NULL',
            [$courseId],
        );
        $lessonQuizIds = $this->db->fetchAll(
            'SELECT l.quiz_id
             FROM lessons l
             INNER JOIN modules m ON m.id = l.module_id
             WHERE m.course_id = ? AND l.quiz_id IS NOT NULL',
            [$courseId],
        );

        $quizIds = array_values(array_unique(array_filter(array_merge(
            [$course['final_quiz_id'] ?? null],
            array_column($moduleQuizIds, 'quiz_id'),
            array_column($lessonQuizIds, 'quiz_id'),
        ))));

        $this->db->transaction(function () use ($courseId, $quizIds): void {
            $this->db->execute('UPDATE media_assets SET course_id = NULL WHERE course_id = ?', [$courseId]);
            $this->db->execute('DELETE FROM courses WHERE id = ?', [$courseId]);

            if ($quizIds !== []) {
                $this->db->execute(
                    sprintf('DELETE FROM quizzes WHERE id IN (%s)', $this->placeholders(count($quizIds))),
                    $quizIds,
                );
            }
        });
    }

    public function updateCourse(string $courseId, array $data): void
    {
        $title = trim((string) ($data['title'] ?? ''));
        if ($title === '') {
            throw new RuntimeException('Название курса обязательно.');
        }

        $this->db->execute(
            "UPDATE courses
             SET title = ?, subtitle = ?, short_description = ?, description = ?, hero_title = ?, hero_description = ?,
                 target_audience = ?, status = ?, updated_at = NOW()
             WHERE id = ?",
            [
                $title,
                trim((string) ($data['subtitle'] ?? '')),
                trim((string) ($data['short_description'] ?? '')),
                trim((string) ($data['description'] ?? '')),
                $title,
                trim((string) (($data['short_description'] ?? '') ?: ($data['description'] ?? ''))),
                trim((string) ($data['target_audience'] ?? '')),
                $data['status'] ?? 'DRAFT',
                $courseId,
            ]
        );
    }

    public function createModule(string $courseId, array $data): string
    {
        $title = trim((string) ($data['title'] ?? ''));
        $description = trim((string) ($data['description'] ?? ''));
        if ($title === '' || $description === '') {
            throw new RuntimeException('Укажите название и описание модуля.');
        }

        $count = $this->db->fetchOne('SELECT COUNT(*) AS total FROM modules WHERE course_id = ?', [$courseId]);
        $moduleId = str_id();

        $this->db->execute(
            'INSERT INTO modules (
                id, course_id, title, description, summary, sort_order, estimated_minutes, pass_score, is_published, created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, NOW(), NOW())',
            [
                $moduleId,
                $courseId,
                $title,
                $description,
                $description,
                (int) ($count['total'] ?? 0) + 1,
                15,
                70,
            ]
        );

        return $moduleId;
    }

    public function deleteModule(string $moduleId): string
    {
        $module = $this->db->fetchOne('SELECT * FROM modules WHERE id = ? LIMIT 1', [$moduleId]);
        if ($module === null) {
            throw new RuntimeException('Модуль не найден.');
        }

        $lessonQuizIds = $this->db->fetchAll('SELECT quiz_id FROM lessons WHERE module_id = ? AND quiz_id IS NOT NULL', [$moduleId]);
        $quizIds = array_values(array_unique(array_filter(array_merge(
            [$module['quiz_id'] ?? null],
            array_column($lessonQuizIds, 'quiz_id'),
        ))));

        $courseId = (string) $module['course_id'];

        $this->db->transaction(function () use ($moduleId, $quizIds): void {
            $this->db->execute('DELETE FROM modules WHERE id = ?', [$moduleId]);

            if ($quizIds !== []) {
                $this->db->execute(
                    sprintf('DELETE FROM quizzes WHERE id IN (%s)', $this->placeholders(count($quizIds))),
                    $quizIds,
                );
            }
        });

        return $courseId;
    }

    public function createLesson(string $moduleId, array $data): string
    {
        $title = trim((string) ($data['title'] ?? ''));
        $description = trim((string) ($data['description'] ?? ''));
        $type = trim((string) ($data['lesson_type'] ?? 'MIXED'));

        if ($title === '' || $description === '') {
            throw new RuntimeException('Укажите название и описание урока.');
        }

        $count = $this->db->fetchOne('SELECT COUNT(*) AS total FROM lessons WHERE module_id = ?', [$moduleId]);
        $lessonId = str_id();

        $this->db->execute(
            'INSERT INTO lessons (
                id, module_id, title, slug, description, summary, sort_order, lesson_type,
                estimated_minutes, is_required, created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, NOW(), NOW())',
            [
                $lessonId,
                $moduleId,
                $title,
                to_slug($title) . '-' . time(),
                $description,
                $description,
                (int) ($count['total'] ?? 0) + 1,
                $type,
                12,
            ]
        );

        return $lessonId;
    }

    public function updateLesson(string $lessonId, array $data): void
    {
        $title = trim((string) ($data['title'] ?? ''));
        $description = trim((string) ($data['description'] ?? ''));
        $type = trim((string) ($data['lesson_type'] ?? 'MIXED'));

        if ($title === '' || $description === '') {
            throw new RuntimeException('Название и описание урока обязательны.');
        }

        $this->db->execute(
            'UPDATE lessons
             SET title = ?, description = ?, summary = ?, lesson_type = ?, updated_at = NOW()
             WHERE id = ?',
            [$title, $description, $description, $type, $lessonId]
        );

        $this->upsertLessonBlock($lessonId, 'RICH_TEXT', 'Основной материал', trim((string) ($data['body'] ?? '')), 1);
        $this->upsertLessonBlock($lessonId, 'RULES', 'Правила модуля', trim((string) ($data['rules_body'] ?? '')), 2);
        $this->upsertLessonBlock($lessonId, 'MISTAKES', 'Типичные ошибки', trim((string) ($data['mistakes_body'] ?? '')), 3);
    }

    public function deleteLesson(string $lessonId): string
    {
        $lesson = $this->db->fetchOne(
            'SELECT l.*, m.course_id, m.quiz_id AS module_quiz_id
             FROM lessons l
             INNER JOIN modules m ON m.id = l.module_id
             WHERE l.id = ? LIMIT 1',
            [$lessonId],
        );

        if ($lesson === null) {
            throw new RuntimeException('Урок не найден.');
        }

        if (!empty($lesson['quiz_id']) && $lesson['module_quiz_id'] === $lesson['quiz_id']) {
            $this->db->execute('UPDATE modules SET quiz_id = NULL, updated_at = NOW() WHERE id = ?', [$lesson['module_id']]);
        }

        $this->db->execute('DELETE FROM lessons WHERE id = ?', [$lessonId]);

        if (!empty($lesson['quiz_id'])) {
            $this->db->execute('DELETE FROM quizzes WHERE id = ?', [$lesson['quiz_id']]);
        }

        return (string) $lesson['course_id'];
    }

    /**
     * @param array<int, string> $questionIds
     */
    public function upsertLessonQuiz(string $lessonId, array $questionIds, string $title, string $description, int $passScore): void
    {
        if ($title === '' || $questionIds === []) {
            throw new RuntimeException('Укажите название теста и минимум один вопрос.');
        }

        $lesson = $this->db->fetchOne(
            'SELECT l.*, m.id AS module_ref_id, m.quiz_id AS module_quiz_id, m.pass_score AS module_pass_score
             FROM lessons l
             INNER JOIN modules m ON m.id = l.module_id
             WHERE l.id = ? LIMIT 1',
            [$lessonId],
        );

        if ($lesson === null) {
            throw new RuntimeException('Урок не найден.');
        }

        $questions = $this->db->fetchAll(
            sprintf('SELECT id FROM questions WHERE id IN (%s)', $this->placeholders(count($questionIds))),
            $questionIds,
        );
        if (count($questions) !== count($questionIds)) {
            throw new RuntimeException('Часть вопросов не найдена в банке вопросов.');
        }

        $quizId = !empty($lesson['quiz_id']) ? (string) $lesson['quiz_id'] : str_id();
        if (!empty($lesson['quiz_id'])) {
            $this->db->execute(
                'UPDATE quizzes SET title = ?, description = ?, pass_score = ?, scope = ?, updated_at = NOW() WHERE id = ?',
                [$title, $description, $passScore, 'LESSON', $quizId],
            );
        } else {
            $this->db->execute(
                'INSERT INTO quizzes (id, title, description, scope, pass_score, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())',
                [$quizId, $title, $description, 'LESSON', $passScore],
            );
        }

        $this->db->execute('DELETE FROM quiz_questions WHERE quiz_id = ?', [$quizId]);
        foreach (array_values($questionIds) as $index => $questionId) {
            $this->db->execute(
                'INSERT INTO quiz_questions (id, quiz_id, question_id, sort_order, points) VALUES (?, ?, ?, ?, 1)',
                [str_id(), $quizId, $questionId, $index + 1],
            );
        }

        $this->db->execute(
            'UPDATE lessons SET quiz_id = ?, lesson_type = ?, updated_at = NOW() WHERE id = ?',
            [$quizId, 'QUIZ', $lessonId],
        );

        if (empty($lesson['module_quiz_id']) || $lesson['module_quiz_id'] === $lesson['quiz_id']) {
            $this->db->execute(
                'UPDATE modules SET quiz_id = ?, pass_score = ?, updated_at = NOW() WHERE id = ?',
                [$quizId, $passScore > 0 ? $passScore : (int) $lesson['module_pass_score'], $lesson['module_ref_id']],
            );
        }
    }

    public function createQuestion(array $data): string
    {
        $prompt = trim((string) ($data['prompt'] ?? ''));
        $type = trim((string) ($data['question_type'] ?? 'SINGLE'));
        $explanation = trim((string) ($data['explanation'] ?? ''));
        $options = $data['options'] ?? [];
        $correctIndexes = $data['correct_indexes'] ?? [];

        if ($prompt === '' || count($options) < 2) {
            throw new RuntimeException('Заполните вопрос и минимум два варианта ответа.');
        }

        $questionId = str_id();
        $this->db->execute(
            'INSERT INTO questions (id, topic, prompt, question_type, explanation, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())',
            [$questionId, 'manual', $prompt, $type, $explanation],
        );

        foreach (array_values($options) as $index => $option) {
            $this->db->execute(
                'INSERT INTO answer_options (id, question_id, label, is_correct, sort_order) VALUES (?, ?, ?, ?, ?)',
                [str_id(), $questionId, $option, in_array($index, $correctIndexes, true) ? 1 : 0, $index + 1],
            );
        }

        return $questionId;
    }

    public function assignCourse(string $userId, string $courseId, ?string $assignedById = null): string
    {
        $existing = $this->db->fetchOne(
            'SELECT id FROM enrollments WHERE user_id = ? AND course_id = ? LIMIT 1',
            [$userId, $courseId],
        );

        if ($existing !== null) {
            return (string) $existing['id'];
        }

        $enrollmentId = str_id();
        $this->db->execute(
            'INSERT INTO enrollments (id, user_id, course_id, assigned_by_id, status, assigned_at) VALUES (?, ?, ?, ?, ?, NOW())',
            [$enrollmentId, $userId, $courseId, $assignedById, 'NOT_STARTED'],
        );

        $this->recalculateEnrollment($enrollmentId);

        return $enrollmentId;
    }

    public function submitLeaderDecision(string $leaderId, string $enrollmentId, string $decision, string $comment = ''): void
    {
        if ($decision === '') {
            throw new RuntimeException('Выберите решение руководителя.');
        }

        $this->db->execute(
            'INSERT INTO supervisor_decisions (id, enrollment_id, leader_id, decision, comment, created_at) VALUES (?, ?, ?, ?, ?, NOW())',
            [str_id(), $enrollmentId, $leaderId, $decision, $this->nullable($comment)],
        );

        $this->recalculateEnrollment($enrollmentId);
    }

    public function markLessonComplete(string $userId, string $lessonId): string
    {
        $lesson = $this->db->fetchOne(
            'SELECT l.id, m.course_id
             FROM lessons l
             INNER JOIN modules m ON m.id = l.module_id
             WHERE l.id = ? LIMIT 1',
            [$lessonId],
        );

        if ($lesson === null) {
            throw new RuntimeException('Урок не найден.');
        }

        $enrollment = $this->db->fetchOne(
            'SELECT * FROM enrollments WHERE user_id = ? AND course_id = ? LIMIT 1',
            [$userId, $lesson['course_id']],
        );

        if ($enrollment === null) {
            throw new RuntimeException('Курс не назначен текущему пользователю.');
        }

        $this->upsertLessonProgress(
            $userId,
            $lessonId,
            (string) $enrollment['id'],
            100,
            true,
        );

        $this->recalculateEnrollment((string) $enrollment['id']);

        return (string) $enrollment['id'];
    }

    /**
     * @param array<string, mixed> $submitted
     * @return array{passed: bool, percentage: int, score: int, max_score: int, enrollment_id: string}
     */
    public function submitQuiz(array $quiz, string $userId, array $submitted): array
    {
        $courseId = $quiz['final_course_id'] ?? ($quiz['module']['course_id'] ?? null) ?? ($quiz['lesson']['course_id'] ?? null);

        if (!is_string($courseId) || $courseId === '') {
            throw new RuntimeException('Не удалось определить курс для этой попытки.');
        }

        $enrollment = $this->db->fetchOne(
            'SELECT * FROM enrollments WHERE user_id = ? AND course_id = ? LIMIT 1',
            [$userId, $courseId],
        );

        if ($enrollment === null) {
            throw new RuntimeException('Курс не назначен текущему пользователю.');
        }

        $score = 0;
        $maxScore = count($quiz['questions']);
        $answersPayload = [];

        foreach ($quiz['questions'] as $item) {
            $questionId = (string) $item['question_id'];
            $questionType = (string) $item['question_type'];
            $correctOptions = array_values(array_filter($item['options'], static fn (array $option): bool => (int) $option['is_correct'] === 1));
            $isCorrect = false;

            if (in_array($questionType, ['SINGLE', 'BOOLEAN', 'CASE'], true)) {
                $selected = (string) ($submitted['question-' . $questionId] ?? '');
                $answersPayload[$questionId] = $selected;
                foreach ($correctOptions as $option) {
                    if ($option['id'] === $selected) {
                        $isCorrect = true;
                        break;
                    }
                }
            } elseif ($questionType === 'MULTIPLE') {
                $selected = $submitted['question-' . $questionId] ?? [];
                if (!is_array($selected)) {
                    $selected = [$selected];
                }
                sort($selected);
                $correct = array_map(static fn (array $option): string => (string) $option['id'], $correctOptions);
                sort($correct);
                $answersPayload[$questionId] = $selected;
                $isCorrect = count($selected) === count($correct) && $selected === $correct;
            } elseif ($questionType === 'MATCHING') {
                $submittedPairs = [];
                $isCorrect = true;
                foreach ($item['options'] as $option) {
                    $value = (string) ($submitted['question-' . $questionId . '-' . $option['id']] ?? '');
                    $submittedPairs[] = ['option_id' => $option['id'], 'value' => $value];
                    if ((string) ($option['match_key'] ?? '') !== $value) {
                        $isCorrect = false;
                    }
                }
                $answersPayload[$questionId] = $submittedPairs;
            }

            if ($isCorrect) {
                $score += (int) ($item['points'] ?? 1);
            }
        }

        $percentage = $maxScore > 0 ? (int) round(($score / $maxScore) * 100) : 0;
        $passed = $percentage >= (int) ($quiz['pass_score'] ?? 70);

        $this->db->execute(
            'INSERT INTO attempts (
                id, quiz_id, user_id, enrollment_id, status, score, max_score, percentage, passed, answers_json, started_at, submitted_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())',
            [
                str_id(),
                $quiz['id'],
                $userId,
                $enrollment['id'],
                'SUBMITTED',
                $score,
                $maxScore,
                $percentage,
                $passed ? 1 : 0,
                json_encode($answersPayload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            ]
        );

        if (!empty($quiz['lesson_id'])) {
            $this->upsertLessonProgress(
                $userId,
                (string) $quiz['lesson_id'],
                (string) $enrollment['id'],
                $passed ? 100 : 0,
                $passed,
            );
        }

        $this->recalculateEnrollment((string) $enrollment['id']);

        return [
            'passed' => $passed,
            'percentage' => $percentage,
            'score' => $score,
            'max_score' => $maxScore,
            'enrollment_id' => (string) $enrollment['id'],
        ];
    }

    public function recalculateEnrollment(string $enrollmentId): void
    {
        $enrollment = $this->db->fetchOne('SELECT * FROM enrollments WHERE id = ? LIMIT 1', [$enrollmentId]);
        if ($enrollment === null) {
            throw new RuntimeException('Назначение не найдено.');
        }

        $course = $this->db->fetchOne('SELECT * FROM courses WHERE id = ? LIMIT 1', [$enrollment['course_id']]);
        if ($course === null) {
            throw new RuntimeException('Курс не найден.');
        }

        $modules = $this->db->fetchAll(
            'SELECT * FROM modules WHERE course_id = ? ORDER BY sort_order ASC',
            [$course['id']],
        );
        $moduleIds = array_column($modules, 'id');
        $lessons = $moduleIds === []
            ? []
            : $this->db->fetchAll(
                sprintf('SELECT * FROM lessons WHERE module_id IN (%s) ORDER BY sort_order ASC', $this->placeholders(count($moduleIds))),
                $moduleIds,
            );
        $lessonsByModule = $this->groupBy($lessons, 'module_id');
        $lessonProgress = $this->db->fetchAll('SELECT * FROM lesson_progress WHERE enrollment_id = ?', [$enrollmentId]);
        $attempts = $this->db->fetchAll('SELECT * FROM attempts WHERE enrollment_id = ? ORDER BY submitted_at DESC, started_at DESC', [$enrollmentId]);
        $latestDecision = $this->db->fetchOne('SELECT * FROM supervisor_decisions WHERE enrollment_id = ? ORDER BY created_at DESC LIMIT 1', [$enrollmentId]);

        $lessonProgressMap = [];
        foreach ($lessonProgress as $item) {
            $lessonProgressMap[(string) $item['lesson_id']] = $item;
        }

        $lessonsCompleted = 0;
        $modulesCompleted = 0;
        $totalLessons = count($lessons);
        $totalModules = count($modules);

        foreach ($modules as $module) {
            $moduleLessons = $lessonsByModule[(string) $module['id']] ?? [];
            $completedLessonsForModule = 0;
            foreach ($moduleLessons as $lesson) {
                if (!empty($lessonProgressMap[(string) $lesson['id']]) && (int) $lessonProgressMap[(string) $lesson['id']]['is_completed'] === 1) {
                    $completedLessonsForModule++;
                }
            }

            $lessonsCompleted += $completedLessonsForModule;
            $lastModuleAttempt = $this->findAttemptByQuizId($attempts, (string) ($module['quiz_id'] ?? ''));
            $modulePassed = $completedLessonsForModule === count($moduleLessons)
                && (empty($module['quiz_id']) || !empty($lastModuleAttempt['passed']));
            $modulePercent = count($moduleLessons) > 0
                ? (int) round(($completedLessonsForModule / count($moduleLessons)) * 100)
                : 0;

            if ($modulePassed) {
                $modulesCompleted++;
            }

            $this->upsertModuleProgress(
                (string) $enrollment['user_id'],
                (string) $module['id'],
                $enrollmentId,
                $modulePercent,
                !empty($lastModuleAttempt['passed']) || empty($module['quiz_id']),
                $modulePassed,
                $completedLessonsForModule > 0,
            );
        }

        $completionPercent = $totalLessons > 0 ? (int) round(($lessonsCompleted / $totalLessons) * 100) : 0;
        $finalAttempt = $this->findAttemptByQuizId($attempts, (string) ($course['final_quiz_id'] ?? ''));
        $status = 'NOT_STARTED';

        if (($latestDecision['decision'] ?? null) === 'RECOMMEND_ACCESS') {
            $status = 'RECOMMENDED_FOR_ACCESS';
        } elseif (in_array($latestDecision['decision'] ?? '', ['REPEAT_TRAINING', 'RETRAIN'], true)) {
            $status = 'REPEAT_TRAINING';
        } elseif (empty($course['final_quiz_id']) && $totalLessons > 0 && $lessonsCompleted === $totalLessons) {
            $status = 'COMPLETED';
        } elseif (!empty($finalAttempt) && empty($finalAttempt['passed'])) {
            $status = 'FAILED';
        } elseif (!empty($finalAttempt['passed']) && $totalLessons > 0 && $lessonsCompleted === $totalLessons) {
            $status = 'SENT_TO_REVIEW';
        } elseif ($lessonsCompleted > 0 || $attempts !== []) {
            $status = 'IN_PROGRESS';
        }

        $lastLessonId = $this->latestCompletedLessonId($lessonProgress);

        $this->db->execute(
            'INSERT INTO progress (
                id, user_id, course_id, enrollment_id, completion_percent, lessons_completed, lessons_total,
                modules_completed, modules_total, status, last_lesson_id, last_activity_at, completed_at, created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ON DUPLICATE KEY UPDATE
                completion_percent = VALUES(completion_percent),
                lessons_completed = VALUES(lessons_completed),
                lessons_total = VALUES(lessons_total),
                modules_completed = VALUES(modules_completed),
                modules_total = VALUES(modules_total),
                status = VALUES(status),
                last_lesson_id = VALUES(last_lesson_id),
                last_activity_at = VALUES(last_activity_at),
                completed_at = VALUES(completed_at),
                updated_at = NOW()',
            [
                str_id(),
                $enrollment['user_id'],
                $enrollment['course_id'],
                $enrollmentId,
                $completionPercent,
                $lessonsCompleted,
                $totalLessons,
                $modulesCompleted,
                $totalModules,
                $status,
                $lastLessonId,
                $lessonsCompleted > 0 ? $this->now() : null,
                in_array($status, ['SENT_TO_REVIEW', 'RECOMMENDED_FOR_ACCESS', 'COMPLETED', 'REPEAT_TRAINING'], true) ? $this->now() : null,
            ]
        );

        $startedAt = $status === 'NOT_STARTED' ? null : ($enrollment['started_at'] ?: $this->now());
        $completedAt = in_array($status, ['SENT_TO_REVIEW', 'RECOMMENDED_FOR_ACCESS', 'COMPLETED', 'REPEAT_TRAINING'], true)
            ? $this->now()
            : null;

        $this->db->execute(
            'UPDATE enrollments SET status = ?, started_at = ?, completed_at = ? WHERE id = ?',
            [$status, $startedAt, $completedAt, $enrollmentId],
        );
    }

    private function requireRoleById(string $roleId): array
    {
        $role = $this->db->fetchOne('SELECT * FROM roles WHERE id = ? LIMIT 1', [$roleId]);
        if ($role === null) {
            throw new RuntimeException('Не удалось определить роль.');
        }

        return $role;
    }

    private function requireRoleByKey(string $roleKey): array
    {
        $role = $this->db->fetchOne('SELECT * FROM roles WHERE `key` = ? LIMIT 1', [$roleKey]);
        if ($role === null) {
            throw new RuntimeException('Роль не найдена.');
        }

        return $role;
    }

    private function assertDepartmentAllowedForRole(mixed $departmentId, string $roleKey): void
    {
        if (!is_string($departmentId) || $departmentId === '') {
            return;
        }

        $department = $this->db->fetchOne('SELECT slug FROM departments WHERE id = ? LIMIT 1', [$departmentId]);
        if (($department['slug'] ?? null) === 'administration' && $roleKey !== 'ADMIN') {
            throw new RuntimeException('Подразделение «Администрирование» доступно только для администраторов.');
        }
    }

    private function emailExists(string $email, ?string $ignoreUserId = null): bool
    {
        if ($ignoreUserId === null) {
            return $this->db->fetchOne('SELECT id FROM users WHERE email = ? LIMIT 1', [$email]) !== null;
        }

        return $this->db->fetchOne('SELECT id FROM users WHERE email = ? AND id <> ? LIMIT 1', [$email, $ignoreUserId]) !== null;
    }

    private function cloneQuiz(?string $quizId): ?string
    {
        if ($quizId === null || $quizId === '') {
            return null;
        }

        $quiz = $this->db->fetchOne('SELECT * FROM quizzes WHERE id = ? LIMIT 1', [$quizId]);
        if ($quiz === null) {
            return null;
        }

        $questionLinks = $this->db->fetchAll(
            'SELECT * FROM quiz_questions WHERE quiz_id = ? ORDER BY sort_order ASC',
            [$quizId],
        );

        $newQuizId = str_id();
        $this->db->execute(
            'INSERT INTO quizzes (id, title, description, scope, pass_score, max_attempts, shuffle_questions, created_at, updated_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())',
            [
                $newQuizId,
                $quiz['title'] . ' (копия)',
                $quiz['description'],
                $quiz['scope'],
                $quiz['pass_score'],
                $quiz['max_attempts'],
                $quiz['shuffle_questions'],
            ]
        );

        foreach ($questionLinks as $link) {
            $this->db->execute(
                'INSERT INTO quiz_questions (id, quiz_id, question_id, sort_order, points) VALUES (?, ?, ?, ?, ?)',
                [str_id(), $newQuizId, $link['question_id'], $link['sort_order'], $link['points']],
            );
        }

        return $newQuizId;
    }

    private function upsertLessonBlock(string $lessonId, string $blockType, string $title, string $body, int $sortOrder): void
    {
        $existing = $this->db->fetchOne(
            'SELECT id FROM lesson_blocks WHERE lesson_id = ? AND block_type = ? LIMIT 1',
            [$lessonId, $blockType],
        );

        if ($existing !== null) {
            $this->db->execute(
                'UPDATE lesson_blocks SET title = ?, body = ?, sort_order = ? WHERE id = ?',
                [$title, $body, $sortOrder, $existing['id']],
            );

            return;
        }

        $this->db->execute(
            'INSERT INTO lesson_blocks (id, lesson_id, block_type, title, body, payload, sort_order) VALUES (?, ?, ?, ?, ?, NULL, ?)',
            [str_id(), $lessonId, $blockType, $title, $body, $sortOrder],
        );
    }

    private function upsertLessonProgress(string $userId, string $lessonId, string $enrollmentId, int $watchedPercent, bool $completed): void
    {
        $now = $this->now();
        $this->db->execute(
            'INSERT INTO lesson_progress (
                id, user_id, lesson_id, enrollment_id, watched_percent, is_completed, completed_at, last_visited_at, created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ON DUPLICATE KEY UPDATE
                watched_percent = VALUES(watched_percent),
                is_completed = VALUES(is_completed),
                completed_at = VALUES(completed_at),
                last_visited_at = VALUES(last_visited_at),
                updated_at = NOW()',
            [
                str_id(),
                $userId,
                $lessonId,
                $enrollmentId,
                $watchedPercent,
                $completed ? 1 : 0,
                $completed ? $now : null,
                $now,
            ]
        );
    }

    private function upsertModuleProgress(
        string $userId,
        string $moduleId,
        string $enrollmentId,
        int $completionPercent,
        bool $quizPassed,
        bool $completed,
        bool $hasActivity,
    ): void {
        $now = $this->now();
        $this->db->execute(
            'INSERT INTO module_progress (
                id, user_id, module_id, enrollment_id, completion_percent, quiz_passed, completed_at, last_activity_at, created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ON DUPLICATE KEY UPDATE
                completion_percent = VALUES(completion_percent),
                quiz_passed = VALUES(quiz_passed),
                completed_at = VALUES(completed_at),
                last_activity_at = VALUES(last_activity_at),
                updated_at = NOW()',
            [
                str_id(),
                $userId,
                $moduleId,
                $enrollmentId,
                $completionPercent,
                $quizPassed ? 1 : 0,
                $completed ? $now : null,
                $hasActivity ? $now : null,
            ]
        );
    }

    private function findAttemptByQuizId(array $attempts, string $quizId): ?array
    {
        if ($quizId === '') {
            return null;
        }

        foreach ($attempts as $attempt) {
            if (($attempt['quiz_id'] ?? null) === $quizId) {
                return $attempt;
            }
        }

        return null;
    }

    private function latestCompletedLessonId(array $lessonProgress): ?string
    {
        $completed = array_values(array_filter($lessonProgress, static fn (array $item): bool => (int) $item['is_completed'] === 1));
        if ($completed === []) {
            return null;
        }

        usort($completed, static function (array $left, array $right): int {
            return strcmp((string) ($right['updated_at'] ?? ''), (string) ($left['updated_at'] ?? ''));
        });

        return (string) ($completed[0]['lesson_id'] ?? '');
    }

    private function audit(?string $userId, string $action, ?string $entityType, ?string $entityId, array $payload): void
    {
        $this->db->execute(
            'INSERT INTO audit_logs (id, user_id, action, entity_type, entity_id, payload_json, ip_address, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, NOW())',
            [
                str_id(),
                $userId,
                $action,
                $entityType,
                $entityId,
                json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                $_SERVER['REMOTE_ADDR'] ?? null,
            ]
        );
    }

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

    private function nullable(mixed $value): mixed
    {
        if (!is_string($value)) {
            return $value;
        }

        $value = trim($value);
        return $value === '' ? null : $value;
    }

    private function now(): string
    {
        return date('Y-m-d H:i:s');
    }
}
