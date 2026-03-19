<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\PageRenderer;
use Illuminate\Http\Response;

abstract class BasePageController extends Controller
{
    public function __construct(
        protected readonly PageRenderer $renderer,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    protected function render(string $template, array $data = [], string $layout = 'layouts/main'): Response
    {
        return response($this->renderer->render($template, $data, $layout));
    }
}
