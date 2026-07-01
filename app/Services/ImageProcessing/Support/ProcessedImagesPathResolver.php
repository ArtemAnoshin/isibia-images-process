<?php

namespace App\Services\ImageProcessing\Support;

class ProcessedImagesPathResolver
{
    private ?string $userDirectory;

    public function directory(): string
    {
        return storage_path('app/public/processed');
    }

    public function relativeDirectory(): string
    {
        return 'processed' . '/' . $this->userDirectory;
    }

    public function url(string $filename): string
    {
        return '/storage/' .
            $this->relativeDirectory() .
            '/' .
            $filename;
    }

    public function path(string $filename): string
    {
        return $this->userDirectoryPath() . '/' . $filename;
    }

    public function ensureDirectoryExists(): void
    {
        if (!file_exists($this->userDirectoryPath())) {
            mkdir($this->userDirectoryPath(), 0777, true);
        }
    }

    public function setUserDirectory(string $userDirectory) {
        $this->userDirectory = $userDirectory;
    }

    private function userDirectoryPath(): string
    {
        return $this->directory() . '/' . $this->userDirectory;
    }
}
