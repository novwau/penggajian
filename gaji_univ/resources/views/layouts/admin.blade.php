    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=crimson-text:400,600,700|lato:300,400,600,700" rel="stylesheet" />

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
                --gray-50: #F9FAFB;
                --gray-100: #F3F4F6;
                --gray-200: #E5E7EB;
                --gray-300: #D1D5DB;
                --gray-600: #4B5563;
                --gray-700: #374151;
                --gray-800: #1F2937;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Lato', sans-serif;
                background: var(--gray-50);
                color: var(--charcoal);
            }

            .heading-font {
                font-family: 'Crimson Text', serif;
            }

            /* Layout Structure */
            .admin-layout {
                display: flex;
                min-height: 100vh;
            }

            /* Sidebar */
            .sidebar {
                width: 260px;
                background: var(--maroon);
                color: white;
                position: fixed;
                height: 100vh;
                overflow-y: auto;
                z-index: 40;
                transition: transform 0.3s ease;
            }

            .sidebar-header {
                padding: 1.75rem 1.5rem;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .sidebar-title {
                font-size: 1.25rem;
                font-weight: 700;
                letter-spacing: 0.3px;
                margin-bottom: 0.25rem;
            }

            .sidebar-subtitle {
                font-size: 0.75rem;
                opacity: 0.8;
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            .sidebar-nav {
                padding: 1.5rem 0;
            }

            .nav-section {
                margin-bottom: 1.5rem;
            }

            .nav-section-title {
                padding: 0 1.5rem;
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 1.5px;
                opacity: 0.6;
                margin-bottom: 0.75rem;
                font-weight: 600;
            }

            .nav-link {
                display: flex;
                align-items: center;
                gap: 0.875rem;
                padding: 0.75rem 1.5rem;
                color: white;
                text-decoration: none;
                transition: all 0.2s ease;
                font-size: 0.9rem;
                font-weight: 500;
                border-left: 3px solid transparent;
            }

            .nav-link:hover {
                background: rgba(255, 255, 255, 0.1);
                border-left-color: var(--gold);
            }

            .nav-link.active {
                background: rgba(255, 255, 255, 0.15);
                border-left-color: var(--gold);
            }

            .nav-icon {
                width: 20px;
                height: 20px;
                opacity: 0.9;
            }

            /* Main Content */
            .main-content {
                margin-left: 260px;
                flex: 1;
                display: flex;
                flex-direction: column;
            }

            /* Top Navigation */
            .top-nav {
                background: white;
                border-bottom: 1px solid var(--gray-200);
                padding: 0 2rem;
                height: 70px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                position: sticky;
                top: 0;
                z-index: 30;
            }

            .page-title {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--charcoal);
            }

            .top-nav-right {
                display: flex;
                align-items: center;
                gap: 1.5rem;
            }

            .user-menu {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                cursor: pointer;
                padding: 0.5rem 1rem;
                border-radius: 8px;
                transition: background 0.2s ease;
            }

            .user-menu:hover {
                background: var(--gray-100);
            }

            .user-avatar {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background: var(--maroon);
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
                font-size: 0.875rem;
            }

            .user-info {
                text-align: right;
            }

            .user-name {
                font-weight: 600;
                font-size: 0.875rem;
                color: var(--charcoal);
            }

            .user-role {
                font-size: 0.75rem;
                color: var(--gray-600);
            }

            /* Content Area */
            .content-area {
                padding: 2rem;
                flex: 1;
            }

            /* Cards */
            .card {
                background: white;
                border-radius: 8px;
                padding: 1.5rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                margin-bottom: 1.5rem;
            }

            .card-header {
                margin-bottom: 1.5rem;
                padding-bottom: 1rem;
                border-bottom: 2px solid var(--gray-100);
            }

            .card-title {
                font-size: 1.25rem;
                font-weight: 700;
                color: var(--charcoal);
            }

            .table-spacious th,
            .table-spacious td {
                padding: 0.9rem 1.25rem;
            }


            /* Buttons */
            .btn {
                padding: 0.625rem 1.25rem;
                border-radius: 6px;
                font-weight: 600;
                font-size: 0.875rem;
                cursor: pointer;
                transition: all 0.2s ease;
                border: none;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .btn-primary {
                background: var(--maroon);
                color: white;
            }

            .btn-primary:hover {
                background: var(--maroon-dark);
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(139, 21, 56, 0.3);
            }

            .btn-secondary {
                background: var(--gold);
                color: var(--charcoal);
            }

            .btn-secondary:hover {
                background: #C59A64;
            }

            .btn-outline {
                background: transparent;
                border: 2px solid var(--maroon);
                color: var(--maroon);
            }

            .btn-outline:hover {
                background: var(--maroon);
                color: white;
            }

            /* Mobile Toggle */
            .mobile-toggle {
                display: none;
                padding: 0.5rem;
                background: transparent;
                border: none;
                cursor: pointer;
            }

            .hamburger {
                width: 24px;
                height: 2px;
                background: var(--charcoal);
                position: relative;
            }

            .hamburger::before,
            .hamburger::after {
                content: '';
                position: absolute;
                width: 24px;
                height: 2px;
                background: var(--charcoal);
                left: 0;
            }

            .hamburger::before {
                top: -7px;
            }

            .hamburger::after {
                bottom: -7px;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .sidebar {
                    transform: translateX(-100%);
                }

                .sidebar.active {
                    transform: translateX(0);
                }

                .main-content {
                    margin-left: 0;
                }

                .mobile-toggle {
                    display: block;
                }

                .content-area {
                    padding: 1rem;
                }

                .top-nav {
                    padding: 0 1rem;
                }
            }
        </style>

        @stack('styles')
    </head>
    <body>
        <div class="admin-layout">
            <!-- Sidebar -->
            <aside class="sidebar" id="sidebar">
                <div class="sidebar-header">
                    <h2 class="sidebar-title heading-font">UNTUBEDES Krian</h2>
                    <p class="sidebar-subtitle">Admin Panel</p>
                </div>

                <nav class="sidebar-nav">
                    <!-- Main Menu -->
                    <div class="nav-section">
                        <div class="nav-section-title">Menu Utama</div>
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                    </div>

                    <!-- Data Management -->
                    <div class="nav-section">
                        <div class="nav-section-title">Manajemen Data</div>
                        <a href="{{ route('admin.employees.index') }}" class="nav-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            Kelola Pegawai
                        </a>
                        <a href="{{ route('admin.attendance.index') }}" class="nav-link {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            Verifikasi Presensi
                        </a>
                    </div>

                    <!-- Payroll -->
                    <div class="nav-section">
                        <div class="nav-section-title">Penggajian</div>
                        <a href="{{ route('admin.payroll.periods') }}" class="nav-link {{ request()->routeIs('admin.payroll.periods') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Periode Gaji
                        </a>
                        <a href="{{ route('admin.payroll.index') }}" class="nav-link {{ request()->routeIs('admin.payroll.index') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Generate Gaji
                        </a>
                        <a href="{{ route('admin.payroll.components.index') }}" class="nav-link {{ request()->routeIs('admin.payroll.components.index') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Komponen Gaji
                        </a>
                        <a href="{{ route('admin.payroll.reports') }}" class="nav-link {{ request()->routeIs('admin.payroll.reports') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Laporan Gaji
                        </a>
                        <a href="{{ route('admin.payroll.user-components.index') }}" class="nav-link {{ request()->routeIs('admin.payroll.user-component.index') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Atur Gaji
                        </a>
                    </div>

                    <!-- System -->
                    <div class="nav-section">
                        <div class="nav-section-title">Sistem</div>
                        <a href="{{ route('admin.audit-logs') }}" class="nav-link {{ request()->routeIs('admin.audit-logs') ? 'active' : '' }}">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Audit Log
                        </a>
                    </div>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="main-content">
                <!-- Top Navigation -->
                <header class="top-nav">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <button class="mobile-toggle" onclick="toggleSidebar()">
                            <span class="hamburger"></span>
                        </button>
                        <h1 class="page-title">@yield('title', 'Dashboard')</h1>
                    </div>

                    <div class="top-nav-right">
                        <!-- User Menu -->
                        <div class="user-menu">
                            <div class="user-info">
                                <div class="user-name">{{ Auth::user()->name }}</div>
                                <div class="user-role">Administrator</div>
                            </div>
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </header>

                <!-- Content Area -->
                <div class="content-area">
                    @yield('content')
                </div>
            </main>
        </div>

        <script>
            function toggleSidebar() {
                document.getElementById('sidebar').classList.toggle('active');
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const sidebar = document.getElementById('sidebar');
                const toggle = document.querySelector('.mobile-toggle');
                
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                        sidebar.classList.remove('active');
                    }
                }
            });
        </script>

        @stack('scripts')
    </body>
    </html>