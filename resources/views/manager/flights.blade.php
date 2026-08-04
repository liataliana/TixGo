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
    .flight-wrapper {
        font-family: 'Poppins', 'Inter', -apple-system, sans-serif;
        background: linear-gradient(145deg, #dbeafe 0%, #eff6ff 50%, #f0f9ff 100%);
        min-height: 100vh;
        padding: 2rem 2rem;
        position: relative;
        overflow: hidden;
    }

    /* Floating Orbs */
    .flight-wrapper .orb {
        position: fixed;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.2;
        pointer-events: none;
        z-index: 0;
        animation: float-orb 20s ease-in-out infinite alternate;
    }
    .flight-wrapper .orb-1 {
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, #66ccff, transparent);
        top: -80px;
        right: -80px;
        animation-delay: 0s;
    }
    .flight-wrapper .orb-2 {
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

    /* ============================================================
       GLASS CARD
       ============================================================ */
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
        padding: 2rem 2.5rem;
    }
    .glass-card::before {
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
    .glass-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 48px rgba(0, 153, 255, 0.18);
    }

    /* ============================================================
       HEADER
       ============================================================ */
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
        position: relative;
        z-index: 1;
    }
    .header-section .title-group {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .header-section .title-group .icon-box {
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
    .header-section .title-group h1 {
        font-size: 2rem;
        font-weight: 900;
        letter-spacing: -0.03em;
        background: linear-gradient(135deg, #0b1a33 0%, #0099ff 50%, #66ccff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
    }
    .header-section .title-group .sub {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
        -webkit-text-fill-color: var(--text-muted);
        margin-top: 2px;
    }
    .header-section .badge-count {
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
    .header-section .badge-count span {
        color: #0099ff;
        font-size: 1.2rem;
    }

    /* ============================================================
       FORM - RAPIH & TERSTRUKTUR
       ============================================================ */
    .form-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 1.5rem;
    }
    .form-title .form-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(0,153,255,0.1), rgba(102,204,255,0.05));
        border: 1px solid rgba(0,153,255,0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0099ff;
        font-size: 18px;
    }
    .form-title h3 {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--text-dark);
        margin: 0;
        letter-spacing: -0.01em;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
    }
    .form-group {
        position: relative;
    }
    .form-group .form-label {
        display: block;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--text-muted);
        margin-bottom: 0.4rem;
    }
    .form-group .form-label i {
        margin-right: 4px;
        color: #0099ff;
    }
    .form-group .form-input {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 2px solid rgba(0, 153, 255, 0.1);
        border-radius: 14px;
        font-size: 0.9rem;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        color: var(--text-dark);
        background: rgba(255, 255, 255, 0.5);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        outline: none;
    }
    .form-group .form-input:focus {
        border-color: #0099ff;
        box-shadow: 0 0 0 4px rgba(0, 153, 255, 0.1);
        background: rgba(255, 255, 255, 0.8);
        transform: scale(1.01);
    }
    .form-group .form-input::placeholder {
        color: #b0c8dd;
        font-weight: 500;
    }
    .form-group .form-input:hover {
        border-color: rgba(0, 153, 255, 0.25);
    }

    .form-submit {
        grid-column: span 4;
        margin-top: 0.5rem;
    }
    .btn-submit {
        width: 100%;
        padding: 0.9rem 2rem;
        background: linear-gradient(135deg, #0099ff, #66ccff);
        color: white;
        font-weight: 800;
        font-size: 1rem;
        font-family: 'Poppins', sans-serif;
        border: none;
        border-radius: 16px;
        box-shadow: 0 6px 24px rgba(0, 153, 255, 0.3);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        letter-spacing: 0.02em;
        position: relative;
        overflow: hidden;
    }
    .btn-submit::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.2), transparent);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }
    .btn-submit:hover::before {
        transform: translateX(100%);
    }
    .btn-submit:hover {
        transform: translateY(-3px) scale(1.01);
        box-shadow: 0 12px 40px rgba(0, 153, 255, 0.4);
    }
    .btn-submit:active {
        transform: scale(0.97);
    }
    .btn-submit .badge-gacor {
        font-size: 0.65rem;
        opacity: 0.7;
        font-weight: 700;
        background: rgba(255,255,255,0.15);
        padding: 0.1rem 0.8rem;
        border-radius: 100px;
    }

    /* ============================================================
       TABLE - RAPIH
       ============================================================ */
    .table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin: 0 -0.5rem;
    }
    .table-gacor {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }
    .table-gacor thead th {
        padding: 1rem 1.2rem;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--text-muted);
        background: rgba(0, 153, 255, 0.04);
        border-bottom: 2px solid rgba(0, 153, 255, 0.08);
        text-align: left;
    }
    .table-gacor thead th:first-child {
        border-radius: 14px 0 0 0;
        padding-left: 0;
    }
    .table-gacor thead th:last-child {
        border-radius: 0 14px 0 0;
        text-align: center;
    }
    .table-gacor tbody tr {
        border-bottom: 1px solid rgba(0, 153, 255, 0.05);
        transition: all 0.3s ease;
    }
    .table-gacor tbody tr:last-child {
        border-bottom: none;
    }
    .table-gacor tbody tr:hover {
        background: rgba(0, 153, 255, 0.03);
    }
    .table-gacor tbody td {
        padding: 1rem 1.2rem;
        font-weight: 600;
        color: var(--text-dark);
        vertical-align: middle;
    }
    .table-gacor tbody td:first-child {
        padding-left: 0;
        font-weight: 800;
        color: #0099ff;
    }
    .table-gacor tbody td .origin-dest {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .table-gacor tbody td .origin-dest i {
        font-size: 0.7rem;
        color: #0099ff;
        opacity: 0.6;
    }
    .table-gacor tbody td .arrow-icon {
        color: #0099ff;
        opacity: 0.3;
        margin: 0 4px;
    }

    .price-tag {
        display: inline-block;
        padding: 0.3rem 1.2rem;
        background: linear-gradient(135deg, rgba(0, 153, 255, 0.08), rgba(102, 204, 255, 0.04));
        border: 1px solid rgba(0, 153, 255, 0.08);
        border-radius: 100px;
        font-weight: 800;
        color: #0099ff;
        font-size: 0.85rem;
    }

    .flight-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 0.3rem 1rem;
        border-radius: 100px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        min-width: 100px;
    }
    .flight-badge.scheduled {
        background: rgba(16, 185, 129, 0.1);
        color: #065f46;
        border: 1px solid rgba(16, 185, 129, 0.15);
    }
    .flight-badge.scheduled::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #10b981;
        animation: pulse-dot 1.5s ease-in-out infinite;
    }
    .flight-badge.delayed {
        background: rgba(245, 158, 11, 0.1);
        color: #92400e;
        border: 1px solid rgba(245, 158, 11, 0.15);
    }
    .flight-badge.delayed::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #f59e0b;
        animation: pulse-dot 1.5s ease-in-out infinite;
    }
    .flight-badge.cancelled {
        background: rgba(239, 68, 68, 0.08);
        color: #991b1b;
        border: 1px solid rgba(239, 68, 68, 0.1);
    }

    @keyframes pulse-dot {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.8); opacity: 0.3; }
    }

    /* Table Footer */
    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1.5rem;
        padding-top: 1.2rem;
        border-top: 2px solid rgba(0, 153, 255, 0.06);
        flex-wrap: wrap;
        gap: 0.8rem;
    }
    .table-footer .total-info {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted);
    }
    .table-footer .total-info strong {
        color: var(--text-dark);
    }
    .table-footer .update-time {
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
    .empty-state {
        text-align: center;
        padding: 3.5rem 1rem;
    }
    .empty-state .empty-icon {
        font-size: 4.5rem;
        color: rgba(0, 153, 255, 0.1);
        margin-bottom: 1rem;
    }
    .empty-state .empty-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--text-dark);
        margin: 0 0 0.3rem 0;
    }
    .empty-state .empty-desc {
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.9rem;
        margin: 0;
    }
    .empty-state .empty-hint {
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
        .form-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .form-submit {
            grid-column: span 2;
        }
    }
    @media (max-width: 768px) {
        .flight-wrapper {
            padding: 1rem 1rem;
        }
        .glass-card {
            padding: 1.25rem 1.25rem;
        }
        .header-section .title-group h1 {
            font-size: 1.5rem;
        }
        .header-section .title-group .icon-box {
            width: 40px;
            height: 40px;
            font-size: 18px;
        }
        .form-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .form-submit {
            grid-column: span 1;
        }
        .table-gacor thead th,
        .table-gacor tbody td {
            padding: 0.7rem 0.8rem;
            font-size: 0.8rem;
        }
        .table-gacor tbody td:first-child {
            padding-left: 0;
        }
        .flight-badge {
            min-width: 80px;
            font-size: 0.6rem;
            padding: 0.2rem 0.6rem;
        }
        .price-tag {
            font-size: 0.75rem;
            padding: 0.2rem 0.8rem;
        }
        .header-section .badge-count {
            font-size: 0.75rem;
            padding: 0.3rem 1rem;
        }
    }
    @media (max-width: 480px) {
        .glass-card {
            padding: 1rem 0.8rem;
        }
        .table-gacor thead th {
            font-size: 0.6rem;
            padding: 0.5rem 0.4rem;
        }
        .table-gacor tbody td {
            font-size: 0.7rem;
            padding: 0.5rem 0.4rem;
        }
        .table-gacor tbody td:first-child {
            padding-left: 0;
        }
        .flight-badge {
            min-width: 60px;
            font-size: 0.5rem;
            padding: 0.15rem 0.4rem;
        }
        .price-tag {
            font-size: 0.65rem;
            padding: 0.15rem 0.5rem;
        }
        .btn-submit {
            font-size: 0.85rem;
            padding: 0.7rem 1rem;
        }
        .form-title h3 {
            font-size: 1rem;
        }
        .table-footer {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="flight-wrapper max-w-7xl mx-auto">

    <!-- Floating Orbs -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <!-- ============================================================
    HEADER
    ============================================================ -->
    <div class="header-section">
        <div class="title-group">
            <div class="icon-box">
                <i class="fa-solid fa-plane-departure"></i>
            </div>
            <div>
                <h1>Kelola Penerbangan</h1>
                <div class="sub">
                    <i class="fa-regular fa-bolt" style="color: #0099ff; font-size: 0.7rem;"></i>
                    Tambah jadwal baru &amp; kelola semua penerbangan
                </div>
            </div>
        </div>
        <div class="badge-count">
            <i class="fa-regular fa-calendar" style="color: #0099ff;"></i>
            <span>{{ isset($flights) ? count($flights) : 0 }}</span> Jadwal
        </div>
    </div>

    <!-- ============================================================
    FORM TAMBAH PENERBANGAN
    ============================================================ -->
    <div class="glass-card" style="margin-bottom: 2rem;">
        <div class="form-title">
            <div class="form-icon">
                <i class="fa-solid fa-plus"></i>
            </div>
            <h3>Tambah Penerbangan Baru</h3>
        </div>

        <form action="{{ route('manager.flights.store') }}" method="POST">
            @csrf
            <div class="form-grid">

                <!-- Asal -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fa-regular fa-location-dot"></i> Asal
                    </label>
                    <input type="text" name="origin" placeholder="Kota Asal..." class="form-input" required>
                </div>

                <!-- Tujuan -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fa-regular fa-flag"></i> Tujuan
                    </label>
                    <input type="text" name="destination" placeholder="Kota Tujuan..." class="form-input" required>
                </div>

                <!-- Waktu Berangkat -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fa-regular fa-clock"></i> Waktu Berangkat
                    </label>
                    <input type="datetime-local" name="departure_time" class="form-input" required>
                </div>

                <!-- Harga -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fa-regular fa-tag"></i> Harga
                    </label>
                    <input type="number" name="price" placeholder="Contoh: 1500000" class="form-input" required>
                </div>

                <!-- Submit -->
                <div class="form-submit">
                    <button type="submit" class="btn-submit">
                        <i class="fa-regular fa-paper-plane"></i>
                        Simpan Penerbangan
                        <span class="badge-gacor">GACOR</span>
                    </button>
                </div>

            </div>
        </form>
    </div>

    <!-- ============================================================
    DAFTAR JADWAL
    ============================================================ -->
    <div class="glass-card">
        <div class="form-title" style="margin-bottom: 1.5rem;">
            <div class="form-icon">
                <i class="fa-regular fa-rectangle-list"></i>
            </div>
            <h3>Daftar Jadwal Tersedia</h3>
        </div>

        @if(isset($flights) && count($flights) > 0)
            <div class="table-wrapper">
                <table class="table-gacor">
                    <thead>
                        <tr>
                            <th style="padding-left: 0;">Asal</th>
                            <th>Tujuan</th>
                            <th>Berangkat</th>
                            <th>Harga</th>
                            <th style="text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($flights as $flight)
                        <tr>
                            <td style="padding-left: 0;">
                                <span class="origin-dest">
                                    <i class="fa-solid fa-plane-departure"></i>
                                    {{ $flight->origin }}
                                </span>
                            </td>
                            <td>
                                <span class="origin-dest">
                                    <i class="fa-solid fa-plane-arrival"></i>
                                    {{ $flight->destination }}
                                </span>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($flight->departure_time)->format('d M Y, H:i') }}
                            </td>
                            <td>
                                <span class="price-tag">
                                    Rp {{ number_format($flight->price, 0, ',', '.') }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $departure = \Carbon\Carbon::parse($flight->departure_time);
                                    $status = 'scheduled';
                                    if ($departure->isPast()) {
                                        $status = 'cancelled';
                                    } elseif ($departure->diffInHours($now) < 2) {
                                        $status = 'delayed';
                                    }
                                @endphp
                                <span class="flight-badge {{ $status }}">
                                    {{ $status == 'scheduled' ? 'Scheduled' : ($status == 'delayed' ? 'Delayed' : 'Cancelled') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <span class="total-info">
                    <i class="fa-regular fa-route" style="color: #0099ff;"></i>
                    Total <strong>{{ count($flights) }}</strong> penerbangan
                </span>
                <span class="update-time">
                    <i class="fa-regular fa-rotate" style="margin-right: 4px;"></i>
                    {{ \Carbon\Carbon::now()->format('H:i') }}
                </span>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fa-regular fa-plane"></i>
                </div>
                <h4 class="empty-title">Belum Ada Penerbangan</h4>
                <p class="empty-desc">Mulai tambahkan jadwal penerbangan pertama kamu!</p>
                <span class="empty-hint">
                    <i class="fa-regular fa-arrow-up"></i> Tambah di form di atas
                </span>
            </div>
        @endif
    </div>

</div>
@endsection