@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <!-- Stats Grid -->
    <div class="stat-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Total Pegawai -->
        <div class="card" style="border-left: 4px solid var(--maroon);">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.5rem; font-weight: 500;">
                        Total Pegawai
                    </div>
                    <div style="font-size: 2rem; font-weight: 700; color: var(--charcoal);">
                        245
                    </div>
                    <div style="font-size: 0.75rem; color: #10B981; margin-top: 0.5rem;">
                        ↑ 12 pegawai baru bulan ini
                    </div>
                </div>
                <div style="width: 48px; height: 48px; background: var(--cream); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 24px; height: 24px; color: var(--maroon);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Presensi Hari Ini -->
        <div class="card" style="border-left: 4px solid #10B981;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.5rem; font-weight: 500;">
                        Presensi Hari Ini
                    </div>
                    <div style="font-size: 2rem; font-weight: 700; color: var(--charcoal);">
                        218
                    </div>
                    <div style="font-size: 0.75rem; color: var(--gray-600); margin-top: 0.5rem;">
                        89% dari total pegawai
                    </div>
                </div>
                <div style="width: 48px; height: 48px; background: #D1FAE5; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 24px; height: 24px; color: #10B981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Perlu Verifikasi -->
        <div class="card" style="border-left: 4px solid #F59E0B;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.5rem; font-weight: 500;">
                        Perlu Verifikasi
                    </div>
                    <div style="font-size: 2rem; font-weight: 700; color: var(--charcoal);">
                        23
                    </div>
                    <div style="font-size: 0.75rem; color: #F59E0B; margin-top: 0.5rem;">
                        Presensi menunggu approval
                    </div>
                </div>
                <div style="width: 48px; height: 48px; background: #FEF3C7; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 24px; height: 24px; color: #F59E0B;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Gaji Bulan Ini -->
        <div class="card" style="border-left: 4px solid var(--gold);">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.5rem; font-weight: 500;">
                        Total Gaji Bulan Ini
                    </div>
                    <div style="font-size: 2rem; font-weight: 700; color: var(--charcoal);">
                        1.2M
                    </div>
                    <div style="font-size: 0.75rem; color: var(--gray-600); margin-top: 0.5rem;">
                        245 pegawai
                    </div>
                </div>
                <div style="width: 48px; height: 48px; background: #FEF3E2; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 24px; height: 24px; color: var(--gold);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Recent Activity -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Aktivitas Terbaru</h3>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--gray-100);">
                            <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Waktu</th>
                            <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Pegawai</th>
                            <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Aktivitas</th>
                            <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom: 1px solid var(--gray-100);">
                            <td style="padding: 0.75rem; font-size: 0.875rem; color: var(--gray-600);">10:23</td>
                            <td style="padding: 0.75rem; font-size: 0.875rem;">Dr. Ahmad Hidayat</td>
                            <td style="padding: 0.75rem; font-size: 0.875rem;">Check-in presensi</td>
                            <td style="padding: 0.75rem;">
                                <span style="padding: 0.25rem 0.75rem; background: #FEF3C7; color: #92400E; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Pending</span>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid var(--gray-100);">
                            <td style="padding: 0.75rem; font-size: 0.875rem; color: var(--gray-600);">09:45</td>
                            <td style="padding: 0.75rem; font-size: 0.875rem;">Siti Nurhaliza, S.Kom</td>
                            <td style="padding: 0.75rem; font-size: 0.875rem;">Check-in presensi</td>
                            <td style="padding: 0.75rem;">
                                <span style="padding: 0.25rem 0.75rem; background: #D1FAE5; color: #065F46; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Verified</span>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid var(--gray-100);">
                            <td style="padding: 0.75rem; font-size: 0.875rem; color: var(--gray-600);">09:12</td>
                            <td style="padding: 0.75rem; font-size: 0.875rem;">Budi Santoso, M.T</td>
                            <td style="padding: 0.75rem; font-size: 0.875rem;">Check-in presensi</td>
                            <td style="padding: 0.75rem;">
                                <span style="padding: 0.25rem 0.75rem; background: #D1FAE5; color: #065F46; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Verified</span>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid var(--gray-100);">
                            <td style="padding: 0.75rem; font-size: 0.875rem; color: var(--gray-600);">08:30</td>
                            <td style="padding: 0.75rem; font-size: 0.875rem;">Dr. Maria Ulfah</td>
                            <td style="padding: 0.75rem; font-size: 0.875rem;">Izin sakit</td>
                            <td style="padding: 0.75rem;">
                                <span style="padding: 0.25rem 0.75rem; background: #FEE2E2; color: #991B1B; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Sakit</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Aksi Cepat</h3>
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary" style="justify-content: center;">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Pegawai Baru
                </a>
                <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary" style="justify-content: center;">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    Verifikasi Presensi
                </a>
                <a href="{{ route('admin.payroll.index') }}" class="btn btn-outline" style="justify-content: center;">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Generate Gaji
                </a>
                <a href="{{ route('admin.payroll.reports') }}" class="btn btn-outline" style="justify-content: center;">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Lihat Laporan
                </a>
            </div>

            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 2px solid var(--gray-100);">
                <h4 style="font-size: 0.875rem; font-weight: 600; margin-bottom: 0.75rem; color: var(--gray-700);">
                    Periode Aktif
                </h4>
                <div style="background: var(--cream); padding: 1rem; border-radius: 6px;">
                    <div style="font-weight: 600; margin-bottom: 0.25rem;">Januari 2026</div>
                    <div style="font-size: 0.875rem; color: var(--gray-600);">1 Jan - 31 Jan 2026</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Payrolls -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Penggajian Terbaru</h3>
            <a href="{{ route('admin.payroll.index') }}" class="link-text" style="font-size: 0.875rem;">
                Lihat Semua →
            </a>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--gray-100);">
                        <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Pegawai</th>
                        <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Periode</th>
                        <th style="padding: 0.75rem; text-align: right; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Gaji Pokok</th>
                        <th style="padding: 0.75rem; text-align: right; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Potongan</th>
                        <th style="padding: 0.75rem; text-align: right; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Total Gaji</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid var(--gray-100);">
                        <td style="padding: 0.75rem; font-size: 0.875rem;">Dr. Ahmad Hidayat</td>
                        <td style="padding: 0.75rem; font-size: 0.875rem; color: var(--gray-600);">Desember 2025</td>
                        <td style="padding: 0.75rem; font-size: 0.875rem; text-align: right;">Rp 8.500.000</td>
                        <td style="padding: 0.75rem; font-size: 0.875rem; text-align: right; color: #DC2626;">Rp 150.000</td>
                        <td style="padding: 0.75rem; font-size: 0.875rem; text-align: right; font-weight: 600;">Rp 8.350.000</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--gray-100);">
                        <td style="padding: 0.75rem; font-size: 0.875rem;">Siti Nurhaliza, S.Kom</td>
                        <td style="padding: 0.75rem; font-size: 0.875rem; color: var(--gray-600);">Desember 2025</td>
                        <td style="padding: 0.75rem; font-size: 0.875rem; text-align: right;">Rp 4.500.000</td>
                        <td style="padding: 0.75rem; font-size: 0.875rem; text-align: right; color: #DC2626;">Rp 0</td>
                        <td style="padding: 0.75rem; font-size: 0.875rem; text-align: right; font-weight: 600;">Rp 4.500.000</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--gray-100);">
                        <td style="padding: 0.75rem; font-size: 0.875rem;">Budi Santoso, M.T</td>
                        <td style="padding: 0.75rem; font-size: 0.875rem; color: var(--gray-600);">Desember 2025</td>
                        <td style="padding: 0.75rem; font-size: 0.875rem; text-align: right;">Rp 6.000.000</td>
                        <td style="padding: 0.75rem; font-size: 0.875rem; text-align: right; color: #DC2626;">Rp 100.000</td>
                        <td style="padding: 0.75rem; font-size: 0.875rem; text-align: right; font-weight: 600;">Rp 5.900.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection