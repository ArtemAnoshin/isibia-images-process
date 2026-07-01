<?php

namespace App\Services\ModelManagers\ProcessedFile;

use App\Models\ProcessedFile;
use App\Services\ImageProcessing\DTOs\ImageProcessingResultDTO;
use App\Services\ModelManagers\User\DTOs\UserContext;
use Illuminate\Support\Facades\Auth;

class ProcessedFileSaver
{
    public function saveProcessedResult(ImageProcessingResultDTO $result, UserContext $userContext): ProcessedFile
    {
        // Определяем тип файла (архив или одиночный)
        $isArchive = $result->isArchive || count($result->files) > 1;

        // Создаем запись в БД, используя идентификатор из контекста
        return ProcessedFile::create([
            // Если пользователь авторизован, ставим его ID, иначе null
            'user_id' => $userContext->isAuthorized() ? $userContext->userId : null,

            // Если это гость, используем его guestId, иначе null
            'anonymous_id' => $userContext->isAuthorized() ? null : $userContext->guestId,

            'type' => $isArchive ? ProcessedFile::TYPE_ARCHIVE : ProcessedFile::TYPE_SINGLE,
            'original_name' => $result->originalFileName,
            'path' => $result->downloadUrl,
            'size' => null, // Размер можно вычислить позже, если нужно
            'expires_at' => now()->addWeek(), // Срок хранения - неделя
        ]);
    }
}
