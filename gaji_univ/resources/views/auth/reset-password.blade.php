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
                    Reset Kata Sandi
                </h2>
                <p style="color: #6B7280; margin-bottom: 2rem; font-size: 0.95rem;">
                    Silakan masukkan kata sandi baru Anda
                </p>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div style="margin-bottom: 1.5rem;">
                        <label for="email" class="form-label">Email</label>
                        <input 
                            id="email" 
                            class="form-input" 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $request->email) }}" 
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
                        <label for="password" class="form-label">Kata Sandi Baru</label>
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
                            Reset Kata Sandi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>