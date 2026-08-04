@extends('layouts.app')

@section('content')
<style>
    /* ============================================================
       ROOT VARIABLES - SKY BLUE THEME
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
    .user-wrapper {
        font-family: 'Poppins', 'Inter', -apple-system, sans-serif;
        background: linear-gradient(145deg, #dbeafe 0%, #eff6ff 50%, #f0f9ff 100%);
        min-height: 100vh;
        padding: 2rem 2rem;
        position: relative;
        overflow: hidden;
    }

    /* Floating Orbs */
    .user-wrapper .orb {
        position: fixed;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.2;
        pointer-events: none;
        z-index: 0;
        animation: float-orb 20s ease-in-out infinite alternate;
    }
    .user-wrapper .orb-1 {
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, #66ccff, transparent);
        top: -80px;
        right: -80px;
        animation-delay: 0s;
    }
    .user-wrapper .orb-2 {
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, #0099ff, transparent);
        bottom: -50px;
        left: -50px;
        animation-delay: -7s;
    }
    .user-wrapper .orb-3 {
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, #4da6ff, transparent);
        top: 40%;
        right: 20%;
        animation-delay: -14s;
    }

    @keyframes float-orb {
        0% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(30px, -30px) scale(1.1); }
        100% { transform: translate(-20px, 20px) scale(0.9); }
    }

    /* ============================================================
       GLASS CARD
       ============================================================ */
    .glass-card-user {
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
        padding: 2rem 2.5rem;
    }
    .glass-card-user::before {
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
    .glass-card-user:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 48px rgba(0, 153, 255, 0.18);
    }

    /* ============================================================
       HEADER
       ============================================================ */
    .header-user {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
        position: relative;
        z-index: 1;
    }
    .header-user .title-group {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .header-user .title-group .icon-box {
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
    .header-user .title-group h1 {
        font-size: 2rem;
        font-weight: 900;
        letter-spacing: -0.03em;
        background: linear-gradient(135deg, #0b1a33 0%, #0099ff 50%, #66ccff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
    }
    .header-user .title-group .sub {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
        -webkit-text-fill-color: var(--text-muted);
        margin-top: 2px;
    }
    .header-user .badge-count {
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
        gap: 8px;
    }
    .header-user .badge-count .number {
        color: #0099ff;
        font-size: 1.2rem;
        font-weight: 900;
    }
    .header-user .badge-count .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        display: inline-block;
        animation: pulse-dot-user 1.5s ease-in-out infinite;
    }
    @keyframes pulse-dot-user {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.6); opacity: 0.4; }
    }

    /* ============================================================
       STATS ROW - GACOR
       ============================================================ */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
        position: relative;
        z-index: 1;
    }
    .stat-mini {
        background: rgba(255,255,255,0.5);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(0,153,255,0.08);
        border-radius: 16px;
        padding: 1rem 1.2rem;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .stat-mini:hover {
        transform: translateY(-3px);
        border-color: rgba(0,153,255,0.2);
        box-shadow: 0 8px 24px rgba(0,153,255,0.08);
    }
    .stat-mini .stat-label {
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--text-muted);
    }
    .stat-mini .stat-value {
        font-size: 1.5rem;
        font-weight: 900;
        color: var(--text-dark);
        margin-top: 2px;
    }
    .stat-mini .stat-value .highlight {
        color: #0099ff;
    }
    .stat-mini .stat-icon {
        float: right;
        font-size: 1.5rem;
        color: rgba(0,153,255,0.12);
    }

    /* ============================================================
       TABLE - RAPIH & GACOR
       ============================================================ */
    .table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin: 0 -0.5rem;
    }
    .table-user {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }
    .table-user thead th {
        padding: 1rem 1.2rem;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--text-muted);
        background: rgba(0, 153, 255, 0.04);
        border-bottom: 2px solid rgba(0, 153, 255, 0.08);
        text-align: left;
        white-space: nowrap;
    }
    .table-user thead th:first-child {
        border-radius: 14px 0 0 0;
        padding-left: 0;
    }
    .table-user thead th:last-child {
        border-radius: 0 14px 0 0;
        text-align: center;
    }
    .table-user tbody tr {
        border-bottom: 1px solid rgba(0, 153, 255, 0.05);
        transition: all 0.3s ease;
    }
    .table-user tbody tr:last-child {
        border-bottom: none;
    }
    .table-user tbody tr:hover {
        background: rgba(0, 153, 255, 0.03);
        transform: scale(1.002);
    }
    .table-user tbody td {
        padding: 1rem 1.2rem;
        font-weight: 600;
        color: var(--text-dark);
        vertical-align: middle;
    }
    .table-user tbody td:first-child {
        padding-left: 0;
    }

    /* User Info dengan Avatar */
    .user-info-full {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .user-avatar-lg {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0099ff, #66ccff);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.9rem;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0,153,255,0.2);
        transition: all 0.3s ease;
    }
    .table-user tbody tr:hover .user-avatar-lg {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(0,153,255,0.3);
    }
    .user-name-full {
        font-weight: 800;
        color: var(--text-dark);
        font-size: 0.95rem;
    }

    /* Email */
    .user-email {
        font-weight: 600;
        color: var(--text-muted);
        font-size: 0.85rem;
    }
    .user-email i {
        margin-right: 6px;
        color: #0099ff;
        opacity: 0.5;
        font-size: 0.7rem;
    }

    /* Role Badge */
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.25rem 1rem;
        border-radius: 100px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .role-badge.admin {
        background: rgba(239, 68, 68, 0.08);
        color: #991b1b;
        border: 1px solid rgba(239, 68, 68, 0.1);
    }
    .role-badge.manager {
        background: rgba(0, 153, 255, 0.08);
        color: #0099ff;
        border: 1px solid rgba(0, 153, 255, 0.1);
    }
    .role-badge.user {
        background: rgba(16, 185, 129, 0.08);
        color: #065f46;
        border: 1px solid rgba(16, 185, 129, 0.1);
    }

    /* Join Date */
    .join-date {
        font-weight: 600;
        color: var(--text-muted);
        font-size: 0.85rem;
        white-space: nowrap;
    }
    .join-date i {
        margin-right: 6px;
        color: #0099ff;
        opacity: 0.4;
        font-size: 0.7rem;
    }

    /* Status User */
    .user-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.25rem 1rem;
        border-radius: 100px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .user-status.active {
        background: rgba(16, 185, 129, 0.08);
        color: #065f46;
        border: 1px solid rgba(16, 185, 129, 0.1);
    }
    .user-status.active::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #10b981;
        animation: pulse-dot-user 1.5s ease-in-out infinite;
    }
    .user-status.inactive {
        background: rgba(239, 68, 68, 0.08);
        color: #991b1b;
        border: 1px solid rgba(239, 68, 68, 0.1);
    }
    .user-status.inactive::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #ef4444;
    }

    /* ============================================================
       TABLE FOOTER
       ============================================================ */
    .table-footer-user {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1.5rem;
        padding-top: 1.2rem;
        border-top: 2px solid rgba(0, 153, 255, 0.06);
        flex-wrap: wrap;
        gap: 0.8rem;
    }
    .table-footer-user .total-info {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted);
    }
    .table-footer-user .total-info strong {
        color: var(--text-dark);
    }
    .table-footer-user .total-info .active-count {
        color: #10b981;
        font-weight: 800;
    }
    .table-footer-user .update-time {
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--text-muted);
        background: rgba(0, 153, 255, 0.04);
        padding: 0.2rem 1rem;
        border-radius: 100px;
    }

    /* ============================================================
       EMPTY STATE
       ============================================================ */
    .empty-state-user {
        text-align: center;
        padding: 3.5rem 1rem;
    }
    .empty-state-user .empty-icon {
        font-size: 4.5rem;
        color: rgba(0, 153, 255, 0.1);
        margin-bottom: 1rem;
    }
    .empty-state-user .empty-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--text-dark);
        margin: 0 0 0.3rem 0;
    }
    .empty-state-user .empty-desc {
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.9rem;
        margin: 0;
    }
    .empty-state-user .empty-hint {
        display: inline-block;
        margin-top: 1.5rem;
        font-size: 0.8rem;
        font-weight: 700;
        color: #0099ff;
        background: rgba(0, 153, 255, 0.06);
        padding: 0.4rem 1.4rem;
        border-radius: 100px;
        border: 1px solid rgba(0, 153, 255, 0.08);
    }

    /* ============================================================
       RESPONSIVE
       ============================================================ */
    @media (max-width: 1024px) {
        .user-wrapper {
            padding: 1.5rem 1.5rem;
        }
        .glass-card-user {
            padding: 1.5rem 1.5rem;
        }
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
        .table-user thead th,
        .table-user tbody td {
            padding: 0.8rem 0.8rem;
            font-size: 0.8rem;
        }
        .table-user tbody td:first-child {
            padding-left: 0;
        }
    }
    @media (max-width: 768px) {
        .user-wrapper {
            padding: 1rem 1rem;
        }
        .glass-card-user {
            padding: 1.25rem 1.25rem;
        }
        .header-user .title-group h1 {
            font-size: 1.5rem;
        }
        .header-user .title-group .icon-box {
            width: 40px;
            height: 40px;
            font-size: 18px;
        }
        .header-user .badge-count {
            font-size: 0.75rem;
            padding: 0.3rem 1rem;
        }
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        .stat-mini .stat-value {
            font-size: 1.2rem;
        }
        .stat-mini .stat-label {
            font-size: 0.55rem;
        }
        .stat-mini .stat-icon {
            font-size: 1.2rem;
        }
        .table-user thead th {
            font-size: 0.6rem;
            padding: 0.6rem 0.5rem;
        }
        .table-user tbody td {
            font-size: 0.75rem;
            padding: 0.6rem 0.5rem;
        }
        .table-user tbody td:first-child {
            padding-left: 0;
        }
        .user-avatar-lg {
            width: 32px;
            height: 32px;
            font-size: 0.7rem;
        }
        .user-name-full {
            font-size: 0.8rem;
        }
        .user-email {
            font-size: 0.7rem;
        }
        .role-badge {
            font-size: 0.6rem;
            padding: 0.15rem 0.6rem;
        }
        .user-status {
            font-size: 0.6rem;
            padding: 0.15rem 0.6rem;
        }
        .join-date {
            font-size: 0.7rem;
        }
        .table-footer-user {
            flex-direction: column;
            align-items: flex-start;
        }
    }
    @media (max-width: 480px) {
        .glass-card-user {
            padding: 0.8rem 0.5rem;
        }
        .stats-row {
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }
        .stat-mini {
            padding: 0.7rem 0.8rem;
        }
        .stat-mini .stat-value {
            font-size: 1rem;
        }
        .stat-mini .stat-label {
            font-size: 0.5rem;
        }
        .stat-mini .stat-icon {
            font-size: 1rem;
        }
        .table-user thead th {
            font-size: 0.5rem;
            padding: 0.4rem 0.3rem;
        }
        .table-user tbody td {
            font-size: 0.65rem;
            padding: 0.4rem 0.3rem;
        }
        .header-user .title-group h1 {
            font-size: 1.2rem;
        }
        .user-avatar-lg {
            width: 26px;
            height: 26px;
            font-size: 0.6rem;
        }
        .user-name-full {
            font-size: 0.7rem;
        }
        .user-email {
            font-size: 0.6rem;
        }
        .role-badge {
            font-size: 0.5rem;
            padding: 0.1rem 0.4rem;
        }
        .user-status {
            font-size: 0.5rem;
            padding: 0.1rem 0.4rem;
        }
        .join-date {
            font-size: 0.6rem;
        }
    }
