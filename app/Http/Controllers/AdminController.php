<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AcademyService;
use App\Services\AcademyWriteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RuntimeException;

final class AdminController extends BasePageController
{
    public function __construct(
        \App\Support\PageRenderer $renderer,
        private readonly AcademyService $academy,
        private readonly AcademyWriteService $academyWrite,
    ) {
        parent::__construct($renderer);
    }

    public function dashboard(): Response
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'ADMIN', 403);

        return $this->render('pages/admin/dashboard', [
            'title' => 'Обзор администратора',
            'user' => $user,
            'dashboard' => $this->academy->getAdminDashboard(),
        ]);
    }

    public function users(): Response
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'ADMIN', 403);
        $resources = $this->academy->getAdminResources();

        return $this->render('pages/admin/users/index', [
            'title' => 'Пользователи',
            'user' => $user,
            'resources' => $resources,
            'options' => $this->academy->getPlatformOptions(),
            'roles' => $this->academy->getRoles(),
        ]);
    }

    public function storeUser(Request $request): RedirectResponse
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'ADMIN', 403);

        try {
            $id = $this->academyWrite->createUser($user, [
                'full_name' => (string) $request->input('full_name', ''),
                'email' => (string) $request->input('email', ''),
                'phone' => (string) $request->input('phone', ''),
                'title' => (string) $request->input('title', ''),
                'role_id' => (string) $request->input('role_id', ''),
                'city_id' => (string) $request->input('city_id', ''),
                'department_id' => (string) $request->input('department_id', ''),
                'supervisor_id' => (string) $request->input('supervisor_id', ''),
                'approval_status' => (string) $request->input('approval_status', 'ACTIVE'),
                'password' => (string) $request->input('password', ''),
            ]);

            return redirect('/admin/users/' . $id)->with('success', 'Пользователь создан.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/users')->with('error', $exception->getMessage());
        }
    }

    public function editUser(string $userId): Response
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'ADMIN', 403);

        return $this->render('pages/admin/users/show', [
            'title' => 'Профиль пользователя',
            'user' => $user,
            'target' => $this->academy->getUserById($userId),
            'options' => $this->academy->getPlatformOptions(),
            'roles' => $this->academy->getRoles(),
        ]);
    }

    public function updateUser(Request $request, string $userId): RedirectResponse
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'ADMIN', 403);

        try {
            $this->academyWrite->updateUserAsAdmin($userId, [
                'full_name' => (string) $request->input('full_name', ''),
                'email' => (string) $request->input('email', ''),
                'phone' => (string) $request->input('phone', ''),
                'title' => (string) $request->input('title', ''),
                'role_id' => (string) $request->input('role_id', ''),
                'city_id' => (string) $request->input('city_id', ''),
                'department_id' => (string) $request->input('department_id', ''),
                'supervisor_id' => (string) $request->input('supervisor_id', ''),
                'approval_status' => (string) $request->input('approval_status', 'ACTIVE'),
                'bio' => (string) $request->input('bio', ''),
                'password' => (string) $request->input('password', ''),
            ], (string) $user['id']);

            return redirect('/admin/users/' . $userId)->with('success', 'Профиль пользователя обновлен.');
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function courses(): Response
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'ADMIN', 403);
        $resources = $this->academy->getAdminResources();

        return $this->render('pages/admin/courses/index', [
            'title' => 'Редактор курсов',
            'user' => $user,
            'resources' => $resources,
            'options' => $this->academy->getPlatformOptions(),
        ]);
    }

    public function storeCourse(Request $request): RedirectResponse
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'ADMIN', 403);

        try {
            $courseId = $this->academyWrite->createCourse((string) $user['id'], [
                'title' => (string) $request->input('title', ''),
                'slug' => (string) $request->input('slug', ''),
                'category_id' => (string) $request->input('category_id', ''),
                'target_audience' => (string) $request->input('target_audience', ''),
                'city_id' => (string) $request->input('city_id', ''),
                'department_id' => (string) $request->input('department_id', ''),
                'description' => (string) $request->input('description', ''),
            ]);

            return redirect('/admin/courses/' . $courseId)->with('success', 'Курс создан.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/courses')->with('error', $exception->getMessage());
        }
    }

    public function duplicateCourse(string $courseId): RedirectResponse
    {
        abort_unless(current_user() && (current_user()['role_key'] ?? '') === 'ADMIN', 403);

        try {
            $source = $this->academy->getCourseEditorData($courseId);
            $newId = $this->academyWrite->duplicateCourse($courseId, $source);

            return redirect('/admin/courses/' . $newId)->with('success', 'Копия курса создана.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/courses')->with('error', $exception->getMessage());
        }
    }

    public function deleteCourse(string $courseId): RedirectResponse
    {
        abort_unless(current_user() && (current_user()['role_key'] ?? '') === 'ADMIN', 403);

        try {
            $source = $this->academy->getCourseEditorData($courseId);
            $this->academyWrite->deleteCourse($courseId, $source);

            return redirect('/admin/courses')->with('success', 'Курс удален.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/courses')->with('error', $exception->getMessage());
        }
    }

    public function editCourse(string $courseId): Response
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'ADMIN', 403);

        return $this->render('pages/admin/courses/show', [
            'title' => 'Редактор курса',
            'user' => $user,
            'course' => $this->academy->getCourseEditorData($courseId),
            'resources' => $this->academy->getAdminResources(),
            'options' => $this->academy->getPlatformOptions(),
        ]);
    }

    public function updateCourse(Request $request, string $courseId): RedirectResponse
    {
        abort_unless(current_user() && (current_user()['role_key'] ?? '') === 'ADMIN', 403);

        try {
            $this->academyWrite->updateCourse($courseId, [
                'title' => (string) $request->input('title', ''),
                'subtitle' => (string) $request->input('subtitle', ''),
                'short_description' => (string) $request->input('short_description', ''),
                'description' => (string) $request->input('description', ''),
                'target_audience' => (string) $request->input('target_audience', ''),
                'status' => (string) $request->input('status', 'DRAFT'),
            ]);

            return redirect('/admin/courses/' . $courseId)->with('success', 'Курс сохранен.');
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function storeModule(Request $request, string $courseId): RedirectResponse
    {
        abort_unless(current_user() && (current_user()['role_key'] ?? '') === 'ADMIN', 403);

        try {
            $this->academyWrite->createModule($courseId, [
                'title' => (string) $request->input('title', ''),
                'description' => (string) $request->input('description', ''),
            ]);

            return redirect('/admin/courses/' . $courseId)->with('success', 'Модуль добавлен.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/courses/' . $courseId)->with('error', $exception->getMessage());
        }
    }

    public function deleteModule(string $moduleId): RedirectResponse
    {
        abort_unless(current_user() && (current_user()['role_key'] ?? '') === 'ADMIN', 403);

        try {
            $courseId = $this->academyWrite->deleteModule($moduleId);

            return redirect('/admin/courses/' . $courseId)->with('success', 'Модуль удален.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/courses')->with('error', $exception->getMessage());
        }
    }

    public function storeLesson(Request $request, string $moduleId): RedirectResponse
    {
        abort_unless(current_user() && (current_user()['role_key'] ?? '') === 'ADMIN', 403);

        try {
            $lessonId = $this->academyWrite->createLesson($moduleId, [
                'title' => (string) $request->input('title', ''),
                'description' => (string) $request->input('description', ''),
                'lesson_type' => (string) $request->input('lesson_type', 'MIXED'),
            ]);

            return redirect('/admin/lessons/' . $lessonId)->with('success', 'Урок создан.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/courses')->with('error', $exception->getMessage());
        }
    }

    public function editLesson(string $lessonId): Response
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'ADMIN', 403);

        return $this->render('pages/admin/lessons/show', [
            'title' => 'Редактор урока',
            'user' => $user,
            'lesson' => $this->academy->getLessonEditorData($lessonId),
            'questions' => $this->academy->getQuestionBank(),
        ]);
    }

    public function updateLesson(Request $request, string $lessonId): RedirectResponse
    {
        abort_unless(current_user() && (current_user()['role_key'] ?? '') === 'ADMIN', 403);

        try {
            $this->academyWrite->updateLesson($lessonId, [
                'title' => (string) $request->input('title', ''),
                'description' => (string) $request->input('description', ''),
                'lesson_type' => (string) $request->input('lesson_type', 'MIXED'),
                'body' => (string) $request->input('body', ''),
                'rules_body' => (string) $request->input('rules_body', ''),
                'mistakes_body' => (string) $request->input('mistakes_body', ''),
            ]);

            return redirect('/admin/lessons/' . $lessonId)->with('success', 'Урок сохранен.');
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function deleteLesson(string $lessonId): RedirectResponse
    {
        abort_unless(current_user() && (current_user()['role_key'] ?? '') === 'ADMIN', 403);

        try {
            $courseId = $this->academyWrite->deleteLesson($lessonId);

            return redirect('/admin/courses/' . $courseId)->with('success', 'Урок удален.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/courses')->with('error', $exception->getMessage());
        }
    }

    public function updateLessonQuiz(Request $request, string $lessonId): RedirectResponse
    {
        abort_unless(current_user() && (current_user()['role_key'] ?? '') === 'ADMIN', 403);

        $questionIds = preg_split('/[\r\n,]+/', (string) $request->input('question_ids', '')) ?: [];
        $questionIds = array_values(array_filter(array_map('trim', $questionIds)));

        try {
            $this->academyWrite->upsertLessonQuiz(
                $lessonId,
                $questionIds,
                (string) $request->input('title', ''),
                (string) $request->input('description', ''),
                (int) $request->input('pass_score', 70),
            );

            return redirect('/admin/lessons/' . $lessonId)->with('success', 'Тест урока обновлен.');
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function questions(): Response
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'ADMIN', 403);

        return $this->render('pages/admin/questions', [
            'title' => 'Банк вопросов',
            'user' => $user,
            'questions' => $this->academy->getQuestionBank(),
        ]);
    }

    public function storeQuestion(Request $request): RedirectResponse
    {
        abort_unless(current_user() && (current_user()['role_key'] ?? '') === 'ADMIN', 403);

        $options = preg_split('/[\r\n]+/', (string) $request->input('options', '')) ?: [];
        $options = array_values(array_filter(array_map('trim', $options)));
        $correctIndexes = preg_split('/,/', (string) $request->input('correct_indexes', '')) ?: [];
        $correctIndexes = array_values(array_filter(array_map(
            static fn (string $value): ?int => is_numeric(trim($value)) ? ((int) trim($value)) - 1 : null,
            $correctIndexes,
        ), static fn ($value) => $value !== null));

        try {
            $this->academyWrite->createQuestion([
                'prompt' => (string) $request->input('prompt', ''),
                'question_type' => (string) $request->input('question_type', 'SINGLE'),
                'explanation' => (string) $request->input('explanation', ''),
                'options' => $options,
                'correct_indexes' => $correctIndexes,
            ]);

            return redirect('/admin/questions')->with('success', 'Вопрос добавлен.');
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function assignments(): Response
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'ADMIN', 403);

        return $this->render('pages/admin/assignments', [
            'title' => 'Назначения',
            'user' => $user,
            'resources' => $this->academy->getAdminResources(),
        ]);
    }

    public function storeAssignment(Request $request): RedirectResponse
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'ADMIN', 403);

        try {
            $this->academyWrite->assignCourse(
                (string) $request->input('user_id', ''),
                (string) $request->input('course_id', ''),
                (string) $user['id'],
            );

            return redirect('/admin/assignments')->with('success', 'Курс назначен.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/assignments')->with('error', $exception->getMessage());
        }
    }

    public function results(): Response
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'ADMIN', 403);

        return $this->render('pages/admin/results/index', [
            'title' => 'Результаты',
            'user' => $user,
            'summaries' => $this->academy->getAdminResultSummaries(),
        ]);
    }

    public function resultDetail(string $userId): Response
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'ADMIN', 403);

        return $this->render('pages/admin/results/show', [
            'title' => 'Карточка сотрудника',
            'user' => $user,
            'employee' => $this->academy->getAdminEmployeeResultDetail($userId),
        ]);
    }

    public function media(): Response
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'ADMIN', 403);
        $resources = $this->academy->getAdminResources();

        return $this->render('pages/admin/media', [
            'title' => 'Медиатека',
            'user' => $user,
            'media' => $resources['media'],
        ]);
    }
}
