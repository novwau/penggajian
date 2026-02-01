@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{-- ===================== STAT GRID ===================== --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:1.5rem;margin-bottom:2rem;">

    {{-- Total Pegawai --}}
    <div class="card" style="border-left:4px solid var(--maroon);">
        <div style="display:flex;justify-content:space-between;">
            <div>
                <div style="font-size:.875rem;color:var(--gray-600);">Total Pegawai</div>
                <div style="font-size:2rem;font-weight:700;">
                    {{ $totalEmployees }}
                </div>
            </div>
        </div>
    </div>

    {{-- Presensi Hari Ini --}}
    <div class="card" style="border-left:4px solid #10B981;">
        <div>
            <div style="font-size:.875rem;color:var(--gray-600);">Presensi Hari Ini</div>
            <div style="font-size:2rem;font-weight:700;">
                {{ $todayAttendances }}
            </div>
            <div style="font-size:.75rem;color:var(--gray-600);">
                {{ $totalEmployees > 0 ? round(($todayAttendances / $totalEmployees) * 100) : 0 }}%
                dari total pegawai
            </div>
        </div>
    </div>

    {{-- Perlu Verifikasi --}}
    <div class="card" style="border-left:4px solid #F59E0B;">
        <div>
            <div style="font-size:.875rem;color:var(--gray-600);">Perlu Verifikasi</div>
            <div style="font-size:2rem;font-weight:700;">
                {{ $pendingAttendances }}
            </div>
        </div>
    </div>

    {{-- Total Gaji --}}
    <div class="card" style="border-left:4px solid var(--gold);">
        <div>
            <div style="font-size:.875rem;color:var(--gray-600);">Total Gaji Periode Aktif</div>
            <div style="font-size:1.75rem;font-weight:700;">
                Rp {{ number_format($totalPayroll, 0, ',', '.') }}
            </div>
        </div>
    </div>

</div>

{{-- ===================== TWO COLUMN ===================== --}}
<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;margin-bottom:2rem;">

    {{-- Aktivitas Terbaru --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Aktivitas Terbaru</h3>
        </div>

        <table style="width:100%;border-collapse:collapse;">
    <thead>
        <tr style="border-bottom:2px solid var(--gray-200);">
            <th style="padding:.75rem;text-align:left;width:80px;">Waktu</th>
            <th style="padding:.75rem;text-align:left;width:180px;">Pegawai</th>
            <th style="padding:.75rem;text-align:left;">Aktivitas</th>
            <th style="padding:.75rem;text-align:center;width:120px;">Status</th>
        </tr>
    </thead>
    <tbody>
    @forelse($recentActivities as $activity)
        <tr style="border-bottom:1px solid var(--gray-100);">
            <td style="padding:.75rem;font-size:.875rem;color:var(--gray-600);">
                {{ $activity->created_at->format('H:i') }}
            </td>

            <td style="padding:.75rem;font-size:.875rem;">
                {{ $activity->user->name }}
            </td>

            <td style="padding:.75rem;font-size:.875rem;">
                {{ $activity->type === 'checkin' ? 'Check-in Presensi' : 'Izin' }}
            </td>

            <td style="padding:.75rem;text-align:center;">
                <span style="
                    padding:.25rem .75rem;
                    border-radius:12px;
                    font-size:.75rem;
                    font-weight:600;
                    background: {{ $activity->status === 'pending' ? '#FEF3C7' : '#D1FAE5' }};
                    color: {{ $activity->status === 'pending' ? '#92400E' : '#065F46' }};
                ">
                    {{ ucfirst($activity->status) }}
                </span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" style="padding:1rem;text-align:center;color:var(--gray-500);">
                Tidak ada aktivitas
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

    </div>

    {{-- Aksi Cepat + Periode --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Aksi Cepat</h3>
        </div>

        <div style="display:flex;flex-direction:column;gap:.75rem;">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Tambah Pegawai</a>
            <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">Verifikasi Presensi</a>
            <a href="{{ route('admin.payroll.index') }}" class="btn btn-outline">Generate Gaji</a>
            <a href="{{ route('admin.payroll.reports') }}" class="btn btn-outline">Laporan Gaji</a>
        </div>

        <div style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--gray-200);">
            <h4 style="font-size:.875rem;font-weight:600;">Periode Aktif</h4>

            @if($activePeriod)
                <div style="background:var(--cream);padding:1rem;border-radius:6px;">
                    <div style="font-weight:600;">{{ $activePeriod->name }}</div>
                    <div style="font-size:.875rem;color:var(--gray-600);">
                        {{ $activePeriod->start_date->format('d M Y') }} –
                        {{ $activePeriod->end_date->format('d M Y') }}
                    </div>
                </div>
            @else
                <div style="color:var(--gray-600);font-size:.875rem;">
                    Belum ada periode aktif
                </div>
            @endif
        </div>
    </div>
</div>

{{-- ===================== PAYROLL TERBARU ===================== --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Penggajian Terbaru</h3>
        <a href="{{ route('admin.payroll.index') }}">Lihat Semua</a>
    </div>

    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr>
                <th>Pegawai</th>
                <th>Periode</th>
                <th style="text-align:right;">Gaji Pokok</th>
                <th style="text-align:right;">Potongan</th>
                <th style="text-align:right;">Total</th>
            </tr>
        </thead>
        <tbody>
        @forelse($recentPayrolls as $payroll)
            <tr>
                <td>{{ $payroll->user->name }}</td>
                <td>{{ $payroll->period->name }}</td>
                <td style="text-align:right;">
                    Rp {{ number_format($payroll->basic_salary, 0, ',', '.') }}
                </td>
                <td style="text-align:right;color:#DC2626;">
                    Rp {{ number_format($payroll->deduction, 0, ',', '.') }}
                </td>
                <td style="text-align:right;font-weight:600;">
                    Rp {{ number_format($payroll->total_salary, 0, ',', '.') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Belum ada data penggajian</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@endsection
