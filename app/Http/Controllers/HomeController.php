<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AcademyService;
use Illuminate\Http\Response;

final class HomeController extends BasePageController
{
    public function __construct(
        \App\Support\PageRenderer $renderer,
        private readonly AcademyService $academy,
    ) {
        parent::__construct($renderer);
    }

    public function index(): Response
    {
        $user = current_user();
        $courses = $user ? $this->academy->getPublishedCourses($user) : [];

        return $this->render('pages/home', [
            'title' => 'СтройТех | сервис обучения ЮСИ',
            'courses' => array_slice($courses, 0, 6),
            'user' => $user,
        ]);
    }
}
