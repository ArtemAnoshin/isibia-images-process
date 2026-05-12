<?php

namespace App\Services\ImageProcessing;

use App\Services\ImageProcessing\DTOs\ProcessedImageDTO;
use App\Services\ImageProcessing\DTOs\ImageProcessingRequestDTO;
use App\Services\ImageProcessing\DTOs\ImageProcessingResultDTO;
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

            $image->save($fullPath, quality: $dto->compression);

            $processedFiles[] = new ProcessedImageDTO(
                filename: $filename,
                path: $fullPath,
                url: $this->pathResolver->url($filename),
            );
        }

        if (count($processedFiles) === 1) {
            return new ImageProcessingResultDTO(
                isArchive: false,
                downloadUrl: $processedFiles[0]->url,
                files: $processedFiles,
            );
        }

        return $processedFiles;
    }
}
