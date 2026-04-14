<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AcademyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RuntimeException;

final class CourseController extends BasePageController
{
    public function __construct(
        \App\Support\PageRenderer $renderer,
        private readonly AcademyService $academy,
    ) {
        parent::__construct($renderer);
    }

    public function catalog(): Response
    {
        $user = current_user();
        $courses = $this->academy->getPublishedCourses($user);

        return $this->render('pages/courses/index', [
            'title' => 'Каталог курсов',
            'courses' => $courses,
            'user' => $user,
        ]);
    }

    public function showCourse(Request $request, string $slug): Response
    {
        $user = current_user();

        try {
            $course = $this->academy->getCourseBySlugForUser($slug, $user['id'] ?? null);
        } catch (RuntimeException) {
            abort(404);
        }

        $roleKey = (string) ($user['role_key'] ?? '');
        if (($course['status'] ?? 'DRAFT') !== 'PUBLISHED' && !in_array($roleKey, ['ADMIN', 'LEADER'], true)) {
            abort(404);
        }

        return $this->render('pages/courses/show', [
            'title' => $course['title'],
            'course' => $course,
            'user' => $user,
        ]);
    }

    public function showLesson(Request $request, string $slug, string $lessonId): Response|RedirectResponse
    {
        $user = current_user();
        if ($user === null) {
            return redirect('/login')->with('error', 'Сначала войдите в систему.');
        }

        $data = $this->academy->getLessonView($slug, $lessonId, (string) $user['id']);

        if ($data === null) {
            return redirect('/courses/' . $slug);
        }

        if ((($data['course']['status'] ?? 'DRAFT') !== 'PUBLISHED') && !in_array((string) ($user['role_key'] ?? ''), ['ADMIN', 'LEADER'], true)) {
            abort(404);
        }

        $enrollment = $data['course']['enrollment'] ?? null;
        if (($user['role_key'] ?? '') === 'STUDENT' && $enrollment === null) {
            return redirect('/courses/' . $slug);
        }

        return $this->render('pages/courses/lesson', [
            'title' => $data['lesson']['title'],
            'course' => $data['course'],
            'lesson' => $data['lesson'],
            'user' => $user,
        ]);
    }
}
