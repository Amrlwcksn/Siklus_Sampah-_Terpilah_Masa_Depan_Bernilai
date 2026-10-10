<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CustomerController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->name('dashboard.admin');

    Route::get('/pelanggan/dashboard', [DashboardController::class, 'pelanggan'])
        ->name('dashboard.pelanggan');

    Route::get('/petugas/dashboard', [DashboardController::class, 'petugas'])
        ->name('dashboard.petugas');

        Route::get('/admin/pelanggan', [CustomerController::class, 'index'])
    ->name('admin.customers.index');
});
