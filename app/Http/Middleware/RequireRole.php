<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\AuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class RequireRole
{
    public function __construct(
        private readonly AuthService $auth,
    ) {
    }

    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $this->auth->currentUser();

        if ($user === null) {
            return redirect('/login')->with('error', 'Сначала войдите в систему.');
        }

        if ($roles !== [] && !in_array((string) ($user['role_key'] ?? ''), $roles, true)) {
            return redirect(role_home((string) $user['role_key']));
        }

        return $next($request);
    }
}
