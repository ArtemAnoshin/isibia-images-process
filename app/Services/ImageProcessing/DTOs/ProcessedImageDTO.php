<?php

namespace App\Services\ImageProcessing\DTOs;

class ProcessedImageDTO
{
    public function __construct(
        public readonly string $filename,
        public readonly string $path,
        public readonly string $url,
    ) {
    }
}
