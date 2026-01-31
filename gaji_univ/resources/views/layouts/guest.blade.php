<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=crimson-text:400,600,700|lato:300,400,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --maroon: #8B1538;
            --maroon-dark: #6B1028;
            --maroon-light: #A52A4A;
            --gold: #D4A574;
            --gold-light: #E8C9A0;
            --cream: #FAF8F5;
            --charcoal: #2C2C2C;
        }

        body {
            font-family: 'Lato', sans-serif;
            background: linear-gradient(135deg, var(--cream) 0%, #F5F1EB 100%);
        }

        .heading-font {
            font-family: 'Crimson Text', serif;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .auth-card {
            background: white;
            border-radius: 0;
            box-shadow: 0 8px 32px rgba(139, 21, 56, 0.12);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            position: relative;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--maroon) 0%, var(--gold) 100%);
        }

        .auth-side {
            padding: 3rem;
        }

        .auth-brand {
            background: var(--maroon);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem 3rem;
            position: relative;
            overflow: hidden;
        }

        .auth-brand::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: var(--gold);
            opacity: 0.1;
            border-radius: 50%;
        }

        .auth-brand::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -15%;
            width: 250px;
            height: 250px;
            background: var(--maroon-dark);
            opacity: 0.3;
            border-radius: 50%;
        }

        .brand-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .university-name {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
            letter-spacing: 0.5px;
        }

        .university-subtitle {
            font-size: 0.95rem;
            opacity: 0.9;
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 2.5rem;
        }

        .decorative-line {
            width: 60px;
            height: 3px;
            background: var(--gold);
            margin: 0 auto 2rem;
        }

        .system-description {
            font-size: 1rem;
            line-height: 1.6;
            opacity: 0.85;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--charcoal);
            margin-bottom: 0.5rem;
            letter-spacing: 0.3px;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #E5E5E5;
            background: white;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--maroon);
            box-shadow: 0 0 0 3px rgba(139, 21, 56, 0.1);
        }

        .btn-primary {
            width: 100%;
            padding: 0.875rem 1.5rem;
            background: var(--maroon);
            color: white;
            border: none;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .btn-primary:hover {
            background: var(--maroon-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(139, 21, 56, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .link-text {
            color: var(--maroon);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .link-text:hover {
            color: var(--maroon-dark);
            text-decoration: underline;
        }

        .error-message {
            color: #DC2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .checkbox-input {
            width: 1rem;
            height: 1rem;
            accent-color: var(--maroon);
        }

        @media (max-width: 768px) {
            .auth-card {
                grid-template-columns: 1fr;
            }

            .auth-brand {
                padding: 2.5rem 2rem;
            }

            .university-name {
                font-size: 1.5rem;
            }

            .auth-side {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        {{ $slot }}
    </div>
</body>
</html>