<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/services')
    ->name('service.')
    ->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('.index');
        Route::get('/all', [ServiceController::class, 'getAllServices'])->name('.getAllServices');
        Route::get('/{service}', [ServiceController::class, 'show'])->name('.show');
    });

Route::prefix('products')
    ->name('product.')
    ->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('.index');
        Route::get('/all', [ProductController::class, 'getAllProducts'])->name('.getAllProducts');
        Route::get('/{product}', [ProductController::class, 'show'])->name('.show');
    });
