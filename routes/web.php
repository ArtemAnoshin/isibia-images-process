<?php

use App\Http\Controllers\PhotoController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

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
