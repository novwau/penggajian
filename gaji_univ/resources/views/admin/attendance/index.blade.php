@extends('layouts.admin')

@section('title', 'Verifikasi Presensi')

@section('content')
<!-- Success Message -->
@if(session('success'))
<div style="background: #D1FAE5; border-left: 4px solid #10B981; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem;">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <svg style="width: 20px; height: 20px; color: #10B981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span style="font-weight: 600; color: #065F46;">{{ session('success') }}</span>
    </div>
</div>
@endif

@if(session('error'))
<div style="background: #FEE2E2; border-left: 4px solid #DC2626; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem;">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <svg style="width: 20px; height: 20px; color: #DC2626;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span style="font-weight: 600; color: #991B1B;">{{ session('error') }}</span>
    </div>
</div>
@endif

<!-- Header -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="font-size: 1.75rem; font-weight: 700; color: var(--charcoal); margin-bottom: 0.5rem;">
            Verifikasi Presensi
        </h2>
        <p style="color: var(--gray-600);">Kelola dan verifikasi presensi dosen & karyawan</p>
    </div>
    <a href="{{ route('admin.attendance.verified') }}" class="btn btn-outline">
        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Lihat yang Sudah Diverifikasi
    </a>
</div>

<!-- Stats -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card" style="border-left: 4px solid #F59E0B; padding: 1.25rem;">
        <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.5rem;">Menunggu Verifikasi</div>
        <div style="font-size: 2rem; font-weight: 700; color: #F59E0B;">{{ $attendances->total() }}</div>
    </div>
    <div class="card" style="border-left: 4px solid var(--maroon); padding: 1.25rem;">
        <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.5rem;">Hari Ini</div>
        <div style="font-size: 2rem; font-weight: 700; color: var(--charcoal);">
            {{ $attendances->where('tanggal', now()->toDateString())->count() }}
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div style="margin-bottom: 1.5rem; border-bottom: 2px solid var(--gray-200);">
    <div style="display: flex; gap: 1rem;">
        <a href="?status=all" 
           class="tab-link {{ request('status', 'all') == 'all' ? 'active' : '' }}"
           style="padding: 0.75rem 1.5rem; text-decoration: none; font-weight: 600; color: {{ request('status', 'all') == 'all' ? 'var(--maroon)' : 'var(--gray-600)' }}; border-bottom: 3px solid {{ request('status', 'all') == 'all' ? 'var(--maroon)' : 'transparent' }}; margin-bottom: -2px;">
            Semua
        </a>
        <a href="?status=hadir" 
           class="tab-link {{ request('status') == 'hadir' ? 'active' : '' }}"
           style="padding: 0.75rem 1.5rem; text-decoration: none; font-weight: 600; color: {{ request('status') == 'hadir' ? 'var(--maroon)' : 'var(--gray-600)' }}; border-bottom: 3px solid {{ request('status') == 'hadir' ? 'var(--maroon)' : 'transparent' }}; margin-bottom: -2px;">
            Hadir
        </a>
        <a href="?status=sakit" 
           class="tab-link {{ request('status') == 'sakit' ? 'active' : '' }}"
           style="padding: 0.75rem 1.5rem; text-decoration: none; font-weight: 600; color: {{ request('status') == 'sakit' ? 'var(--maroon)' : 'var(--gray-600)' }}; border-bottom: 3px solid {{ request('status') == 'sakit' ? 'var(--maroon)' : 'transparent' }}; margin-bottom: -2px;">
            Sakit
        </a>
        <a href="?status=izin" 
           class="tab-link {{ request('status') == 'izin' ? 'active' : '' }}"
           style="padding: 0.75rem 1.5rem; text-decoration: none; font-weight: 600; color: {{ request('status') == 'izin' ? 'var(--maroon)' : 'var(--gray-600)' }}; border-bottom: 3px solid {{ request('status') == 'izin' ? 'var(--maroon)' : 'transparent' }}; margin-bottom: -2px;">
            Izin
        </a>
    </div>
</div>

<!-- Attendance List -->
<div class="card">
    @forelse($attendances as $attendance)
    <div style="padding: 1.5rem; border-bottom: 1px solid var(--gray-100); {{ $loop->last ? 'border-bottom: none;' : '' }}">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 1.5rem; align-items: start;">
            <!-- Info Pegawai -->
            <div>
                <div style="font-weight: 600; font-size: 1rem; color: var(--charcoal); margin-bottom: 0.5rem;">
                    {{ $attendance->user->name }}
                </div>
                <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem;">
                    NIP: {{ $attendance->user->employee->nip ?? '-' }}
                </div>
                <div style="font-size: 0.875rem; color: var(--gray-600);">
                    {{ $attendance->user->employee->jabatan ?? '-' }}
                </div>
            </div>

            <!-- Info Presensi -->
            <div>
                <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.5rem;">Tanggal & Waktu</div>
                <div style="font-weight: 600; margin-bottom: 0.25rem;">
                    {{ \Carbon\Carbon::parse($attendance->tanggal)->format('d M Y') }}
                </div>
                <div style="font-size: 0.875rem; color: var(--gray-600);">
                    {{ $attendance->created_at->format('H:i') }} WIB
                </div>
                <div style="margin-top: 0.5rem;">
                    @if($attendance->status == 'hadir')
                        <span style="padding: 0.25rem 0.75rem; background: #D1FAE5; color: #065F46; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Hadir</span>
                    @elseif($attendance->status == 'sakit')
                        <span style="padding: 0.25rem 0.75rem; background: #FEE2E2; color: #991B1B; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Sakit</span>
                    @elseif($attendance->status == 'izin')
                        <span style="padding: 0.25rem 0.75rem; background: #FEF3C7; color: #92400E; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Izin</span>
                    @endif
                </div>
            </div>

            <!-- Bukti Foto -->
            <div>
                <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.5rem;">Bukti Foto</div>
                @if($attendance->bukti_foto)
                    <a href="{{ Storage::url($attendance->bukti_foto) }}" 
                       target="_blank"
                       style="display: inline-block; padding: 0.5rem 1rem; background: var(--cream); border: 2px solid var(--gold); border-radius: 6px; text-decoration: none; font-size: 0.875rem; font-weight: 600; color: var(--maroon);">
                        <svg style="width: 16px; height: 16px; display: inline; vertical-align: middle; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Lihat Foto
                    </a>
                @else
                    <span style="color: var(--gray-600); font-size: 0.875rem;">Tidak ada foto</span>
                @endif
            </div>

            <!-- Action Button -->
            <div style="display: flex; gap: 0.5rem;">
                <form action="{{ route('admin.attendance.verify', $attendance) }}" method="POST" onsubmit="return confirm('Verifikasi presensi ini?')">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="padding: 0.625rem 1rem; white-space: nowrap;">
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Verifikasi
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div style="padding: 3rem; text-align: center; color: var(--gray-600);">
        <svg style="width: 48px; height: 48px; margin: 0 auto 1rem; opacity: 0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div style="font-weight: 500; margin-bottom: 0.5rem;">Tidak ada presensi yang perlu diverifikasi</div>
        <div style="font-size: 0.875rem;">Semua presensi sudah diverifikasi</div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($attendances->hasPages())
<div style="margin-top: 1.5rem;">
    {{ $attendances->links() }}
</div>
@endif
@endsection