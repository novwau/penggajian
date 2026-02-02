@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{-- ===================== STAT GRID ===================== --}}
<div class="stats-grid">
    {{-- Total Pegawai --}}
    <div class="card stat-card">
        <div>
            <div class="stat-label">Total Pegawai</div>
            <div class="stat-value">
                {{ $totalEmployees }}
            </div>
        </div>
    </div>

    {{-- Statistik lain bisa ditambahkan di sini --}}
</div>

{{-- ===================== TWO COLUMN LAYOUT ===================== --}}
<div class="dashboard-grid">
    {{-- PRESENSI TERBARU --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Presensi Terbaru</h3>
        </div>
        
        <div class="table-responsive">
            <table class="mobile-friendly-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Pegawai</th>
                        <th>Status</th>
                        <th>Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentAttendances as $attendance)
                        <tr>
                            <td data-label="Tanggal">
                                {{ \Carbon\Carbon::parse($attendance->tanggal)->format('d M Y') }}
                            </td>
                            <td data-label="Pegawai">
                                {{ $attendance->user->name }}
                            </td>
                            <td data-label="Status">
                                <span class="status-badge status-{{ $attendance->status }}">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td data-label="Verifikasi">
                                @if($attendance->verified_at)
                                    <span class="verified-status">
                                        Terverifikasi
                                    </span>
                                @else
                                    <span class="pending-status">
                                        Pending
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-state">
                                Belum ada data presensi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- AKSI CEPAT + PERIODE --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Aksi Cepat</h3>
        </div>

        <div class="quick-actions">
            <a href="{{ route('admin.employees.create') }}" class="btn btn-primary btn-block">
                <i class="fas fa-user-plus"></i> Tambah Pegawai
            </a>
            <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary btn-block">
                <i class="fas fa-check-circle"></i> Verifikasi Presensi
            </a>
            <a href="{{ route('admin.payroll.index') }}" class="btn btn-outline btn-block">
                <i class="fas fa-calculator"></i> Generate Gaji
            </a>
            <a href="{{ route('admin.payroll.reports') }}" class="btn btn-outline btn-block">
                <i class="fas fa-file-alt"></i> Laporan Gaji
            </a>
        </div>

        <div class="active-period">
            <h4>Periode Aktif</h4>
            @if($activePeriod)
                <div class="period-name">{{ $activePeriod->nama }}</div>
                <div class="period-date">
                    {{ \Carbon\Carbon::parse($activePeriod->start_date)->format('d M Y') }}
                    –
                    {{ \Carbon\Carbon::parse($activePeriod->end_date)->format('d M Y') }}
                </div>
            @else
                <div class="no-period">
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
        <a href="{{ route('admin.payroll.index') }}" class="view-all">Lihat Semua</a>
    </div>

    <div class="table-responsive">
        <table class="mobile-friendly-table">
            <thead>
                <tr>
                    <th>Pegawai</th>
                    <th>Periode</th>
                    <th>Gaji Pokok</th>
                    <th>Potongan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentPayrolls as $payroll)
                    <tr>
                        <td data-label="Pegawai">{{ $payroll->user->name }}</td>
                        <td data-label="Periode">{{ $payroll->period->nama }}</td>
                        <td data-label="Gaji Pokok" class="text-right">
                            Rp {{ number_format($payroll->total_income, 0, ',', '.') }}
                        </td>
                        <td data-label="Potongan" class="text-right deduction">
                            Rp {{ number_format($payroll->total_deduction, 0, ',', '.') }}
                        </td>
                        <td data-label="Total" class="text-right total">
                            Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            Belum ada data penggajian
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
/* ===== RESPONSIVE GRID ===== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

/* ===== RESPONSIVE TABLE ===== */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.mobile-friendly-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 600px; /* Minimum width untuk desktop */
}

.mobile-friendly-table th,
.mobile-friendly-table td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid var(--gray-200);
}

