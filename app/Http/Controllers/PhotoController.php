<?php
// app/Http/Controllers/PhotoController.php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessPhotosRequest;
use App\Services\ImageProcessing\DTOs\ImageProcessingRequestDTO;
use App\Services\ImageProcessing\ImageProcessingService;

class PhotoController extends Controller
{
    /**
     * Обработать загруженные фотографии
     */
    public function processPhotos(ProcessPhotosRequest $request, ImageProcessingService $service)
    {
        $dto = ImageProcessingRequestDTO::fromArray(
            $request->validated()
        );

        $result = $service->process($dto);

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
