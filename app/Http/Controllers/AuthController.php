<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AcademyService;
use App\Services\AcademyWriteService;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RuntimeException;

final class AuthController extends BasePageController
{
    public function __construct(
        \App\Support\PageRenderer $renderer,
        private readonly AuthService $auth,
        private readonly AcademyService $academy,
        private readonly AcademyWriteService $academyWrite,
    ) {
        parent::__construct($renderer);
    }

    public function showLogin(): Response|RedirectResponse
    {
        if (current_user() !== null) {
            return redirect(role_home((string) current_user()['role_key']));
        }

        return $this->render('pages/auth/login', [
            'title' => 'Вход',
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        try {
            $user = $this->auth->attempt(
                (string) $request->input('email', ''),
                (string) $request->input('password', ''),
            );

            return redirect(role_home((string) $user['role_key']))->with('success', 'Вход выполнен.');
        } catch (RuntimeException $exception) {
            return back()->withInput($request->only('email'))->with('error', $exception->getMessage());
        }
    }

    public function showRegister(): Response|RedirectResponse
    {
        if (current_user() !== null) {
            return redirect(role_home((string) current_user()['role_key']));
        }

        return $this->render('pages/auth/register', [
            'title' => 'Регистрация',
            'options' => $this->academy->getPlatformOptions(),
        ]);
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'full_name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'title' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8'],
            'city_id' => ['required', 'string'],
            'department_id' => ['required', 'string'],
        ]);

        try {
            $this->academyWrite->registerStudent([
                'full_name' => (string) $request->input('full_name', ''),
                'email' => (string) $request->input('email', ''),
                'phone' => (string) $request->input('phone', ''),
                'title' => (string) $request->input('title', ''),
                'password' => (string) $request->input('password', ''),
                'city_id' => (string) $request->input('city_id', ''),
                'department_id' => (string) $request->input('department_id', ''),
                'supervisor_id' => (string) $request->input('supervisor_id', ''),
            ]);

            $user = $this->auth->attempt(
                (string) $request->input('email', ''),
                (string) $request->input('password', ''),
            );

            return redirect(role_home((string) $user['role_key']))->with('success', 'Регистрация завершена.');
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function logout(): RedirectResponse
    {
        $this->auth->logout();

        return redirect('/')->with('success', 'Вы вышли из системы.');
    }
}
