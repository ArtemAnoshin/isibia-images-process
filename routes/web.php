<?php

use App\Http\Controllers\AboutDeveloperPageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PhotoController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

// Форма для обработки изображений (GET)
Route::get('/', [PhotoController::class, 'index'])
    ->name('process-photos.form');

Route::get('/image-optimizer', [PhotoController::class, 'optimizer'])
    ->name('images.optimizer');

Route::get('/convert-images', [PhotoController::class, 'converter'])
    ->name('images.converter');

Route::get('/create-thumbnails', [PhotoController::class, 'thumbnails'])
    ->name('images.thumbnails');

Route::redirect('/compress-images', '/image-optimizer', 301);

Route::get('/sitemap.xml', function () {
    return response()
        ->view('sitemap')
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

// Обработка изображений (POST)
Route::post('process-photos', [PhotoController::class, 'processPhotos'])
    ->name('process-photos.process');

// Удаление файлов
Route::delete('/files/{file}', [PhotoController::class, 'destroy'])->name('destroy');
Route::delete('/files', [PhotoController::class, 'destroyAll'])->name('destroyAll');

// Страница о разработчике
Route::get('/about-developer', [AboutDeveloperPageController::class, 'page'])
    ->name('about-developer-page');

// Обработка запроса с контактной формы
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
