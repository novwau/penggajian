<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PayrollPeriod;
use App\Services\PayrollService;
class PayrollController extends Controller
{
    public function __construct(
        protected PayrollService $payroll
    ) {}

    public function generate(User $user, PayrollPeriod $period)
    {
        $result = $this->payroll->generate($user, $period);

        return response()->json($result);
    }
}
