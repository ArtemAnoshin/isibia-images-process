<?php

namespace App\Services\ImageProcessing;

use App\Services\ImageProcessing\DTOs\ProcessedImageDTO;
use App\Services\ImageProcessing\DTOs\ImageProcessingRequestDTO;
use App\Services\ImageProcessing\DTOs\ImageProcessingResultDTO;
use App\Services\ImageProcessing\Support\ProcessedImagesPathResolver;
use App\Services\ImageProcessing\Processors\ResizeProcessor;
use App\Services\ImageProcessing\Support\ProcessedImageFilenameGenerator;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

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

        // Создаем директорию для пользователя, если ее нет
        $this->pathResolver->setUserDirectory($dto->identifier);
        $this->pathResolver->ensureDirectoryExists();

        foreach ($dto->files as $file) {
            $image = Image::decode($file);
            // Генерация базового имени файла и пути
            $baseFileName = $this->filenameGenerator->generate($file);
            $fullPath = $this->pathResolver->path($baseFileName);

            // Resize
            if ($dto->needsResize()) {
                $image = $this->resizeProcessor->process(
                    $image,
                    $dto->maxWidth,
                    $dto->maxHeight
                );
            }

            // Миниатюры, водяной знак и прочее

            // Сохраняем изображение в нужном формате и качестве в стораже
            $image->save($fullPath, quality: $dto->compression, format: $file->getClientOriginalExtension());

            $processedFiles[] = new ProcessedImageDTO(
                filename: $baseFileName,
                path: $fullPath,
                url: $this->pathResolver->url($baseFileName),
            );
        }

        $archiveUrl = null;

        if (count($processedFiles) > 1) {
            // Создаем архив из обработанных файлов
            $archiveName = date('Ymd_His', time()) . '_processed_images.zip';
            $archivePath = $this->pathResolver->path($archiveName);
            $zip = new \ZipArchive();
            if ($zip->open($archivePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
                foreach ($processedFiles as $file) {
                    $zip->addFile($file->path, $file->filename);
                }
                $zip->close();
                $archiveUrl = $this->pathResolver->url($archiveName);
            }
        }

        return new ImageProcessingResultDTO(
            isArchive: count($processedFiles) === 1 ? false : true,
            downloadUrl: count($processedFiles) === 1 ? $processedFiles[0]->url : $archiveUrl,
            originalFileName: count($processedFiles) === 1 ? $baseFileName : $archiveName,
            files: $processedFiles,
        );
    }
}
