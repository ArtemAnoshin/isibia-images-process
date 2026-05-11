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
}
