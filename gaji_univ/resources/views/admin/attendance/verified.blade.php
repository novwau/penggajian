@extends('layouts.admin')

@section('title', 'Presensi Terverifikasi')

@section('content')
<!-- Breadcrumb -->
<div style="margin-bottom: 2rem;">
    <a href="{{ route('admin.attendance.index') }}" style="color: var(--gray-600); text-decoration: none; font-size: 0.875rem;">
        ← Kembali ke Verifikasi Presensi
    </a>
</div>

<!-- Header -->
<div style="margin-bottom: 2rem;">
    <h2 style="font-size: 1.75rem; font-weight: 700; color: var(--charcoal); margin-bottom: 0.5rem;">
        Presensi Terverifikasi
    </h2>
    <p style="color: var(--gray-600);">Daftar presensi yang sudah diverifikasi</p>
</div>

<!-- Filter -->
<div class="card" style="margin-bottom: 1.5rem;">
    <form method="GET" style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 1rem; align-items: end;">
        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.875rem;">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" 
                   style="width: 100%; padding: 0.625rem; border: 2px solid var(--gray-200); border-radius: 6px;">
        </div>
        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; font-size: 0.875rem;">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" 
                   style="width: 100%; padding: 0.625rem; border: 2px solid var(--gray-200); border-radius: 6px;">
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.attendance.verified') }}" class="btn btn-outline">Reset</a>
        </div>
    </form>
</div>

<!-- Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Presensi Terverifikasi</h3>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid var(--gray-100);">
                    <th style="padding: 0.875rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Tanggal</th>
                    <th style="padding: 0.875rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Pegawai</th>
                    <th style="padding: 0.875rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Status</th>
                    <th style="padding: 0.875rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Check-in</th>
                    <th style="padding: 0.875rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Diverifikasi</th>
                    <th style="padding: 0.875rem; text-align: center; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Foto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $attendance)
                <tr style="border-bottom: 1px solid var(--gray-100);">
                    <td style="padding: 0.875rem; font-size: 0.875rem; font-weight: 500;">
                        {{ \Carbon\Carbon::parse($attendance->tanggal)->format('d M Y') }}
                    </td>
                    <td style="padding: 0.875rem; font-size: 0.875rem;">
                        <div style="font-weight: 600; margin-bottom: 0.25rem;">{{ $attendance->user->name }}</div>
                        <div style="font-size: 0.8rem; color: var(--gray-600);">{{ $attendance->user->employee->nip ?? '-' }}</div>
                    </td>
                    <td style="padding: 0.875rem;">
                        @if($attendance->status == 'hadir')
                            <span style="padding: 0.25rem 0.75rem; background: #D1FAE5; color: #065F46; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Hadir</span>
                        @elseif($attendance->status == 'sakit')
                            <span style="padding: 0.25rem 0.75rem; background: #FEE2E2; color: #991B1B; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Sakit</span>
                        @elseif($attendance->status == 'izin')
                            <span style="padding: 0.25rem 0.75rem; background: #FEF3C7; color: #92400E; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Izin</span>
                        @endif
                    </td>
                    <td style="padding: 0.875rem; font-size: 0.875rem; color: var(--gray-600);">
                        {{ $attendance->created_at->format('H:i') }} WIB
                    </td>
                    <td style="padding: 0.875rem; font-size: 0.875rem; color: var(--gray-600);">
                        {{ $attendance->verified_at ? \Carbon\Carbon::parse($attendance->verified_at)->format('d M Y H:i') : '-' }}
                    </td>
                    <td style="padding: 0.875rem; text-align: center;">
                        @if($attendance->bukti_foto)
                            <a href="{{ Storage::url($attendance->bukti_foto) }}" 
                               target="_blank"
                               style="color: var(--maroon); text-decoration: none; font-size: 0.875rem; font-weight: 500;">
                                <svg style="width: 18px; height: 18px; display: inline;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </a>
                        @else
                            <span style="color: var(--gray-400);">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 3rem; text-align: center; color: var(--gray-600);">
                        <svg style="width: 48px; height: 48px; margin: 0 auto 1rem; opacity: 0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <div style="font-weight: 500; margin-bottom: 0.5rem;">Tidak ada data</div>
                        <div style="font-size: 0.875rem;">Belum ada presensi terverifikasi di periode ini</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($attendances->hasPages())
    <div style="padding: 1.5rem; border-top: 1px solid var(--gray-200);">
        {{ $attendances->links() }}
    </div>
    @endif
</div>
@endsection