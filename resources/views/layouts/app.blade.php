<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ===== RESET & BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Figtree', sans-serif;
            background: #f4f7fc;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }

        /* ===== VARIABEL WARNA ===== */
        :root {
            --primary: #1e3a5f;
            --primary-light: #2d5a87;
            --primary-dark: #0f2440;
            --accent: #3b82f6;
            --accent-light: #60a5fa;
            --white: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
            --radius: 12px;
            --radius-sm: 8px;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            background: var(--white);
            border-right: 1px solid var(--gray-200);
            box-shadow: var(--shadow-xl);
            width: 280px;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 50;
            overflow-y: auto;
        }
        .sidebar-header {
            background: var(--primary);
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            flex-shrink: 0;
        }
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: white;
            font-weight: 800;
            font-size: 1.25rem;
            letter-spacing: -0.025em;
        }
        .sidebar-brand i {
            font-size: 1.5rem;
        }
        .sidebar-toggle {
            color: rgba(255,255,255,0.7);
            background: transparent;
            border: none;
            padding: 0.5rem;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: 0.2s;
        }
        .sidebar-toggle:hover {
            background: rgba(255,255,255,0.15);
            color: white;
        }
        .sidebar-nav {
            padding: 1.25rem 0.75rem;
            flex: 1;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.75rem 1rem;
            border-radius: var(--radius-sm);
            font-weight: 600;
            color: var(--gray-600);
            transition: all 0.15s ease;
            text-decoration: none;
            margin-bottom: 0.25rem;
            font-size: 0.95rem;
        }
        .sidebar-link i {
            width: 1.25rem;
            text-align: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        .sidebar-link:hover {
            background: var(--gray-100);
            color: var(--primary);
        }
        .sidebar-link.active {
            background: var(--primary);
            color: white;
            box-shadow: var(--shadow-md);
        }
        .sidebar-link.active i {
            color: white;
        }
        .sidebar-link.logout {
            color: #ef4444;
        }
        .sidebar-link.logout:hover {
            background: #fef2f2;
            color: #dc2626;
        }
        .sidebar-divider {
            border-top: 1px solid var(--gray-200);
            margin: 1rem 0.75rem;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--gray-50);
        }
        .main-content.sidebar-open {
            margin-left: 280px;
        }

        /* ===== TOP NAVBAR ===== */
        .top-nav {
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            padding: 0 1.5rem;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
            box-shadow: var(--shadow-sm);
            flex-shrink: 0;
        }
        .top-nav-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .top-nav-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--gray-600);
            font-size: 1.25rem;
            padding: 0.5rem;
            border-radius: var(--radius-sm);
            cursor: pointer;
        }
        .top-nav-toggle:hover {
            background: var(--gray-100);
            color: var(--primary);
        }
        .top-nav-title {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.1rem;
            letter-spacing: -0.01em;
        }
        .top-nav-right {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }
        .top-nav-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .top-nav-user-name {
            font-weight: 600;
            color: var(--gray-700);
            font-size: 0.9rem;
        }
        .top-nav-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        /* ===== PAGE CONTENT ===== */
        .page-content {
            padding: 1.5rem;
            flex: 1;
        }

        /* ===== OVERLAY ===== */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.3);
            z-index: 40;
            transition: opacity 0.3s;
            display: none;
        }
        .sidebar-overlay.active {
            display: block;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .main-content.sidebar-open {
                margin-left: 0;
            }
            .top-nav-toggle {
                display: block;
            }
            .sidebar-overlay.active {
                display: block;
            }
        }
        @media (max-width: 640px) {
            .top-nav-user-name {
                display: none;
            }
            .top-nav-title {
                font-size: 0.95rem;
            }
            .page-content {
                padding: 1rem;
            }
        }

        /* ===== UTILITY ===== */
        .bg-primary { background-color: var(--primary); }
        .text-primary { color: var(--primary); }
        .btn-primary {
            background-color: var(--primary);
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: var(--radius-sm);
            font-weight: 700;
            border: none;
            transition: 0.2s;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-primary:hover {
            background-color: var(--primary-dark);
            box-shadow: var(--shadow-md);
        }
        .btn-primary-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
            padding: 0.6rem 1.5rem;
            border-radius: var(--radius-sm);
            font-weight: 700;
            transition: 0.2s;
            cursor: pointer;
        }
        .btn-primary-outline:hover {
            background: var(--primary);
            color: white;
        }
        .card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            border: 1px solid var(--gray-200);
            transition: box-shadow 0.2s;
        }
        .card:hover {
            box-shadow: var(--shadow-md);
        }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: var(--gray-100);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }

        .tab-btn {
    background: transparent;
    color: #64748b;
}
.tab-btn.active {
    background: #1e3a5f;
    color: white;
}
.tab-btn:hover:not(.active) {
    background: #f1f5f9;
}

/* ===== TAB STYLE ===== */
.tab-btn {
    background: transparent;
    color: #64748b;
    border: none;
    cursor: pointer;
}
.tab-btn.active {
    background: #1e3a5f;
    color: white;
    box-shadow: 0 4px 12px rgba(30, 58, 95, 0.25);
}
.tab-btn:hover:not(.active) {
    background: #f1f5f9;
}
.tab-content {
    animation: fadeIn 0.3s ease;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}

