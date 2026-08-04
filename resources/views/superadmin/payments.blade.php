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

    .superadmin-wrapper {
        font-family: 'Poppins', 'Inter', -apple-system, sans-serif;
        background: linear-gradient(145deg, #dbeafe 0%, #eff6ff 50%, #f0f9ff 100%);
        min-height: 100vh;
        padding: 2rem 2rem;
        position: relative;
        overflow: hidden;
    }

    .superadmin-wrapper .orb {
        position: fixed;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.2;
        pointer-events: none;
        z-index: 0;
        animation: float-orb 25s ease-in-out infinite alternate;
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

    @keyframes float-orb {
        0% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(40px, -40px) scale(1.15); }
        100% { transform: translate(-30px, 30px) scale(0.85); }
    }

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

    .table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .table-super {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }
    .table-super thead th {
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
    .table-super thead th:first-child {
        border-radius: 14px 0 0 0;
        padding-left: 0;
    }
    .table-super thead th:last-child {
        border-radius: 0 14px 0 0;
        text-align: center;
    }
    .table-super tbody tr {
        border-bottom: 1px solid rgba(0, 153, 255, 0.05);
        transition: all 0.3s ease;
    }
    .table-super tbody tr:last-child {
        border-bottom: none;
    }
    .table-super tbody tr:hover {
        background: rgba(0, 153, 255, 0.03);
        transform: scale(1.002);
    }
    .table-super tbody td {
        padding: 1rem 1.2rem;
        font-weight: 600;
        color: var(--text-dark);
        vertical-align: middle;
    }
    .table-super tbody td:first-child {
        padding-left: 0;
    }

    .price-tag {
        display: inline-block;
        padding: 0.2rem 1rem;
        background: linear-gradient(135deg, rgba(0,153,255,0.08), rgba(102,204,255,0.04));
        border: 1px solid rgba(0,153,255,0.08);
        border-radius: 100px;
        font-weight: 800;
        color: #0099ff;
        font-size: 0.85rem;
    }

    .status-badge {
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
    .status-badge.confirmed {
        background: rgba(16, 185, 129, 0.08);
        color: #065f46;
        border: 1px solid rgba(16, 185, 129, 0.1);
    }
    .status-badge.pending {
        background: rgba(245, 158, 11, 0.08);
        color: #92400e;
        border: 1px solid rgba(245, 158, 11, 0.1);
    }
    .status-badge.pending::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #f59e0b;
        animation: pulse-dot 1.5s ease-in-out infinite;
    }
    .status-badge.cancelled {
        background: rgba(239, 68, 68, 0.08);
        color: #991b1b;
        border: 1px solid rgba(239, 68, 68, 0.1);
    }

    @keyframes pulse-dot {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.8); opacity: 0.3; }
    }

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

    @media (max-width: 768px) {
        .superadmin-wrapper {
            padding: 1rem 1rem;
        }
        .glass-card-super {
            padding: 1.25rem 1.25rem;
        }
        .header-super .title-group h1 {
            font-size: 1.5rem;
        }
        .header-super .title-group .icon-box {
            width: 44px;
            height: 44px;
            font-size: 20px;
        }
        .table-super thead th {
            font-size: 0.6rem;
            padding: 0.5rem 0.5rem;
        }
        .table-super tbody td {
            font-size: 0.75rem;
            padding: 0.5rem 0.5rem;
        }
        .table-super tbody td:first-child {
            padding-left: 0;
        }
        .price-tag {
            font-size: 0.7rem;
            padding: 0.15rem 0.6rem;
        }
        .status-badge {
            font-size: 0.6rem;
            padding: 0.15rem 0.6rem;
        }
    }
    @media (max-width: 480px) {
        .superadmin-wrapper {
            padding: 0.75rem 0.5rem;
        }
        .glass-card-super {
            padding: 0.8rem 0.5rem;
        }
        .header-super .title-group h1 {
            font-size: 1.2rem;
        }
        .header-super .title-group .icon-box {
            width: 36px;
            height: 36px;
            font-size: 16px;
        }
        .table-super thead th {
            font-size: 0.5rem;
            padding: 0.3rem 0.3rem;
        }
        .table-super tbody td {
            font-size: 0.65rem;
            padding: 0.3rem 0.3rem;
        }
        .price-tag {
            font-size: 0.6rem;
            padding: 0.1rem 0.4rem;
        }
        .status-badge {
            font-size: 0.5rem;
            padding: 0.1rem 0.4rem;
        }
    }
</style>

<div class="superadmin-wrapper max-w-7xl mx-auto">

    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <!-- HEADER -->
    <div class="header-super">
        <div class="title-group">
            <div class="icon-box">
                <i class="fa-regular fa-credit-card"></i>
            </div>
            <div>
                <h1>Semua Pembayaran</h1>
                <div class="sub">
                    <i class="fa-regular fa-bolt" style="color: #0099ff; font-size: 0.7rem;"></i>
                    Pantau semua transaksi pembayaran di sistem
                </div>
            </div>
        </div>
        <div class="badge-super">
            <i class="fa-regular fa-circle-dollar" style="color: #0099ff;"></i>
            {{ $payments->count() }} Transaksi
        </div>
    </div>

    <!-- TABLE -->
    <div class="glass-card-super">
        <div class="table-wrapper">
            <table class="table-super">
                <thead>
                    <tr>
                        <th style="padding-left: 0;">ID</th>
                        <th>User</th>
                        <th>Kode Booking</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th style="text-align: center;">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td style="padding-left: 0; font-weight: 700; color: #0099ff; font-size: 0.8rem;">
                            #{{ $payment->id }}
                        </td>
                        <td class="font-bold">{{ $payment->booking->user->name ?? '-' }}</td>
                        <td>
                            <span class="font-mono font-bold text-[#0099ff] text-xs bg-[#0099ff]/5 px-2 py-1 rounded">
                                {{ $payment->booking->booking_code ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <span class="price-tag">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge {{ $payment->status ?? 'pending' }}">
                                {{ $payment->status ?? 'pending' }}
                            </span>
                        </td>
                        <td style="text-align: center; font-size: 0.8rem; color: #5a7a9a;">
                            {{ $payment->created_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-[#5a7a9a]">Belum ada transaksi pembayaran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <span class="total-info">
                <i class="fa-regular fa-credit-card" style="color: #0099ff;"></i>
                Total <strong>{{ $payments->count() }}</strong> transaksi
                @php
                    $pending = $payments->where('status', 'pending')->count();
                @endphp
                @if($pending > 0)
                    <span style="color: #f59e0b; font-weight: 800;">| {{ $pending }} pending</span>
                @endif
            </span>
            <span class="update-time">
                <i class="fa-regular fa-rotate" style="margin-right: 4px;"></i>
                {{ \Carbon\Carbon::now()->format('H:i') }}
            </span>
        </div>
    </div>

</div>
@endsection