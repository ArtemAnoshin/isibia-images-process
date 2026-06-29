<?php

namespace App\Services\ImageProcessing\DTOs;

use Illuminate\Http\UploadedFile;

class ImageProcessingRequestDTO
{
    /**
     * @param UploadedFile[] $files
     */
    public function __construct(
        public readonly ?string $identifier,

        public readonly array $files,

        public readonly int $compression,

        public readonly ?int $maxWidth,
        public readonly ?int $maxHeight,

        public readonly array $thumbnails,

        public readonly bool $watermarkEnabled,
        public readonly ?string $watermarkType,
        public readonly ?string $watermarkText,
        public readonly ?UploadedFile $watermarkImage,
        public readonly ?float $watermarkX,
        public readonly ?float $watermarkY,
        public readonly ?float $watermarkScale,
        public readonly ?int $watermarkOpacity,
    ) {
    }

    public function needsResize(): bool
    {
        return $this->maxWidth !== null
            || $this->maxHeight !== null;
    }

    public function needsWatermark(): bool
    {
        return $this->watermarkEnabled;
    }

    public function usesTextWatermark(): bool
    {
        return $this->watermarkType === 'text';
    }

    public function usesImageWatermark(): bool
    {
        return $this->watermarkType === 'image';
    }

    public function needsThumbnails(): bool
    {
        return !empty($this->thumbnails);
    }

    public static function fromArray(array $data, ?string $identifier = null): self
    {
        return new self(
            identifier: $identifier,

            files: $data['files'],

            compression: $data['compression'],

            maxWidth: $data['resolution']['width'] ?? null,
            maxHeight: $data['resolution']['height'] ?? null,

            thumbnails: $data['thumbnails'] ?? [],

            watermarkEnabled: $data['watermark']['enabled'] ?? false,
            watermarkType: $data['watermark']['type'] ?? null,
            watermarkText: $data['watermark']['text'] ?? null,
            watermarkImage: $data['watermark']['image'] ?? null,

            watermarkX: $data['watermark']['x'] ?? null,
            watermarkY: $data['watermark']['y'] ?? null,
            watermarkScale: $data['watermark']['scale'] ?? null,
            watermarkOpacity: $data['watermark']['opacity'] ?? null,
        );
    }
}
