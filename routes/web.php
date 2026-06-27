<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\UtilityPageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PrayerRequestController;
use App\Http\Controllers\PublicSiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicSiteController::class, 'home'])->name('home');
Route::post('/prayer-requests', [PrayerRequestController::class, 'store'])->name('prayer-requests.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [UtilityPageController::class, 'reports'])->name('reports');
    Route::get('/settings', [UtilityPageController::class, 'settings'])->name('settings');
    Route::get('/{module}', [ModuleController::class, 'index'])->name('modules.index');
    Route::get('/{module}/export/{format}', [ModuleController::class, 'export'])->name('modules.export');
});
