<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PropertyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', function () {
        return view('admin.login');
    })->name('admin.login');

    Route::post('/admin/login', [AuthController::class, 'login'])
        ->name('admin.login.submit');
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('admin.logout');

    Route::prefix('api')->group(function () {
        Route::get('/properties', [PropertyController::class, 'getAll']);
        Route::put('/properties/{property}', [PropertyController::class, 'update']);
        Route::patch('/properties/{property}/status', [PropertyController::class, 'updateStatus']);
    });
});
