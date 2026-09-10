<?php

// app/Http/Controllers/PhotoController.php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessPhotosRequest;
use App\Models\ProcessedFile;
use App\Services\ImageProcessing\DTOs\ImageProcessingRequestDTO;
use App\Services\ImageProcessing\ImageProcessingService;
use App\Services\ModelManagers\ProcessedFile\ProcessedFileRepository;
use App\Services\ModelManagers\ProcessedFile\ProcessedFileSaver;
use App\Services\ModelManagers\User\DTOs\UserContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class PhotoController extends Controller
{
    /**
     * Отображение формы обработки изображений
     *
     * @return Response
     */
    public function index(Request $request, ProcessedFileRepository $repository)
    {
        return $this->renderTool($request, $repository, 'batch');
    }

    /**
     * Отображение инструмента оптимизации изображений для веба.
     */
    public function optimizer(Request $request, ProcessedFileRepository $repository)
    {
        return $this->renderTool($request, $repository, 'optimizer');
    }

    /**
     * Отображение инструмента изменения формата изображений.
     */
    public function converter(Request $request, ProcessedFileRepository $repository)
    {
        return $this->renderTool($request, $repository, 'converter');
    }

    /**
     * Отображение инструмента создания миниатюр.
     */
    public function thumbnails(Request $request, ProcessedFileRepository $repository)
    {
        return $this->renderTool($request, $repository, 'thumbnails');
    }

    private function renderTool(
        Request $request,
        ProcessedFileRepository $repository,
        string $tool
    ) {
        $userContext = UserContext::fromRequest($request);

        // Обработанные файлы пользователя
        $files = $repository->filesForCurrentUser($userContext);

        return Inertia::render('ProcessPhotos/Form', [
            'files' => $files,
            'tool' => $tool,
        ])->rootView('pages.' . $tool);
    }

    /**
     * Обработать загруженные фотографии
     */
    public function processPhotos(
        ProcessPhotosRequest $request,
        ImageProcessingService $service,
        ProcessedFileSaver $processedFileSaver
    ) {
        // Создаем контекст из запроса
        $userContext = UserContext::fromRequest($request);
        $validated = $request->validated();

        // Создаем DTO для передачи данных в сервис - массив файлов, параметры обработки и идентификатор пользователя
        $dto = ImageProcessingRequestDTO::fromArray(
            $validated,
            $userContext
        );

        // TODO: В будущем тут будет RabbitMQ
        $result = $service->process($dto);

        // Сохранить в базу данных информацию о загруженных файлах
        $processedFileSaver->saveProcessedResult($result, $userContext);

        $redirectRoute = match ($validated['source'] ?? 'batch') {
            'optimizer' => 'images.optimizer',
            'converter' => 'images.converter',
            'thumbnails' => 'images.thumbnails',
            default => 'process-photos.form',
        };

        return to_route($redirectRoute)
            ->with('success', 'Файлы обработаны')
            ->with('processed', [
                'isArchive' => $result->isArchive,
                'downloadUrl' => $result->downloadUrl,
                'originalSize' => $result->originalSize,
                'processedSize' => $result->processedSize,
                'downloadSize' => $result->downloadSize,
                'fileCount' => count($result->files),
                'files' => array_map(static fn ($file) => [
                    'filename' => $file->filename,
                    'url' => $file->downloadUrl,
                    'size' => $file->size,
                ], $result->files),
            ]);
    }

    public function destroy(ProcessedFile $file, Request $request)
    {
        $userContext = UserContext::fromRequest($request);

        // Проверка прав: удалять можно только свои файлы
        $this->authorizeDelete($file, $userContext);

        // Удаляем физический файл с диска
        $relativePath = str_replace('/storage/', '', $file->path);

        // Удаляем через Storage
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }

        $file->delete();

        // Возвращаем обновленный список
        return $this->redirectWithUpdatedFiles();
    }

    public function destroyAll(Request $request)
    {
        $userContext = UserContext::fromRequest($request);

        // Получаем все файлы пользователя перед удалением
        $files = ProcessedFile::where(function ($query) use ($userContext) {
            if ($userContext->isAuthorized()) {
                $query->where('user_id', $userContext->userId);
            } else {
                $query->where('anonymous_id', $userContext->guestId);
            }
        })->get();

        // Удаляем файлы с диска
        foreach ($files as $file) {
            $relativePath = str_replace('/storage/', '', $file->path);

            // Удаляем через Storage
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }

        // Удаляем все файлы текущего пользователя/гостя
        ProcessedFile::where(function ($query) use ($userContext) {
            if ($userContext->isAuthorized()) {
                $query->where('user_id', $userContext->userId);
            } else {
                $query->where('anonymous_id', $userContext->guestId);
            }
        })->delete();

        return $this->redirectWithUpdatedFiles();
    }

    private function redirectWithUpdatedFiles()
    {
        return to_route('process-photos.form')
            ->with('success', 'Файлы успешно удалены');
    }

    private function authorizeDelete(ProcessedFile $file, UserContext $context): void
    {
        // Простая проверка: ID владельца должен совпадать с текущим контекстом
        $isOwner = false;

        if ($context->isAuthorized() && $file->user_id == $context->userId) {
            $isOwner = true;
        } elseif (! $context->isAuthorized() && $file->anonymous_id == $context->guestId) {
            $isOwner = true;
        }

        if (! $isOwner) {
            abort(403, 'У вас нет прав на удаление этого файла.');
        }
    }
}
