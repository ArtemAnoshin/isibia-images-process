<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnonymousIdentifier
{
    /**
     * Название куки для хранения анонимного идентификатора
     */
    protected const COOKIE_NAME = 'anonymous_id';

    /**
     * Время жизни куки (в минутах)
     * 30 дней = 43200 минут
     */
    protected const COOKIE_LIFETIME = 43200;

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Если пользователь авторизован - пропускаем без куки
        if ($request->user()) {
            return $next($request);
        }

        // Проверяем наличие куки
        $anonymousId = $request->cookie(self::COOKIE_NAME);

        // Если куки нет - создаем новую
        if (!$anonymousId) {
            $anonymousId = $this->generateAnonymousId();

            // Устанавливаем куку
            $response = $next($request);
            $response->cookie(
                self::COOKIE_NAME,
                $anonymousId,
                self::COOKIE_LIFETIME,
                '/',
                null,
                config('app.env') === 'production', // secure
                false, // httpOnly
                false, // raw
                'Lax' // sameSite
            );

            return $response;
        }

        // Если кука есть - просто передаем дальше
        return $next($request);
    }

    /**
     * Сгенерировать уникальный идентификатор
     */
    private function generateAnonymousId(): string
    {
        return hash('sha256', Str::uuid() . microtime() . random_bytes(32));
    }
}
