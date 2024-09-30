<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});
