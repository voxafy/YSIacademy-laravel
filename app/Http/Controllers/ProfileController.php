<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AcademyService;
use App\Services\AcademyWriteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RuntimeException;

final class ProfileController extends BasePageController
{
    public function __construct(
        \App\Support\PageRenderer $renderer,
        private readonly AcademyService $academy,
        private readonly AcademyWriteService $academyWrite,
    ) {
        parent::__construct($renderer);
    }

    public function show(): Response
    {
        $user = current_user();
        abort_unless($user !== null, 403);

        return $this->render('pages/profile/show', [
            'title' => 'Профиль',
            'user' => $user,
            'options' => $this->academy->getPlatformOptions(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = current_user();
        abort_unless($user !== null, 403);

        try {
            $this->academyWrite->updateOwnProfile((string) $user['id'], [
                'full_name' => (string) $request->input('full_name', ''),
                'email' => (string) $request->input('email', ''),
                'phone' => (string) $request->input('phone', ''),
                'title' => (string) $request->input('title', ''),
                'bio' => (string) $request->input('bio', ''),
                'city_id' => (string) $request->input('city_id', ''),
                'department_id' => (string) $request->input('department_id', ''),
                'supervisor_id' => (string) $request->input('supervisor_id', ''),
                'password' => (string) $request->input('password', ''),
            ]);

            return redirect('/profile')->with('success', 'Профиль обновлен.');
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }
    }
}
