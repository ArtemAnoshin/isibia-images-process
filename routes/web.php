<?php

use App\Http\Controllers\PhotoController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Alignment;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

// Форма для обработки изображений (GET)
Route::get('process-photos', [PhotoController::class, 'index'])
    ->name('process-photos.form');

// Обработка изображений (POST)
Route::post('process-photos', [PhotoController::class, 'processPhotos'])
    ->name('process-photos.process');

// Удаление файлов
Route::delete('/files/{file}', [PhotoController::class, 'destroy'])->name('destroy');
Route::delete('/files', [PhotoController::class, 'destroyAll'])->name('destroyAll');


/*Route::get('/test', function () {
    // create test image
    dd(public_path('test.jpg'));
    $image = ImageManager::usingDriver(Driver::class)->decode(public_path('test.jpg'));

    // write text to image
    $image->text('The quick brown fox', 120, 100, function (FontFactory $font) {
        $font->filepath(resource_path('fonts/arial.ttf'));
        $font->size(70);
        $font->color('fff');
        $font->stroke('ff5500', 2);
        $font->align(Alignment::CENTER, Alignment::TOP);
        $font->lineHeight(1.6);
        $font->angle(10);
        $font->wrap(250);
    });

    $image->save(public_path('test_with_text.jpg'));
});*/
