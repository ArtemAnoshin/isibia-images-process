<?php

namespace App\Services\ImageProcessing\DTOs;

class ImageProcessingResultDTO
{
    public function __construct(
        public readonly bool $isArchive,
        public readonly string $downloadUrl,
        public readonly array $files = [],
    ) {
    }
}
