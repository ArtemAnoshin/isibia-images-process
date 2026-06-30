<?php

namespace App\Services\ModelManagers\ProcessedFile;

use App\Models\ProcessedFile;

class ProcessedFileRepository
{
    public function filesForCurrentUser()
    {
        return ProcessedFile::forCurrentUser()
            ->active()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($file) {
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
