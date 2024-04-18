<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/', [BlogController::class, 'index'])->name('guests.page');
Route::get('/dashboard', [BlogController::class, 'user_blog'])->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('blogs', BlogController::class);
