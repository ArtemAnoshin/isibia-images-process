<?php

namespace App\Services\ImageProcessing\Support;

class ProcessedImagesPathResolver
{
    public function directory(): string
    {
        return storage_path('app/public/processed');
    }

    public function relativeDirectory(): string
    {
        return 'processed';
    }

    public function url(string $filename): string
    {
        return asset(
            'storage/' .
            $this->relativeDirectory() .
            '/' .
            $filename
        );
    }

    public function path(string $filename): string
    {
        return $this->directory() . '/' . $filename;
    }

    public function ensureDirectoryExists(): void
    {
        if (!file_exists($this->directory())) {
            mkdir($this->directory(), 0777, true);
        }
    }
}
