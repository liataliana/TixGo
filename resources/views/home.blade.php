@extends('layouts.app')

@section('content')
<style>
    /* 🍃 THEME COLORS */
    :root {
        --nature-green: #064e3b; /* emerald-900 */
        --nature-green-light: #059669; /* emerald-600 */
        --nature-sand: #fef08a; /* yellow-200 */
        --glass-bg: rgba(255, 255, 255, 0.15);
        --glass-border: rgba(255, 255, 255, 0.2);
    }

    /* Override padding dari layout agar hero bisa full width & full height */
    main.max-w-7xl {
        max-width: 100% !important;
        padding: 0 !important;
    }

    /* CUSTOM NAVBAR TRANSPARENT TO SOLID */
    .nature-navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 50;
        transition: all 0.4s ease;
        padding: 20px 40px;
        background: transparent;
    }
    .nature-navbar.scrolled {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        padding: 15px 40px;
    }
    .nature-navbar .brand {
        font-weight: 800;
        font-size: 24px;
        color: white;
        transition: color 0.4s;
    }
    .nature-navbar.scrolled .brand {
        color: var(--nature-green);
    }
    .nature-navbar .nav-links a {
        color: white;
        font-weight: 600;
        margin-left: 20px;
        transition: color 0.4s;
    }
    .nature-navbar.scrolled .nav-links a {
        color: #374151;
    }
    .nature-navbar.scrolled .nav-links a:hover {
        color: var(--nature-green-light);
    }

    /* Tombol Login/Register */
    .btn-glass {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        backdrop-filter: blur(5px);
        padding: 8px 24px;
        border-radius: 999px;
        color: white !important;
        transition: all 0.3s;
    }
    .btn-glass:hover {
        background: rgba(255,255,255,0.3);
    }
    .nature-navbar.scrolled .btn-glass {
        background: var(--nature-green);
        border-color: var(--nature-green);
    }
    .nature-navbar.scrolled .btn-glass:hover {
        background: var(--nature-green-light);
    }

    /* HERO SECTION */
    .hero-nature {
        height: 100vh;
        width: 100%;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-image: url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=2021&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
    .hero-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(to bottom, rgba(6, 78, 59, 0.4), rgba(0,0,0,0.6));
    }
    .hero-content {
        position: relative;
        z-index: 10;
        text-align: center;
        color: white;
        max-width: 800px;
        padding: 0 20px;
        margin-top: -50px;
    }
    .hero-content h1 {
        font-size: 56px;
        font-weight: 900;
        letter-spacing: -1px;
        line-height: 1.2;
        margin-bottom: 16px;
        text-shadow: 0 4px 20px rgba(0,0,0,0.5);
    }
    .hero-content p {
        font-size: 20px;
        color: rgba(255,255,255,0.9);
        margin-bottom: 40px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.5);
    }

    /* 3D GLASSMORPHISM CARDS */
    .menu-container {
        position: relative;
        z-index: 20;
        margin-top: -100px; /* Pull up into the hero */
        padding: 0 40px;
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
        perspective: 1000px;
    }
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
    }
    
    /* [Magfi Adi Radza Putra] - 3D Tilt Effect CSS */
    .glass-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 24px;
        padding: 32px 20px;
        text-align: center;
        text-decoration: none;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        color: white;
        transform-style: preserve-3d;
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease, background 0.4s ease;
        display: block;
    }
    
    .glass-card:hover {
        transform: translateY(-15px) rotateX(10deg) rotateY(-5deg);
        box-shadow: -10px 20px 40px rgba(0, 0, 0, 0.4);
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.6);
    }

    .card-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, rgba(255,255,255,0.4), rgba(255,255,255,0.1));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 32px;
        color: white;
        box-shadow: inset 0 2px 4px rgba(255,255,255,0.3), 0 4px 10px rgba(0,0,0,0.2);
        transform: translateZ(30px); /* 3D pop out effect */
        transition: transform 0.4s;
    }
    .glass-card:hover .card-icon {
        transform: translateZ(50px) scale(1.1);
    }
    .glass-card h3 {
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 8px;
        transform: translateZ(20px);
    }
    .glass-card p {
        font-size: 13px;
        color: rgba(255,255,255,0.8);
        margin: 0;
        transform: translateZ(10px);
    }

    /* Content Section */
    .explore-section {
        padding: 100px 40px;
        background: #f8fafc;
    }
    .section-title {
        text-align: center;
        font-size: 36px;
        font-weight: 800;
        color: var(--nature-green);
        margin-bottom: 50px;
    }

    @media (max-width: 1024px) {
        .menu-grid { grid-template-columns: repeat(3, 1fr); }
        .menu-container { margin-top: -50px; }
    }
    @media (max-width: 768px) {
        .menu-grid { grid-template-columns: repeat(2, 1fr); gap: 15px; }
        .hero-content h1 { font-size: 40px; }
        .nature-navbar { padding: 15px 20px; }
    }
    @media (max-width: 480px) {
        .menu-grid { grid-template-columns: 1fr; }
    }
