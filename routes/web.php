<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

Route::get('/login',[LoginController::class, 'index']);


Route::get('/register', [RegisterController::class, 'index']);

Route::get('/', function () {
    return view('index');
});
