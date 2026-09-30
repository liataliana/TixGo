@extends('layouts.user')
@section('title', 'Dashboard Saya')

@push('styles')
<style>
    /* ========== HERO DASHBOARD ========== */
    .hero-dash {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 40%, #064e3b 100%);
        border-radius: 24px;
        padding: 2.5rem 2rem;
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    .hero-dash::before {
        content: '✈';
        position: absolute;
        font-size: 12rem;
        right: -2rem;
        top: 50%;
        transform: translateY(-50%) rotate(-20deg);
        opacity: 0.04;
        line-height: 1;
    }
    .hero-dash .avatar {
        width: 64px; height: 64px;
        background: linear-gradient(135deg, #34d399, #059669);
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; font-weight: 900; color: white;
        box-shadow: 0 8px 24px rgba(52,211,153,0.3);
        flex-shrink: 0;
    }
    .hero-dash h1 { color: white; font-weight: 800; font-size: 1.5rem; margin: 0; }
    .hero-dash p { color: rgba(255,255,255,0.6); margin: 0.25rem 0 0; font-size: 0.9rem; }
    .role-badge {
        display: inline-block;
        background: rgba(52,211,153,0.15);
        border: 1px solid rgba(52,211,153,0.3);
        color: #34d399;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 0.2rem 0.8rem;
        border-radius: 100px;
        margin-top: 0.5rem;
    }

    /* ========== STAT CARDS ========== */
    .stat-card {
        background: white;
        border-radius: 18px;
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(5,150,105,0.1); }
    .stat-card .num { font-size: 2rem; font-weight: 900; }
    .stat-card .label { font-size: 0.8rem; color: #64748b; font-weight: 600; margin-top: 0.25rem; }
    .stat-card .icon-box {
        width: 44px; height: 44px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }

    /* ========== BOOKING CARD ========== */
    .booking-card {
        background: white;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s;
        text-decoration: none;
        color: inherit;
    }
    .booking-card:hover { transform: translateX(6px); box-shadow: 0 8px 30px rgba(5,150,105,0.1); border-color: #6ee7b7; }
    .booking-card .ticket-icon {
        width: 52px; height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    .booking-card .route { font-weight: 800; color: #0f172a; font-size: 0.95rem; }
    .booking-card .meta { font-size: 0.75rem; color: #64748b; margin-top: 0.1rem; }
    .booking-card .code { font-family: monospace; font-size: 0.75rem; color: #059669; font-weight: 700; }
    .badge-pending { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; padding: 0.2rem 0.8rem; border-radius: 100px; font-size: 0.7rem; font-weight: 700; }
    .badge-confirmed { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; padding: 0.2rem 0.8rem; border-radius: 100px; font-size: 0.7rem; font-weight: 700; }
    .badge-cancelled { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 0.2rem 0.8rem; border-radius: 100px; font-size: 0.7rem; font-weight: 700; }

    /* ========== QUICK ACTIONS ========== */
    .quick-btn {
        background: linear-gradient(135deg, #059669, #0ea5e9);
        color: white;
        font-weight: 700;
        padding: 0.75rem 1.5rem;
        border-radius: 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s;
        font-size: 0.9rem;
        box-shadow: 0 4px 20px rgba(5,150,105,0.25);
    }
    .quick-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(5,150,105,0.35); color: white; }
</style>
@endpush

@section('content')

{{-- HERO --}}
<div class="hero-dash">
    <div class="flex items-start gap-4">
        <div class="avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
        <div>
            <h1>Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
            <p>{{ auth()->user()->email }}</p>
            <span class="role-badge">
                <i class="fa-solid fa-circle-check mr-1"></i>
                {{ ucfirst(auth()->user()->role ?? 'User') }}
            </span>
        </div>
    </div>
    <div class="mt-5 flex flex-wrap gap-3">
        <a href="{{ route('flights.index') }}" class="quick-btn">
            <i class="fa-solid fa-plane"></i> Cari & Pesan Tiket
        </a>
        <a href="{{ route('user.orders') }}" class="quick-btn" style="background: rgba(255,255,255,0.1); box-shadow: none; border: 1px solid rgba(255,255,255,0.15);">
            <i class="fa-regular fa-receipt"></i> Lihat Pesanan Saya
        </a>
    </div>
</div>

{{-- STATS --}}
@php
    $bookings = auth()->user()->bookings;
    $totalBookings = $bookings->count();
    $confirmed = $bookings->where('status', 'confirmed')->count();
    $pending = $bookings->where('status', 'pending')->count();
@endphp
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <div class="stat-card">
        <div class="icon-box" style="background: #ecfdf5;">✈️</div>
        <div class="num" style="color: #059669;">{{ $totalBookings }}</div>
        <div class="label">Total Pesanan</div>
    </div>
    <div class="stat-card">
        <div class="icon-box" style="background: #d1fae5;">✅</div>
        <div class="num" style="color: #065f46;">{{ $confirmed }}</div>
        <div class="label">Tiket Dikonfirmasi</div>
    </div>
    <div class="stat-card">
        <div class="icon-box" style="background: #fef3c7;">⏳</div>
        <div class="num" style="color: #92400e;">{{ $pending }}</div>
        <div class="label">Menunggu Konfirmasi</div>
    </div>
</div>

{{-- RECENT BOOKINGS --}}
<div class="glass p-6">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-black text-gray-900">📋 Pesanan Terbaru</h2>
        <a href="{{ route('user.orders') }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-800">
            Lihat Semua <i class="fa-solid fa-arrow-right ml-1"></i>
        </a>
    </div>

    @if($totalBookings > 0)
        <div class="space-y-3">
            @foreach($bookings->take(5) as $booking)
            <div class="booking-card">
                <div class="ticket-icon">
                    @php $icons = ['flight'=>'✈️','hotel'=>'🏨','villa'=>'🏡','train'=>'🚂','bus'=>'🚌']; @endphp
                    {{ $icons[$booking->category] ?? '🎫' }}
                </div>
                <div class="flex-1">
                    <div class="route">
                        @if($booking->flight)
                            {{ $booking->flight->origin }} → {{ $booking->flight->destination }}
                        @else
                            {{ ucfirst($booking->category ?? 'Perjalanan') }}
                        @endif
                    </div>
                    <div class="meta">
                        {{ $booking->nama_penumpang }} &bull; {{ $booking->jumlah_penumpang }} penumpang
                    </div>
                    <div class="code">{{ $booking->booking_code }}</div>
                </div>
                <div class="text-right flex flex-col items-end gap-2">
                    <span class="font-bold text-sm text-gray-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    @if($booking->status === 'confirmed')
                        <span class="badge-confirmed"><i class="fa-solid fa-circle-check mr-1"></i>Terkonfirmasi</span>
                        <a href="{{ route('bookings.download', $booking->id) }}" class="text-xs text-emerald-600 font-bold hover:underline">
                            <i class="fa-solid fa-download mr-1"></i>E-Ticket
                        </a>
                    @elseif($booking->status === 'pending')
                        <span class="badge-pending"><i class="fa-solid fa-clock mr-1"></i>Pending</span>
                    @else
                        <span class="badge-cancelled">Dibatalkan</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div style="font-size: 4rem; margin-bottom: 1rem;">🎫</div>
            <h3 class="font-black text-gray-700 text-lg">Belum Ada Pesanan</h3>
            <p class="text-gray-500 mt-1">Yuk, pesan tiket pertama kamu sekarang!</p>
            <a href="{{ route('flights.index') }}" class="quick-btn inline-flex mt-4">
                <i class="fa-solid fa-plane"></i> Cari Tiket Sekarang
            </a>
        </div>
    @endif
</div>

@endsection