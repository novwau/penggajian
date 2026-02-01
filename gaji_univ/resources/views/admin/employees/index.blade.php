@extends('layouts.admin')

@section('title', 'Kelola Pegawai')

@section('content')
<!-- Success Message -->
@if(session('success'))
<div style="background: #D1FAE5; border-left: 4px solid #10B981; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem;">
    <div style="display: flex; align-items: start; gap: 0.75rem;">
        <svg style="width: 20px; height: 20px; color: #10B981; flex-shrink: 0; margin-top: 2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <div style="font-weight: 600; color: #065F46; margin-bottom: 0.25rem;">{{ session('success') }}</div>
            @if(session('password_default'))
            <div style="font-size: 0.875rem; color: #059669; margin-top: 0.5rem;">
                <strong>Password Default:</strong> <code style="background: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-family: monospace;">{{ session('password_default') }}</code>
                <br><span style="font-size: 0.8rem; opacity: 0.9;">⚠️ Harap dicatat! Password ini tidak akan ditampilkan lagi.</span>
            </div>
            @endif
        </div>
    </div>
</div>
@endif

<!-- Header -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="font-size: 1.75rem; font-weight: 700; color: var(--charcoal); margin-bottom: 0.5rem;">
            Kelola Pegawai
        </h2>
        <p style="color: var(--gray-600);">Manajemen data pegawai dan akun user</p>
    </div>
    <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Pegawai
    </a>
</div>

<!-- Stats -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card" style="border-left: 4px solid var(--maroon); padding: 1.25rem;">
        <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.5rem;">Total Pegawai</div>
        <div style="font-size: 2rem; font-weight: 700; color: var(--charcoal);">{{ $employees->total() }}</div>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pegawai</h3>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid var(--gray-100);">
                    <th style="padding: 0.875rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">NIP</th>
                    <th style="padding: 0.875rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Nama</th>
                    <th style="padding: 0.875rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Email</th>
                    <th style="padding: 0.875rem; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Jabatan</th>
                    <th style="padding: 0.875rem; text-align: right; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Gaji Pokok</th>
                    <th style="padding: 0.875rem; text-align: center; font-size: 0.875rem; font-weight: 600; color: var(--gray-600);">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                <tr style="border-bottom: 1px solid var(--gray-100);">
                    <td style="padding: 0.875rem; font-size: 0.875rem; font-family: monospace;">
                        {{ $employee->employee->nip ?? '-' }}
                    </td>
                    <td style="padding: 0.875rem; font-size: 0.875rem; font-weight: 500;">
                        {{ $employee->name }}
                    </td>
                    <td style="padding: 0.875rem; font-size: 0.875rem; color: var(--gray-600);">
                        {{ $employee->email }}
                    </td>
                    <td style="padding: 0.875rem; font-size: 0.875rem;">
                        {{ $employee->employee->jabatan ?? '-' }}
                    </td>
                    <td style="padding: 0.875rem; font-size: 0.875rem; text-align: right; font-weight: 500;">
                        Rp {{ number_format($employee->employee->gaji_pokok ?? 0, 0, ',', '.') }}
                    </td>
                    <td style="padding: 0.875rem; text-align: center;">
                        <div style="display: inline-flex; gap: 0.5rem;">
                            <a href="{{ route('admin.employees.show', $employee) }}" 
                               class="btn btn-outline" 
                               style="padding: 0.375rem 0.75rem; font-size: 0.8rem;"
                               title="Detail">
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.employees.edit', $employee) }}" 
                               class="btn btn-secondary" 
                               style="padding: 0.375rem 0.75rem; font-size: 0.8rem;"
                               title="Edit">
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.employees.destroy', $employee) }}" 
                                  method="POST" 
                                  style="display: inline;"
                                  onsubmit="return confirm('Yakin ingin menghapus pegawai ini? Data presensi dan gaji akan ikut terhapus!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn" 
                                        style="padding: 0.375rem 0.75rem; font-size: 0.8rem; background: #DC2626; color: white;"
                                        title="Hapus">
                                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 3rem; text-align: center; color: var(--gray-600);">
                        <svg style="width: 48px; height: 48px; margin: 0 auto 1rem; opacity: 0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <div style="font-weight: 500; margin-bottom: 0.5rem;">Belum ada data pegawai</div>
                        <div style="font-size: 0.875rem;">Klik tombol "Tambah Pegawai" untuk menambahkan pegawai baru</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($employees->hasPages())
    <div style="padding: 1.5rem; border-top: 1px solid var(--gray-200);">
        {{ $employees->links() }}
    </div>
    @endif
</div>
@endsection