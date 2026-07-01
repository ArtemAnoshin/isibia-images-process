<?php

namespace App\Services\ImageProcessing\DTOs;

class ProcessedImageDTO
{
    public function __construct(
        public readonly string $filename,
        public readonly string $serverPath,
        public readonly string $downloadUrl,
    ) {
    }
}
