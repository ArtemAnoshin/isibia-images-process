<?php

namespace App\Services\ImageProcessing;

class ImageProcessingService
{
    public function process(array $data)
    {
        foreach ($data['files'] as $file) {
            // пока просто сохраняем
            $file->store('uploads');
        }

        return true;
    }
}
