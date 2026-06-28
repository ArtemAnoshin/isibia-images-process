<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserIdentifierHelper
{
    /**
     * Получить идентификатор пользователя
     * - Для авторизованных: user_{id}
     * - Для гостей с кукой: значение куки
     * - Для гостей без куки: null
     */
    public static function getIdentifier(Request $request = null): ?string
    {
        $request = $request ?? request();

        // 1. Если пользователь авторизован - используем user_id
        if ($user = $request->user()) {
            return 'user_' . $user->id;
        }

        // 2. Для гостей - используем ID сессии
        $sessionId = Session::getId();

        if ($sessionId) {
            return 'guest_' . $sessionId;
        }

        return null;
    }
}
