<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PayrollPeriod;
use App\Services\PayrollService;

class PayrollController extends Controller
{
    public function __construct(
        protected PayrollService $payrollService
    ) {}

    public function generate(User $user, PayrollPeriod $period)
    {
        $this->payrollService->generate($user, $period);

        return back()->with('success', 'Payroll generated');
    }
}
