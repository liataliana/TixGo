{{-- [Magfi Adi Radza Putra] - Layout Utama User TixGo --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TixGo - @yield('title', 'E-Ticketing System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        :root {
            --primary: #059669;
            --primary-dark: #047857;
            --sky: #0ea5e9;
            --gold: #d97706;
        }

        /* === NAVBAR === */
        .tixgo-nav {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #064e3b 100%);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .tixgo-nav .nav-logo {
            background: linear-gradient(135deg, #34d399, #0ea5e9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 900;
            font-size: 1.5rem;
            letter-spacing: -0.04em;
        }
        .tixgo-nav .nav-link {
            color: rgba(255,255,255,0.7);
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.4rem 0.9rem;
            border-radius: 8px;
            transition: all 0.2s;
            text-decoration: none;
        }
        .tixgo-nav .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .tixgo-nav .nav-link.active {
            background: rgba(52, 211, 153, 0.15);
            color: #34d399;
        }
        .tixgo-nav .btn-logout {
            background: rgba(239,68,68,0.1);
            color: #f87171;
            border: 1px solid rgba(239,68,68,0.2);
            padding: 0.35rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .tixgo-nav .btn-logout:hover {
            background: rgba(239,68,68,0.2);
            color: #fca5a5;
        }

        /* === MAIN === */
        body { background: #f0fdf4; }
        .page-bg {
            min-height: 100vh;
            background: linear-gradient(160deg, #ecfdf5 0%, #f0f9ff 40%, #fdf4ff 100%);
        }

        /* === GLASS CARD === */
        .glass {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.5);
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(5,150,105,0.07);
        }

        /* === ALERT === */
        .alert-success { background: #ecfdf5; border: 1px solid #6ee7b7; color: #065f46; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1rem; }
        .alert-error { background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1rem; }
    </style>
    @stack('styles')
</head>
<body>

{{-- ===================== NAVBAR ===================== --}}
<nav class="tixgo-nav">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="nav-logo flex items-center gap-2">
                <i class="fa-solid fa-plane-departure text-emerald-400" style="-webkit-text-fill-color: #34d399;"></i>
                TixGo
            </a>

            {{-- MENU LINKS --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="fa-regular fa-house mr-1"></i> Home
                </a>
                <a href="{{ route('flights.index') }}" class="nav-link {{ request()->routeIs('flights.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-plane mr-1"></i> Penerbangan
                </a>
                @auth
                    <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                        <i class="fa-regular fa-user mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('user.orders') }}" class="nav-link {{ request()->routeIs('user.orders') ? 'active' : '' }}">
                        <i class="fa-regular fa-receipt mr-1"></i> Pesanan Saya
                    </a>
                @endauth
            </div>

            {{-- AUTH SECTION --}}
            <div class="flex items-center gap-3">
                @auth
                    <span class="text-white/60 text-xs hidden md:block">
                        👋 <span class="font-semibold text-white">{{ auth()->user()->name }}</span>
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="fa-solid fa-right-from-bracket mr-1"></i> Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <a href="{{ route('register') }}" class="nav-link" style="background:rgba(52,211,153,0.15); color:#34d399;">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- ===================== CONTENT ===================== --}}
<div class="page-bg">
    <div class="max-w-7xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="alert-success"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error"><i class="fa-solid fa-circle-exclamation mr-2"></i>{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

{{-- ===================== FOOTER ===================== --}}
<footer style="background: linear-gradient(135deg, #0f172a, #064e3b); color: rgba(255,255,255,0.5); text-align: center; padding: 1.5rem; font-size: 0.8rem;">
    © 2026 TixGo E-Ticketing System &mdash; Magfi Adi Radza Putra &mdash; All Rights Reserved
</footer>

@stack('scripts')
</body>
</html>
