@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{-- ===================== STAT GRID ===================== --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:1.5rem;margin-bottom:2rem;">

    {{-- Total Pegawai --}}
    <div class="card" style="border-left:4px solid var(--maroon);">
        <div>
            <div style="font-size:.875rem;color:var(--gray-600);">Total Pegawai</div>
            <div style="font-size:2rem;font-weight:700;">
                {{ $totalEmployees }}
            </div>
        </div>
    </div>

 {{-- Presensi Terbaru --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Presensi Terbaru</h3>
    </div>

    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="border-bottom:2px solid var(--gray-200);">
                <th style="padding:.75rem;text-align:left;">Tanggal</th>
                <th style="padding:.75rem;text-align:left;">Pegawai</th>
                <th style="padding:.75rem;text-align:center;">Status</th>
                <th style="padding:.75rem;text-align:center;">Verifikasi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($recentAttendances as $attendance)
            <tr style="border-bottom:1px solid var(--gray-100);">
                <td style="padding:.75rem;font-size:.875rem;">
                    {{ $attendance->tanggal->format('d M Y') }}
                </td>

                <td style="padding:.75rem;">
                    {{ $attendance->user->name }}
                </td>

                <td style="padding:.75rem;text-align:center;">
                    <span style="
                        padding:.25rem .75rem;
                        border-radius:12px;
                        font-size:.75rem;
                        font-weight:600;
                        background:#D1FAE5;
                        color:#065F46;
                    ">
                        {{ ucfirst($attendance->status) }}
                    </span>
                </td>

                <td style="padding:.75rem;text-align:center;">
                    @if($attendance->verified_at)
                        <span style="color:#065F46;font-weight:600;">Terverifikasi</span>
                    @else
                        <span style="color:#92400E;font-weight:600;">Menunggu</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="padding:1rem;text-align:center;color:var(--gray-500);">
                    Belum ada presensi
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
</div>


{{-- ===================== TWO COLUMN ===================== --}}
<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;margin-bottom:2rem;">

    {{-- Presensi Terbaru --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Presensi Terbaru</h3>
        </div>

        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid var(--gray-200);">
                    <th style="padding:.75rem;text-align:left;width:140px;">Tanggal</th>
                    <th style="padding:.75rem;text-align:left;">Pegawai</th>
                    <th style="padding:.75rem;text-align:center;width:120px;">Status</th>
                    <th style="padding:.75rem;text-align:center;width:140px;">Verifikasi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($recentAttendances as $attendance)
                <tr style="border-bottom:1px solid var(--gray-100);">
                    <td style="padding:.75rem;font-size:.875rem;">
                        {{ \Carbon\Carbon::parse($attendance->tanggal)->format('d M Y') }}
                    </td>

                    <td style="padding:.75rem;font-size:.875rem;">
                        {{ $attendance->user->name }}
                    </td>

                    <td style="padding:.75rem;text-align:center;">
                        <span style="
                            padding:.25rem .75rem;
                            border-radius:12px;
                            font-size:.75rem;
                            font-weight:600;
                            background:
                                {{ $attendance->status === 'hadir' ? '#D1FAE5' :
                                   ($attendance->status === 'izin' ? '#FEF3C7' : '#DBEAFE') }};
                            color:
                                {{ $attendance->status === 'hadir' ? '#065F46' :
                                   ($attendance->status === 'izin' ? '#92400E' : '#1E40AF') }};
                        ">
                            {{ ucfirst($attendance->status) }}
                        </span>
                    </td>

                    <td style="padding:.75rem;text-align:center;font-size:.75rem;">
                        @if($attendance->verified_at)
                            <span style="color:#065F46;font-weight:600;">
                                Terverifikasi
                            </span>
                        @else
                            <span style="color:#92400E;font-weight:600;">
                                Pending
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="padding:1rem;text-align:center;color:var(--gray-600);">
                        Belum ada data presensi
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
            <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">Tambah Pegawai</a>
            <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">Verifikasi Presensi</a>
            <a href="{{ route('admin.payroll.index') }}" class="btn btn-outline">Generate Gaji</a>
            <a href="{{ route('admin.payroll.reports') }}" class="btn btn-outline">Laporan Gaji</a>
        </div>

        <div style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--gray-200);">
            <h4 style="font-size:.875rem;font-weight:600;">Periode Aktif</h4>

            @if($activePeriod)
    <div style="font-weight:600;">{{ $activePeriod->nama }}</div>
    <div style="font-size:.875rem;color:var(--gray-600);">
        {{ \Carbon\Carbon::parse($activePeriod->start_date)->format('d M Y') }}
        –
        {{ \Carbon\Carbon::parse($activePeriod->end_date)->format('d M Y') }}
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
                <td>{{ $payroll->period->nama }}</td>
                <td style="text-align:right;">
                    Rp {{ number_format($payroll->total_income, 0, ',', '.') }}
                </td>
                <td style="text-align:right;color:#DC2626;">
                    Rp {{ number_format($payroll->total_deduction, 0, ',', '.') }}
                </td>
                <td style="text-align:right;font-weight:600;">
                    Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}
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
