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
        $user = $this->requireAdmin();

        return $this->render('pages/admin/dashboard', [
            'title' => 'Обзор администратора',
            'user' => $user,
            'dashboard' => $this->academy->getAdminDashboard(),
        ]);
    }

    public function users(): Response
    {
        $user = $this->requireAdmin();
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
        $user = $this->requireAdmin();

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
        $user = $this->requireAdmin();

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
        $user = $this->requireAdmin();

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
        $user = $this->requireCourseEditorAccess();
        $resources = $this->academy->getAdminResources();

        return $this->render('pages/admin/courses/index', [
            'title' => 'Редактор курсов',
            'user' => $user,
            'resources' => $resources,
            'options' => $this->academy->getPlatformOptions(),
        ]);
    }

    public function courseCategories(): Response
    {
        $user = $this->requireAdmin();

        return $this->render('pages/admin/courses/categories', [
            'title' => 'Категории курсов',
            'user' => $user,
            'categories' => $this->academy->getCourseCategoryResources(),
        ]);
    }

    public function storeCourseCategory(Request $request): RedirectResponse
    {
        $this->requireAdmin();

        try {
            $this->academyWrite->createCourseCategory([
                'title' => (string) $request->input('title', ''),
                'slug' => (string) $request->input('slug', ''),
                'description' => (string) $request->input('description', ''),
                'sort_order' => (int) $request->input('sort_order', 0),
            ]);

            return redirect('/admin/course-categories')->with('success', 'Категория создана.');
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function updateCourseCategory(Request $request, string $categoryId): RedirectResponse
    {
        $this->requireAdmin();

        try {
            $this->academyWrite->updateCourseCategory($categoryId, [
                'title' => (string) $request->input('title', ''),
                'slug' => (string) $request->input('slug', ''),
                'description' => (string) $request->input('description', ''),
                'sort_order' => (int) $request->input('sort_order', 0),
            ]);

            return redirect('/admin/course-categories')->with('success', 'Категория обновлена.');
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function deleteCourseCategory(string $categoryId): RedirectResponse
    {
        $this->requireAdmin();

        try {
            $this->academyWrite->deleteCourseCategory($categoryId);

            return redirect('/admin/course-categories')->with('success', 'Категория удалена.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/course-categories')->with('error', $exception->getMessage());
        }
    }

    public function storeCourse(Request $request): RedirectResponse
    {
        $user = $this->requireCourseEditorAccess();

        try {
            $courseId = $this->academyWrite->createCourse((string) $user['id'], [
                'title' => (string) $request->input('title', ''),
                'slug' => (string) $request->input('slug', ''),
                'subtitle' => (string) $request->input('subtitle', ''),
                'short_description' => (string) $request->input('short_description', ''),
                'category_id' => (string) $request->input('category_id', ''),
                'target_audience' => (string) $request->input('target_audience', ''),
                'city_ids' => $request->input('city_ids', []),
                'department_ids' => $request->input('department_ids', []),
                'estimated_minutes' => (int) $request->input('estimated_minutes', 45),
                'pass_score' => (int) $request->input('pass_score', 70),
                'description' => (string) $request->input('description', ''),
            ]);

            return redirect('/admin/courses/' . $courseId)->with('success', 'Курс создан.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/courses')->with('error', $exception->getMessage());
        }
    }

    public function duplicateCourse(string $courseId): RedirectResponse
    {
        $this->requireCourseEditorAccess();

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
        $this->requireCourseEditorAccess();

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
        $user = $this->requireCourseEditorAccess();

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
        $this->requireCourseEditorAccess();

        try {
            $this->academyWrite->updateCourse($courseId, [
                'title' => (string) $request->input('title', ''),
                'slug' => (string) $request->input('slug', ''),
                'subtitle' => (string) $request->input('subtitle', ''),
                'short_description' => (string) $request->input('short_description', ''),
                'description' => (string) $request->input('description', ''),
                'category_id' => (string) $request->input('category_id', ''),
                'target_audience' => (string) $request->input('target_audience', ''),
                'city_ids' => $request->input('city_ids', []),
                'department_ids' => $request->input('department_ids', []),
                'estimated_minutes' => (int) $request->input('estimated_minutes', 0),
                'pass_score' => (int) $request->input('pass_score', 70),
                'status' => (string) $request->input('status', 'DRAFT'),
            ]);

            return redirect('/admin/courses/' . $courseId)->with('success', 'Курс сохранен.');
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function storeModule(Request $request, string $courseId): RedirectResponse
    {
        $this->requireCourseEditorAccess();

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

    public function updateModule(Request $request, string $moduleId): RedirectResponse
    {
        $this->requireCourseEditorAccess();

        try {
            $courseId = $this->academyWrite->updateModule($moduleId, [
                'title' => (string) $request->input('title', ''),
                'description' => (string) $request->input('description', ''),
                'sort_order' => (int) $request->input('sort_order', 1),
                'estimated_minutes' => (int) $request->input('estimated_minutes', 15),
                'pass_score' => (int) $request->input('pass_score', 70),
                'is_published' => $request->boolean('is_published'),
            ]);

            return redirect('/admin/courses/' . $courseId)->with('success', 'Модуль сохранён.');
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function deleteModule(string $moduleId): RedirectResponse
    {
        $this->requireCourseEditorAccess();

        try {
            $courseId = $this->academyWrite->deleteModule($moduleId);

            return redirect('/admin/courses/' . $courseId)->with('success', 'Модуль удален.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/courses')->with('error', $exception->getMessage());
        }
    }

    public function storeLesson(Request $request, string $moduleId): RedirectResponse
    {
        $this->requireCourseEditorAccess();

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
        $user = $this->requireCourseEditorAccess();

        return $this->render('pages/admin/lessons/show', [
            'title' => 'Редактор урока',
            'user' => $user,
            'lesson' => $this->academy->getLessonEditorData($lessonId),
            'questions' => $this->academy->getQuestionBank(),
        ]);
    }

    public function updateLesson(Request $request, string $lessonId): RedirectResponse
    {
        $this->requireCourseEditorAccess();

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
        $this->requireCourseEditorAccess();

        try {
            $courseId = $this->academyWrite->deleteLesson($lessonId);

            return redirect('/admin/courses/' . $courseId)->with('success', 'Урок удален.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/courses')->with('error', $exception->getMessage());
        }
    }

    public function updateLessonQuiz(Request $request, string $lessonId): RedirectResponse
    {
        $this->requireCourseEditorAccess();

        $questionIdsInput = $request->input('question_ids', []);
        if (is_array($questionIdsInput)) {
            $questionIds = array_values(array_filter(array_map(
                static fn (mixed $value): string => trim((string) $value),
                $questionIdsInput,
            )));
        } else {
            $questionIds = preg_split('/[\r\n,]+/', (string) $questionIdsInput) ?: [];
            $questionIds = array_values(array_filter(array_map('trim', $questionIds)));
        }

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
        $user = $this->requireCourseEditorAccess();

        return $this->render('pages/admin/questions', [
            'title' => 'Банк вопросов',
            'user' => $user,
            'questions' => $this->academy->getQuestionBank(),
        ]);
    }

    public function storeQuestion(Request $request): RedirectResponse
    {
        $this->requireCourseEditorAccess();

        $options = $this->normalizeOptionsInput($request->input('options', []));
        $correctIndexes = $this->normalizeCorrectIndexes($request->input('correct_indexes', []));

        try {
            $this->academyWrite->createQuestion([
                'topic' => (string) $request->input('topic', 'manual'),
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

    public function updateQuestion(Request $request, string $questionId): RedirectResponse
    {
        $this->requireCourseEditorAccess();

        try {
            $this->academyWrite->updateQuestion($questionId, [
                'topic' => (string) $request->input('topic', 'manual'),
                'prompt' => (string) $request->input('prompt', ''),
                'question_type' => (string) $request->input('question_type', 'SINGLE'),
                'explanation' => (string) $request->input('explanation', ''),
                'options' => $this->normalizeOptionsInput($request->input('options', [])),
                'correct_indexes' => $this->normalizeCorrectIndexes($request->input('correct_indexes', [])),
            ]);

            return redirect('/admin/questions')->with('success', 'Вопрос обновлён.');
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function deleteQuestion(string $questionId): RedirectResponse
    {
        $this->requireCourseEditorAccess();

        try {
            $this->academyWrite->deleteQuestion($questionId);

            return redirect('/admin/questions')->with('success', 'Вопрос удалён.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/questions')->with('error', $exception->getMessage());
        }
    }

    public function knowledgeBase(): Response
    {
        $user = $this->requireAdmin();

        return $this->render('pages/admin/knowledge/index', [
            'title' => 'Редактор базы знаний',
            'user' => $user,
            'knowledge' => $this->academy->getKnowledgeBaseAdminResources(),
        ]);
    }

    public function storeKnowledgeCategory(Request $request): RedirectResponse
    {
        $user = $this->requireAdmin();

        try {
            $this->academyWrite->createKnowledgeCategory($user, [
                'title' => (string) $request->input('title', ''),
                'slug' => (string) $request->input('slug', ''),
                'description' => (string) $request->input('description', ''),
                'accent_color' => (string) $request->input('accent_color', ''),
                'sort_order' => (int) $request->input('sort_order', 0),
            ]);

            return redirect('/admin/knowledge-base')->with('success', 'Раздел базы знаний создан.');
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function updateKnowledgeCategory(Request $request, string $categoryId): RedirectResponse
    {
        $user = $this->requireAdmin();

        try {
            $this->academyWrite->updateKnowledgeCategory($categoryId, $user, [
                'title' => (string) $request->input('title', ''),
                'slug' => (string) $request->input('slug', ''),
                'description' => (string) $request->input('description', ''),
                'accent_color' => (string) $request->input('accent_color', ''),
                'sort_order' => (int) $request->input('sort_order', 0),
            ]);

            return redirect('/admin/knowledge-base')->with('success', 'Раздел базы знаний обновлён.');
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function deleteKnowledgeCategory(string $categoryId): RedirectResponse
    {
        $user = $this->requireAdmin();

        try {
            $this->academyWrite->deleteKnowledgeCategory($categoryId, $user);

            return redirect('/admin/knowledge-base')->with('success', 'Раздел базы знаний удалён.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/knowledge-base')->with('error', $exception->getMessage());
        }
    }

    public function storeKnowledgeArticle(Request $request): RedirectResponse
    {
        $user = $this->requireAdmin();

        try {
            $articleId = $this->academyWrite->createKnowledgeArticle($user, [
                'category_id' => (string) $request->input('category_id', ''),
                'title' => (string) $request->input('title', ''),
                'slug' => (string) $request->input('slug', ''),
                'article_type' => (string) $request->input('article_type', 'DOCUMENT'),
                'visibility_scope' => (string) $request->input('visibility_scope', 'ALL'),
                'status' => (string) $request->input('status', 'DRAFT'),
                'is_featured' => (string) $request->input('is_featured', ''),
                'sort_order' => (int) $request->input('sort_order', 0),
                'estimated_minutes' => (int) $request->input('estimated_minutes', 0),
                'excerpt' => (string) $request->input('excerpt', ''),
                'body' => (string) $request->input('body', ''),
                'search_keywords' => (string) $request->input('search_keywords', ''),
            ]);

            return redirect('/admin/knowledge-base/articles/' . $articleId)->with('success', 'Материал базы знаний создан.');
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function editKnowledgeArticle(string $articleId): Response
    {
        $user = $this->requireAdmin();

        return $this->render('pages/admin/knowledge/show', [
            'title' => 'Редактор материала базы знаний',
            'user' => $user,
            'knowledge' => $this->academy->getKnowledgeArticleEditorData($articleId),
        ]);
    }

    public function updateKnowledgeArticle(Request $request, string $articleId): RedirectResponse
    {
        $user = $this->requireAdmin();

        try {
            $this->academyWrite->updateKnowledgeArticle($articleId, $user, [
                'category_id' => (string) $request->input('category_id', ''),
                'title' => (string) $request->input('title', ''),
                'slug' => (string) $request->input('slug', ''),
                'article_type' => (string) $request->input('article_type', 'DOCUMENT'),
                'visibility_scope' => (string) $request->input('visibility_scope', 'ALL'),
                'status' => (string) $request->input('status', 'DRAFT'),
                'is_featured' => (string) $request->input('is_featured', ''),
                'sort_order' => (int) $request->input('sort_order', 0),
                'estimated_minutes' => (int) $request->input('estimated_minutes', 0),
                'excerpt' => (string) $request->input('excerpt', ''),
                'body' => (string) $request->input('body', ''),
                'search_keywords' => (string) $request->input('search_keywords', ''),
            ]);

            return redirect('/admin/knowledge-base/articles/' . $articleId)->with('success', 'Материал базы знаний обновлён.');
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function deleteKnowledgeArticle(string $articleId): RedirectResponse
    {
        $user = $this->requireAdmin();

        try {
            $this->academyWrite->deleteKnowledgeArticle($articleId, $user);

            return redirect('/admin/knowledge-base')->with('success', 'Материал базы знаний удалён.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/knowledge-base')->with('error', $exception->getMessage());
        }
    }

    public function assignments(): Response
    {
        $user = $this->requireAdmin();

        return $this->render('pages/admin/assignments', [
            'title' => 'Назначения',
            'user' => $user,
            'resources' => $this->academy->getAdminResources(),
        ]);
    }

    public function storeAssignment(Request $request): RedirectResponse
    {
        $user = $this->requireAdmin();

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
        $user = $this->requireAdmin();

        return $this->render('pages/admin/results/index', [
            'title' => 'Результаты',
            'user' => $user,
            'summaries' => $this->academy->getAdminResultSummaries(),
        ]);
    }

    public function resultDetail(string $userId): Response
    {
        $user = $this->requireAdmin();

        return $this->render('pages/admin/results/show', [
            'title' => 'Карточка сотрудника',
            'user' => $user,
            'employee' => $this->academy->getAdminEmployeeResultDetail($userId),
        ]);
    }

    public function media(): Response
    {
        $user = $this->requireAdmin();
        $resources = $this->academy->getAdminResources();

        return $this->render('pages/admin/media', [
            'title' => 'Медиатека',
            'user' => $user,
            'media' => $resources['media'],
        ]);
    }

    public function deleteMedia(string $assetId): RedirectResponse
    {
        $this->requireAdmin();

        try {
            $this->academyWrite->deleteMedia($assetId);

            return redirect('/admin/media')->with('success', 'Файл удалён из медиатеки.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/media')->with('error', $exception->getMessage());
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function requireAdmin(): array
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'ADMIN', 403);

        return $user;
    }

    /**
     * @return array<string, mixed>
     */
    private function requireCourseEditorAccess(): array
    {
        $user = current_user();
        abort_unless($user && in_array($user['role_key'] ?? '', ['ADMIN', 'LEADER'], true), 403);

        return $user;
    }

    /**
     * @return array<int, string>
     */
    private function normalizeOptionsInput(mixed $raw): array
    {
        if (is_array($raw)) {
            return array_values(array_filter(array_map(
                static fn (mixed $value): string => trim((string) $value),
                $raw,
            )));
        }

        $options = preg_split('/[\r\n]+/', (string) $raw) ?: [];

        return array_values(array_filter(array_map('trim', $options)));
    }

    /**
     * @return array<int, int>
     */
    private function normalizeCorrectIndexes(mixed $raw): array
    {
        $fromArray = is_array($raw);
        $values = $fromArray ? $raw : (preg_split('/,/', (string) $raw) ?: []);

        return array_values(array_filter(array_map(
            static function (mixed $value) use ($fromArray): ?int {
                $trimmed = trim((string) $value);
                if ($trimmed === '' || !is_numeric($trimmed)) {
                    return null;
                }

                $index = (int) $trimmed;

                return $fromArray ? $index : max(0, $index - 1);
            },
            $values,
        ), static fn (?int $value): bool => $value !== null));
    }
}
