<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\PayrollPeriod;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total pegawai (role user)
        $totalEmployees = User::where('role', 'user')->count();

        // Presensi hari ini
        $todayAttendances = Attendance::whereDate('tanggal', today())->count();

        // Presensi pending
        $pendingAttendances = Attendance::where('status', 'pending')->count();

        // Periode aktif
        $activePeriod = PayrollPeriod::where('status', 'active')->first();

        // Total gaji periode aktif
        $totalPayroll = 0;
        if ($activePeriod) {
            $totalPayroll = Payroll::where('payroll_period_id', $activePeriod->id)
                ->sum('total_income');
        }

        // Aktivitas terbaru (ambil dari presensi)
        $recentActivities = Attendance::with('user')
            ->latest()
            ->limit(5)
            ->get();

        // Payroll terbaru
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
            'recentActivities',
            'recentPayrolls'
        ));
    }
}
