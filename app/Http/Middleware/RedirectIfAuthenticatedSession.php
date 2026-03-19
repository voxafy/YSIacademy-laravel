<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\AuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class RedirectIfAuthenticatedSession
{
    public function __construct(
        private readonly AuthService $auth,
    ) {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $user = $this->auth->currentUser();

        if ($user !== null) {
            return redirect(role_home((string) $user['role_key']));
        }

        return $next($request);
    }
}
