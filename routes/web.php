<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LockerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MaintenanceController;


// guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('user')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'userIndex'])->name('user.dashboard.index');

    Route::prefix('/location')->group(function() {
        Route::get('/', [LocationController::class, 'index'])->name('location-user');
        Route::get('/view-locker/{id}', [LocationController::class, 'viewLocker'])->name('view-locker');
        Route::post('/locker/{id}/use', [LocationController::class, 'useLocker'])->name('use-locker');
        Route::post('/locker/{id}/release', [LocationController::class, 'releaseLocker'])->name('release-locker');
    });
});


Route::prefix('admin')->group( function(){

    Route::get('/', [DashboardController::class, 'adminIndex'])->name('admin.dashboard');

    Route::prefix('maintenance')->name('maintenance.')->group(function () {
        Route::get('/', [MaintenanceController::class, 'index'])->name('index');
        Route::get('/create', [MaintenanceController::class, 'create'])->name('create');
        Route::post('/', [MaintenanceController::class, 'store'])->name('store');
        Route::put('/{maintenance}', [MaintenanceController::class, 'update'])->name('update');
        Route::delete('/{maintenance}', [MaintenanceController::class, 'destroy'])->name('destroy');
    });


    Route::prefix('locker')->name('locker.')->group(function () {
        Route::get('/', [LockerController::class, 'index'])->name('index');
        Route::get('/create', [LockerController::class, 'create'])->name('create');
        Route::post('/', [LockerController::class, 'store'])->name('store');
        Route::get('/{locker}', [LockerController::class, 'show'])->name('show');
        Route::get('/{locker}/edit', [LockerController::class, 'edit'])->name('edit');
        Route::put('/{locker}', [LockerController::class, 'update'])->name('update');
        Route::delete('/{locker}', [LockerController::class, 'destroy'])->name('destroy');
    });


    Route::prefix('location')->name('location.')->group(function () {
        Route::get('/', [LocationController::class, 'index'])->name('index');
        Route::get('/create', [LocationController::class, 'create'])->name('create');
        Route::post('/', [LocationController::class, 'store'])->name('store');
        Route::get('/{location}/edit', [LocationController::class, 'edit'])->name('edit');
        Route::put('/{location}', [LocationController::class, 'update'])->name('update');
        Route::delete('/{location}', [LocationController::class, 'destroy'])->name('destroy');
    });


});