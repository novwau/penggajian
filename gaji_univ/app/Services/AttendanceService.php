<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\User;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AttendanceService
{
    public function __construct(
        protected AuditLogService $audit
    ) {}

    /**
     * User melakukan presensi
     */
    public function checkIn(
        User $user,
        string $status,
        ?UploadedFile $photo = null
    ): Attendance {
        return DB::transaction(function () use ($user, $status, $photo) {

            // Cegah presensi ganda di tanggal yang sama
            $today = now()->toDateString();

            if (
                Attendance::where('user_id', $user->id)
                    ->where('tanggal', $today)
                    ->exists()
            ) {
                throw new Exception('Presensi hari ini sudah ada');
            }

            // Simpan foto jika ada
            $path = null;
            if ($photo) {
                $path = $photo->store('attendance', 'public');
            }

            $attendance = Attendance::create([
                'user_id' => $user->id,
                'tanggal' => $today,
                'status' => $status,
                'bukti_foto' => $path,
            ]);

            // Audit
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
            throw new Exception('Presensi sudah diverifikasi');
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
