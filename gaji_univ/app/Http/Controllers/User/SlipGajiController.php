<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\User;

class SlipGajiController extends Controller
{
    public function index()
{
    $payrolls = Payroll::where('user_id', auth()->id())
        ->with('period')
        ->orderByDesc('created_at')
        ->get();

    return view('user.payroll.index', compact('payrolls'));
}


public function show(Payroll $payroll)
{
    if (auth()->id() !== $payroll->user_id) {
        abort(403);
    }

    $payroll->load('details', 'period');

    return view('user.payroll.show', compact('payroll'));
}


}
