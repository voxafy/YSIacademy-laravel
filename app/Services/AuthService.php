<?php

declare(strict_types=1);

namespace App\Services;

use App\Support\LegacyDb;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Session;
use RuntimeException;

final class AuthService
{
    private ?array $currentUser = null;

    public function __construct(
        private readonly LegacyDb $db,
    ) {
    }

    /**
     * @return array<string, mixed>|null
     */
    public function currentUser(): ?array
    {
        if ($this->currentUser !== null) {
            return $this->currentUser;
        }

        $userId = session('user_id');
        if (!is_string($userId) || $userId === '') {
            return null;
        }

        $user = $this->db->fetchOne(
            'SELECT u.*, r.key AS role_key, r.name AS role_name, c.name AS city_name, d.name AS department_name,
                    s.full_name AS supervisor_name, co.name AS company_name
             FROM users u
             INNER JOIN roles r ON r.id = u.role_id
             LEFT JOIN cities c ON c.id = u.city_id
             LEFT JOIN departments d ON d.id = u.department_id
             LEFT JOIN users s ON s.id = u.supervisor_id
             LEFT JOIN companies co ON co.id = u.company_id
             WHERE u.id = ?
             LIMIT 1',
            [$userId],
        );

        if ($user === null) {
            Session::forget('user_id');

            return null;
        }

        $this->currentUser = $user;

        return $user;
    }

    /**
     * @return array<string, mixed>
     */
    public function attempt(string $email, string $password): array
    {
        $user = $this->db->fetchOne(
            'SELECT u.*, r.key AS role_key, r.name AS role_name
             FROM users u
             INNER JOIN roles r ON r.id = u.role_id
             WHERE u.email = ?
             LIMIT 1',
            [mb_strtolower(trim($email))],
        );

        if ($user === null || !password_verify($password, (string) $user['password_hash'])) {
            throw new RuntimeException('Неверный email или пароль.');
        }

        if (($user['approval_status'] ?? 'ACTIVE') !== 'ACTIVE') {
            throw new RuntimeException('Учетная запись деактивирована или ожидает активации.');
        }

        request()->session()->regenerate();
        Session::put('user_id', $user['id']);

        $this->db->execute(
            'REPLACE INTO auth_sessions (session_id, user_id, user_agent, ip_address, last_activity_at, created_at, updated_at)
             VALUES (?, ?, ?, ?, NOW(), NOW(), NOW())',
            [
                request()->session()->getId(),
                $user['id'],
                request()->userAgent() ?? '',
                request()->ip() ?? '',
            ],
        );

        $this->currentUser = null;

        return $this->currentUser();
    }

    public function logout(): void
    {
        $sessionId = request()->session()->getId();
        if ($sessionId !== '') {
            $this->db->execute('DELETE FROM auth_sessions WHERE session_id = ?', [$sessionId]);
        }

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        $this->currentUser = null;
    }

    /**
     * @return array<string, mixed>
     */
    public function requireUser(): array
    {
        $user = $this->currentUser();
        if ($user === null) {
            throw new AuthenticationException('Сначала войдите в систему.');
        }

        return $user;
    }

    /**
     * @param array<int, string> $roles
     * @return array<string, mixed>
     */
    public function requireRole(array $roles): array
    {
        $user = $this->requireUser();

        if (!in_array((string) $user['role_key'], $roles, true)) {
            abort(403);
        }

        return $user;
    }
}
