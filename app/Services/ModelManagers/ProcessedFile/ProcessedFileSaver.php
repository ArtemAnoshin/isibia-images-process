<?php

namespace App\Services\ModelManagers\ProcessedFile;

use App\Models\ProcessedFile;
use App\Services\ImageProcessing\DTOs\ImageProcessingResultDTO;
use Illuminate\Support\Facades\Auth;

class ProcessedFileSaver
{
    public function saveProcessedResult(ImageProcessingResultDTO $result): ProcessedFile
    {
        $sessionId = session()->getId();
        $userId = Auth::id();

        // Определяем тип и имя
        $isArchive = $result->isArchive || count($result->files) > 1;

        // Создаем запись в БД
        return ProcessedFile::create([
            'anonymous_id' => $sessionId,
            'user_id' => $userId,
            'type' => $isArchive ? ProcessedFile::TYPE_ARCHIVE : ProcessedFile::TYPE_SINGLE,
            'original_name' => $result->originalFileName,
            'path' => $result->downloadUrl,
            'size' => null,
            'expires_at' => now()->addWeek(), // Срок хранения - неделя
        ]);
    }
}
