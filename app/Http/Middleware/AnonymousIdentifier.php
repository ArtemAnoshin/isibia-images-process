<?php

namespace App\Http\Middleware;

use App\Services\ModelManagers\User\DTOs\UserContext;
use Closure;
use Illuminate\Http\Request;

class AnonymousIdentifier
{
    public function handle(Request $request, Closure $next)
    {
        // Если пользователь авторизован - пропускаем
        if ($request->user()) {
            return $next($request);
        }

        // Пытаемся получить ID из куки
        $anonymousId = $request->cookie(UserContext::GUEST_COOKIE_NAME);

        if (!$anonymousId) {
            $anonymousId = UserContext::generateAnonymousId();

            $response = $next($request);

            // Устанавливаем куку на 300 дней
            $response->cookie(
                UserContext::GUEST_COOKIE_NAME,
                $anonymousId,
                UserContext::GUEST_COOKIE_LIFETIME,
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
}
