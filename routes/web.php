<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LockerController;
use Illuminate\Support\Facades\Route;
//user route
Route::prefix('user')->group(function (){
    Route::get('/location', [LocationController::class, 'index'])->name('location-user');
    Route::get('/location/view-locker/{id}', [LocationController::class, 'viewLocker'])->name('view-locker');
});

Route::get('/admin/dashboard', [DashboardController::class, 'adminDashborad'])->name('admin');

Route::prefix('maintenance')->name('maintenance.')->group(function () {
    Route::get('/', [MaintenanceController::class, 'index'])->name('index');
    Route::get('/index', [MaintenanceController::class, 'index'])->name('index'); // → /maintenance/index
    Route::get('/create', [MaintenanceController::class, 'create'])->name('create');
    Route::post('/', [MaintenanceController::class, 'store'])->name('store');
    Route::put('/{maintenance}', [MaintenanceController::class, 'update'])->name('update');
    Route::delete('/{maintenance}', [MaintenanceController::class, 'destroy'])->name('destroy');
});

Route::prefix('locker')->name('locker.')->group(function () {
    Route::get('/', [LocationStaffController::class, 'index'])->name('index');
    Route::get('/index', [LocationStaffController::class, 'index']); // alias, no name to avoid clash
    Route::get('/create', [LocationStaffController::class, 'create'])->name('create');
    Route::post('/', [LocationStaffController::class, 'store'])->name('store');
    Route::get('/{locker}', [LocationStaffController::class, 'show'])->name('show');
    Route::get('/{locker}/edit', [LocationStaffController::class, 'edit'])->name('edit');
    Route::put('/{locker}', [LocationStaffController::class, 'update'])->name('update');
    Route::delete('/{locker}', [LocationStaffController::class, 'destroy'])->name('destroy');
    Route::get('/locker', [LocationStaffController::class, 'index'])->name('location-user');
});


Route::prefix('location')->name('location.')->group(function () {
    Route::get('/', [LockerStaffController::class, 'index'])->name('index');
    Route::get('/create', [LockerStaffController::class, 'create'])->name('create');
    Route::post('/', [LockerStaffController::class, 'store'])->name('store');
    Route::get('/{location}/edit', [LockerStaffController::class, 'edit'])->name('edit');
    Route::put('/{location}', [LockerLockerStaffControllerController::class, 'update'])->name('update');
    Route::delete('/{location}', [LockerStaffController::class, 'destroy'])->name('destroy');
});