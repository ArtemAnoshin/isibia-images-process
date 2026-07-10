<?php

namespace App\Services\ImageProcessing;

use App\Services\ImageProcessing\DTOs\ProcessedImageDTO;
use App\Services\ImageProcessing\DTOs\ImageProcessingRequestDTO;
use App\Services\ImageProcessing\DTOs\ImageProcessingResultDTO;
use App\Services\ImageProcessing\Support\ProcessedImagesPathResolver;
use App\Services\ImageProcessing\Processors\ResizeProcessor;
use App\Services\ImageProcessing\Processors\ThumbnailsProcessor;
use App\Services\ImageProcessing\Processors\WatermarkProcessor;
use App\Services\ImageProcessing\Support\ProcessedImageFilenameGenerator;
use Intervention\Image\Laravel\Facades\Image;
use ZipArchive;

class ImageProcessingService
{
    public function __construct(
        protected ResizeProcessor $resizeProcessor,
        protected ThumbnailsProcessor $thumbnailsProcessor,
        protected WatermarkProcessor $watermarkProcessor,
        protected ProcessedImagesPathResolver $pathResolver,
        protected ProcessedImageFilenameGenerator $filenameGenerator,
    ) {
    }

    public function process(ImageProcessingRequestDTO $dto): ImageProcessingResultDTO
    {
        $processedFiles = [];

        // Подготовка окружения
        $this->setUserDirectory($dto);

        foreach ($dto->files as $file) {
            // 1. Определение финального формата один раз
            $isOriginalFormat = $dto->format === 'original';
            $finalFormat = $isOriginalFormat
                ? pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION)
                : $dto->format;

            // Нормализация jpg -> jpeg для Intervention
            if ($finalFormat === 'jpg') {
                $finalFormat = 'jpeg';
            }

            // 2. Генерация базового имени
            $baseFileName = $this->filenameGenerator->generate($file, $finalFormat);

            // 3. Загрузка изображения
            $baseImage = Image::decode($file);

            // 4. Resize (основного изображения)
            if ($dto->needsResize()) {
                $baseImage = $this->resizeProcessor->process(
                    $baseImage,
                    $dto->maxWidth,
                    $dto->maxHeight
                );

                $baseFileName = $this->filenameGenerator->withSizeSuffix(
                    $baseFileName,
                    $baseImage->width(),
                    $baseImage->height()
                );
            }

            // 5. Watermark (накладываем ДО сохранения, чтобы не читать файл с диска повторно)
            if ($dto->needsWatermark()) {
                $baseImage = $this->watermarkProcessor->process(
                    $baseImage,
                    $dto->watermarkType,
                    $dto->watermarkText,
                    $dto->watermarkImage,
                    $dto->watermarkX,
                    $dto->watermarkY,
                    $dto->watermarkScale,
                    $dto->watermarkOpacity
                );
            }

            // 6. Сохранение основного изображения
            $baseServerPath = $this->pathResolver->path($baseFileName);
            $baseImage->save($baseServerPath, quality: $dto->compression, format: $finalFormat);

            $processedFiles[] = new ProcessedImageDTO(
                filename: $baseFileName,
                serverPath: $baseServerPath,
                downloadUrl: $this->pathResolver->url($baseFileName),
            );

            // 7. Генерация миниатюр
            if ($dto->needsThumbnails()) {
                foreach ($dto->thumbnails as $thumbConfig) {
                    // Клонируем уже обработанное (ресайз + водяной знак) изображение
                    $thumbImage = clone $baseImage;

                    $thumbImage = $this->thumbnailsProcessor->process(
                        $thumbImage,
                        $thumbConfig['width'],
                        $thumbConfig['height']
                    );

                    $thumbName = $this->filenameGenerator->withSizeSuffix(
                        $baseFileName,
                        $thumbConfig['width'],
                        $thumbConfig['height']
                    );

                    $thumbPath = $this->pathResolver->path($thumbName);

                    // Сохраняем миниатюру
                    $thumbImage->save($thumbPath, quality: $dto->compression, format: $finalFormat);

                    // Освобождаем память сразу после сохранения миниатюры
                    unset($thumbImage);

                    $processedFiles[] = new ProcessedImageDTO(
                        filename: $thumbName,
                        serverPath: $thumbPath,
                        downloadUrl: $this->pathResolver->url($thumbName),
                    );
                }
            }

            // Освобождаем память основного изображения перед следующей итерацией цикла
            unset($baseImage);
        }

        // 8. Создание архива (если нужно)
        $result = $this->prepareResult($processedFiles);

        return $result;
    }

    private function prepareResult(array $processedFiles): ImageProcessingResultDTO
    {
        if (count($processedFiles) === 1) {
            return new ImageProcessingResultDTO(
                isArchive: false,
                downloadUrl: $processedFiles[0]->downloadUrl,
                originalFileName: $processedFiles[0]->filename,
                files: $processedFiles,
            );
        }

        // Создаем архив
        $archiveName = date('Ymd_His') . '_processed_images.zip';
        $archivePath = $this->pathResolver->path($archiveName);

        $zip = new ZipArchive();
        $isOpen = $zip->open($archivePath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        if ($isOpen === true) {
            foreach ($processedFiles as $file) {
                // Защита от Zip Slip: используем только имя файла без путей
                $safeName = basename($file->filename);
                $zip->addFile($file->serverPath, $safeName);
            }
            $zip->close();

            return new ImageProcessingResultDTO(
                isArchive: true,
                downloadUrl: $this->pathResolver->url($archiveName),
                originalFileName: $archiveName,
                files: $processedFiles,
            );
        }

        // Если архив создать не удалось, возвращаем первый файл или ошибку
        // В реальном проекте лучше бросить исключение
        throw new \RuntimeException("Failed to create zip archive at: {$archivePath}");
    }

    private function setUserDirectory(ImageProcessingRequestDTO $dto): void
    {
        $userDirectory = $dto->userContext->getUserDirectory();
        $this->pathResolver->setUserDirectory($userDirectory);
        $this->pathResolver->ensureDirectoryExists();
    }
}
