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
                    Masuk ke Sistem
                </h2>
                <p style="color: #6B7280; margin-bottom: 2rem; font-size: 0.95rem;">
                    Silakan masukkan kredensial Anda untuk melanjutkan
                </p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
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
                            autocomplete="current-password"
                        />
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div style="margin-bottom: 1.5rem;">
                        <label for="remember_me" class="checkbox-wrapper">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                class="checkbox-input" 
                                name="remember"
                            />
                            <span style="font-size: 0.875rem; color: #4B5563;">Ingat saya</span>
                        </label>
                    </div>

                    <!-- Actions -->
                    <div style="margin-bottom: 1.5rem;">
                        <button type="submit" class="btn-primary">
                            Masuk
                        </button>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 0.75rem; align-items: center; font-size: 0.875rem;">
                        @if (Route::has('password.request'))
                            <a class="link-text" href="{{ route('password.request') }}">
                                Lupa kata sandi?
                            </a>
                        @endif

                        @if (Route::has('register'))
                            <div style="color: #6B7280;">
                                Belum punya akun? 
                                <a href="{{ route('register') }}" class="link-text">Daftar di sini</a>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>