<?php

namespace App\Frontend\Auth;

/**
 * Keeps the backend token + the logged-in user inside Laravel's session.
 * (Native $_SESSION is NOT used: Laravel never starts it.)
 */
class ApiSession
{
    private const TOKEN = 'api.token';
    private const USER  = 'api.user';

    public static function store(string $token, array $user): void
    {
        $user += ['id' => $user['email'] ?? 0, 'name' => '', 'email' => '', 'account_type' => 'candidate'];

        session([self::TOKEN => $token, self::USER => $user]);
    }

    public static function token(): ?string
    {
        return session(self::TOKEN);
    }

    public static function user(): ?array
    {
        return session(self::USER);
    }

    public static function check(): bool
    {
        return self::token() !== null && self::user() !== null;
    }

    public static function forget(): void
    {
        session()->forget([self::TOKEN, self::USER]);
    }
}
