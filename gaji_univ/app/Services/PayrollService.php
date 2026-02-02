<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\PayrollDetail;
use App\Models\PayrollPeriod;
use App\Models\User;
use App\Models\PayrollComponent;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Services\AuditLogService;

class PayrollService
{
    public function __construct(
        protected AuditLogService $audit
    ) {}

    /**
     * Generate gaji untuk satu user
     */
    public function generate(User $user, PayrollPeriod $period)
    {
        if (!$user->employee) {
            abort(400, 'Employee not found');
        }

        DB::beginTransaction();

        try {
            // Hapus payroll lama jika ada
            Payroll::where('user_id', $user->id)
                   ->where('payroll_period_id', $period->id)
                   ->delete();

            // Hitung kehadiran
            $attendances = Attendance::where('user_id', $user->id)
                ->whereBetween('tanggal', [$period->start_date, $period->end_date])
                ->get();

            $daysWorked = $attendances->where('status', 'hadir')->count();
            $alpaCount = $attendances->where('status', 'alpa')->count();

            $totalIncome = 0;
            $totalDeduction = 0;

            // Buat payroll
            $payroll = Payroll::create([
                'user_id' => $user->id,
                'payroll_period_id' => $period->id,
                'total_income' => 0,
                'total_deduction' => 0,
                'net_salary' => 0,
            ]);

            // Ambil semua komponen gaji
            $components = PayrollComponent::all();

            foreach ($components as $component) {
                $amount = 0;

                switch ($component->calculation_type) {
                    case 'fixed':
                        $amount = $component->value;
                        break;

                    case 'daily':
                        $amount = $component->value * $daysWorked;
                        break;

                    case 'percent':
                        $amount = ($component->value / 100) * $user->employee->gaji_pokok;
                        break;
                }

                PayrollDetail::create([
                    'payroll_id' => $payroll->id,
                    'component' => $component->name,
                    'type' => $component->type,
                    'description' => $component->name,
                    'amount' => $amount,
                ]);

                if ($component->type === 'income') {
                    $totalIncome += $amount;
                } else {
                    $totalDeduction += $amount;
                }
            }

            // Tambah potongan alpa
            $alpaPenalty = $alpaCount * 50000;
            if ($alpaPenalty > 0) {
                PayrollDetail::create([
                    'payroll_id' => $payroll->id,
                    'component_id' => null,
                    'type' => 'deduction',
                    'description' => 'Potongan Alpa',
                    'amount' => $alpaPenalty,
                ]);
                $totalDeduction += $alpaPenalty;
            }

            // Update total di payroll
            $payroll->update([
                'total_income' => $totalIncome,
                'total_deduction' => $totalDeduction,
                'net_salary' => $totalIncome - $totalDeduction,
            ]);

            DB::commit();

            return $payroll;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

