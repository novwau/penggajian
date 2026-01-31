<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\PayrollDetail;
use App\Models\PayrollPeriod;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Services\AuditLogService;

class PayrollService
{
    public function __construct(
        protected AuditLogService $audit
    ) {}

    public function generate(User $user, PayrollPeriod $period)
{
    if (!$user->employee) {
        abort(400, 'Employee not found');
    }

    $gajiPokok = $user->employee->gaji_pokok;

    $alpa = Attendance::where('user_id', $user->id)
        ->whereBetween('tanggal', [$period->start_date, $period->end_date])
        ->where('status', 'alpa')
        ->count();

    $potongan = $alpa * 50000;
    $net = $gajiPokok - $potongan;

    return Payroll::create([
        'user_id' => $user->id,
        'payroll_period_id' => $period->id,
        'total_income' => $gajiPokok,
        'total_deduction' => $potongan,
        'net_salary' => $net
    ]);
}
}