/* ===== CARD STYLES ===== */
.card {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--gray-200);
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
}

/* ===== STAT CARD ===== */
.stat-card {
    border-left: 4px solid var(--maroon);
    padding: 1.5rem;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--gray-600);
    margin-bottom: 0.5rem;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--gray-900);
}

/* ===== STATUS BADGES ===== */
.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-block;
}

.status-hadir {
    background: #D1FAE5;
    color: #065F46;
}

.status-izin {
    background: #FEF3C7;
    color: #92400E;
}

.status-cuti {
    background: #DBEAFE;
    color: #1E40AF;
}

/* ===== QUICK ACTIONS ===== */
.quick-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.btn-block {
    display: block;
    width: 100%;
    text-align: center;
    padding: 0.75rem 1rem;
}

.btn-block i {
    margin-right: 0.5rem;
}

/* ===== ACTIVE PERIOD ===== */
.active-period {
    padding-top: 1rem;
    border-top: 1px solid var(--gray-200);
}

.active-period h4 {
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.period-name {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.period-date {
    font-size: 0.875rem;
    color: var(--gray-600);
}

.no-period {
    color: var(--gray-600);
    font-size: 0.875rem;
}

/* ===== PAYROLL TABLE ===== */
.text-right {
    text-align: right;
}

.deduction {
    color: #DC2626;
}

.total {
    font-weight: 600;
}

/* ===== EMPTY STATE ===== */
.empty-state {
    padding: 2rem 1rem;
    text-align: center;
    color: var(--gray-500);
}

/* ===== MOBILE RESPONSIVE ===== */
@media (max-width: 768px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .card {
        padding: 1rem;
    }
    
    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .card-title {
        font-size: 1.125rem;
    }
    
    .stat-card {
        padding: 1rem;
    }
    
    .stat-value {
        font-size: 1.75rem;
    }
    
    /* Responsive table untuk mobile */
    .mobile-friendly-table {
        min-width: unset;
    }
    
    .mobile-friendly-table thead {
        display: none;
    }
    
    .mobile-friendly-table tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid var(--gray-200);
        border-radius: 0.5rem;
        padding: 0.75rem;
    }
    
    .mobile-friendly-table td {
        display: block;
        text-align: right !important;
        padding: 0.5rem;
        border: none;
        position: relative;
    }
    
    .mobile-friendly-table td::before {
        content: attr(data-label);
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-weight: 600;
        color: var(--gray-700);
    }
    
    /* Status badges di mobile */
    .status-badge {
        display: inline-block;
        float: right;
    }
    
    /* Quick actions di mobile */
    .quick-actions .btn {
        padding: 0.875rem 1rem;
        font-size: 0.875rem;
    }
    
    .btn-block i {
        font-size: 1rem;
        vertical-align: middle;
    }
    
    /* Payroll columns di mobile */
    .mobile-friendly-table td.text-right::before {
        text-align: left;
    }
}

/* Untuk tablet */
@media (min-width: 769px) and (max-width: 1024px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
    
    .mobile-friendly-table {
        min-width: unset;
    }
}

/* Untuk layar sangat kecil */
@media (max-width: 480px) {
    .stat-card {
        padding: 0.875rem;
    }
    
    .stat-value {
        font-size: 1.5rem;
    }
    
    .quick-actions .btn {
        font-size: 0.8125rem;
        padding: 0.75rem;
    }
    
    .btn-block i {
        font-size: 0.875rem;
    }
}

/* View all link */
.view-all {
    font-size: 0.875rem;
    color: var(--maroon);
    text-decoration: none;
    font-weight: 500;
}

.view-all:hover {
    text-decoration: underline;
}

/* Verified/Pending status */
.verified-status {
    color: #065F46;
    font-weight: 600;
    font-size: 0.75rem;
}

.pending-status {
    color: #92400E;
    font-weight: 600;
    font-size: 0.75rem;
}
</style>

@endsection