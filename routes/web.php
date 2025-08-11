<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\ProfileController;

Route::get('/', fn () => auth()->check()
    ? redirect()->route('dashboard')
    : redirect()->route('login'));

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [StreamController::class, 'index'])->name('dashboard'); // now "Stream"
    Route::post('/stream/comments', [StreamController::class, 'store'])->name('stream.comments.store');

    // Breeze profile (optional but usually present)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
