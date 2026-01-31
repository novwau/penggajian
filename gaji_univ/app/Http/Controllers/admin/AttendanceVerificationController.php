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
        $result = $this->attendance->verify($attendance);

        return response()->json($result);
    }
}
