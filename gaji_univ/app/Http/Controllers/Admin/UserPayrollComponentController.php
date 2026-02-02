<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PayrollComponent;
use Illuminate\Http\Request;

class UserPayrollComponentController extends Controller
{
    /**
     * Daftar pegawai untuk atur komponen gaji
     */
    public function index()
    {
        $users = User::with('employee')->where('role', 'user')->get();
        return view('admin.payroll.user-components.index', compact('users'));
    }

    /**
     * Halaman edit komponen per pegawai
     */
    public function edit(User $user)
{
    $components = PayrollComponent::orderBy('type')->get();
    $userComponents = $user->payrollComponents->pluck('pivot.value', 'id')->toArray();

    return view('admin.payroll.user-components.edit', compact(
        'user', 'components', 'userComponents'
    ));
}


    /**
     * Simpan komponen per pegawai
     */
    public function update(Request $request, User $user)
    {
        $data = [];
        if ($request->filled('components')) {
            foreach ($request->components as $componentId => $value) {
                if ($value !== null && $value !== '') {
                    $data[$componentId] = ['value' => $value];
                }
            }
        }

        $user->payrollComponents()->sync($data);

        return redirect()->route('admin.payroll.user-components.index')
                         ->with('success', 'Komponen gaji pegawai berhasil disimpan');
    }
}
