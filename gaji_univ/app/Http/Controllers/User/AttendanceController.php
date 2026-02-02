<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Services\AttendanceService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct(
        protected AttendanceService $attendance
    ) {}

    public function checkIn(Request $request)
{
    $validated = $request->validate([
        'status' => 'required|in:hadir,sakit,izin',
        'photo'  => 'nullable|image|max:2048',
    ]);

    try {
        $this->attendance->checkIn(
            auth()->user(),
            $validated['status'],
            $request->file('photo')
        );

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Presensi hari ini berhasil dicatat.');

    } catch (\Exception $e) {

        if ($e->getMessage() === 'ANDA_SUDAH_CHECKIN_HARI_INI') {
            return redirect()
                ->route('attendance.index')
                ->with('error', 'Anda sudah melakukan presensi hari ini.');
        }

        throw $e;
    }
}

}
