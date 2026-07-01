<?php

namespace App\Services\ModelManagers\User\DTOs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserContext
{
    public const GUEST_COOKIE_NAME = 'anonymous_id';
    public const GUEST_COOKIE_LIFETIME = 60 * 24 * 300; // 300 дней

    public function __construct(
        public readonly ?int $userId = null,
        public readonly ?string $guestId = null,
    ) {}

    // Статический метод для создания из запроса
    public static function fromRequest(Request $request): self
    {
        return new self(
            userId: Auth::id(),
            guestId: $request->cookie(self::GUEST_COOKIE_NAME)
        );
    }

    // Механизм генерации уникального ID для неавторизованного пользователя
    public static function generateAnonymousId(): string
    {
        return hash('sha256', Str::uuid() . microtime() . random_bytes(32));
    }

    public function isAuthorized(): bool
    {
        return $this->userId !== null;
    }

    public function getIdentifier(): string|int
    {
        return $this->userId ?? $this->guestId;
    }
}
