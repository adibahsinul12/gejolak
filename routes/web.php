<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\CommodityController;
use App\Http\Controllers\Admin\MarketController;
use App\Http\Controllers\Admin\ReasonTemplateController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/jenis', [JenisController::class, 'set'])->name('jenis.set');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('markets', MarketController::class)->except('show');
    Route::resource('commodities', CommodityController::class)->except('show');
    Route::resource('reason-templates', ReasonTemplateController::class)->except('show');
    Route::resource('users', UserController::class)->except('show');
    });
    
    });