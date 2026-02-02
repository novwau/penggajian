@extends('layouts.user')

@section('content')
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-label">Status Presensi Hari Ini</div>
        <div class="stat-value">
            {{ $todayAttendance?->status ?? 'Belum Presensi' }}
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Slip Gaji Terakhir</div>
        <div class="stat-value">
            {{ $latestPayroll?->period?->nama ?? '-' }}
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Informasi Pegawai</h3>
    </div>
    <table>
        <tr>
            <td>Nama</td>
            <td>: {{ $user->name }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>: {{ $user->email }}</td>
        </tr>
    </table>
</div>
@endsection
