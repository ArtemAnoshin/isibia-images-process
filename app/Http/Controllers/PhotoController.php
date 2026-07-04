<?php
// app/Http/Controllers/PhotoController.php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessPhotosRequest;
use App\Models\ProcessedFile;
use App\Services\ImageProcessing\DTOs\ImageProcessingRequestDTO;
use App\Services\ImageProcessing\ImageProcessingService;
use App\Services\ModelManagers\ProcessedFile\ProcessedFileSaver;
use App\Services\ModelManagers\ProcessedFile\ProcessedFileRepository;
use App\Services\ModelManagers\User\DTOs\UserContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function destroy(ProcessedFile $file, Request $request)
    {
        $userContext = UserContext::fromRequest($request);

        // Проверка прав: удалять можно только свои файлы
        $this->authorizeDelete($file, $userContext);

        // Удаляем физический файл с диска (если нужно)
        Storage::delete($file->path);

        $file->delete();

        // Возвращаем обновленный список
        return $this->redirectWithUpdatedFiles($request);
    }

    public function destroyAll(Request $request)
    {
        $userContext = UserContext::fromRequest($request);

        // Удаляем все файлы текущего пользователя/гостя
        ProcessedFile::where(function ($query) use ($userContext) {
            if ($userContext->isAuthorized()) {
                $query->where('user_id', $userContext->userId);
            } else {
                $query->where('anonymous_id', $userContext->guestId);
            }
        })->delete();

        return $this->redirectWithUpdatedFiles($request);
    }

    private function redirectWithUpdatedFiles(Request $request)
    {
        $userContext = UserContext::fromRequest($request);
        $repository = app()->make(ProcessedFileRepository::class);

        return Inertia::render('ProcessPhotos/Form', [
            'files' => $repository->filesForCurrentUser($userContext),
            'flash' => [
                'success' => 'Файлы успешно удалены',
            ],
        ]);
    }

    private function authorizeDelete(ProcessedFile $file, UserContext $context): void
    {
        // Простая проверка: ID владельца должен совпадать с текущим контекстом
        $isOwner = false;

        if ($context->isAuthorized() && $file->user_id == $context->userId) {
            $isOwner = true;
        } elseif (!$context->isAuthorized() && $file->anonymous_id == $context->guestId) {
            $isOwner = true;
        }

        if (!$isOwner) {
            abort(403, 'У вас нет прав на удаление этого файла.');
        }
    }
}
