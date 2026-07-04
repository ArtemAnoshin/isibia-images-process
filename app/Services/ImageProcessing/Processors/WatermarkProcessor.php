<?php

namespace App\Services\ImageProcessing\Processors;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Typography\FontFactory;

class WatermarkProcessor
{
    public function process(
        ImageInterface $image,
        ?string $type,
        ?string $text,
        ?UploadedFile $watermarkFile,
        ?float $x,
        ?float $y,
        ?float $scale,
        ?int $opacity
    ): ImageInterface {
        $imgWidth = $image->width();
        $imgHeight = $image->height();

        if ($type === 'text') {
            $image = $this->applyTextWatermark(
                $image,
                $text ?? 'Watermark',
                $x ?? 0.95,
                $y ?? 0.95,
                $opacity ?? 50
            );
        } elseif ($type === 'image' && $watermarkFile) {
            $image = $this->applyImageWatermark(
                $image,
                $watermarkFile,
                $x ?? 0.5,
                $y ?? 0.5,
                $scale ?? 0.2,
                $opacity ?? 50,
                $imgWidth,
                $imgHeight
            );
        }

        return $image;
    }

    private function applyTextWatermark(
        ImageInterface $image,
        string $text,
        float $x,
        float $y,
        int $opacity
    ): ImageInterface {
        $pixelX = (int) ($x * $image->width());
        $pixelY = (int) ($y * $image->height());

        // В v4 текст накладывается через метод text() с использованием FontFactory
        $image->text($text, $pixelX, $pixelY, function (FontFactory $font) use ($opacity) {
            $font->filename(resource_path('fonts/arial.ttf')); // Путь к шрифту
            $font->size(24);
            $font->color('#ffffff');
            $font->align('center');
        });

        return $image;
    }

    private function applyImageWatermark(
        ImageInterface $image,
        UploadedFile $watermarkFile,
        float $x,
        float $y,
        float $scale,
        int $opacity,
        int $baseWidth,
        int $baseHeight
    ): ImageInterface {
        $wmImage = Image::decode($watermarkFile->getRealPath());

        // Масштабируем водяной знак
        $newWidth = (int) ($baseWidth * $scale);
        $wmImage->scale(width: $newWidth);

        $pixelX = (int) ($x * $baseWidth);
        $pixelY = (int) ($y * $baseHeight);

        // В v4 метод place принимает изображение и координаты
        $image->insert($wmImage, $pixelX, $pixelY);

        return $image;
    }
}
