<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\User;

class SlipGajiController extends Controller
{
    public function index()
    {
        return Payroll::where('user_id', auth()->id())
            ->where('is_active', true)
            ->with('period')
            ->get();
    }

    public function show(Payroll $payroll)
    {
        if (
        auth()->id() !== $payroll->user_id &&
        ! auth()->user()->hasRole('admin')
    ) {
        abort(403);
    }
        return $payroll->load('details','period');
    }
}
