<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Services\AttendanceService;

class AttendanceVerificationController extends Controller
{
    public function __construct(
        protected AttendanceService $attendance
    ) {}

    public function verify(Attendance $attendance)
    {
        try {
            $result = $this->attendance->verify($attendance);
            
            return redirect()
                ->route('admin.attendance.index')
                ->with('success', 'Presensi berhasil diverifikasi!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}
