<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::controller(PostController::class)->group(function () {
    Route::get('/posts', 'all')->name('posts.all');
    Route::get('/posts/{slug}', 'find')->name('posts.find');

    Route::post('/posts', 'store')
        ->middleware('auth:sanctum')
        ->name('posts.store');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('auth.login');
    Route::get('/validate', 'validate')
        ->middleware('auth:sanctum')
        ->name('auth.validate');
});

Route::controller(CacheController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::delete('/cache', 'flush')->name('cache.flush');
    });
