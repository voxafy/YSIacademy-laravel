<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AcademyService;
use App\Services\AcademyWriteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RuntimeException;

final class StudentController extends BasePageController
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
        abort_unless($user && ($user['role_key'] ?? '') === 'STUDENT', 403);

        return $this->render('pages/student/dashboard', [
            'title' => 'Кабинет стажера',
            'dashboard' => $this->academy->getStudentDashboard((string) $user['id']),
            'user' => $user,
        ]);
    }

    public function completeLesson(Request $request, string $lessonId): RedirectResponse
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'STUDENT', 403);

        try {
            $this->academyWrite->markLessonComplete((string) $user['id'], $lessonId);

            return redirect(internal_path((string) url()->previous()))->with('success', 'Урок отмечен как пройденный.');
        } catch (RuntimeException $exception) {
            return redirect(internal_path((string) url()->previous()))->with('error', $exception->getMessage());
        }
    }

    public function submitQuiz(Request $request, string $quizId): RedirectResponse
    {
        $user = current_user();
        abort_unless($user !== null, 403);

        try {
            $quiz = $this->academy->getQuizForAttempt($quizId);
            $result = $this->academyWrite->submitQuiz($quiz, (string) $user['id'], $request->all());

            return redirect(internal_path((string) url()->previous()))->with(
                $result['passed'] ? 'success' : 'error',
                $result['passed']
                    ? 'Тест сдан: ' . $result['percentage'] . '%.'
                    : 'Тест не сдан: ' . $result['percentage'] . '%. Нужна пересдача.',
            );
        } catch (RuntimeException $exception) {
            return redirect(internal_path((string) url()->previous()))->with('error', $exception->getMessage());
        }
    }
}
