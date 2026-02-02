<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\PayrollPeriod;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    $totalEmployees = User::where('role', '!=', 'admin')->count();

    $todayAttendances = Attendance::whereDate('tanggal', today())->count();

    $pendingAttendances = Attendance::whereNull('verified_at')->count();

    $activePeriod = PayrollPeriod::where('status', 'active')->first();

    $totalPayroll = 0;
    if ($activePeriod) {
        $totalPayroll = Payroll::where('payroll_period_id', $activePeriod->id)
            ->sum('total_income');
    }

    $recentAttendances = Attendance::with('user')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    $recentPayrolls = Payroll::with(['user', 'period'])
        ->latest()
        ->limit(5)
        ->get();

    return view('admin.dashboard', compact(
        'totalEmployees',
        'todayAttendances',
        'pendingAttendances',
        'activePeriod',
        'totalPayroll',
        'recentAttendances',
        'recentPayrolls'
    ));
}

}
