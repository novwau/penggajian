<?php

namespace App\Enums;

enum AttendanceStatusEnum:string {
    case HADIR = 'hadir';
    case SAKIT = 'sakit';
    case IZIN = 'izin';
    case ALPA = 'alpa';
}
