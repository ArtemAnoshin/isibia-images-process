<?php

namespace App\Console\Commands;

use App\Models\ProcessedFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Команда удаляет все файлы старше config('filesystems.processed_files_ttl', 24) часов для всех пользователей.
 */
class CleanupExpiredFiles extends Command
{
    protected $signature = 'files:cleanup-expired';
    protected $description = 'Удаляет файлы старше установленного TTL';

    public function handle(): int
    {
        // Время жизни обработанных файлов в часах
        $ttl = config('filesystems.processed_files_ttl', 24);

        // Получение всех файлов с истекшим временем жизни, с ограничением в 50 штук
        $expiredFiles = ProcessedFile::where('created_at', '<', now()->subHours($ttl))
            ->limit(50)
            ->get();

        if ($expiredFiles->isEmpty()) {
            return self::SUCCESS;
        }

        // Удаляем из хранилища
        foreach ($expiredFiles as $file) {
            $relativePath = str_replace('/storage/', '', $file->path);

            // Удаляем через Storage
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }

        // Удаляем из базы
        ProcessedFile::whereIn('id', $expiredFiles->pluck('id'))->delete();

        return self::SUCCESS;
    }
}
