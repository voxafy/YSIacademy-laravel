<?php

declare(strict_types=1);

namespace App\Support;

final class PageRenderer
{
    /**
     * @param array<string, mixed> $context
     */
    public function render(string $template, array $context = [], string $layout = 'layouts/main'): string
    {
        $layoutView = str_replace('/', '.', $layout);
        $pageView = str_replace('/', '.', $template);

        return view($layoutView, array_merge($context, [
            'pageView' => $pageView,
        ]))->render();
    }
}
