@extends('layouts.app')

@section('content')
<style>
    /* ============================================================
       ROOT VARIABLES - SKY BLUE THEME (SAMA KAYAK MANAGER)
       ============================================================ */
    :root {
        --primary: #0099ff;
        --primary-dark: #0077cc;
        --primary-light: #66ccff;
        --primary-glow: rgba(0, 153, 255, 0.3);
        --card-bg: rgba(255, 255, 255, 0.85);
        --card-border: rgba(255, 255, 255, 0.3);
        --text-dark: #0b1a33;
        --text-muted: #5a7a9a;
        --shadow-glow: 0 8px 32px rgba(0, 153, 255, 0.12);
    }

    /* ============================================================
       BASE
       ============================================================ */
    .superadmin-wrapper {
        font-family: 'Poppins', 'Inter', -apple-system, sans-serif;
        background: linear-gradient(145deg, #dbeafe 0%, #eff6ff 50%, #f0f9ff 100%);
        min-height: 100vh;
        padding: 2rem 2rem;
        position: relative;
        overflow: hidden;
    }

    /* Floating Orbs */
    .superadmin-wrapper .orb {
        position: fixed;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.2;
        pointer-events: none;
        z-index: 0;
        animation: float-orb-super 25s ease-in-out infinite alternate;
    }
    .superadmin-wrapper .orb-1 {
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, #66ccff, transparent);
        top: -120px;
        right: -100px;
        animation-delay: 0s;
    }
    .superadmin-wrapper .orb-2 {
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, #0099ff, transparent);
        bottom: -80px;
        left: -80px;
        animation-delay: -8s;
    }
    .superadmin-wrapper .orb-3 {
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, #4da6ff, transparent);
        top: 40%;
        right: 10%;
        animation-delay: -16s;
    }

    @keyframes float-orb-super {
        0% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(40px, -40px) scale(1.15); }
        100% { transform: translate(-30px, 30px) scale(0.85); }
    }

    /* ============================================================
       GLASS CARD
       ============================================================ */
    .glass-card-super {
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--card-border);
        border-radius: 24px;
        box-shadow: var(--shadow-glow);
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        overflow: hidden;
        z-index: 1;
        padding: 2rem 2.5rem;
    }
    .glass-card-super::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.4) 0%, transparent 50%);
        pointer-events: none;
        border-radius: 24px;
    }
    .glass-card-super:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 60px rgba(0, 153, 255, 0.18);
    }

    /* ============================================================
       HEADER
       ============================================================ */
    .header-super {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
        flex-wrap: wrap;
        gap: 1rem;
        position: relative;
        z-index: 1;
    }
    .header-super .title-group {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .header-super .title-group .icon-box {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        background: linear-gradient(135deg, rgba(0,153,255,0.12), rgba(102,204,255,0.06));
        border: 2px solid rgba(0,153,255,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: #0099ff;
        flex-shrink: 0;
        position: relative;
    }
    .header-super .title-group .icon-box::after {
        content: '👑';
        position: absolute;
        top: -8px;
        right: -8px;
        font-size: 16px;
        animation: crown-float 3s ease-in-out infinite;
    }
    @keyframes crown-float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-5px) rotate(5deg); }
    }
    .header-super .title-group h1 {
        font-size: 2.25rem;
        font-weight: 900;
        letter-spacing: -0.03em;
        background: linear-gradient(135deg, #0b1a33 0%, #0099ff 50%, #66ccff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
    }
    .header-super .title-group .sub {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
        -webkit-text-fill-color: var(--text-muted);
        margin-top: 2px;
    }
    .header-super .badge-super {
        background: rgba(255,255,255,0.6);
        backdrop-filter: blur(8px);
        padding: 0.5rem 1.8rem;
        border-radius: 100px;
        border: 1px solid rgba(0,153,255,0.12);
        font-weight: 800;
        font-size: 0.85rem;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* ============================================================
       STATS GRID
       ============================================================ */
    .stats-grid-super {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2.5rem;
        position: relative;
        z-index: 1;
    }
    .stat-card-super {
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
    .stat-card-super::before {
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
    .stat-card-super:hover::before {
        opacity: 1;
    }
    @keyframes shimmer-border {
        0% { background-position: 0% 0%; }
        100% { background-position: 200% 0%; }
    }
    .stat-card-super:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 60px rgba(0, 153, 255, 0.18);
        border-color: rgba(0, 153, 255, 0.2);
    }
    .stat-card-super .stat-label {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--text-muted);
    }
    .stat-card-super .stat-value {
        font-size: 2.2rem;
        font-weight: 900;
        color: var(--text-dark);
        margin-top: 4px;
        letter-spacing: -0.02em;
    }
    .stat-card-super .stat-value .highlight {
        color: #0099ff;
    }
    .stat-card-super .stat-icon {
        float: right;
        font-size: 2rem;
        color: rgba(0,153,255,0.12);
    }
    .stat-card-super .stat-sub {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-muted);
        margin-top: 6px;
    }
    .stat-card-super .stat-sub .up {
        color: #10b981;
        font-weight: 800;
    }

    /* ============================================================
       RESPONSIVE
       ============================================================ */
    @media (max-width: 1024px) {
        .stats-grid-super {
            grid-template-columns: repeat(2, 1fr);
        }
        .superadmin-wrapper {
            padding: 1.5rem 1.5rem;
        }
        .glass-card-super {
            padding: 1.5rem 1.5rem;
        }
    }
    @media (max-width: 768px) {
        .header-super .title-group h1 {
            font-size: 1.5rem;
        }
        .header-super .title-group .icon-box {
            width: 44px;
            height: 44px;
            font-size: 20px;
        }
        .header-super .title-group .icon-box::after {
            font-size: 12px;
            top: -6px;
            right: -6px;
        }
        .stats-grid-super {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.8rem;
        }
        .stat-card-super {
            padding: 1.25rem 1rem;
        }
        .stat-card-super .stat-value {
            font-size: 1.6rem;
        }
        .stat-card-super .stat-icon {
            font-size: 1.5rem;
        }
    }
    @media (max-width: 480px) {
        .superadmin-wrapper {
            padding: 1rem 0.75rem;
        }
        .glass-card-super {
            padding: 1rem 0.8rem;
        }
        .stats-grid-super {
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }
        .stat-card-super {
            padding: 0.8rem 0.8rem;
        }
        .stat-card-super .stat-value {
            font-size: 1.2rem;
        }
        .stat-card-super .stat-label {
            font-size: 0.55rem;
        }
        .stat-card-super .stat-icon {
            font-size: 1.2rem;
        }
        .header-super .title-group h1 {
            font-size: 1.2rem;
        }
        .header-super .title-group .icon-box {
            width: 36px;
            height: 36px;
            font-size: 16px;
        }
        .header-super .title-group .icon-box::after {
            font-size: 10px;
            top: -5px;
            right: -5px;
        }
        .header-super .badge-super {
            font-size: 0.65rem;
            padding: 0.3rem 1rem;
        }
    }
</style>

<div class="superadmin-wrapper max-w-7xl mx-auto">

    <!-- Floating Orbs -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <!-- ============================================================
    HEADER
    ============================================================ -->
    <div class="header-super">
        <div class="title-group">
            <div class="icon-box">
                <i class="fa-regular fa-crown"></i>
            </div>
            <div>
                <h1>Dashboard Super Admin</h1>
                <div class="sub">
                    <i class="fa-regular fa-bolt" style="color: #0099ff; font-size: 0.7rem;"></i>
                    Pantau semua aktivitas sistem secara realtime
                </div>
            </div>
        </div>
        <div class="badge-super">
            👑 Super Admin
            <span style="font-size: 0.6rem; opacity: 0.5;">| GACOR</span>
        </div>
    </div>

    <!-- ============================================================
    STATS GRID
    ============================================================ -->
    <div class="stats-grid-super">
        <!-- Card 1: Total Pendapatan -->
        <div class="stat-card-super">
            <span class="stat-icon"><i class="fa-regular fa-circle-dollar"></i></span>
            <div class="stat-label">💰 Total Pendapatan</div>
            <div class="stat-value">Rp <span class="highlight">{{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</span></div>
            <div class="stat-sub"><span class="up">↑ 8.5%</span> dari bulan lalu</div>
        </div>

        <!-- Card 2: Total Tiket -->
        <div class="stat-card-super">
            <span class="stat-icon"><i class="fa-regular fa-ticket"></i></span>
            <div class="stat-label">🎫 Total Tiket Terjual</div>
            <div class="stat-value">{{ number_format($totalTickets ?? 0) }}</div>
            <div class="stat-sub"><span class="up">↑ 12%</span> dari bulan lalu</div>
        </div>

        <!-- Card 3: Total User -->
        <div class="stat-card-super">
            <span class="stat-icon"><i class="fa-regular fa-users"></i></span>
            <div class="stat-label">👥 Total User</div>
            <div class="stat-value">{{ $users->count() ?? 0 }}</div>
            <div class="stat-sub">Terdaftar aktif</div>
        </div>

        <!-- Card 4: Pembayaran Pending -->
        <div class="stat-card-super">
            <span class="stat-icon"><i class="fa-regular fa-clock"></i></span>
            <div class="stat-label">⏳ Pembayaran Pending</div>
            <div class="stat-value">{{ $payments ?? 0 }}</div>
            <div class="stat-sub">Menunggu konfirmasi</div>
        </div>
    </div>

    <!-- ============================================================
    TABLE USER TERBARU (PREVIEW)
    ============================================================ -->
    <div class="glass-card-super">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#0099ff]/10 flex items-center justify-center text-[#0099ff]">
                    <i class="fa-regular fa-users"></i>
                </div>
                <h3 class="text-lg font-extrabold text-[#0b1a33]">User Terbaru</h3>
            </div>
            <a href="{{ route('superadmin.users.index') }}" class="text-sm font-bold text-[#0099ff] hover:text-[#0077cc]">
                Lihat Semua <i class="fa-regular fa-arrow-right"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-xs font-extrabold uppercase text-[#5a7a9a] bg-[#0099ff]/5">
                    <tr>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Role</th>
                        <th class="px-4 py-3 text-left">Bergabung</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($users->take(5) as $user)
                    <tr class="hover:bg-[#0099ff]/5 transition">
                        <td class="px-4 py-3 font-bold">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-[#5a7a9a]">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-bold 
                                @if($user->role == 'super_admin' || $user->role == 'admin') bg-red-100 text-red-700
                                @elseif($user->role == 'manager' || $user->role == 'admin_maskapai') bg-yellow-100 text-yellow-700
                                @else bg-blue-100 text-blue-700 @endif
                            ">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-[#5a7a9a] text-xs">{{ $user->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-[#5a7a9a]">Belum ada user terdaftar</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection