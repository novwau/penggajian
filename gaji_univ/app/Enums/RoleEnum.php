<?php

namespace App\Enums;

enum RoleEnum:string {
    case ADMIN = 'admin';
    case DOSEN = 'dosen';
    case KARYAWAN = 'karyawan';
}
