<?php

use App\Http\Controllers\PageDisplayController;
use Illuminate\Support\Facades\Route;


require __DIR__.'/auth.php';


//Route::get('/', function () {
//    return ['Laravel' => app()->version()];
//});

Route::get('/', [PageDisplayController::class, 'home'])->name('frontend.home');

Route::get('pages/{slug}', [PageDisplayController::class, 'show'])->name('frontend.page');
