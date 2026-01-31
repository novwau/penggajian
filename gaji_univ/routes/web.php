<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\user\AttendanceController;
use App\Http\Controllers\admin\AttendanceVerificationController;
use App\Http\Controllers\admin\PayrollController;
use App\Http\Controllers\user\SlipGajiController;
use App\Models\Payroll;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Attendance & Payroll routes
Route::middleware('auth')->group(function () {
    Route::post('/attendance', [AttendanceController::class, 'checkIn']);

    Route::get('/slip-gaji', function() {
        $payrolls = \App\Models\Payroll::where('user_id', auth()->id())
            ->where('is_active', true)
            ->with('period')
            ->get();

        return view('slipgaji.index', compact('payrolls'));
    });

     Route::get('/slip-gaji/{payroll}', function(Payroll $payroll) {
        if (auth()->id() !== $payroll->user_id && ! auth()->user()->hasRole('admin')) {
            return redirect('/slip-gaji')->with('error', 'Tidak punya akses.');
        }

        $payroll->load('details','period');

        return view('slipgaji.show', compact('payroll'));
    });

    Route::middleware('role:admin')->group(function () {
        Route::post('/attendance/{attendance}/verify', [AttendanceVerificationController::class, 'verify']);
        Route::post('/payroll/{user}/{period}', [PayrollController::class, 'generate']);
    });

    Route::get('/slip-gaji', [SlipGajiController::class, 'index']);
    Route::get('/slip-gaji/{payroll}', [SlipGajiController::class, 'show']);
});

require __DIR__.'/auth.php';
