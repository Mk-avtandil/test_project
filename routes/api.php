<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('services')
    ->name('service.')
    ->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('index');
        Route::get('/all', [ServiceController::class, 'getAllServices'])->name('getAllServices');
        Route::get('/{id}', [ServiceController::class, 'show'])->name('show');
    });

Route::prefix('products')
    ->name('product.')
    ->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/all', [ProductController::class, 'getAllProducts'])->name('getAllProducts');
        Route::get('/{id}', [ProductController::class, 'show'])->name('show');
    });

Route::prefix('orders')
   ->middleware(['auth:sanctum'])
    ->name('order.')
    ->group(function () {
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::put('/{order}', [OrderController::class, 'update'])->name('update');
    });

Route::prefix('comments')
    ->middleware(['auth:sanctum'])
    ->name('comment.')
    ->group(function () {
        Route::post('/', [CommentController::class, 'store'])->name('store');
    });
