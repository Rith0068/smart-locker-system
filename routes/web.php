<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;

//user route
Route::prefix('user')->group(function (){
    Route::get('/location', [LocationController::class, 'index'])->name('location-user');
    Route::get('/location/view-locker/{id}', [LocationController::class, 'viewLocker'])->name('view-locker');
});
