<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AcademyService;
use App\Services\AcademyWriteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RuntimeException;

final class LeaderController extends BasePageController
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
        abort_unless($user && ($user['role_key'] ?? '') === 'LEADER', 403);

        $team = $this->academy->getLeaderDashboard((string) $user['id']);
        $options = $this->academy->getPlatformOptions();
        $courses = $this->academy->getPublishedCourses($user);

        $members = array_map(static function (array $member): array {
            $progressValues = array_map(static fn (array $enrollment): int => (int) ($enrollment['completion_percent'] ?? 0), $member['enrollments']);
            $statuses = array_map(static fn (array $enrollment): string => (string) $enrollment['status'], $member['enrollments']);

            return [
                'id' => $member['id'],
                'full_name' => $member['full_name'],
                'city_name' => $member['city_name'] ?? 'Без города',
                'department_name' => $member['department_name'] ?? 'Без подразделения',
                'assigned_courses' => count($member['enrollments']),
                'overall_progress' => average_progress($progressValues),
                'overall_status' => overall_status($statuses),
            ];
        }, $team);

        return $this->render('pages/leader/dashboard', [
            'title' => 'Обзор руководителя',
            'user' => $user,
            'team' => $team,
            'members' => $members,
            'options' => $options,
            'courses' => $courses,
        ]);
    }

    public function assignments(): Response
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'LEADER', 403);

        return $this->render('pages/leader/assignments', [
            'title' => 'Назначения',
            'user' => $user,
            'team' => $this->academy->getLeaderDashboard((string) $user['id']),
            'courses' => $this->academy->getPublishedCourses($user),
        ]);
    }

    public function storeTrainee(Request $request): RedirectResponse
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'LEADER', 403);

        try {
            $id = $this->academyWrite->createLeaderTrainee((string) $user['id'], [
                'full_name' => (string) $request->input('full_name', ''),
                'email' => (string) $request->input('email', ''),
                'phone' => (string) $request->input('phone', ''),
                'title' => (string) $request->input('title', ''),
                'city_id' => (string) $request->input('city_id', ''),
                'department_id' => (string) $request->input('department_id', ''),
                'password' => (string) $request->input('password', ''),
            ]);

            return redirect('/leader/team/' . $id)->with('success', 'Стажер добавлен.');
        } catch (RuntimeException $exception) {
            return redirect('/leader')->with('error', $exception->getMessage());
        }
    }

    public function assignCourse(Request $request): RedirectResponse
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'LEADER', 403);

        try {
            $this->academyWrite->assignCourse(
                (string) $request->input('user_id', ''),
                (string) $request->input('course_id', ''),
                (string) $user['id'],
            );

            return redirect('/leader/assignments')->with('success', 'Курс назначен сотруднику.');
        } catch (RuntimeException $exception) {
            return redirect('/leader/assignments')->with('error', $exception->getMessage());
        }
    }

    public function employeeDetail(string $userId): Response
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'LEADER', 403);

        return $this->render('pages/leader/team/show', [
            'title' => 'Карточка сотрудника',
            'user' => $user,
            'employee' => $this->academy->getLeaderEmployeeDetail($userId, (string) $user['id']),
        ]);
    }

    public function editEmployee(string $userId): Response
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'LEADER', 403);

        return $this->render('pages/leader/team/edit', [
            'title' => 'Редактирование сотрудника',
            'user' => $user,
            'employee' => $this->academy->getLeaderEmployeeDetail($userId, (string) $user['id']),
            'options' => $this->academy->getPlatformOptions(),
        ]);
    }

    public function updateEmployee(Request $request, string $userId): RedirectResponse
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'LEADER', 403);

        try {
            $this->academyWrite->updateLeaderEmployee((string) $user['id'], $userId, [
                'full_name' => (string) $request->input('full_name', ''),
                'email' => (string) $request->input('email', ''),
                'phone' => (string) $request->input('phone', ''),
                'title' => (string) $request->input('title', ''),
                'city_id' => (string) $request->input('city_id', ''),
                'department_id' => (string) $request->input('department_id', ''),
                'password' => (string) $request->input('password', ''),
            ]);

            return redirect('/leader/team/' . $userId . '/edit')->with('success', 'Профиль сотрудника обновлен.');
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function submitDecision(Request $request, string $enrollmentId): RedirectResponse
    {
        $user = current_user();
        abort_unless($user && ($user['role_key'] ?? '') === 'LEADER', 403);

        try {
            $this->academyWrite->submitLeaderDecision(
                (string) $user['id'],
                $enrollmentId,
                (string) $request->input('decision', ''),
                (string) $request->input('comment', ''),
            );

            return redirect(internal_path((string) url()->previous()))->with('success', 'Решение руководителя сохранено.');
        } catch (RuntimeException $exception) {
            return redirect(internal_path((string) url()->previous()))->with('error', $exception->getMessage());
        }
    }
}
