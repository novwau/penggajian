<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\user\AttendanceController;
use App\Http\Controllers\admin\AttendanceVerificationController;
use App\Http\Controllers\admin\PayrollController;
use App\Http\Controllers\user\SlipGajiController;
use Illuminate\Support\Facades\Route;

// Semua API pakai auth:sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Profile API
    Route::get('/profile', [ProfileController::class, 'profileApi']);
    Route::patch('/profile', [ProfileController::class, 'updateApi']);
    Route::delete('/profile', [ProfileController::class, 'destroyApi']);

    // Attendance API
    Route::post('/attendance', [AttendanceController::class, 'checkInApi']);

    // Admin only
    Route::middleware('role:admin')->group(function () {
        Route::post('/attendance/{attendance}/verify', [AttendanceVerificationController::class, 'verifyApi']);
        Route::post('/payroll/{user}/{period}', [PayrollController::class, 'generateApi']);
    });

    // Slip gaji API
    Route::get('/slip-gaji', [SlipGajiController::class, 'indexApi']);
    Route::get('/slip-gaji/{payroll}', [SlipGajiController::class, 'showApi']);
});
