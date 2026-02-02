<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\AttendanceController as UserAttendanceController;
use App\Http\Controllers\User\SlipGajiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\AttendanceVerificationController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\UserPayrollComponentController;
use App\Http\Controllers\Admin\PayrollComponentController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Dosen & Karyawan)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    | Dashboard
    */
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $employee = $user->employee;

        $todayAttendance = \App\Models\Attendance::where('user_id', $user->id)
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        $latestPayroll = \App\Models\Payroll::where('user_id', $user->id)
            ->with('period')
            ->latest()
            ->first();

        return view('user.dashboard', compact(
            'user',
            'employee',
            'todayAttendance',
            'latestPayroll'
        ));
    })->name('dashboard');

    /*
    | Profile
    */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('user.profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    /*
    | Attendance (Presensi User)
    */
    Route::prefix('attendance')->name('attendance.')->group(function () {

        Route::get('/', function () {
            return view('user.attendance.index');
        })->name('index');

        Route::post('/check-in', [UserAttendanceController::class, 'checkIn'])
            ->name('checkin');

        Route::get('/history', function () {
            $attendances = \App\Models\Attendance::where('user_id', auth()->id())
                ->orderBy('tanggal', 'desc')
                ->paginate(20);

            return view('user.attendance.history', compact('attendances'));
        })->name('history');
    });

    /*
    | Payroll (Slip Gaji User)
    */
    Route::prefix('payroll')->name('payroll.')->group(function () {

        Route::get('/', function () {
            $payrolls = \App\Models\Payroll::where('user_id', auth()->id())
                ->with('period')
                ->orderByDesc('created_at')
                ->paginate(12);

            return view('user.payroll.index', compact('payrolls'));
        })->name('index');

        Route::get('/{payroll}', function (\App\Models\Payroll $payroll) {
            abort_unless(
                auth()->id() === $payroll->user_id || auth()->user()->role === 'admin',
                403
            );

            $payroll->load('details', 'period');

            return view('user.payroll.show', compact('payroll'));
        })->name('show');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    /*
    | Admin Dashboard
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    | Employees
    */
    Route::prefix('employees')->name('employees.')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        Route::get('/create', [EmployeeController::class, 'create'])->name('create');
        Route::post('/', [EmployeeController::class, 'store'])->name('store');
        Route::get('/{user}', [EmployeeController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [EmployeeController::class, 'edit'])->name('edit');
        Route::patch('/{user}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/{user}', [EmployeeController::class, 'destroy'])->name('destroy');
        Route::patch('/{user}/reset-password', [EmployeeController::class, 'resetPassword'])
            ->name('reset-password');
    });

    /*
    | Attendance Verification
    */
    Route::prefix('attendance')->name('attendance.')->group(function () {

        Route::get('/', function () {
            $query = \App\Models\Attendance::with('user.employee')
                ->whereNull('verified_at')
                ->orderByDesc('tanggal')
                ->orderByDesc('created_at');

            if (request('status') && request('status') !== 'all') {
                $query->where('status', request('status'));
            }

            $attendances = $query->paginate(20);

            return view('admin.attendance.index', compact('attendances'));
        })->name('index');

        Route::post('/{attendance}/verify',
            [AttendanceVerificationController::class, 'verify']
        )->name('verify');

        Route::get('/verified', function () {
            $attendances = \App\Models\Attendance::with('user.employee')
                ->whereNotNull('verified_at')
                ->orderByDesc('verified_at')
                ->paginate(20);

            return view('admin.attendance.verified', compact('attendances'));
        })->name('verified');
    });

    /*
    | Payroll Management
    */
    Route::prefix('payroll')->name('payroll.')->group(function () {

        // Periods
        Route::get('/periods', [PayrollController::class, 'periods'])->name('periods');
        Route::get('/periods/create', [PayrollController::class, 'createPeriod'])->name('periods.create');
        Route::post('/periods', [PayrollController::class, 'storePeriod'])->name('periods.store');
        Route::get('/user-components', [UserPayrollComponentController::class, 'index'])->name('user-components.index');
        Route::get('/user-components/{user}/edit', [UserPayrollComponentController::class, 'edit'])->name('user-components.edit');
        Route::put('/user-components/{user}', [UserPayrollComponentController::class, 'update'])->name('user-components.update');

        // Payroll list
        Route::get('/', [PayrollController::class, 'index'])->name('index');

        // Generate
        Route::post('/generate/{user}/{period}',
            [PayrollController::class, 'generate']
        )->name('generate.single');

        Route::post('/generate-bulk/{period}',
            [PayrollController::class, 'generateBulk']
        )->name('generate.bulk');

        // Reports
        Route::get('/reports', [PayrollController::class, 'reports'])->name('reports');
        Route::get('/reports/{period}',
            [PayrollController::class, 'reportDetail']
        )->name('reports.detail');

        // Payroll Components
Route::prefix('components')->name('components.')->group(function () {
    Route::get('/', [PayrollComponentController::class, 'index'])->name('index');         // List semua komponen
    Route::get('/create', [PayrollComponentController::class, 'create'])->name('create'); // Form tambah komponen baru
    Route::post('/', [PayrollComponentController::class, 'store'])->name('store');        // Simpan komponen baru
    Route::get('/{component}/edit', [PayrollComponentController::class, 'edit'])->name('edit');   // Form edit
    Route::put('/{component}', [PayrollComponentController::class, 'update'])->name('update');   // Update komponen
    Route::delete('/{component}', [PayrollComponentController::class, 'destroy'])->name('destroy'); // Hapus komponen
});

    });

    /*
    | Audit Logs
    */
    Route::get('/audit-logs', [AuditLogController::class, 'index'])
        ->name('audit-logs');
});
