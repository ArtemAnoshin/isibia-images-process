<?php
// app/Http/Controllers/PhotoController.php

namespace App\Http\Controllers;

use App\Helpers\UserIdentifierHelper;
use App\Http\Requests\ProcessPhotosRequest;
use App\Services\ImageProcessing\DTOs\ImageProcessingRequestDTO;
use App\Services\ImageProcessing\ImageProcessingService;
use App\Services\ModelManagers\ProcessedFile\ProcessedFileSaver;
use App\Services\ModelManagers\ProcessedFile\ProcessedFileRepository;
use Inertia\Inertia;

class PhotoController extends Controller
{
    /**
     * Отображение формы обработки изображений
     * @param ProcessedFileRepository $repository
     * @return \Inertia\Response
     */
    public function index(ProcessedFileRepository $repository)
    {
        // Обработанные файлы пользователя
        $files = $repository->filesForCurrentUser();

        return Inertia::render('ProcessPhotos/Form', [
            'files' => $files,
        ]);
    }

    /**
     * Обработать загруженные фотографии
     */
    public function processPhotos(
        ProcessPhotosRequest $request,
        ImageProcessingService $service,
        ProcessedFileSaver $processedFileSaver,
    )
    {
        // Получаем идентификатор из сессии
        $identifier = UserIdentifierHelper::getIdentifier();

        // Создаем DTO для передачи данных в сервис - массив файлов, параметры обработки и идентификатор пользователя
        $dto = ImageProcessingRequestDTO::fromArray(
            $request->validated(),
            $identifier
        );

        // TODO: В будущем тут будет RabbitMQ
        $result = $service->process($dto);

        // Сохранить в базу данных информацию о загруженных файлах
        $processedFileSaver->saveProcessedResult($result);

        return back()->with([
            'success' => 'Файлы обработаны',

            'processed' => [
                'isArchive' => $result->isArchive,
                'downloadUrl' => $result->downloadUrl,

                'files' => collect($result->files)
                    ->map(fn ($file) => [
                        'filename' => $file->filename,
                        'url' => $file->url,
                    ])
                    ->values(),
            ],
        ]);
    }
}
