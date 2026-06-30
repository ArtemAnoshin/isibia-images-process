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

// Для страницы с формой (GET запрос)
Route::get('process-photos', [PhotoController::class, 'index'])
    ->name('process-photos.form');

// Для обработки POST запроса (обычный Route, не inertia)
Route::post('process-photos', [PhotoController::class, 'processPhotos'])
    ->name('process-photos.process');

require __DIR__.'/settings.php';
