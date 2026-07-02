<?php
// app/Http/Controllers/PhotoController.php

namespace App\Http\Controllers;

use App\Helpers\UserIdentifierHelper;
use App\Http\Requests\ProcessPhotosRequest;
use App\Services\ImageProcessing\DTOs\ImageProcessingRequestDTO;
use App\Services\ImageProcessing\ImageProcessingService;
use App\Services\ModelManagers\ProcessedFile\ProcessedFileSaver;
use App\Services\ModelManagers\ProcessedFile\ProcessedFileRepository;
use App\Services\ModelManagers\User\DTOs\UserContext;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PhotoController extends Controller
{
    /**
     * Отображение формы обработки изображений
     * @param ProcessedFileRepository $repository
     * @return \Inertia\Response
     */
    public function index(Request $request, ProcessedFileRepository $repository)
    {
        $userContext = UserContext::fromRequest($request);

        // Обработанные файлы пользователя
        $files = $repository->filesForCurrentUser($userContext);

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
        ProcessedFileRepository $repository
    )
    {
        // Создаем контекст из запроса
        $userContext = UserContext::fromRequest($request);

        // Создаем DTO для передачи данных в сервис - массив файлов, параметры обработки и идентификатор пользователя
        $dto = ImageProcessingRequestDTO::fromArray(
            $request->validated(),
            $userContext
        );

        // TODO: В будущем тут будет RabbitMQ
        $result = $service->process($dto);

        // Сохранить в базу данных информацию о загруженных файлах
        $processedFileSaver->saveProcessedResult($result, $userContext);

        // Получим все файлы пользователя
        $updatedFiles = $repository->filesForCurrentUser($userContext);

        return Inertia::render('ProcessPhotos/Form', [
            'files' => $updatedFiles,
            'flash' => [
                'success' => 'Файлы обработаны',
                'processed' => [
                    'isArchive' => $result->isArchive,
                    'downloadUrl' => $result->downloadUrl,
                ]
            ],
        ]);
    }
}
