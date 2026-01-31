@extends('layouts.user')

@section('content')
    <!-- Welcome Banner -->
    <div style="background: linear-gradient(135deg, var(--maroon) 0%, var(--maroon-dark) 100%); border-radius: 12px; padding: 2rem; margin-bottom: 2rem; color: white; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: var(--gold); opacity: 0.1; border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: white; opacity: 0.05; border-radius: 50%;"></div>
        
        <div style="position: relative; z-index: 1;">
            <h2 class="heading-font" style="font-size: 1.75rem; margin-bottom: 0.5rem;">
                Selamat Datang, {{ Auth::user()->name }}!
            </h2>
            <p style="opacity: 0.9; font-size: 0.95rem;">
                NIP: {{ Auth::user()->employee->nip ?? '-' }} | {{ Auth::user()->employee->jabatan ?? 'Staff' }}
            </p>
            <div style="margin-top: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                <div style="background: rgba(255, 255, 255, 0.15); padding: 0.75rem 1.25rem; border-radius: 8px; backdrop-filter: blur(10px);">
                    <div style="font-size: 0.75rem; opacity: 0.9; margin-bottom: 0.25rem;">Hari Ini</div>
                    <div style="font-size: 1.125rem; font-weight: 700;">{{ now()->format('d F Y') }}</div>
                </div>
                <div style="background: rgba(255, 255, 255, 0.15); padding: 0.75rem 1.25rem; border-radius: 8px; backdrop-filter: blur(10px);">
                    <div style="font-size: 0.75rem; opacity: 0.9; margin-bottom: 0.25rem;">Status Presensi</div>
                    <div style="font-size: 1.125rem; font-weight: 700;">Belum Check-in</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stat-grid">
        <!-- Presensi Bulan Ini -->
        <div class="stat-card" style="border-left-color: #10B981;">
            <div class="stat-icon" style="background: #D1FAE5; color: #10B981;">
                <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="stat-label">Kehadiran Bulan Ini</div>
            <div class="stat-value">18</div>
            <div style="font-size: 0.75rem; color: var(--gray-600); margin-top: 0.5rem;">
                dari 20 hari kerja
            </div>
        </div>

        <!-- Izin/Sakit -->
        <div class="stat-card" style="border-left-color: #F59E0B;">
            <div class="stat-icon" style="background: #FEF3C7; color: #F59E0B;">
                <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="stat-label">Izin/Sakit</div>
            <div class="stat-value">2</div>
            <div style="font-size: 0.75rem; color: var(--gray-600); margin-top: 0.5rem;">
                hari dalam bulan ini
            </div>
        </div>

        <!-- Gaji Bulan Ini -->
        <div class="stat-card" style="border-left-color: var(--gold);">
            <div class="stat-icon" style="background: #FEF3E2; color: var(--gold);">
                <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="stat-label">Gaji Bulan Ini</div>
            <div class="stat-value" style="font-size: 1.5rem;">5.9M</div>
            <div style="font-size: 0.75rem; color: var(--gray-600); margin-top: 0.5rem;">
                Januari 2026
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Quick Check-in -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Presensi Hari Ini</h3>
            </div>
            <div style="text-align: center; padding: 1.5rem 0;">
                <div style="width: 80px; height: 80px; margin: 0 auto 1rem; background: linear-gradient(135deg, var(--maroon) 0%, var(--maroon-light) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 40px; height: 40px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--charcoal);">
                    {{ now()->format('H:i') }}
                </div>
                <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 1.5rem;">
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
                <a href="{{ route('attendance.index') }}" class="btn btn-primary" style="width: 100%; justify-content: center; font-size: 1rem; padding: 0.875rem;">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Check-in Sekarang
                </a>
            </div>
        </div>

        <!-- Latest Slip Gaji -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Slip Gaji Terakhir</h3>
                <a href="{{ route('payroll.index') }}" style="font-size: 0.875rem; color: var(--maroon); text-decoration: none; font-weight: 500;">
                    Lihat Semua →
                </a>
            </div>
            <div style="background: var(--cream); padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                    <div>
                        <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem;">Periode</div>
                        <div style="font-weight: 600; font-size: 1.125rem;">Desember 2025</div>
                    </div>
                    <span style="padding: 0.375rem 0.875rem; background: #D1FAE5; color: #065F46; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Lunas</span>
                </div>
                <div style="border-top: 2px dashed var(--gray-300); padding-top: 1rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span style="font-size: 0.875rem; color: var(--gray-600);">Gaji Pokok</span>
                        <span style="font-size: 0.875rem; font-weight: 500;">Rp 6.000.000</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span style="font-size: 0.875rem; color: var(--gray-600);">Potongan</span>
                        <span style="font-size: 0.875rem; font-weight: 500; color: #DC2626;">- Rp 100.000</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding-top: 0.75rem; border-top: 2px solid var(--gray-300); margin-top: 0.75rem;">
                        <span style="font-weight: 600;">Total Gaji</span>
                        <span style="font-weight: 700; font-size: 1.25rem; color: var(--maroon);">Rp 5.900.000</span>
                    </div>
                </div>
            </div>
            <a href="{{ route('payroll.show', 1) }}" class="btn btn-outline" style="width: 100%; justify-content: center;">
                Lihat Detail Slip
            </a>
        </div>
    </div>

    <!-- Recent Attendance -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Riwayat Presensi Terbaru</h3>
            <a href="{{ route('attendance.history') }}" style="font-size: 0.875rem; color: var(--maroon); text-decoration: none; font-weight: 500;">
                Lihat Semua →
            </a>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--gray-100);">
                        <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Tanggal</th>
                        <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Hari</th>
                        <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Status</th>
                        <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid var(--gray-100);">
                        <td style="padding: 0.75rem; font-size: 0.875rem;">31 Januari 2026</td>
                        <td style="padding: 0.75rem; font-size: 0.875rem; color: var(--gray-600);">Jumat</td>
                        <td style="padding: 0.75rem;">
                            <span style="padding: 0.25rem 0.75rem; background: #D1FAE5; color: #065F46; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Hadir</span>
                        </td>
                        <td style="padding: 0.75rem;">
                            <span style="padding: 0.25rem 0.75rem; background: #D1FAE5; color: #065F46; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">✓ Verified</span>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--gray-100);">
                        <td style="padding: 0.75rem; font-size: 0.875rem;">30 Januari 2026</td>
                        <td style="padding: 0.75rem; font-size: 0.875rem; color: var(--gray-600);">Kamis</td>
                        <td style="padding: 0.75rem;">
                            <span style="padding: 0.25rem 0.75rem; background: #D1FAE5; color: #065F46; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Hadir</span>
                        </td>
                        <td style="padding: 0.75rem;">
                            <span style="padding: 0.25rem 0.75rem; background: #D1FAE5; color: #065F46; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">✓ Verified</span>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--gray-100);">
                        <td style="padding: 0.75rem; font-size: 0.875rem;">29 Januari 2026</td>
                        <td style="padding: 0.75rem; font-size: 0.875rem; color: var(--gray-600);">Rabu</td>
                        <td style="padding: 0.75rem;">
                            <span style="padding: 0.25rem 0.75rem; background: #FEE2E2; color: #991B1B; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Sakit</span>
                        </td>
                        <td style="padding: 0.75rem;">
                            <span style="padding: 0.25rem 0.75rem; background: #D1FAE5; color: #065F46; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">✓ Verified</span>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--gray-100);">
                        <td style="padding: 0.75rem; font-size: 0.875rem;">28 Januari 2026</td>
                        <td style="padding: 0.75rem; font-size: 0.875rem; color: var(--gray-600);">Selasa</td>
                        <td style="padding: 0.75rem;">
                            <span style="padding: 0.25rem 0.75rem; background: #D1FAE5; color: #065F46; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Hadir</span>
                        </td>
                        <td style="padding: 0.75rem;">
                            <span style="padding: 0.25rem 0.75rem; background: #D1FAE5; color: #065F46; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">✓ Verified</span>
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--gray-100);">
                        <td style="padding: 0.75rem; font-size: 0.875rem;">27 Januari 2026</td>
                        <td style="padding: 0.75rem; font-size: 0.875rem; color: var(--gray-600);">Senin</td>
                        <td style="padding: 0.75rem;">
                            <span style="padding: 0.25rem 0.75rem; background: #D1FAE5; color: #065F46; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Hadir</span>
                        </td>
                        <td style="padding: 0.75rem;">
                            <span style="padding: 0.25rem 0.75rem; background: #D1FAE5; color: #065F46; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">✓ Verified</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection