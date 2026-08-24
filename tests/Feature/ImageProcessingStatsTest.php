<?php

namespace Tests\Feature;

use App\Models\ProcessedFile;
use App\Services\ModelManagers\User\DTOs\UserContext;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageProcessingStatsTest extends TestCase
{
    use RefreshDatabase;

    public function test_processing_returns_real_file_size_statistics(): void
    {
        config()->set('image.driver', \Intervention\Image\Drivers\Gd\Driver::class);

        $response = $this
            ->withCookie(UserContext::GUEST_COOKIE_NAME, 'stats-test')
            ->post('/process-photos', [
                'files' => [new UploadedFile(
                    public_path('images/artem-main-image.jpg'),
                    'photo.jpg',
                    'image/jpeg',
                    null,
                    true,
                )],
                'source' => 'batch',
                'format' => 'original',
                'originalFileName' => true,
                'includeOriginal' => true,
                'compression' => true,
                'resolution' => ['width' => null, 'height' => null],
                'thumbnails' => [],
            ]);

        $response
            ->assertRedirect(route('process-photos.form'))
            ->assertSessionHas('processed', function (array $result): bool {
                return $result['originalSize'] > 0
                    && $result['processedSize'] > 0
                    && $result['downloadSize'] > 0
                    && $result['fileCount'] === 1;
            });

        $processedFile = ProcessedFile::query()->firstOrFail();
        $this->assertGreaterThan(0, $processedFile->size);

        Storage::disk('public')->delete(
            str_replace('/storage/', '', $processedFile->path),
        );
    }
}
