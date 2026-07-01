<?php

namespace App\Services\ModelManagers\ProcessedFile;

use App\Models\ProcessedFile;
use App\Services\ModelManagers\User\DTOs\UserContext;

class ProcessedFileRepository
{
    public function filesForCurrentUser(UserContext $userContext)
    {
        $query = ProcessedFile::query();

        // Применяем фильтр по пользователю/гостю
        if ($userContext->isAuthorized()) {
            $query->where('user_id', $userContext->userId);
        } else {
            $query->where('anonymous_id', $userContext->guestId);
        }

        // Фильтр активных файлов (не истек срок действия)
        $query->where(function ($q) {
            $q->whereNull('expires_at')
            ->orWhere('expires_at', '>', now());
        });

        // Сортировка
        $query->orderBy('created_at', 'desc');

        // Получаем данные и маппим
        return $query->get()->map(function ($file) {
            return [
                'id' => $file->id,
                'original_name' => $file->original_name,
                'type' => $file->type,
                'download_url' => $file->path,
                'expires_at' => $file->expires_at,
            ];
        });
    }
}
