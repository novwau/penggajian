<x-guest-layout>
    <div class="auth-card">
        <!-- Brand Side -->
        <div class="auth-brand">
            <div class="brand-content">
                <h1 class="university-name heading-font">Universitas<br>17 Agustus 1945<br>Surabaya</h1>
                <p class="university-subtitle">Untag Surabaya</p>
                <div class="decorative-line"></div>
                <p class="system-description">
                    Sistem Informasi Penggajian<br>
                    Dosen dan Karyawan
                </p>
            </div>
        </div>

        <!-- Form Side -->
        <div class="auth-side">
            <div style="max-width: 400px; margin: 0 auto;">
                <h2 class="heading-font" style="font-size: 1.75rem; font-weight: 700; color: var(--maroon); margin-bottom: 0.5rem;">
                    Lupa Kata Sandi?
                </h2>
                <p style="color: #6B7280; margin-bottom: 2rem; font-size: 0.95rem; line-height: 1.6;">
                    Tidak masalah. Cukup masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mereset kata sandi.
                </p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div style="margin-bottom: 1.5rem;">
                        <label for="email" class="form-label">Email</label>
                        <input 
                            id="email" 
                            class="form-input" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                        />
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div style="margin-bottom: 1.5rem;">
                        <button type="submit" class="btn-primary">
                            Kirim Tautan Reset
                        </button>
                    </div>

                    <div style="text-align: center; font-size: 0.875rem; color: #6B7280;">
                        <a href="{{ route('login') }}" class="link-text">Kembali ke halaman login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>