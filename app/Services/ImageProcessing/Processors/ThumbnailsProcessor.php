<?php

namespace App\Services\ImageProcessing\Processors;

use Intervention\Image\Interfaces\ImageInterface;

class ThumbnailsProcessor
{
    public function process(
        ImageInterface $image,
        ?int $width = null,
        ?int $height = null,
    ): ImageInterface {
        if (!$width && !$height) {
            return $image;
        }

        $image->scaleDown(
            width: $width,
            height: $height
        );

        return $image;
    }
}
