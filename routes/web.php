<?php

use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Master\MediaController;
use App\Http\Controllers\Master\ThemeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Theme
    Route::get('/theme', [ThemeController::class, 'index'])->name('theme.index');
    Route::post('/create-theme', [ThemeController::class, 'store'])->name('theme.create');
    Route::get('/theme/{id}/edit', [ThemeController::class, 'edit'])->name('theme.edit');
    Route::post('/theme/{id}/edit', [ThemeController::class, 'update'])->name('theme.update');
    Route::delete('/theme/{id}', [ThemeController::class, 'destroy'])->name('theme.destroy');

     // Route Media
     Route::get('/media', [MediaController::class, 'index'])->name('media.index');
     Route::post('/create-media', [MediaController::class, 'store'])->name('media.create');
     Route::get('/media/{id}/edit', [MediaController::class, 'edit'])->name('media.edit');
     Route::post('/media/{id}/edit', [MediaController::class, 'update'])->name('media.update');
     Route::delete('/media/{id}', [MediaController::class, 'destroy'])->name('media.destroy');

});

Route::get('/', [FrontController::class, 'index'])->name('index');
Route::get('/theme/details', [FrontController::class, 'theme'])->name('theme');
Route::get('/theme/details/{id}', [FrontController::class, 'themeDetails'])->name('themeDetails');
Route::get('/theme/details/kosakata/{id}', [FrontController::class, 'themeDetailsKosakata'])->name('themeDetailsKosakata');
Route::get('/theme/details/video/{id}', [FrontController::class, 'themeDetailsVideo'])->name('themeDetailsVideo');
Route::get('/theme/details/quiz/{id}', [FrontController::class, 'themeDetailsQuiz'])->name('themeDetailsQuiz');
Route::get('/theme/details/quiz/mulai/{id}', [FrontController::class, 'themeDetailsQuizMulai'])->name('themeDetailsQuizMulai');
Route::get('/front/profil', [FrontController::class, 'frontProfil'])->name('frontProfil');
Route::get('/juknis', [FrontController::class, 'juknis'])->name('juknis');


require __DIR__.'/auth.php';
