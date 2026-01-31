<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\user\AttendanceController;
use App\Http\Controllers\admin\AttendanceVerificationController;
use App\Http\Controllers\admin\PayrollController;
use App\Http\Controllers\user\SlipGajiController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {

    Route::post('/attendance', [AttendanceController::class, 'checkIn']);

    Route::middleware('role:admin')->group(function () {
        Route::post('/attendance/{attendance}/verify', [AttendanceVerificationController::class, 'verify']);
        Route::post('/payroll/{user}/{period}', [PayrollController::class, 'generate']);
    });

    Route::get('/slip-gaji', [SlipGajiController::class, 'index']);
    Route::get('/slip-gaji/{payroll}', [SlipGajiController::class, 'show']);
});


require __DIR__.'/auth.php';
