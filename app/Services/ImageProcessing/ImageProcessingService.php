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

        $this->pathResolver->setUserDirectory($dto->identifier);
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

            // Определяем формат
            $extension = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
            $format = $dto->format ?? $extension;

            // Сохраняем с учетом формата
            // TODO: есть проблемы со сжатием PNG, нужно разобраться
            $this->saveImageWithFormat($image, $fullPath, $format, $dto->compression);

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

    // Добавляем метод
    private function saveImageWithFormat($image, string $path, string $format, int $quality): void
    {
        switch ($format) {
            case 'png':
                // Для PNG quality работает от 0 до 9 (уровень сжатия)
                $pngQuality = $this->convertToPngQuality($quality);
                $image->save($path, quality: $pngQuality, format: 'png');
                break;

            case 'webp':
                $image->save($path, quality: $quality, format: 'webp');
                break;

            case 'jpeg':
            case 'jpg':
            default:
                $image->save($path, quality: $quality);
                break;
        }
    }

    private function convertToPngQuality(int $jpegQuality): int
    {
        // Конвертируем quality из 0-100 в 0-9 для PNG
        // 0 - максимальное сжатие (самый маленький файл)
        // 9 - минимальное сжатие (самый большой файл)

        if ($jpegQuality >= 90) {
            return 1; // Минимальное сжатие, максимальное качество
        } elseif ($jpegQuality >= 70) {
            return 3;
        } elseif ($jpegQuality >= 50) {
            return 5;
        } elseif ($jpegQuality >= 30) {
            return 7;
        } else {
            return 9; // Максимальное сжатие
        }
    }
}
