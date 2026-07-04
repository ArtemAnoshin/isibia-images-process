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

    public function process(ImageProcessingRequestDTO $dto)
    {
        $processedFiles = [];

        // Создание папки пользователя
        $this->setUserDirectory($dto);

        foreach ($dto->files as $file) {
            // Генерация базового имени загруженного файла
            $baseFileName = $this->filenameGenerator->generate($file);

            // Начало работы пакета Intervention
            $baseImage = Image::decode($file);

            // Resize
            if ($dto->needsResize()) {
                // обработка
                $baseImage = $this->resizeProcessor->process(
                    $baseImage,
                    $dto->maxWidth,
                    $dto->maxHeight
                );

                // имя файла
                $baseFileName = $this->filenameGenerator->withSizeSuffix(
                    $baseFileName,
                    $baseImage->width(),
                    $baseImage->height()
                );
            }

            // Миниатюры
            if ($dto->needsThumbnails()) {
                foreach ($dto->thumbnails as $thumbConfig) {
                    // Клонируем изображение, чтобы не менять основной объект $image
                    $thumbImage = clone $baseImage;

                    // обработка
                    $thumbImage = $this->thumbnailsProcessor->process(
                        $thumbImage,
                        $thumbConfig['width'],
                        $thumbConfig['height']
                    );

                    // имя файла
                    $thumbName = $this->filenameGenerator->withSizeSuffix(
                        $baseFileName,
                        $thumbConfig['width'],
                        $thumbConfig['height']
                    );

                    $thumbPath = $this->pathResolver->path($thumbName);

                    // Сохранение миниатюры
                    $thumbImage->save($thumbPath, quality: $dto->compression, format: $file->getClientOriginalExtension());

                    // Добавляем в список результатов
                    $processedFiles[] = new ProcessedImageDTO(
                        filename: $thumbName,
                        serverPath: $thumbPath,
                        downloadUrl: $this->pathResolver->url($thumbName),
                    );
                }
            }

            // Сохраняем изображение в нужном формате и качестве в стораже
            $baseServerPath = $this->pathResolver->path($baseFileName);
            $baseImage->save($baseServerPath, quality: $dto->compression, format: $file->getClientOriginalExtension());

            $processedFiles[] = new ProcessedImageDTO(
                filename: $baseFileName,
                serverPath: $baseServerPath,
                downloadUrl: $this->pathResolver->url($baseFileName),
            );
        }

        if ($dto->needsWatermark()) {
            foreach ($processedFiles as $processedImage) {
                $watermarkImage = Image::decode($processedImage->serverPath);

                // Делегируем всю работу процессору
                $watermarkImage = $this->watermarkProcessor->process(
                    $watermarkImage,
                    $dto->watermarkType,
                    $dto->watermarkText,
                    $dto->watermarkImage,
                    $dto->watermarkX,
                    $dto->watermarkY,
                    $dto->watermarkScale,
                    $dto->watermarkOpacity
                );

                $watermarkImage->save();
            }
        }

        $archiveUrl = null;

        if (count($processedFiles) > 1) {
            // Создаем архив из обработанных файлов
            $archiveName = date('Ymd_His', time()) . '_processed_images.zip';
            $archivePath = $this->pathResolver->path($archiveName);
            $zip = new \ZipArchive();
            if ($zip->open($archivePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
                foreach ($processedFiles as $file) {
                    $zip->addFile($file->serverPath, $file->filename);
                }
                $zip->close();
                $archiveUrl = $this->pathResolver->url($archiveName);
            }
        }

        return new ImageProcessingResultDTO(
            isArchive: count($processedFiles) === 1 ? false : true,
            downloadUrl: count($processedFiles) === 1 ? $processedFiles[0]->downloadUrl : $archiveUrl,
            originalFileName: count($processedFiles) === 1 ? $baseFileName : $archiveName,
            files: $processedFiles,
        );
    }

    private function setUserDirectory(ImageProcessingRequestDTO $dto)
    {
        $userDirectory = $dto->userContext->getUserDirectory();

        // Создаем директорию для пользователя, если ее нет
        $this->pathResolver->setUserDirectory($userDirectory);
        $this->pathResolver->ensureDirectoryExists();

        return $userDirectory;
    }
}
