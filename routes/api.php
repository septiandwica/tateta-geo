<?php

use App\Http\Controllers\RegionController;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        $dbStatus = 'connected';
    } catch (\Exception $e) {
        $dbStatus = 'disconnected';
    }

    return response()->json([
        'status' => 'healthy',
        'database' => $dbStatus,
        'timestamp' => now()->toIso8601String(),
    ]);
});

Route::prefix('v1/geo')->middleware('auth:sanctum')->group(function () {
    Route::get('/provinces', [RegionController::class, 'provinces']);
    Route::get('/provinces/find', [RegionController::class, 'findProvince']);

    Route::get('/regencies', [RegionController::class, 'regencies']);
    Route::get('/regencies/find', [RegionController::class, 'findRegency']);

    Route::get('/districts', [RegionController::class, 'districts']);
    Route::get('/districts/find', [RegionController::class, 'findDistrict']);

    Route::get('/villages', [RegionController::class, 'villages']);
    Route::get('/villages/find', [RegionController::class, 'findVillage']);
});
