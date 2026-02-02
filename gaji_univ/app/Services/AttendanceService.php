<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\User;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AttendanceService
{
    public function __construct(
        protected AuditLogService $audit
    ) {}

    /**
     * User melakukan presensi (1x per hari)
     */
    public function checkIn(
        User $user,
        string $status,
        ?UploadedFile $photo = null
    ): Attendance {
        return DB::transaction(function () use ($user, $status, $photo) {

            $today = Carbon::today();

            // Kunci presensi satu kali per hari
            $alreadyCheckedIn = Attendance::where('user_id', $user->id)
                ->whereDate('tanggal', $today)
                ->lockForUpdate()
                ->exists();

            if ($alreadyCheckedIn) {
                throw new Exception('ANDA_SUDAH_CHECKIN_HARI_INI');
            }

            // Simpan foto jika ada
            $path = null;
            if ($photo) {
                $path = $photo->store('attendance', 'public');
            }

            $attendance = Attendance::create([
                'user_id'     => $user->id,
                'tanggal'     => $today,
                'status'      => $status,
                'bukti_foto'  => $path,
            ]);

            // Audit log
            $this->audit->log(
                'check-in',
                $attendance,
                null,
                $attendance->toArray()
            );

            return $attendance;
        });
    }

    /**
     * Admin memverifikasi presensi
     */
    public function verify(Attendance $attendance): Attendance
    {
        if ($attendance->verified_at) {
            throw new Exception('PRESENSI_SUDAH_DIVERIFIKASI');
        }

        $old = $attendance->toArray();

        $attendance->update([
            'verified_at' => now(),
        ]);

        $this->audit->log(
            'verify',
            $attendance,
            $old,
            $attendance->toArray()
        );

        return $attendance;
    }
}
