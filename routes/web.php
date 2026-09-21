<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MaintenanceController;
use Illuminate\Support\Facades\Route;

// user route
Route::redirect('/', '/user/location');

// guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('user')->group(function () {
    Route::get('/location', [LocationController::class, 'index'])->name('location-user');
    Route::get('/location/view-locker/{id}', [LocationController::class, 'viewLocker'])->name('view-locker');
    Route::post('/location/locker/{id}/use', [LocationController::class, 'useLocker'])->name('use-locker');
    Route::post('/location/locker/{id}/release', [LocationController::class, 'releaseLocker'])->name('release-locker');
});

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::prefix('maintenance')->name('maintenance.')->group(function () {
    Route::get('/', [MaintenanceController::class, 'index'])->name('index');
    Route::get('/create', [MaintenanceController::class, 'create'])->name('create');
    Route::post('/', [MaintenanceController::class, 'store'])->name('store');
    Route::put('/{maintenance}', [MaintenanceController::class, 'update'])->name('update');
    Route::delete('/{maintenance}', [MaintenanceController::class, 'destroy'])->name('destroy');
});
