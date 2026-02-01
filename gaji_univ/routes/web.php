<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\user\AttendanceController;
use App\Http\Controllers\admin\AttendanceVerificationController;
use App\Http\Controllers\admin\PayrollController;
use App\Http\Controllers\user\SlipGajiController;
use App\Models\Payroll;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| User/Employee Routes (Dosen & Karyawan)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard - Redirect admin ke admin dashboard
    Route::get('/dashboard', function () {
        // Jika admin, redirect ke admin dashboard
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Attendance (Presensi)
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', function () {
            return view('attendance.index');
        })->name('index');
        
        Route::post('/check-in', [AttendanceController::class, 'checkIn'])->name('checkin');
        
        Route::get('/history', function () {
            $attendances = \App\Models\Attendance::where('user_id', auth()->id())
                ->orderBy('tanggal', 'desc')
                ->paginate(20);
            return view('attendance.history', compact('attendances'));
        })->name('history');
    });

    // Slip Gaji (Payroll)
    Route::prefix('payroll')->name('payroll.')->group(function () {
        Route::get('/', [SlipGajiController::class, 'index'])->name('index');
        Route::get('/{payroll}', [SlipGajiController::class, 'show'])->name('show');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Admin routes dengan RoleMiddleware
// Kalau sudah daftarkan alias di bootstrap/app.php, pakai: 'role:admin'
// Kalau belum, pakai: RoleMiddleware::class.':admin'
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Kelola Pegawai (Users/Employees)
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', function () {
            $users = \App\Models\User::with('employee')->paginate(20);
            return view('admin.users.index', compact('users'));
        })->name('index');
        
        Route::get('/create', function () {
            return view('admin.users.create');
        })->name('create');
        
        Route::post('/', function () {
            // Store logic here
        })->name('store');
        
        Route::get('/{user}', function (\App\Models\User $user) {
            return view('admin.users.show', compact('user'));
        })->name('show');
        
        Route::get('/{user}/edit', function (\App\Models\User $user) {
            return view('admin.users.edit', compact('user'));
        })->name('edit');
        
        Route::patch('/{user}', function (\App\Models\User $user) {
            // Update logic here
        })->name('update');
        
        Route::delete('/{user}', function (\App\Models\User $user) {
            // Delete logic here
        })->name('destroy');
    });

    // Verifikasi Presensi
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', function () {
            $attendances = \App\Models\Attendance::with('user')
                ->whereNull('verified_at')
                ->orderBy('tanggal', 'desc')
                ->paginate(20);
            return view('admin.attendance.index', compact('attendances'));
        })->name('index');
        
        Route::post('/{attendance}/verify', [AttendanceVerificationController::class, 'verify'])->name('verify');
        
        Route::get('/verified', function () {
            $attendances = \App\Models\Attendance::with('user')
                ->whereNotNull('verified_at')
                ->orderBy('verified_at', 'desc')
                ->paginate(20);
            return view('admin.attendance.verified', compact('attendances'));
        })->name('verified');
    });

    // Payroll Management
    Route::prefix('payroll')->name('payroll.')->group(function () {
        
        // Periode Gaji
        Route::get('/periods', function () {
            $periods = \App\Models\PayrollPeriod::orderBy('start_date', 'desc')->paginate(20);
            return view('admin.payroll.periods', compact('periods'));
        })->name('periods');
        
        Route::get('/periods/create', function () {
            return view('admin.payroll.periods-create');
        })->name('periods.create');
        
        Route::post('/periods', function () {
            // Store period logic
        })->name('periods.store');
        
        // Generate Gaji
        Route::get('/', function () {
            $periods = \App\Models\PayrollPeriod::where('status', 'active')->get();
            $users = \App\Models\User::with('employee')->get();
            return view('admin.payroll.index', compact('periods', 'users'));
        })->name('index');
        
        Route::post('/generate/{user}/{period}', [PayrollController::class, 'generate'])->name('generate');
        
        Route::post('/generate-bulk/{period}', function (\App\Models\PayrollPeriod $period) {
            // Bulk generate logic
        })->name('generate.bulk');
        
        // Laporan Gaji
        Route::get('/reports', function () {
            $payrolls = \App\Models\Payroll::with(['user', 'period'])
                ->orderBy('created_at', 'desc')
                ->paginate(20);
            return view('admin.payroll.reports', compact('payrolls'));
        })->name('reports');
        
        Route::get('/reports/{period}', function (\App\Models\PayrollPeriod $period) {
            $payrolls = \App\Models\Payroll::with(['user', 'details'])
                ->where('payroll_period_id', $period->id)
                ->get();
            return view('admin.payroll.report-detail', compact('period', 'payrolls'));
        })->name('reports.detail');
    });

    // Audit Logs
    Route::get('/audit-logs', function () {
        $logs = \App\Models\AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        return view('admin.audit-logs', compact('logs'));
    })->name('audit-logs');
});