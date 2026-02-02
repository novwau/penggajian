<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees
     */
    public function index()
    {
        $employees = User::with('employee')
            ->where('role', 'user')
            ->orderBy('name')
            ->paginate(20);
            
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee
     */
    public function create()
    {
        return view('admin.employees.create');
    }

    /**
     * Store a newly created employee in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nip' => 'required|string|max:50|unique:employees',
            'jabatan' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        
        try {
            // Generate password default
            $defaultPassword = 'untag' . substr($validated['nip'], -4); // untag + 4 digit terakhir NIP
            
            // Create User Account
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($defaultPassword),
                'role' => 'user',
            ]);

            // Create Employee Data
            Employee::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'],
                'jabatan' => $validated['jabatan'],
                'gaji_pokok' => $validated['gaji_pokok'],
            ]);

            DB::commit();

            // Simpan password default untuk ditampilkan (hanya sekali)
            session()->flash('password_default', $defaultPassword);
            session()->flash('success', 'Pegawai berhasil ditambahkan!');

            return redirect()->route('admin.employees.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal menambahkan pegawai: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified employee
     */
    public function show(User $user)
    {
        $user->load('employee');
        
        // Ambil data presensi bulan ini
        $currentMonth = now()->format('Y-m');
        $attendances = \App\Models\Attendance::where('user_id', $user->id)
            ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$currentMonth])
            ->orderBy('tanggal', 'desc')
            ->get();
            
        // Ambil data gaji terbaru
        $latestPayroll = \App\Models\Payroll::where('user_id', $user->id)
            ->with('period')
            ->latest()
            ->first();
        
        return view('admin.employees.show', compact('user', 'attendances', 'latestPayroll'));
    }

    /**
     * Show the form for editing the specified employee
     */
    public function edit(User $user)
    {
        $user->load('employee');
        
        return view('admin.employees.edit', compact('user'));
    }

    /**
     * Update the specified employee in storage
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'nip' => ['required', 'string', 'max:50', Rule::unique('employees')->ignore($user->employee->id)],
            'jabatan' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        
        try {
            // Update User
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Update Employee
            $user->employee->update([
                'nip' => $validated['nip'],
                'jabatan' => $validated['jabatan'],
                'gaji_pokok' => $validated['gaji_pokok'],
            ]);

            DB::commit();

            return redirect()
                ->route('admin.employees.index')
                ->with('success', 'Data pegawai berhasil diperbarui!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified employee from storage
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        
        try {
            // Hapus employee data
            if ($user->employee) {
                $user->employee->delete();
            }
            
            // Hapus user account
            $user->delete();

            DB::commit();

            return redirect()
                ->route('admin.employees.index')
                ->with('success', 'Pegawai berhasil dihapus!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withErrors(['error' => 'Gagal menghapus pegawai: ' . $e->getMessage()]);
        }
    }

    /**
     * Reset password pegawai
     */
    public function resetPassword(User $user)
    {
        $newPassword = 'unmer' . substr($user->employee->nip, -4);
        
        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        session()->flash('password_default', $newPassword);
        
        return back()->with('success', 'Password berhasil direset!');
    }
}