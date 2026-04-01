<?php

declare(strict_types=1);

use App\Services\AuthService;
use Illuminate\Support\Str;

if (!function_exists('current_user')) {
    function current_user(): ?array
    {
        return app(AuthService::class)->currentUser();
    }
}

if (!function_exists('flash_now')) {
    function flash_now(string $key, mixed $default = null): mixed
    {
        if ($key === 'old_form') {
            $old = session()->getOldInput();

            return $old === [] ? $default : $old;
        }

        return session($key, $default);
    }
}

if (!function_exists('flash')) {
    function flash(string $key, mixed $value): void
    {
        session()->flash($key, $value);
    }
}

if (!function_exists('asset_url')) {
    function asset_url(string $path): string
    {
        return asset('build/' . ltrim($path, '/'));
    }
}

if (!function_exists('media_url')) {
    function media_url(string $assetId): string
    {
        return route('media.show', ['assetId' => $assetId]);
    }
}

if (!function_exists('role_home')) {
    function role_home(string $roleKey): string
    {
        return match ($roleKey) {
            'ADMIN' => '/admin',
            'LEADER' => '/leader',
            default => '/student',
        };
    }
}

if (!function_exists('nav_sections_for')) {
    /**
     * @param array<string, mixed>|null $user
     * @return array<int, array{href:string,label:string,patterns?:array<int,string>}>
     */
    function nav_sections_for(?array $user): array
    {
        if ($user === null) {
            return [];
        }

        return match ($user['role_key'] ?? '') {
            'ADMIN' => [
                ['href' => '/courses', 'label' => 'Каталог курсов', 'patterns' => ['/courses', '/courses/*']],
                ['href' => '/knowledge-base', 'label' => 'База знаний', 'patterns' => ['/knowledge-base', '/knowledge-base/*']],
                ['href' => '/admin', 'label' => 'Обзор', 'patterns' => ['/admin']],
                ['href' => '/admin/courses', 'label' => 'Курсы', 'patterns' => ['/admin/courses', '/admin/courses/*', '/admin/lessons/*']],
                ['href' => '/admin/users', 'label' => 'Пользователи', 'patterns' => ['/admin/users', '/admin/users/*']],
                ['href' => '/admin/assignments', 'label' => 'Назначения', 'patterns' => ['/admin/assignments']],
                ['href' => '/admin/results', 'label' => 'Результаты', 'patterns' => ['/admin/results', '/admin/results/*']],
                ['href' => '/admin/media', 'label' => 'Медиа', 'patterns' => ['/admin/media']],
                ['href' => '/admin/questions', 'label' => 'Банк вопросов', 'patterns' => ['/admin/questions']],
            ],
            'LEADER' => [
                ['href' => '/courses', 'label' => 'Каталог курсов', 'patterns' => ['/courses', '/courses/*']],
                ['href' => '/knowledge-base', 'label' => 'База знаний', 'patterns' => ['/knowledge-base', '/knowledge-base/*']],
                ['href' => '/leader', 'label' => 'Обзор', 'patterns' => ['/leader', '/leader/team/*']],
                ['href' => '/leader/assignments', 'label' => 'Назначения', 'patterns' => ['/leader/assignments']],
                ['href' => '/admin/courses', 'label' => 'Редактор курсов', 'patterns' => ['/admin/courses', '/admin/courses/*', '/admin/lessons/*', '/admin/questions']],
            ],
            default => [
                ['href' => '/courses', 'label' => 'Каталог курсов', 'patterns' => ['/courses', '/courses/*']],
                ['href' => '/knowledge-base', 'label' => 'База знаний', 'patterns' => ['/knowledge-base', '/knowledge-base/*']],
                ['href' => '/student', 'label' => 'Мой кабинет', 'patterns' => ['/student']],
            ],
        };
    }
}

if (!function_exists('nav_item_is_active')) {
    /**
     * @param array{href:string,label:string,patterns?:array<int,string>} $item
     */
    function nav_item_is_active(array $item): bool
    {
        $currentPath = '/' . ltrim(request()->path(), '/');
        $patterns = $item['patterns'] ?? [$item['href']];

        foreach ($patterns as $pattern) {
            $pattern = '/' . ltrim($pattern, '/');

            if ($currentPath === $pattern) {
                return true;
            }

            if ($pattern !== '/' && str_ends_with($pattern, '/*')) {
                $prefix = rtrim(substr($pattern, 0, -2), '/');
                if ($prefix !== '' && str_starts_with($currentPath, $prefix . '/')) {
                    return true;
                }
            }
        }

        return false;
    }
}

