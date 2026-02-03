<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayrollComponent;
use Illuminate\Http\Request;

class PayrollComponentController extends Controller
{
    public function index()
    {
        $components = PayrollComponent::orderBy('type')->get();
        return view('admin.payroll.components.index', compact('components'));
    }

    public function create()
    {
        return view('admin.payroll.components.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,deduction',
            'calculation_type' => 'required|in:fixed,daily,percent',
            'value' => 'required|numeric|min:0'
        ]);

        PayrollComponent::create($validated);

        return redirect()->route('admin.payroll.components.index')
                         ->with('success', 'Komponen gaji berhasil dibuat');
    }

    public function edit(PayrollComponent $component)
    {
        return view('admin.payroll.components.edit', compact('component'));
    }

    public function update(Request $request, PayrollComponent $component)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,deduction',
            'calculation_type' => 'required|in:fixed,daily,percent',
            'value' => 'required|numeric|min:0'
        ]);

        $component->update($validated);

        return redirect()->route('admin.payroll.components.index')
                         ->with('success', 'Komponen gaji berhasil diupdate');
    }

    public function destroy(PayrollComponent $component)
    {
        $component->delete();

        return redirect()->route('admin.payroll.components.index')
                         ->with('success', 'Komponen gaji berhasil dihapus');
    }
}
