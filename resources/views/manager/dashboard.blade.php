@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #0099ff;
        --primary-dark: #0077cc;
        --primary-light: #66ccff;
        --card-bg: rgba(255, 255, 255, 0.85);
        --card-border: rgba(255, 255, 255, 0.3);
        --text-dark: #0b1a33;
        --text-muted: #5a7a9a;
        --shadow-glow: 0 8px 32px rgba(0, 153, 255, 0.12);
    }

    .manager-wrapper {
        font-family: 'Poppins', 'Inter', -apple-system, sans-serif;
        background: linear-gradient(145deg, #dbeafe 0%, #eff6ff 50%, #f0f9ff 100%);
        min-height: 100vh;
        padding: 2rem 2rem;
        position: relative;
        overflow: hidden;
    }

    .manager-wrapper .orb {
        position: fixed;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.2;
        pointer-events: none;
        z-index: 0;
        animation: float-orb 20s ease-in-out infinite alternate;
    }
    .manager-wrapper .orb-1 {
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, #66ccff, transparent);
        top: -80px;
        right: -80px;
        animation-delay: 0s;
    }
    .manager-wrapper .orb-2 {
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, #0099ff, transparent);
        bottom: -50px;
        left: -50px;
        animation-delay: -7s;
    }

    @keyframes float-orb {
        0% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(30px, -30px) scale(1.1); }
        100% { transform: translate(-20px, 20px) scale(0.9); }
    }

    .glass-card {
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--card-border);
        border-radius: 24px;
        box-shadow: var(--shadow-glow);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .header-manager {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
        position: relative;
        z-index: 1;
    }
    .header-manager .title-group {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .header-manager .title-group .icon-box {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(0,153,255,0.12), rgba(102,204,255,0.06));
        border: 1px solid rgba(0,153,255,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #0099ff;
        flex-shrink: 0;
    }
    .header-manager .title-group h1 {
        font-size: 2rem;
        font-weight: 900;
        letter-spacing: -0.03em;
        background: linear-gradient(135deg, #0b1a33 0%, #0099ff 50%, #66ccff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
    }
    .header-manager .title-group .sub {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
        -webkit-text-fill-color: var(--text-muted);
        margin-top: 2px;
    }
    .status-badge {
        background: rgba(255,255,255,0.6);
        backdrop-filter: blur(8px);
        padding: 0.5rem 1.5rem;
        border-radius: 100px;
        border: 1px solid rgba(0,153,255,0.12);
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .status-badge .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #10b981;
        position: relative;
    }
    .status-badge .dot::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        background: rgba(16, 185, 129, 0.3);
        animation: pulse-dot 2s ease-in-out infinite;
    }
    @keyframes pulse-dot {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.8); opacity: 0; }
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
        position: relative;
        z-index: 1;
    }
    .stat-card {
        background: var(--card-bg);
        backdrop-filter: blur(16px);
        border: 1px solid var(--card-border);
        border-radius: 20px;
        padding: 1.75rem 1.5rem;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(0, 153, 255, 0.06);
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #0099ff, #66ccff, #0099ff);
        background-size: 200% 100%;
        opacity: 0;
        transition: opacity 0.5s ease;
        animation: shimmer-border 3s linear infinite;
    }
    .stat-card:hover::before {
        opacity: 1;
    }
    @keyframes shimmer-border {
        0% { background-position: 0% 0%; }
        100% { background-position: 200% 0%; }
    }
    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 60px rgba(0, 153, 255, 0.18);
        border-color: rgba(0, 153, 255, 0.2);
    }
    .stat-card .stat-label {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--text-muted);
    }
    .stat-card .stat-value {
        font-size: 2.5rem;
        font-weight: 900;
        color: var(--text-dark);
        margin-top: 4px;
        letter-spacing: -0.02em;
    }
    .stat-card .stat-value .highlight {
        color: #0099ff;
    }
    .stat-card .stat-icon {
        float: right;
        font-size: 2rem;
        color: rgba(0,153,255,0.12);
    }
    .stat-card .stat-sub {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-muted);
        margin-top: 6px;
    }
    .stat-card .stat-sub .up {
        color: #10b981;
        font-weight: 800;
    }
    .stat-card .stat-sub .warning {
        color: #f59e0b;
        font-weight: 800;
    }

    @media (max-width: 768px) {
        .manager-wrapper {
            padding: 1rem 1rem;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .header-manager .title-group h1 {
            font-size: 1.5rem;
        }
        .header-manager .title-group .icon-box {
            width: 40px;
            height: 40px;
            font-size: 18px;
        }
        .stat-card .stat-value {
            font-size: 2rem;
        }
    }
</style>

<div class="manager-wrapper max-w-7xl mx-auto">

    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <!-- HEADER -->
    <div class="header-manager">
        <div class="title-group">
            <div class="icon-box">
                <i class="fa-regular fa-chart-pie"></i>
            </div>
            <div>
                <h1>Dashboard Manager</h1>
                <div class="sub">
                    <i class="fa-regular fa-bolt" style="color: #0099ff; font-size: 0.7rem;"></i>
                    Pantau aktivitas sistem dengan gaya kekinian
                </div>
            </div>
        </div>
        <div class="status-badge">
            <span class="dot"></span>
            <span>Sistem <strong style="color: #0099ff;">Online</strong></span>
            <span style="font-size: 0.7rem; opacity: 0.6;">| LIVE</span>
        </div>
    </div>

    <!-- STATS -->
    <div class="stats-grid">
        <!-- Card 1: Total Penerbangan -->
        <div class="stat-card">
            <span class="stat-icon"><i class="fa-regular fa-plane"></i></span>
            <div class="stat-label">Total Penerbangan</div>
            <div class="stat-value">{{ $flightsCount ?? 0 }}</div>
            <div class="stat-sub"><span class="up">↑ 12%</span> dari bulan lalu</div>
        </div>

        <!-- Card 2: Menunggu Konfirmasi -->
        <div class="stat-card">
            <span class="stat-icon"><i class="fa-regular fa-clock"></i></span>
            <div class="stat-label">Menunggu Konfirmasi</div>
            <div class="stat-value">{{ $pendingCount ?? 0 }}</div>
            <div class="stat-sub"><span class="warning">⚠️ Perlu Tindakan</span></div>
        </div>

        <!-- Card 3: User Terdaftar -->
        <div class="stat-card">
            <span class="stat-icon"><i class="fa-regular fa-users"></i></span>
            <div class="stat-label">User Terdaftar</div>
            <div class="stat-value">{{ $usersCount ?? 0 }}</div>
            <div class="stat-sub">Total member</div>
        </div>
    </div>

</div>
@endsection