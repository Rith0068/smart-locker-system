<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LockerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\LocationStaffController;

//user route
Route::prefix('user')->group(function (){
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

Route::get('/admin/dashboard', [DashboardController::class, 'adminDashborad'])->name('admin.dashboard');

Route::prefix('maintenance')->name('maintenance.')->group(function () {
    Route::get('/', [MaintenanceController::class, 'index'])->name('index');
    Route::get('/create', [MaintenanceController::class, 'create'])->name('create');
    Route::post('/', [MaintenanceController::class, 'store'])->name('store');
    Route::put('/{maintenance}', [MaintenanceController::class, 'update'])->name('update');
    Route::delete('/{maintenance}', [MaintenanceController::class, 'destroy'])->name('destroy');
});

Route::prefix('locker')->name('locker.')->group(function () {
    Route::get('/', [LockerController::class, 'index'])->name('index');
    Route::get('/index', [LockerController::class, 'index']); // alias, no name to avoid clash
    Route::get('/create', [LockerController::class, 'create'])->name('create');
    Route::post('/', [LockerController::class, 'store'])->name('store');
    Route::get('/{locker}', [LockerController::class, 'show'])->name('show');
    Route::get('/{locker}/edit', [LockerController::class, 'edit'])->name('edit');
    Route::put('/{locker}', [LockerController::class, 'update'])->name('update');
    Route::delete('/{locker}', [LockerController::class, 'destroy'])->name('destroy');
});

Route::prefix('location')->name('location.')->group(function () {
    Route::get('/', [LockerStaffController::class, 'index'])->name('index');
    Route::get('/create', [LockerStaffController::class, 'create'])->name('create');
    Route::post('/', [LockerStaffController::class, 'store'])->name('store');
    Route::get('/{location}/edit', [LockerStaffController::class, 'edit'])->name('edit');
    Route::put('/{location}', [LockerLockerStaffControllerController::class, 'update'])->name('update');
    Route::delete('/{location}', [LockerStaffController::class, 'destroy'])->name('destroy');
});
