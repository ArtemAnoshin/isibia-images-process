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

        $service->process($dto);

        return back()->with('success', 'Файлы загружены');
    }
}
