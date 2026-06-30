<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnonymousIdentifier
{
    protected const COOKIE_NAME = 'anonymous_id';
    protected const COOKIE_LIFETIME = 60 * 24 * 300; // 300 дней

    public function handle(Request $request, Closure $next)
    {
        // Если пользователь авторизован - пропускаем
        if ($request->user()) {
            return $next($request);
        }

        // Пытаемся получить ID из куки
        $anonymousId = $request->cookie(self::COOKIE_NAME);

        if (!$anonymousId) {
            $anonymousId = $this->generateAnonymousId();

            $response = $next($request);

            // Устанавливаем куку на 300 дней
            $response->cookie(
                self::COOKIE_NAME,
                $anonymousId,
                self::COOKIE_LIFETIME,
                '/',
                null,
                config('app.env') === 'production',
                false,
                false,
                'Lax'
            );

            return $response;
        }

        return $next($request);
    }

    private function generateAnonymousId(): string
    {
        return hash('sha256', Str::uuid() . microtime() . random_bytes(32));
    }
}
