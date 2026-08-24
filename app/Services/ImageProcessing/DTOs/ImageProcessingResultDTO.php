<?php

namespace App\Services\ImageProcessing\DTOs;

class ImageProcessingResultDTO
{
    public function __construct(
        public readonly bool $isArchive,
        public readonly string $downloadUrl,
        public readonly string $originalFileName,
        public readonly array $files = [],
        public readonly int $originalSize = 0,
        public readonly int $processedSize = 0,
        public readonly int $downloadSize = 0,
    ) {}
}
