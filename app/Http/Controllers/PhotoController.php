<?php
// app/Http/Controllers/PhotoController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Обработать загруженные фотографии
     */
    public function processPhotos(Request $request)
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        $processedPhotos = [];

        foreach ($request->file('photos') as $photo) {
            $originalName = $photo->getClientOriginalName();
            $originalSize = $photo->getSize();

            // Загружаем через GD
            $image = imagecreatefromstring(file_get_contents($photo));

            if ($image) {
                // Генерируем имя файла
                $filename = time() . '_' . uniqid() . '.jpg';
                $path = 'processed/' . $filename;
                $fullPath = Storage::disk('public')->path($path);

                // Создаем директорию если нет
                $dir = dirname($fullPath);
                if (!file_exists($dir)) {
                    mkdir($dir, 0755, true);
                }

                // Сохраняем с качеством 90%
                imagejpeg($image, $fullPath, 90);
                imagedestroy($image);

                $newSize = filesize($fullPath);

                $processedPhotos[] = [
                    'original_name' => $originalName,
                    'url' => Storage::disk('public')->url($path),
                    'original_size' => $this->formatBytes($originalSize),
                    'new_size' => $this->formatBytes($newSize),
                    'saved' => $this->formatBytes($originalSize - $newSize)
                ];
            }
        }

        return redirect()->route('dashboard.process-photos.form')
            ->with('processedPhotos', $processedPhotos);
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
