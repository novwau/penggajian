<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\AttendanceController;
use App\Http\Controllers\Admin\AttendanceVerificationController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\User\SlipGajiController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('login');
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

Route::middleware(['auth'])->group(function () {
    
    // Dashboard - Redirect admin ke admin dashboard
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // Load data untuk dashboard user
        $user = auth()->user();
        $employee = $user->employee;
        $todayAttendance = \App\Models\Attendance::where('user_id', $user->id)
            ->whereDate('tanggal', today())
            ->first();
        $latestPayroll = \App\Models\Payroll::where('user_id', $user->id)
            ->with('period')
            ->latest()
            ->first();
        
        return view('user/dashboard', compact('user', 'employee', 'todayAttendance', 'latestPayroll'));
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

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

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');


     Route::prefix('employees')->name('employees.')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        Route::get('/create', [EmployeeController::class, 'create'])->name('create');
        Route::post('/', [EmployeeController::class, 'store'])->name('store');
        Route::get('/{user}', [EmployeeController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [EmployeeController::class, 'edit'])->name('edit');
        Route::patch('/{user}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/{user}', [EmployeeController::class, 'destroy'])->name('destroy');
        Route::patch('/{user}/reset-password', [EmployeeController::class, 'resetPassword'])->name('reset-password');
    });

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
        $query = \App\Models\Attendance::with('user.employee')  // ← Tambah .employee
            ->whereNull('verified_at')
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc');

        // Filter by status
        if (request('status') && request('status') != 'all') {
            $query->where('status', request('status'));
        }

        $attendances = $query->paginate(20);
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

        // Periode
        Route::get('/periods', [PayrollController::class, 'periods'])->name('periods');
        Route::get('/periods/create', [PayrollController::class, 'createPeriod'])->name('periods.create');
        Route::post('/periods', [PayrollController::class, 'storePeriod'])->name('periods.store');

        // Generate Gaji (INI YANG SEBELUMNYA KOSONG)
        Route::get('/', [PayrollController::class, 'index'])->name('index');

        Route::post(
            '/generate/{user}/{period}',
            [PayrollController::class, 'generate']
        )->name('generate.single');

        Route::post(
            '/generate-bulk/{period}',
            [PayrollController::class, 'generateBulk']
        )->name('generate.bulk');

        // Reports
        Route::get('/reports', [PayrollController::class, 'reports'])->name('reports');
        Route::get('/reports/{period}', [PayrollController::class, 'reportDetail'])->name('reports.detail');
    });

    // Audit Logs
    Route::get('/audit-logs', [AuditLogController::class, 'index'])
    ->name('audit-logs');
});