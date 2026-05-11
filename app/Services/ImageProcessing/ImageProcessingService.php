<?php

namespace App\Services\ImageProcessing;

use App\Services\ImageProcessing\DTOs\ProcessedImageDTO;
use App\Services\ImageProcessing\DTOs\ImageProcessingRequestDTO;
use App\Services\ImageProcessing\Support\ProcessedImagesPathResolver;
use App\Services\ImageProcessing\Processors\ResizeProcessor;
use App\Services\ImageProcessing\Support\ProcessedImageFilenameGenerator;
use Intervention\Image\Laravel\Facades\Image;

class ImageProcessingService
{
    public function __construct(
        protected ResizeProcessor $resizeProcessor,
        protected ProcessedImagesPathResolver $pathResolver,
        protected ProcessedImageFilenameGenerator $filenameGenerator,
    ) {
    }

    public function process(ImageProcessingRequestDTO $dto)
    {
        $processedFiles = [];

        $this->pathResolver->ensureDirectoryExists();

        foreach ($dto->files as $file) {
            // Исправление 1: Загрузка изображения из файла
            $image = Image::decode($file);

            // Resize
            if ($dto->needsResize()) {
                $image = $this->resizeProcessor->process(
                    $image,
                    $dto->maxWidth,
                    $dto->maxHeight
                );
            }

            // Генерация имени и сохранение
            $filename = $this->filenameGenerator->generate($file);
            $fullPath = $this->pathResolver->path($filename);

            $image->save($fullPath);

            $processedFiles[] = new ProcessedImageDTO(
                filename: $filename,
                path: $fullPath,
                url: $this->pathResolver->url($filename),
            );
        }

        return $processedFiles;
    }
}
