<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payroll;
use App\Models\Attendance;
use App\Models\PayrollPeriod;
use App\Services\PayrollService;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function __construct(
        protected PayrollService $payrollService
    ) {}

    /**
     * Halaman Generate Gaji
     */
    public function index(Request $request)
{
    $periods = PayrollPeriod::where('status', 'active')->get();
    $selectedPeriod = null;
    $users = collect();

    if ($request->filled('period')) {
        $selectedPeriod = PayrollPeriod::findOrFail($request->period);

        $users = User::with([
            'employee',
            'payrolls' => function ($q) use ($selectedPeriod) {
                $q->where('payroll_period_id', $selectedPeriod->id);
            }
        ])->where('role', 'user')->get();
    }

    return view('admin.payroll.index', compact(
        'periods',
        'selectedPeriod',
        'users'
    ));
}


    /**
     * Generate gaji per pegawai
     */
    public function generate(User $user, PayrollPeriod $period)
    {
        $this->payrollService->generate($user, $period);

        return back()->with('success', 'Gaji berhasil digenerate');
    }

    
    /**
 * Halaman Laporan Gaji
 */
public function reports()
{
    $periods = PayrollPeriod::whereHas('payrolls')
        ->orderBy('start_date', 'desc')
        ->get();

    return view('admin.payroll.reports', compact('periods'));
}

/**
 * Detail Laporan Gaji per Periode
 */
public function reportDetail(PayrollPeriod $period)
{
    $payrolls = Payroll::with([
            'user.employee',
            'details'
        ])
        ->where('payroll_period_id', $period->id)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin.payroll.report-detail', compact(
        'period',
        'payrolls'
    ));
}

/**
 * Daftar Periode Gaji
 */
public function periods()
{
    $periods = PayrollPeriod::orderBy('start_date', 'desc')->paginate(10);

    return view('admin.payroll.periods.index', compact('periods'));
}

/**
 * Form Tambah Periode
 */
public function createPeriod()
{
    return view('admin.payroll.periods.create');
}

/**
 * Simpan Periode Baru
 */
public function storePeriod(Request $request)
{
    $validated = $request->validate([
        'nama'       => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date'   => 'required|date|after_or_equal:start_date',
    ]);

    PayrollPeriod::create([
        'nama'       => $validated['nama'],
        'start_date' => $validated['start_date'],
        'end_date'   => $validated['end_date'],
        'status'     => 'draft',
        'is_locked'  => false,
    ]);

    return redirect()
        ->route('admin.payroll.periods')
        ->with('success', 'Periode gaji berhasil dibuat');
}


}
