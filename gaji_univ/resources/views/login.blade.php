<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#8B0000">

    <title>Login - Sistem Pengajian UNTAG</title>

    <style>
        :root {
            --untag-red: #E30613;
            --untag-maroon: #8B0000;
            --untag-yellow: #FFD700;
            --untag-white: #FFFFFF;
            --untag-gray: #F5F5F5;
            --untag-border: #DDDDDD;
            --untag-text: #333333;
            --untag-error: #DC3545;
            --untag-success: #28A745;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", sans-serif;
            background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            line-height: 1.6;
        }

        .login-wrapper {
            width: 100%;
            max-width: 450px;
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background-color: var(--untag-maroon);
            color: var(--untag-white);
            padding: 35px 25px;
            text-align: center;
            border-radius: 12px 12px 0 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .logo-section {
            margin-bottom: 15px;
        }

        .logo-text {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }

        .logo-subtitle {
            font-size: 13px;
            opacity: 0.95;
            font-weight: 400;
        }

        .system-title {
            font-size: 17px;
            font-weight: 700;
            margin-top: 18px;
            padding-top: 18px;
            border-top: 2px solid rgba(255, 255, 255, 0.25);
            letter-spacing: 1px;
        }

        .login-container {
            background-color: var(--untag-white);
            padding: 40px 35px;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
            border: 4px solid var(--untag-maroon);
            border-top: none;
        }

        /* Alert Messages */
        .alert {
            padding: 15px 18px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 15px;
            border: 1px solid;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        .alert ul {
            margin: 8px 0 0 0;
            padding-left: 20px;
        }

        .alert li {
            margin: 5px 0;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--untag-text);
            font-size: 15px;
        }

        .form-label .required {
            color: var(--untag-error);
            margin-left: 2px;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--untag-border);
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: var(--untag-white);
            color: var(--untag-text);
        }

        .form-input:focus {
            border-color: var(--untag-yellow);
            outline: none;
            box-shadow: 0 0 0 4px rgba(255, 215, 0, 0.1);
        }

        .form-input::placeholder {
            color: #999;
        }

        .form-input.is-invalid {
            border-color: var(--untag-error);
        }

        .form-input.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            padding: 8px;
            line-height: 1;
            transition: opacity 0.2s;
            color: #666;
        }

        .password-toggle:hover {
            opacity: 0.7;
        }

        .password-toggle:active {
            transform: translateY(-50%) scale(0.95);
        }

        .invalid-feedback {
            color: var(--untag-error);
            font-size: 14px;
            margin-top: 6px;
            display: block;
        }

        /* Options Row */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 15px;
            color: var(--untag-text);
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            cursor: pointer;
            accent-color: var(--untag-maroon);
        }

        .forgot-link {
            color: var(--untag-red);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .forgot-link:hover {
            opacity: 0.8;
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 16px;
            background-color: var(--untag-maroon);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
        }

        .btn-submit:hover:not(:disabled) {
            background-color: var(--untag-red);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(227, 6, 19, 0.35);
        }

        .btn-submit:active:not(:disabled) {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            background-color: #aaa;
            cursor: not-allowed;
            transform: none;
        }

        .btn-submit .btn-text {
            display: inline-block;
        }

        .btn-submit .btn-loading {
            display: none;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit.loading .btn-text {
            display: none;
        }

        .btn-submit.loading .btn-loading {
            display: flex;
        }

        .spinner {
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            width: 20px;
            height: 20px;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-wrapper {
                max-width: 100%;
            }

            .login-header {
                padding: 28px 20px;
            }

            .logo-text {
                font-size: 19px;
            }

            .system-title {
                font-size: 15px;
            }

            .login-container {
                padding: 30px 22px;
            }

            .form-options {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* Accessibility */
        *:focus-visible {
            outline: 2px solid var(--untag-yellow);
            outline-offset: 2px;
        }

        /* Print styles */
        @media print {
            body {
                background: white;
            }
            .login-wrapper {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Header -->
        <div class="login-header">
            <div class="logo-section">
                <div class="logo-text">UNIVERSITAS 17 DESEMBER KRIAN</div>
                <div class="logo-subtitle">Universitas Terbuka Gresik</div>
            </div>
            <div class="system-title">SISTEM PENGAJIAN</div>
        </div>

        <!-- Login Form Container -->
        <div class="login-container">
            <!-- Session Status Message -->
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-error" role="alert">
                    <strong>Terjadi kesalahan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                @csrf
                
                <!-- Email Input -->
                <div class="form-group">
                    <label for="email" class="form-label">
                        Email <span class="required">*</span>
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form-input @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        autocomplete="email"
                        placeholder="nama@untag.ac.id"
                        aria-describedby="emailHelp"
                    >
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                
                <!-- Password Input -->
                <div class="form-group">
                    <label for="password" class="form-label">
                        Password <span class="required">*</span>
                    </label>
                    <div class="password-wrapper">
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-input @error('password') is-invalid @enderror"
                            required 
                            autocomplete="current-password"
                            placeholder="Masukkan password Anda"
                            aria-describedby="passwordHelp"
                        >
                        <button 
                            type="button" 
                            class="password-toggle" 
                            id="togglePassword"
                            aria-label="Tampilkan password"
                            tabindex="-1"
                        >
                            👁️
                        </button>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                
                <!-- Remember Me & Forgot Password -->
                <div class="form-options">
                    <label class="remember-me">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            id="remember"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <span>Ingat Saya</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            Lupa Password?
                        </a>
                    @endif
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn-submit" id="submitBtn">
                    <span class="btn-text">MASUK</span>
                    <span class="btn-loading">
                        <span class="spinner"></span>
                        <span>Memproses...</span>
                    </span>
                </button>
            </form>
        </div>
    </div>

    <script>
        (function() {
            'use strict';

            // Toggle Password Visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    // Change icon
                    this.textContent = type === 'password' ? '👁️' : '🙈';
                    
                    // Update aria-label
                    this.setAttribute('aria-label', type === 'password' ? 'Tampilkan password' : 'Sembunyikan password');
                });
            }

            // Form Submission Handler
            const loginForm = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');
            let isSubmitting = false;

            if (loginForm && submitBtn) {
                loginForm.addEventListener('submit', function(e) {
                    // Prevent double submission
                    if (isSubmitting) {
                        e.preventDefault();
                        return false;
                    }

                    // Basic validation
                    const emailInput = document.getElementById('email');
                    const passwordInput = document.getElementById('password');

                    if (!emailInput.value.trim() || !passwordInput.value.trim()) {
                        e.preventDefault();
                        alert('Email dan password harus diisi!');
                        return false;
                    }

                    // Show loading state
                    isSubmitting = true;
                    submitBtn.classList.add('loading');
                    submitBtn.disabled = true;
                });
            }

            // Reset loading state on page show (back button)
            window.addEventListener('pageshow', function(event) {
                if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                    if (submitBtn) {
                        submitBtn.classList.remove('loading');
                        submitBtn.disabled = false;
                        isSubmitting = false;
                    }
                }
            });

            // Auto-dismiss alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 300);
                }, 5000);
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Alt+L to focus email
                if (e.altKey && e.key === 'l') {
                    e.preventDefault();
                    document.getElementById('email').focus();
                }
                
                // Alt+P to focus password
                if (e.altKey && e.key === 'p') {
                    e.preventDefault();
                    document.getElementById('password').focus();
                }
            });

            // Clear validation errors on input
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    this.classList.remove('is-invalid');
                    const feedback = this.parentElement.querySelector('.invalid-feedback');
                    if (feedback) {
                        feedback.style.display = 'none';
                    }
                });
            });

        })();
    </script>
</body>
</html>