</style>

<!-- ALPINE JS UNTUK NAVBAR SCROLL -->
<div x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 50)">
    
    <!-- NAVBAR TRANSPARENT -->
    <nav class="nature-navbar flex justify-between items-center" :class="{ 'scrolled': scrolled }">
        <div class="brand flex items-center gap-2">
            <i class="fa-solid fa-leaf"></i> TixGo
        </div>
        <div class="nav-links flex items-center">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-glass">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-glass">Login</a>
                <a href="{{ route('register') }}" class="ml-4 hover:text-white" :class="scrolled ? 'text-gray-700' : 'text-white'">Register</a>
            @endauth
        </div>
    </nav>

    <!-- HERO SECTION -->
    <div class="hero-nature">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Jelajahi Alam & Dunia</h1>
            <p>Pesan tiket perjalanan dan penginapan eksklusifmu bersama TixGo. Rasakan pengalaman premium yang menyatu dengan alam.</p>
        </div>
    </div>

    <!-- 5 CARD KATEGORI DENGAN EFEK 3D TILT -->
    <div class="menu-container">
        <div class="menu-grid">
            
            <!-- 1. Penerbangan -->
            <a href="{{ route('flights.index') }}" class="glass-card">
                <div class="card-icon">
                    <i class="fa-solid fa-plane-departure"></i>
                </div>
                <h3>Penerbangan</h3>
                <p>Jelajahi langit dunia</p>
            </a>

            <!-- 2. Hotel -->
            <a href="{{ route('hotels.index') }}" class="glass-card">
                <div class="card-icon">
                    <i class="fa-solid fa-hotel"></i>
                </div>
                <h3>Hotel</h3>
                <p>Istirahat di tempat terbaik</p>
            </a>

            <!-- 3. Villa -->
            <a href="{{ route('villas.index') }}" class="glass-card">
                <div class="card-icon">
                    <i class="fa-solid fa-house-tree"></i>
                </div>
                <h3>Villa</h3>
                <p>Privasi & harmoni alam</p>
            </a>

            <!-- 4. Kereta -->
            <a href="{{ route('trains.index') }}" class="glass-card">
                <div class="card-icon">
                    <i class="fa-solid fa-train"></i>
                </div>
                <h3>Kereta Api</h3>
                <p>Menikmati setiap jalur</p>
            </a>

            <!-- 5. Bus & Travel -->
            <a href="{{ route('buses.index') }}" class="glass-card">
                <div class="card-icon">
                    <i class="fa-solid fa-bus-simple"></i>
                </div>
                <h3>Bus & Travel</h3>
                <p>Perjalanan darat yang nyaman</p>
            </a>

        </div>
    </div>

    <!-- PROMO SECTION -->
    <div class="explore-section">
        <h2 class="section-title">Kenapa Memilih TixGo?</h2>
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-3xl shadow-lg border border-emerald-50 text-center hover:shadow-xl transition-shadow">
                <i class="fa-solid fa-leaf text-5xl text-emerald-500 mb-6"></i>
                <h4 class="text-xl font-bold text-gray-800 mb-3">Eco-Friendly Premium</h4>
                <p class="text-gray-500">Berkontribusi untuk kelestarian alam pada setiap pemesanan tiket perjalanan.</p>
            </div>
            <div class="bg-white p-8 rounded-3xl shadow-lg border border-emerald-50 text-center hover:shadow-xl transition-shadow">
                <i class="fa-solid fa-shield-halved text-5xl text-blue-500 mb-6"></i>
                <h4 class="text-xl font-bold text-gray-800 mb-3">Transaksi Aman</h4>
                <p class="text-gray-500">Sistem pembayaran cerdas yang terenkripsi penuh menjamin keamanan datamu.</p>
            </div>
            <div class="bg-white p-8 rounded-3xl shadow-lg border border-emerald-50 text-center hover:shadow-xl transition-shadow">
                <i class="fa-solid fa-headset text-5xl text-orange-500 mb-6"></i>
                <h4 class="text-xl font-bold text-gray-800 mb-3">Support 24/7</h4>
                <p class="text-gray-500">Tim kami siap memandu liburan eksklusifmu kapanpun dan dimanapun.</p>
            </div>
        </div>
    </div>

</div>
@endsection