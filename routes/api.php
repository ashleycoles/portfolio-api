<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::controller(PostController::class)->group(function () {
    Route::get('/posts', 'all')->name('posts.all');

    Route::post('/posts', 'store')
        ->middleware('auth:sanctum')
        ->name('posts.store');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('auth.login');
});