/* TAB BUTTON */
.tab-btn {
    background: transparent;
    color: #64748b;
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
}
.tab-btn:hover:not(.active) {
    background: #f1f5f9;
}
.tab-btn.active {
    background: #1e3a5f;
    color: white;
    box-shadow: 0 4px 12px rgba(30, 58, 95, 0.25);
}
.tab-content {
    animation: fadeIn 0.25s ease;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(6px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ===== DROPZONE ===== */
#dropzone {
    transition: all 0.2s;
}
#dropzone:hover {
    border-color: #1e3a5f;
    background: rgba(30, 58, 95, 0.05);
}

    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

@if(auth()->check() && (auth()->user()->role == 'super_admin' || auth()->user()->role == 'manager'))
    <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }"
         x-init="window.addEventListener('resize', () => { if (window.innerWidth >= 1024) sidebarOpen = true; else sidebarOpen = false; })"
         class="relative min-h-screen">

        <!-- SIDEBAR -->
        <aside class="sidebar" :class="{ 'open': sidebarOpen }">
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <i class="fa-solid fa-ticket" style="transform: rotate(12deg);"></i>
                    <span>TixGo</span>
                </div>
                <button @click="sidebarOpen = !sidebarOpen" class="sidebar-toggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            <nav class="sidebar-nav">
                @if(auth()->user()->role == 'super_admin')
                    {{-- SIDEBAR SUPER ADMIN --}}
                    <a href="{{ route('superadmin.dashboard') }}" class="sidebar-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-pie"></i> Dashboard
                    </a>
                    <a href="{{ route('superadmin.users.index') }}" class="sidebar-link {{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i> Kelola Users
                    </a>
                    <a href="{{ route('superadmin.flights.index') }}" class="sidebar-link {{ request()->routeIs('superadmin.flights.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-plane"></i> Penerbangan
                    </a>
                    <a href="{{ route('superadmin.payments.index') }}" class="sidebar-link {{ request()->routeIs('superadmin.payments.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-credit-card"></i> Pembayaran
                    </a>
                    <a href="{{ route('superadmin.tickets.index') }}" class="sidebar-link {{ request()->routeIs('superadmin.tickets.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-ticket"></i> Kelola Tiket
                    </a>
                    <a href="{{ route('superadmin.reports.index') }}" class="sidebar-link {{ request()->routeIs('superadmin.reports.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-bar"></i> Laporan
                    </a>
                @elseif(auth()->user()->role == 'manager')
                    {{-- SIDEBAR MANAGER --}}
                    <a href="{{ route('manager.dashboard') }}" class="sidebar-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-pie"></i> Dashboard
                    </a>
                    <a href="{{ route('manager.flights.index') }}" class="sidebar-link {{ request()->routeIs('manager.flights.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-plane"></i> Kelola Jadwal
                    </a>
                    <a href="{{ route('manager.payments.index') }}" class="sidebar-link {{ request()->routeIs('manager.payments.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-credit-card"></i> Konfirmasi Pembayaran
                    </a>
                    <a href="{{ route('manager.users.index') }}" class="sidebar-link {{ request()->routeIs('manager.users.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i> Daftar User
                    </a>
                    <a href="{{ route('manager.tickets.index') }}" class="sidebar-link {{ request()->routeIs('manager.tickets.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-ticket"></i> Kelola Tiket
                    </a>
                @endif

                <div class="sidebar-divider"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link logout w-full text-left">
                        <i class="fa-solid fa-right-from-bracket"></i> Log Out
                    </button>
                </form>
            </nav>
        </aside>

        <!-- OVERLAY -->
        <div class="sidebar-overlay" :class="{ 'active': sidebarOpen && window.innerWidth < 1024 }" @click="sidebarOpen = false"></div>

        <!-- MAIN CONTENT -->
        <main class="main-content" :class="{ 'sidebar-open': sidebarOpen }">
            <!-- TOP NAVBAR -->
            <header class="top-nav">
                <div class="top-nav-left">
                    <button @click="sidebarOpen = !sidebarOpen" class="top-nav-toggle">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <span class="top-nav-title">
                        {{ auth()->user()->role == 'super_admin' ? '👑 Super Admin Panel' : '📊 Manager Panel' }}
                    </span>
                </div>

                <div class="top-nav-right">
                    <div class="top-nav-user">
                        <span class="top-nav-user-name">{{ auth()->user()->name }}</span>
                        <div class="top-nav-avatar">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- PAGE CONTENT -->
            <div class="page-content">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl text-sm font-semibold">
                        <i class="fa-solid fa-check-circle mr-1"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded-xl text-sm font-semibold">
                        <i class="fa-solid fa-exclamation-circle mr-1"></i> {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </div>

            <!-- FOOTER -->
            <footer class="text-center py-4 text-xs text-gray-400 border-t border-gray-200 bg-white">
                © 2026 TixGo E-Ticketing System — By <strong>Magfi Adi Radza Putra</strong>. All rights reserved.
            </footer>
        </main>
    </div>

@else
    <!-- LAYOUT UNTUK USER BIASA & GUEST (tanpa sidebar) -->
    <div class="min-h-screen bg-gray-50 flex flex-col">
        @auth
            @include('layouts.navigation')
        @endauth
        <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 w-full">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl text-sm font-semibold">
                    <i class="fa-solid fa-check-circle mr-1"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded-xl text-sm font-semibold">
                    <i class="fa-solid fa-exclamation-circle mr-1"></i> {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </main>
        <footer class="text-center py-4 text-xs text-gray-400 border-t border-gray-200 bg-white">
            © 2026 TixGo E-Ticketing System — By <strong>Magfi Adi Radza Putra</strong>. All rights reserved.
        </footer>
    </div>
@endif

@stack('modals')
</body>
</html>