<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/services')->name('service.')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('.index');
    Route::get('/{service}', [ServiceController::class, 'show'])->name('.show');
});

Route::prefix('products')
    ->name('product.')
    ->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show');
});