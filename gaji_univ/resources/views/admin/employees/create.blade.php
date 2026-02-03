@extends('layouts.admin')

@section('title', 'Tambah Pegawai Baru')

@section('content')
<!-- Breadcrumb -->
<div style="margin-bottom: 2rem;">
    <a href="{{ route('admin.employees.index') }}" style="color: var(--gray-600); text-decoration: none; font-size: 0.875rem;">
        ← Kembali ke Daftar Pegawai
    </a>
</div>

<!-- Header -->
<div style="margin-bottom: 2rem;">
    <h2 style="font-size: 1.75rem; font-weight: 700; color: var(--charcoal); margin-bottom: 0.5rem;">
        Tambah Pegawai Baru
    </h2>
    <p style="color: var(--gray-600);">Buat akun user baru untuk pegawai</p>
</div>

<!-- Error Messages -->
@if($errors->any())
<div style="background: #FEE2E2; border-left: 4px solid #DC2626; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem;">
    <div style="font-weight: 600; color: #991B1B; margin-bottom: 0.5rem;">Terjadi Kesalahan:</div>
    <ul style="margin: 0; padding-left: 1.5rem; color: #991B1B;">
        @foreach($errors->all() as $error)
        <li style="margin-bottom: 0.25rem;">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Form -->
<div class="card">
    <form action="{{ route('admin.employees.store') }}" method="POST">
        @csrf

        <div style="display: grid; gap: 1.5rem;">
            <!-- Data Akun -->
            <div style="background: var(--cream); padding: 1rem; border-radius: 6px; border-left: 3px solid var(--maroon);">
                <h3 style="font-size: 1rem; font-weight: 600; color: var(--charcoal); margin-bottom: 0.25rem;">
                    Data Akun Login
                </h3>
                <p style="font-size: 0.875rem; color: var(--gray-600);">
                    Password default akan dibuat otomatis: <strong>unmer</strong> + <strong>4 digit terakhir NIP</strong>
                </p>
            </div>

            <!-- Nama -->
            <div>
                <label for="name" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--charcoal);">
                    Nama Lengkap <span style="color: #DC2626;">*</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    required
                    style="width: 100%; padding: 0.75rem; border: 2px solid var(--gray-200); border-radius: 6px; font-size: 0.95rem; transition: border 0.2s;"
                    onfocus="this.style.borderColor='var(--maroon)'"
                    onblur="this.style.borderColor='var(--gray-200)'"
                    placeholder="Contoh: Dr. Ahmad Hidayat, M.Kom">
                @error('name')
                <div style="color: #DC2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--charcoal);">
                    Email <span style="color: #DC2626;">*</span>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required
                    style="width: 100%; padding: 0.75rem; border: 2px solid var(--gray-200); border-radius: 6px; font-size: 0.95rem; transition: border 0.2s;"
                    onfocus="this.style.borderColor='var(--maroon)'"
                    onblur="this.style.borderColor='var(--gray-200)'"
                    placeholder="contoh@unmer.ac.id">
                @error('email')
                <div style="color: #DC2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Divider -->
            <hr style="border: none; border-top: 2px solid var(--gray-100); margin: 0.5rem 0;">

            <!-- Data Pegawai -->
            <div style="background: var(--cream); padding: 1rem; border-radius: 6px; border-left: 3px solid var(--gold);">
                <h3 style="font-size: 1rem; font-weight: 600; color: var(--charcoal);">
                    Data Kepegawaian
                </h3>
            </div>

            <!-- NIP -->
            <div>
                <label for="nip" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--charcoal);">
                    NIP (Nomor Induk Pegawai) <span style="color: #DC2626;">*</span>
                </label>
                <input 
                    type="text" 
                    id="nip" 
                    name="nip" 
                    value="{{ old('nip') }}"
                    required
                    style="width: 100%; padding: 0.75rem; border: 2px solid var(--gray-200); border-radius: 6px; font-size: 0.95rem; font-family: monospace; transition: border 0.2s;"
                    onfocus="this.style.borderColor='var(--maroon)'"
                    onblur="this.style.borderColor='var(--gray-200)'"
                    placeholder="Contoh: 198501012010011001">
                <div style="font-size: 0.875rem; color: var(--gray-600); margin-top: 0.5rem;">
                    💡 Password default akan dibuat: <strong>unmer</strong> + <strong>4 digit terakhir NIP</strong>
                </div>
                @error('nip')
                <div style="color: #DC2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Jabatan -->
            <div>
                <label for="jabatan" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--charcoal);">
                    Jabatan <span style="color: #DC2626;">*</span>
                </label>
                <input 
                    type="text" 
                    id="jabatan" 
                    name="jabatan" 
                    value="{{ old('jabatan') }}"
                    required
                    style="width: 100%; padding: 0.75rem; border: 2px solid var(--gray-200); border-radius: 6px; font-size: 0.95rem; transition: border 0.2s;"
                    onfocus="this.style.borderColor='var(--maroon)'"
                    onblur="this.style.borderColor='var(--gray-200)'"
                    placeholder="Contoh: Dosen Teknik Informatika">
                @error('jabatan')
                <div style="color: #DC2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Gaji Pokok -->
            <div>
                <label for="gaji_pokok" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--charcoal);">
                    Gaji Pokok <span style="color: #DC2626;">*</span>
                </label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--gray-600); font-weight: 500;">Rp</span>
                    <input 
                        type="number" 
                        id="gaji_pokok" 
                        name="gaji_pokok" 
                        value="{{ old('gaji_pokok') }}"
                        required
                        min="0"
                        step="1000"
                        style="width: 100%; padding: 0.75rem 0.75rem 0.75rem 3rem; border: 2px solid var(--gray-200); border-radius: 6px; font-size: 0.95rem; transition: border 0.2s;"
                        onfocus="this.style.borderColor='var(--maroon)'"
                        onblur="this.style.borderColor='var(--gray-200)'"
                        placeholder="5000000">
                </div>
                @error('gaji_pokok')
                <div style="color: #DC2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Buttons -->
        <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; padding-top: 1.5rem; border-top: 2px solid var(--gray-100);">
            <a href="{{ route('admin.employees.index') }}" class="btn btn-outline">
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Pegawai
            </button>
        </div>
    </form>
</div>

<!-- Info Box -->
<div style="background: #DBEAFE; border-left: 4px solid #3B82F6; padding: 1rem; border-radius: 6px; margin-top: 1.5rem;">
    <div style="display: flex; gap: 0.75rem;">
        <svg style="width: 20px; height: 20px; color: #3B82F6; flex-shrink: 0; margin-top: 2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div style="color: #1E40AF; font-size: 0.875rem;">
            <strong>Catatan:</strong>
            <ul style="margin: 0.5rem 0 0 1rem; padding: 0;">
                <li>Akun user akan otomatis dibuat dengan role "user"</li>
                <li>Password default: <strong>unmer</strong> + <strong>4 digit terakhir NIP</strong></li>
                <li>Pegawai dapat mengubah password setelah login pertama kali</li>
                <li>Email akan digunakan untuk login dan notifikasi sistem</li>
            </ul>
        </div>
    </div>
</div>
@endsection