if (!function_exists('role_label')) {
    function role_label(string $roleKey): string
    {
        return match ($roleKey) {
            'ADMIN' => 'Администратор',
            'LEADER' => 'Руководитель',
            default => 'Стажер',
        };
    }
}

if (!function_exists('role_text_class')) {
    function role_text_class(string $roleKey): string
    {
        return match ($roleKey) {
            'ADMIN' => 'text-role-admin',
            'LEADER' => 'text-role-leader',
            default => 'text-role-student',
        };
    }
}

if (!function_exists('role_badge_class')) {
    function role_badge_class(string $roleKey): string
    {
        return match ($roleKey) {
            'ADMIN' => 'badge badge-danger',
            'LEADER' => 'badge badge-warning',
            default => 'badge badge-success',
        };
    }
}

if (!function_exists('course_status_label')) {
    function course_status_label(string $status): string
    {
        return match ($status) {
            'IN_PROGRESS' => 'В процессе',
            'FAILED' => 'Тест не сдан',
            'COMPLETED' => 'Курс завершен',
            'SENT_TO_REVIEW' => 'Отправлен руководителю',
            'RECOMMENDED_FOR_ACCESS' => 'Рекомендован к выдаче доступа',
            'REPEAT_TRAINING' => 'Отправлен на повторное обучение',
            default => 'Не начат',
        };
    }
}

if (!function_exists('course_status_class')) {
    function course_status_class(string $status): string
    {
        return match ($status) {
            'IN_PROGRESS' => 'badge badge-info',
            'FAILED' => 'badge badge-danger',
            'COMPLETED' => 'badge badge-success',
            'SENT_TO_REVIEW' => 'badge badge-warning',
            'RECOMMENDED_FOR_ACCESS' => 'badge badge-cyan',
            'REPEAT_TRAINING' => 'badge badge-orange',
            default => 'badge badge-muted',
        };
    }
}

if (!function_exists('publication_status_label')) {
    function publication_status_label(string $status): string
    {
        return match ($status) {
            'PUBLISHED' => 'Опубликован',
            'TEMPLATE' => 'Шаблон',
            'ARCHIVED' => 'В архиве',
            default => 'Черновик',
        };
    }
}

if (!function_exists('publication_status_badge_class')) {
    function publication_status_badge_class(string $status): string
    {
        return match ($status) {
            'PUBLISHED' => 'badge badge-success',
            'TEMPLATE' => 'badge badge-cyan',
            'ARCHIVED' => 'badge badge-warning',
            default => 'badge badge-muted',
        };
    }
}

if (!function_exists('lesson_type_label')) {
    function lesson_type_label(string $type): string
    {
        return match ($type) {
            'VIDEO' => 'Видео',
            'MIXED' => 'Смешанный',
            'QUIZ' => 'Тест',
            default => 'Текстовый',
        };
    }
}

if (!function_exists('lesson_type_badge_class')) {
    function lesson_type_badge_class(string $type): string
    {
        return match ($type) {
            'VIDEO' => 'badge badge-cyan',
            'MIXED' => 'badge badge-info',
            'QUIZ' => 'badge badge-warning',
            default => 'badge badge-muted',
        };
    }
}

if (!function_exists('knowledge_article_type_label')) {
    function knowledge_article_type_label(string $type): string
    {
        return match ($type) {
            'INSTRUCTION' => 'Инструкция',
            'RULE' => 'Правило',
            'FAQ' => 'FAQ',
            default => 'Документ',
        };
    }
}

if (!function_exists('knowledge_article_type_badge_class')) {
    function knowledge_article_type_badge_class(string $type): string
    {
        return match ($type) {
            'INSTRUCTION' => 'badge badge-info',
            'RULE' => 'badge badge-warning',
            'FAQ' => 'badge badge-success',
            default => 'badge badge-cyan',
        };
    }
}

if (!function_exists('knowledge_visibility_label')) {
    function knowledge_visibility_label(string $scope): string
    {
        return match ($scope) {
            'ADMIN' => 'Только администратор',
            'LEADER' => 'Для руководителей',
            'STUDENT' => 'Для сотрудников',
            default => 'Для всех ролей',
        };
    }
}

if (!function_exists('decision_label')) {
    function decision_label(string $decision): string
    {
        return match ($decision) {
            'RECOMMEND_ACCESS' => 'Рекомендован к выдаче доступа',
            'RETRAIN' => 'Нужна переподготовка',
            'REPEAT_TRAINING' => 'Отправить на повторное обучение',
            default => 'Решение не принято',
        };
    }
}

if (!function_exists('format_date')) {
    function format_date(?string $value): string
    {
        return $value ? date('d.m.Y', strtotime($value)) : '—';
    }
}

