<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\PayrollDetail;
use App\Models\PayrollPeriod;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class PayrollService
{
    public function __construct(
        protected AuditLogService $audit
    ) {}

    public function generate(User $user, PayrollPeriod $period): Payroll
    {
        // 1. Validasi periode
        if ($period->is_locked) {
            throw new Exception('Periode gaji sudah dikunci');
        }

        // 2. Validasi data pegawai
        if (!$user->employee) {
            throw new Exception('User tidak memiliki data employee');
        }

        return DB::transaction(function () use ($user, $period) {

            // 3. Hitung dasar
            $gajiPokok = $user->employee->gaji_pokok;

            $alpa = Attendance::where('user_id', $user->id)
                ->whereBetween('tanggal', [
                    $period->start_date,
                    $period->end_date
                ])
                ->where('status', 'alpa')
                ->count();

            $potongan = $alpa * 50000;
            $net = max(0, $gajiPokok - $potongan);

            // 4. Simpan payroll utama
            $payroll = Payroll::create([
                'user_id' => $user->id,
                'payroll_period_id' => $period->id,
                'total_income' => $gajiPokok,
                'total_deduction' => $potongan,
                'net_salary' => $net,
                'version' => 1,
                'is_active' => true,
            ]);

            // 5. Detail gaji
            PayrollDetail::create([
                'payroll_id' => $payroll->id,
                'component' => 'Gaji Pokok',
                'amount' => $gajiPokok,
                'type' => 'income',
            ]);

            if ($potongan > 0) {
                PayrollDetail::create([
                    'payroll_id' => $payroll->id,
                    'component' => 'Potongan Alpa',
                    'amount' => $potongan,
                    'type' => 'deduction',
                ]);
            }

            // 6. Audit log
            $this->audit->log(
                'generate',
                $payroll,
                null,
                $payroll->toArray()
            );

            return $payroll;
        });
    }
}
