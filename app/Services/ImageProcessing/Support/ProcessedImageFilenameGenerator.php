<?php

namespace App\Services\ImageProcessing\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ProcessedImageFilenameGenerator
{
    public function generate(
        UploadedFile $file
    ): string {

        $extension = strtolower(
            $file->getClientOriginalExtension()
        );

        return Str::uuid() . '.' . $extension;
    }

    /**
     * Добавляет суффикс размеров к базовому имени
     * Пример: image_uuid.jpg -> image_uuid_800x600.jpg
     */
    public function withSizeSuffix(string $baseName, ?int $width, ?int $height): string
    {
        if (!$width && !$height) {
            return $baseName;
        }

        $suffix = '';
        if ($width) $suffix .= "{$width}w";
        if ($height) $suffix .= "x{$height}h";

        // Убираем последнее расширение, добавляем суффикс и возвращаем расширение обратно
        $extension = pathinfo($baseName, PATHINFO_EXTENSION);
        $nameWithoutExt = pathinfo($baseName, PATHINFO_FILENAME);

        return "{$nameWithoutExt}_{$suffix}.{$extension}";
    }
}
