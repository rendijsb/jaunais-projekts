<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PropertyController;
use App\Models\Property;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/floors', function () {
    $properties = Property::all();

    $floorData = $properties->groupBy('floor')->map(function ($properties, $floor) {
        $availableCount = $properties->where('status', 'available')->count();
        $minPrice = $properties->min('price');
        $maxPrice = $properties->max('price');

        return [
            'level' => $floor,
            'total_units' => $properties->count(),
            'available_units' => $availableCount,
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'properties' => $properties->map(function ($property) {
                return [
                    'id' => $property->id,
                    'flat_number' => $property->flat_number,
                    'flat_area' => $property->flat_area,
                    'total_area' => $property->total_area,
                    'terrace_area' => $property->terrace_area,
                    'balcony_area' => $property->balcony_area,
                    'price' => $property->price,
                    'status' => $property->status,
                ];
            })->values(),
        ];
    })->sortKeys()->values();

    return response()->json($floorData);
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
