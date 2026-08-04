@extends('layouts.app')

@section('content')
<style>
    .hero-home {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
        border-radius: 16px;
        padding: 40px 48px;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(30, 58, 95, 0.25);
    }
    .hero-home h1 {
        font-size: 32px;
        font-weight: 900;
        color: white;
        margin: 0;
    }
    .hero-home p {
        color: rgba(255,255,255,0.8);
        font-size: 14px;
        margin-top: 4px;
    }
    .hero-bg-text {
        position: absolute;
        right: 20px;
        top: -10px;
        font-size: 100px;
        font-weight: 900;
        color: rgba(255,255,255,0.08);
        letter-spacing: -5px;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
        margin-bottom: 32px;
    }
    .menu-card {
        background: white;
        border-radius: 16px;
        padding: 24px 16px;
        text-align: center;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: all 0.2s;
        text-decoration: none;
        display: block;
    }
    .menu-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        transform: translateY(-3px);
    }
    .menu-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 24px;
    }
    .menu-card h3 {
        font-weight: 700;
        font-size: 16px;
        color: #1e293b;
        margin: 0 0 2px;
    }
    .menu-card p {
        font-size: 12px;
        color: #94a3b8;
        margin: 0;
    }

    .promo-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }
    .promo-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .promo-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }
    .promo-card h4 {
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 2px;
        font-size: 15px;
    }
    .promo-card p {
        font-size: 13px;
        color: #64748b;
        margin: 0 0 6px;
    }
    .promo-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 2px 10px;
        border-radius: 20px;
        display: inline-block;
    }

    @media (max-width: 768px) {
        .menu-grid { grid-template-columns: repeat(3, 1fr); }
        .promo-grid { grid-template-columns: 1fr; }
        .hero-home { padding: 24px; }
        .hero-home h1 { font-size: 24px; }
    }
    @media (max-width: 480px) {
        .menu-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>

<div class="max-w-6xl mx-auto px-4 py-4">

    {{-- HERO --}}
    <div class="hero-home">
        <h1>✈️ Cari Tiket & Liburan</h1>
        <p>Temukan penerbangan, hotel, villa, kereta, dan bus terbaik</p>
        <div class="hero-bg-text">TIX</div>
    </div>

    {{-- MENU KATEGORI --}}
    <div class="menu-grid">
        <a href="{{ route('flights.index') }}" class="menu-card">
            <div class="menu-icon" style="background:#1e3a5f15;color:#1e3a5f;">
                <i class="fa-solid fa-plane"></i>
            </div>
            <h3>Penerbangan</h3>
            <p>Cari tiket pesawat</p>
        </a>

        <a href="{{ route('hotels.index') }}" class="menu-card">
            <div class="menu-icon" style="background:#3b82f615;color:#3b82f6;">
                <i class="fa-solid fa-hotel"></i>
            </div>
            <h3>Hotel</h3>
            <p>Cari penginapan</p>
        </a>

        <a href="{{ route('villas.index') }}" class="menu-card">
            <div class="menu-icon" style="background:#22c55e15;color:#22c55e;">
                <i class="fa-solid fa-house-chimney"></i>
            </div>
            <h3>Villa</h3>
            <p>Sewa villa & apartemen</p>
        </a>

        <a href="{{ route('trains.index') }}" class="menu-card">
            <div class="menu-icon" style="background:#a855f715;color:#a855f7;">
                <i class="fa-solid fa-train"></i>
            </div>
            <h3>Kereta</h3>
            <p>Cari tiket kereta</p>
        </a>

        <a href="{{ route('buses.index') }}" class="menu-card">
            <div class="menu-icon" style="background:#f9731615;color:#f97316;">
                <i class="fa-solid fa-bus"></i>
            </div>
            <h3>Bus & Travel</h3>
            <p>Cari tiket bus</p>
        </a>
    </div>

    {{-- PROMO --}}
    <div class="promo-grid">
        <div class="promo-card">
            <div class="promo-icon" style="background:#1e3a5f;color:white;">🎉</div>
            <div>
                <h4>Diskon 20%</h4>
                <p>Pemesanan pertama</p>
                <span class="promo-badge" style="background:#1e3a5f15;color:#1e3a5f;">TIXGO20</span>
            </div>
        </div>
        <div class="promo-card">
            <div class="promo-icon" style="background:#22c55e;color:white;">🏆</div>
            <div>
                <h4>Cashback 10%</h4>
                <p>Untuk member TixGo</p>
                <span class="promo-badge" style="background:#22c55e20;color:#16a34a;">Auto apply</span>
            </div>
        </div>
        <div class="promo-card">
            <div class="promo-icon" style="background:#a855f7;color:white;">✈️</div>
            <div>
                <h4>Partner Resmi</h4>
                <p>Garuda, Lion, Citilink</p>
                <span class="promo-badge" style="background:#a855f720;color:#7e22ce;">Trusted</span>
            </div>
        </div>
    </div>
</div>
@endsection