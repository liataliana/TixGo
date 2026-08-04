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
    .payment-wrapper {
        font-family: 'Poppins', 'Inter', -apple-system, sans-serif;
        background: linear-gradient(145deg, #dbeafe 0%, #eff6ff 50%, #f0f9ff 100%);
        min-height: 100vh;
        padding: 2rem 2rem;
        position: relative;
        overflow: hidden;
    }

    /* Floating Orbs */
    .payment-wrapper .orb {
        position: fixed;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.2;
        pointer-events: none;
        z-index: 0;
        animation: float-orb 20s ease-in-out infinite alternate;
    }
    .payment-wrapper .orb-1 {
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, #66ccff, transparent);
        top: -80px;
        right: -80px;
        animation-delay: 0s;
    }
    .payment-wrapper .orb-2 {
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, #0099ff, transparent);
        bottom: -50px;
        left: -50px;
        animation-delay: -7s;
    }
    .payment-wrapper .orb-3 {
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, #4da6ff, transparent);
        top: 50%;
        left: 10%;
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
    .glass-card-payment {
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
    .glass-card-payment::before {
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
    .glass-card-payment:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 48px rgba(0, 153, 255, 0.18);
    }

    /* ============================================================
       HEADER
       ============================================================ */
    .header-payment {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
        position: relative;
        z-index: 1;
    }
    .header-payment .title-group {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .header-payment .title-group .icon-box {
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
    .header-payment .title-group h1 {
        font-size: 2rem;
        font-weight: 900;
        letter-spacing: -0.03em;
        background: linear-gradient(135deg, #0b1a33 0%, #0099ff 50%, #66ccff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
    }
    .header-payment .title-group .sub {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
        -webkit-text-fill-color: var(--text-muted);
        margin-top: 2px;
    }
    .header-payment .badge-count {
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
    .header-payment .badge-count .number {
        color: #0099ff;
        font-size: 1.2rem;
        font-weight: 900;
    }
    .header-payment .badge-count .pulse-dot-badge {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #f59e0b;
        display: inline-block;
        animation: pulse-dot-badge 1.5s ease-in-out infinite;
    }
    @keyframes pulse-dot-badge {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.6); opacity: 0.4; }
    }

    /* ============================================================
       TABLE - RAPIH & GACOR
       ============================================================ */
    .table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin: 0 -0.5rem;
    }
    .table-payment {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }
    .table-payment thead th {
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
    .table-payment thead th:first-child {
        border-radius: 14px 0 0 0;
        padding-left: 0;
        text-align: center;
    }
    .table-payment thead th:last-child {
        border-radius: 0 14px 0 0;
        text-align: center;
    }
    .table-payment tbody tr {
        border-bottom: 1px solid rgba(0, 153, 255, 0.05);
        transition: all 0.3s ease;
    }
    .table-payment tbody tr:last-child {
        border-bottom: none;
    }
    .table-payment tbody tr:hover {
        background: rgba(0, 153, 255, 0.03);
        transform: scale(1.002);
    }
    .table-payment tbody td {
        padding: 1rem 1.2rem;
        font-weight: 600;
        color: var(--text-dark);
        vertical-align: middle;
    }
    .table-payment tbody td:first-child {
        padding-left: 0;
        text-align: center;
        font-family: 'Courier New', monospace;
        font-weight: 700;
        color: #0099ff;
        font-size: 0.8rem;
    }

    /* ID Badge */
    .id-badge {
        display: inline-block;
        background: rgba(0, 153, 255, 0.06);
        padding: 0.2rem 0.8rem;
        border-radius: 8px;
        border: 1px solid rgba(0, 153, 255, 0.08);
        font-weight: 700;
        color: #0099ff;
        font-size: 0.75rem;
    }

    /* User Info */
    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0099ff, #66ccff);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.75rem;
        flex-shrink: 0;
    }
    .user-name {
        font-weight: 700;
        color: var(--text-dark);
    }

    /* Booking Code */
    .booking-code {
        font-family: 'Courier New', monospace;
        font-weight: 800;
        color: #0099ff;
        background: rgba(0, 153, 255, 0.04);
        padding: 0.2rem 0.8rem;
        border-radius: 8px;
        border: 1px solid rgba(0, 153, 255, 0.06);
        font-size: 0.8rem;
        letter-spacing: 0.05em;
    }

    /* Price Tag */
    .price-tag-payment {
        display: inline-block;
        padding: 0.3rem 1.2rem;
        background: linear-gradient(135deg, rgba(0, 153, 255, 0.08), rgba(102, 204, 255, 0.04));
        border: 1px solid rgba(0, 153, 255, 0.08);
        border-radius: 100px;
        font-weight: 800;
        color: #0099ff;
        font-size: 0.85rem;
    }

    /* Payment Method */
    .method-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.3rem 1rem;
        border-radius: 100px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        background: rgba(0, 153, 255, 0.06);
        color: #0099ff;
        border: 1px solid rgba(0, 153, 255, 0.08);
    }
    .method-badge i {
        font-size: 0.8rem;
    }

    /* Date */
    .date-time {
        font-weight: 600;
        color: var(--text-muted);
        font-size: 0.8rem;
        white-space: nowrap;
    }

    /* ============================================================
       ACTION BUTTON - KONFIRMASI
       ============================================================ */
    .btn-confirm {
        padding: 0.5rem 1.2rem;
        background: linear-gradient(135deg, #0099ff, #66ccff);
        color: white;
        font-weight: 700;
        font-size: 0.75rem;
        font-family: 'Poppins', sans-serif;
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 153, 255, 0.25);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }
    .btn-confirm:hover {
        transform: translateY(-2px) scale(1.04);
        box-shadow: 0 8px 28px rgba(0, 153, 255, 0.35);
        background: linear-gradient(135deg, #0077cc, #4da6ff);
    }
    .btn-confirm:active {
        transform: scale(0.95);
    }
    .btn-confirm i {
        font-size: 0.85rem;
    }

    /* ============================================================
       ALERT SUCCESS
       ============================================================ */
    .alert-success {
        background: rgba(16, 185, 129, 0.08);
        border-left: 4px solid #10b981;
        color: #065f46;
        padding: 1rem 1.5rem;
        border-radius: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        margin-top: 1.5rem;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(16, 185, 129, 0.12);
    }
    .alert-success i {
        font-size: 1.4rem;
        color: #10b981;
    }

    /* ============================================================
       EMPTY STATE
       ============================================================ */
    .empty-state-payment {
        text-align: center;
        padding: 3.5rem 1rem;
    }
    .empty-state-payment .empty-icon {
        font-size: 4.5rem;
        color: rgba(0, 153, 255, 0.1);
        margin-bottom: 1rem;
    }
    .empty-state-payment .empty-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--text-dark);
        margin: 0 0 0.3rem 0;
    }
    .empty-state-payment .empty-desc {
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.9rem;
        margin: 0;
    }
    .empty-state-payment .empty-hint {
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
       TABLE FOOTER
       ============================================================ */
    .table-footer-payment {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1.5rem;
        padding-top: 1.2rem;
        border-top: 2px solid rgba(0, 153, 255, 0.06);
        flex-wrap: wrap;
        gap: 0.8rem;
    }
    .table-footer-payment .total-info {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted);
    }
    .table-footer-payment .total-info strong {
        color: var(--text-dark);
    }
    .table-footer-payment .total-info .pending-count {
        color: #f59e0b;
        font-weight: 800;
    }
    .table-footer-payment .update-time {
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--text-muted);
        background: rgba(0, 153, 255, 0.04);
        padding: 0.2rem 1rem;
        border-radius: 100px;
    }

    /* ============================================================
       RESPONSIVE
       ============================================================ */
    @media (max-width: 1024px) {
        .payment-wrapper {
            padding: 1.5rem 1.5rem;
        }
        .glass-card-payment {
            padding: 1.5rem 1.5rem;
        }
        .table-payment thead th,
        .table-payment tbody td {
            padding: 0.8rem 0.8rem;
            font-size: 0.8rem;
        }
        .table-payment tbody td:first-child {
            padding-left: 0;
        }
    }
    @media (max-width: 768px) {
        .payment-wrapper {
            padding: 1rem 1rem;
        }
        .glass-card-payment {
            padding: 1.25rem 1.25rem;
        }
        .header-payment .title-group h1 {
            font-size: 1.5rem;
        }
        .header-payment .title-group .icon-box {
            width: 40px;
            height: 40px;
            font-size: 18px;
        }
        .header-payment .badge-count {
            font-size: 0.75rem;
            padding: 0.3rem 1rem;
        }
        .table-payment thead th {
            font-size: 0.6rem;
            padding: 0.6rem 0.5rem;
        }
        .table-payment tbody td {
            font-size: 0.75rem;
            padding: 0.6rem 0.5rem;
        }
        .table-payment tbody td:first-child {
            padding-left: 0;
        }
        .btn-confirm {
            font-size: 0.65rem;
            padding: 0.3rem 0.8rem;
        }
        .price-tag-payment {
            font-size: 0.7rem;
            padding: 0.15rem 0.6rem;
        }
        .booking-code {
            font-size: 0.7rem;
            padding: 0.15rem 0.5rem;
        }
        .method-badge {
            font-size: 0.6rem;
            padding: 0.15rem 0.6rem;
        }
        .date-time {
            font-size: 0.7rem;
        }
        .user-avatar {
            width: 24px;
            height: 24px;
            font-size: 0.6rem;
        }
        .id-badge {
            font-size: 0.65rem;
            padding: 0.1rem 0.5rem;
        }
        .table-footer-payment {
            flex-direction: column;
            align-items: flex-start;
        }
    }
    @media (max-width: 480px) {
        .glass-card-payment {
            padding: 0.8rem 0.5rem;
        }
        .table-payment thead th {
            font-size: 0.5rem;
            padding: 0.4rem 0.3rem;
        }
        .table-payment tbody td {
            font-size: 0.65rem;
            padding: 0.4rem 0.3rem;
        }
        .btn-confirm {
            font-size: 0.55rem;
            padding: 0.2rem 0.5rem;
            gap: 3px;
        }
        .btn-confirm i {
            font-size: 0.6rem;
        }
        .price-tag-payment {
            font-size: 0.6rem;
            padding: 0.1rem 0.4rem;
        }
        .header-payment .title-group h1 {
            font-size: 1.2rem;
        }
        .user-name {
            font-size: 0.65rem;
        }
    }
</style>

<div class="payment-wrapper max-w-7xl mx-auto">

    <!-- Floating Orbs -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <!-- ============================================================
    HEADER
    ============================================================ -->
    <div class="header-payment">
        <div class="title-group">
            <div class="icon-box">
                <i class="fa-regular fa-credit-card"></i>
            </div>
            <div>
                <h1>Konfirmasi Pembayaran</h1>
                <div class="sub">
                    <i class="fa-regular fa-bolt" style="color: #0099ff; font-size: 0.7rem;"></i>
                    Verifikasi &amp; konfirmasi pembayaran tiket
                </div>
            </div>
        </div>
        <div class="badge-count">
            <span class="pulse-dot-badge"></span>
            <span class="number">{{ isset($payments) ? $payments->count() : 0 }}</span>
            Menunggu
        </div>
    </div>

    <!-- ============================================================
    TABLE KONFIRMASI
    ============================================================ -->
    <div class="glass-card-payment">

        @if(isset($payments) && $payments->count() > 0)
            <div class="table-wrapper">
                <table class="table-payment">
                    <thead>
                        <tr>
                            <th style="text-align: center; padding-left: 0;">ID</th>
                            <th>Pemesan</th>
                            <th>Kode Booking</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th>Tanggal</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr>
                            <td style="padding-left: 0; text-align: center;">
                                <span class="id-badge">#{{ $payment->id }}</span>
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr(optional($payment->booking->user)->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <span class="user-name">
                                        {{ optional($payment->booking->user)->name ?? 'Tidak diketahui' }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span class="booking-code">
                                    {{ optional($payment->booking)->booking_code ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="price-tag-payment">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <span class="method-badge">
                                    <i class="fa-regular fa-building-columns"></i>
                                    {{ $payment->payment_method ?? 'Transfer' }}
                                </span>
                            </td>
                            <td>
                                <span class="date-time">
                                    {{ $payment->created_at->format('d M Y, H:i') }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <form action="{{ route('manager.payments.confirm', $payment->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn-confirm">
                                        <i class="fa-regular fa-check-circle"></i>
                                        Konfirmasi
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="table-footer-payment">
                <span class="total-info">
                    <i class="fa-regular fa-circle-dollar" style="color: #0099ff;"></i>
                    Total <strong>{{ $payments->count() }}</strong> pembayaran,
                    <span class="pending-count">{{ $payments->count() }}</span> menunggu konfirmasi
                </span>
                <span class="update-time">
                    <i class="fa-regular fa-rotate" style="margin-right: 4px;"></i>
                    {{ \Carbon\Carbon::now()->format('H:i') }}
                </span>
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state-payment">
                <div class="empty-icon">
                    <i class="fa-regular fa-circle-check"></i>
                </div>
                <h4 class="empty-title">Tidak Ada Pembayaran Menunggu</h4>
                <p class="empty-desc">Semua pembayaran sudah dikonfirmasi. Santai dulu! 😎</p>
                <span class="empty-hint">
                    <i class="fa-regular fa-face-smile"></i> Semua aman terkendali
                </span>
            </div>
        @endif

    </div>

    <!-- ============================================================
    ALERT SUCCESS
    ============================================================ -->
    @if(session('success'))
    <div class="alert-success">
        <i class="fa-regular fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

</div>
@endsection