if (!function_exists('format_datetime')) {
    function format_datetime(?string $value): string
    {
        return $value ? date('d.m.Y H:i', strtotime($value)) : '—';
    }
}

if (!function_exists('format_percent')) {
    function format_percent(int|float $value): string
    {
        return (string) round((float) $value) . '%';
    }
}

if (!function_exists('str_id')) {
    function str_id(): string
    {
        return Str::lower(Str::random(24));
    }
}

if (!function_exists('to_slug')) {
    function to_slug(string $value): string
    {
        return Str::slug($value, '-') ?: 'item';
    }
}

if (!function_exists('initials')) {
    function initials(string $fullName): string
    {
        $parts = preg_split('/\s+/u', trim($fullName)) ?: [];
        $initials = '';

        foreach (array_slice(array_values(array_filter($parts)), 0, 2) as $part) {
            $initials .= mb_strtoupper(mb_substr($part, 0, 1));
        }

        return $initials !== '' ? $initials : 'U';
    }
}

if (!function_exists('overall_status')) {
    /**
     * @param array<int, string> $statuses
     */
    function overall_status(array $statuses): string
    {
        if ($statuses === []) {
            return 'NOT_STARTED';
        }

        if (in_array('RECOMMENDED_FOR_ACCESS', $statuses, true)) {
            return 'RECOMMENDED_FOR_ACCESS';
        }

        if (in_array('SENT_TO_REVIEW', $statuses, true)) {
            return 'SENT_TO_REVIEW';
        }

        if (in_array('REPEAT_TRAINING', $statuses, true)) {
            return 'REPEAT_TRAINING';
        }

        if (in_array('FAILED', $statuses, true)) {
            return 'FAILED';
        }

        if (in_array('IN_PROGRESS', $statuses, true)) {
            return 'IN_PROGRESS';
        }

        foreach ($statuses as $status) {
            if ($status !== 'COMPLETED') {
                return 'NOT_STARTED';
            }
        }

        return 'COMPLETED';
    }
}

if (!function_exists('average_progress')) {
    /**
     * @param array<int, int> $values
     */
    function average_progress(array $values): int
    {
        if ($values === []) {
            return 0;
        }

        return (int) round(array_sum(array_map('intval', $values)) / count($values));
    }
}

if (!function_exists('old_or_value')) {
    /**
     * @param array<string, mixed> $source
     */
    function old_or_value(array $source, string $key, mixed $fallback = ''): mixed
    {
        return old($key, $source[$key] ?? $fallback);
    }
}

if (!function_exists('markdown_html')) {
    function markdown_html(?string $text): string
    {
        $text = trim((string) $text);
        if ($text === '') {
            return '';
        }

        $escaped = e($text);
        $escaped = preg_replace('/\*\*(.+?)\*\*/u', '<strong>$1</strong>', $escaped) ?? $escaped;
        $escaped = preg_replace('/\*(.+?)\*/u', '<em>$1</em>', $escaped) ?? $escaped;
        $escaped = preg_replace('/`(.+?)`/u', '<code>$1</code>', $escaped) ?? $escaped;
        $paragraphs = preg_split("/\R{2,}/u", $escaped) ?: [];
        $html = [];

        foreach ($paragraphs as $paragraph) {
            $lines = preg_split("/\R/u", trim($paragraph)) ?: [];
            $isList = true;

            foreach ($lines as $line) {
                if (!preg_match('/^[-*]\s+/u', $line)) {
                    $isList = false;
                    break;
                }
            }

            if ($isList) {
                $items = array_map(
                    static fn (string $line): string => '<li>' . preg_replace('/^[-*]\s+/u', '', $line) . '</li>',
                    $lines,
                );
                $html[] = '<ul>' . implode('', $items) . '</ul>';
                continue;
            }

            $html[] = '<p>' . implode('<br>', $lines) . '</p>';
        }

        return implode('', $html);
    }
}

if (!function_exists('internal_path')) {
    function internal_path(string $path): string
    {
        $parts = parse_url($path);
        $candidate = $parts['path'] ?? '/';
        $host = $parts['host'] ?? null;

        if ($host !== null && request()->getHost() !== $host) {
            return '/';
        }

        return '/' . ltrim($candidate, '/');
    }
}

if (!function_exists('knowledge_article_status_label')) {
    function knowledge_article_status_label(string $status): string
    {
        return match ($status) {
            'PUBLISHED' => 'Опубликован',
            default => 'Черновик',
        };
    }
}

if (!function_exists('knowledge_article_status_badge_class')) {
    function knowledge_article_status_badge_class(string $status): string
    {
        return match ($status) {
            'PUBLISHED' => 'badge badge-success',
            default => 'badge badge-muted',
        };
    }
}