</style>

<div class="user-wrapper max-w-7xl mx-auto">

    <!-- Floating Orbs -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <!-- ============================================================
    HEADER
    ============================================================ -->
    <div class="header-user">
        <div class="title-group">
            <div class="icon-box">
                <i class="fa-regular fa-users"></i>
            </div>
            <div>
                <h1>Daftar User</h1>
                <div class="sub">
                    <i class="fa-regular fa-bolt" style="color: #0099ff; font-size: 0.7rem;"></i>
                    Kelola semua user &amp; pembeli tiket
                </div>
            </div>
        </div>
        <div class="badge-count">
            <span class="status-dot"></span>
            <span class="number">{{ isset($users) ? $users->count() : 0 }}</span>
            Total User
        </div>
    </div>

    <!-- ============================================================
    STATS ROW
    ============================================================ -->
    @php
        $totalUsers = isset($users) ? $users->count() : 0;
        $activeUsers = isset($users) ? $users->filter(function($u) { return $u->email_verified_at !== null; })->count() : 0;
        $admins = isset($users) ? $users->filter(function($u) { return $u->role === 'admin'; })->count() : 0;
        $managers = isset($users) ? $users->filter(function($u) { return $u->role === 'manager'; })->count() : 0;
    @endphp

    <div class="stats-row">
        <div class="stat-mini">
            <span class="stat-icon"><i class="fa-regular fa-user"></i></span>
            <div class="stat-label">Total User</div>
            <div class="stat-value">{{ $totalUsers }}</div>
        </div>
        <div class="stat-mini">
            <span class="stat-icon"><i class="fa-regular fa-circle-check" style="color: #10b981;"></i></span>
            <div class="stat-label">Aktif</div>
            <div class="stat-value"><span class="highlight">{{ $activeUsers }}</span></div>
        </div>
        <div class="stat-mini">
            <span class="stat-icon"><i class="fa-regular fa-shield" style="color: #ef4444;"></i></span>
            <div class="stat-label">Admin</div>
            <div class="stat-value">{{ $admins }}</div>
        </div>
        <div class="stat-mini">
            <span class="stat-icon"><i class="fa-regular fa-user-tie" style="color: #0099ff;"></i></span>
            <div class="stat-label">Manager</div>
            <div class="stat-value">{{ $managers }}</div>
        </div>
    </div>

    <!-- ============================================================
    TABLE USER
    ============================================================ -->
    <div class="glass-card-user">

        @if(isset($users) && $users->count() > 0)
            <div class="table-wrapper">
                <table class="table-user">
                    <thead>
                        <tr>
                            <th style="padding-left: 0;">User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Bergabung</th>
                            <th style="text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td style="padding-left: 0;">
                                <div class="user-info-full">
                                    <div class="user-avatar-lg">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="user-name-full">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="user-email">
                                    <i class="fa-regular fa-envelope"></i>
                                    {{ $user->email }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $role = $user->role ?? 'user';
                                    $roleClass = $role === 'admin' ? 'admin' : ($role === 'manager' ? 'manager' : 'user');
                                    $roleIcon = $role === 'admin' ? 'fa-regular fa-shield' : ($role === 'manager' ? 'fa-regular fa-user-tie' : 'fa-regular fa-user');
                                @endphp
                                <span class="role-badge {{ $roleClass }}">
                                    <i class="{{ $roleIcon }}"></i>
                                    {{ ucfirst($role) }}
                                </span>
                            </td>
                            <td>
                                <span class="join-date">
                                    <i class="fa-regular fa-calendar-plus"></i>
                                    {{ $user->created_at->diffForHumans() }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <span class="user-status {{ $user->email_verified_at ? 'active' : 'inactive' }}">
                                    {{ $user->email_verified_at ? 'Aktif' : 'Belum Verifikasi' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="table-footer-user">
                <span class="total-info">
                    <i class="fa-regular fa-users" style="color: #0099ff;"></i>
                    Total <strong>{{ $users->count() }}</strong> user,
                    <span class="active-count">{{ $activeUsers }}</span> aktif
                </span>
                <span class="update-time">
                    <i class="fa-regular fa-rotate" style="margin-right: 4px;"></i>
                    {{ \Carbon\Carbon::now()->format('H:i') }}
                </span>
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state-user">
                <div class="empty-icon">
                    <i class="fa-regular fa-user-plus"></i>
                </div>
                <h4 class="empty-title">Belum Ada User Terdaftar</h4>
                <p class="empty-desc">User pertama akan muncul di sini setelah mendaftar.</p>
                <span class="empty-hint">
                    <i class="fa-regular fa-face-smile"></i> Tunggu user baru daftar
                </span>
            </div>
        @endif

    </div>

</div>
@endsection