<x-guest-layout>
    <div class="auth-card">
        <!-- Brand Side -->
        <div class="auth-brand">
            <div class="brand-content">
                <h1 class="university-name heading-font">Universitas<br>17 Desember 1945<br>Krian</h1>
                <p class="university-subtitle">Unter Krian</p>
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
                    Daftar Akun Baru
                </h2>
                <p style="color: #6B7280; margin-bottom: 2rem; font-size: 0.95rem;">
                    Silakan lengkapi formulir pendaftaran di bawah ini
                </p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div style="margin-bottom: 1.5rem;">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input 
                            id="name" 
                            class="form-input" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus 
                            autocomplete="name"
                        />
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

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
                            autocomplete="username"
                        />
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div style="margin-bottom: 1.5rem;">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input 
                            id="password" 
                            class="form-input"
                            type="password" 
                            name="password"
                            required 
                            autocomplete="new-password"
                        />
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div style="margin-bottom: 1.5rem;">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <input 
                            id="password_confirmation" 
                            class="form-input"
                            type="password" 
                            name="password_confirmation"
                            required 
                            autocomplete="new-password"
                        />
                        @error('password_confirmation')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div style="margin-bottom: 1.5rem;">
                        <button type="submit" class="btn-primary">
                            Daftar
                        </button>
                    </div>

                    <div style="text-align: center; font-size: 0.875rem; color: #6B7280;">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="link-text">Masuk di sini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>