@extends('layouts.user')
@section('title', 'Pesanan Saya')

@push('styles')
<style>
    .orders-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    .orders-hero::after {
        content: '🎫';
        position: absolute; right: 2rem; top: 50%;
        transform: translateY(-50%);
        font-size: 5rem;
        opacity: 0.07;
    }
    .orders-hero h1 { color: white; font-weight: 900; font-size: 1.5rem; margin: 0; }
    .orders-hero p { color: rgba(255,255,255,0.5); margin: 0.3rem 0 0; font-size: 0.85rem; }

    .order-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        transition: all 0.3s;
        margin-bottom: 1.25rem;
    }
    .order-card:hover { box-shadow: 0 12px 40px rgba(5,150,105,0.1); border-color: #a7f3d0; }

    .order-card .card-header {
        background: linear-gradient(135deg, #f8fafc, #ecfdf5);
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .order-card .card-body { padding: 1.25rem 1.5rem; }

    .order-code { font-family: monospace; font-weight: 800; color: #059669; font-size: 1rem; }
    .order-route { font-size: 1.1rem; font-weight: 800; color: #0f172a; }
    .order-meta { font-size: 0.8rem; color: #64748b; margin-top: 0.25rem; }
    .order-price { font-size: 1.1rem; font-weight: 900; color: #059669; }

    .badge-pending { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; padding: 0.25rem 1rem; border-radius: 100px; font-size: 0.75rem; font-weight: 700; white-space: nowrap; }
    .badge-confirmed { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; padding: 0.25rem 1rem; border-radius: 100px; font-size: 0.75rem; font-weight: 700; white-space: nowrap; }
    .badge-cancelled { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; padding: 0.25rem 1rem; border-radius: 100px; font-size: 0.75rem; font-weight: 700; white-space: nowrap; }

    .btn-ticket {
        background: linear-gradient(135deg, #059669, #0ea5e9);
        color: white;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.5rem 1.25rem;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(5,150,105,0.25);
    }
    .btn-ticket:hover { transform: translateY(-2px); color: white; box-shadow: 0 6px 20px rgba(5,150,105,0.35); }

    .info-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px dashed #e2e8f0;
    }
    .info-row .info-item label { display: block; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.06em; color: #94a3b8; font-weight: 700; }
    .info-row .info-item span { font-weight: 700; color: #0f172a; font-size: 0.85rem; }
</style>
@endpush

@section('content')

<div class="orders-hero">
    <h1>📋 Pesanan Saya</h1>
    <p>Kelola semua tiket dan transaksi perjalanan kamu di sini.</p>
</div>

@php
    $bookings = auth()->user()->bookings()->with(['flight', 'payment'])->latest()->get();
@endphp

@if($bookings->count() > 0)
    @foreach($bookings as $booking)
    <div class="order-card">
        <div class="card-header">
            <div>
                <div class="order-code">{{ $booking->booking_code }}</div>
                <div class="order-meta">Dipesan pada {{ $booking->created_at->format('d M Y, H:i') }}</div>
            </div>
            @if($booking->status === 'confirmed')
                <span class="badge-confirmed"><i class="fa-solid fa-circle-check mr-1"></i>Terkonfirmasi</span>
            @elseif($booking->status === 'cancelled')
                <span class="badge-cancelled"><i class="fa-solid fa-times mr-1"></i>Dibatalkan</span>
            @else
                <span class="badge-pending"><i class="fa-solid fa-clock mr-1"></i>Menunggu Konfirmasi Manager</span>
            @endif
        </div>
        <div class="card-body">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div style="font-size:2.5rem; line-height:1;">
                        {{ $booking->category === 'flight' ? '✈️' : ($booking->category === 'train' ? '🚂' : '🚌') }}
                    </div>
                    <div>
                        <div class="order-route">
                            @if($booking->flight)
                                {{ $booking->flight->origin }} ✈ {{ $booking->flight->destination }}
                            @else
                                {{ ucfirst($booking->category) }} &mdash; {{ $booking->nama_penumpang }}
                            @endif
                        </div>
                        <div class="order-meta">
                            @if($booking->flight)
                                🕐 {{ \Carbon\Carbon::parse($booking->flight->departure_time)->format('D, d M Y H:i') }}
                                &bull; Maskapai: {{ $booking->flight->airline }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="order-price">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                    <div class="order-meta">{{ $booking->jumlah_penumpang }} penumpang</div>
                    @if($booking->status === 'confirmed')
                        <a href="{{ route('bookings.download', $booking->id) }}" class="btn-ticket mt-2">
                            <i class="fa-solid fa-download"></i> Download E-Ticket
                        </a>
                    @elseif($booking->status === 'pending')
                        <div class="mt-2 text-xs text-amber-600 font-semibold bg-amber-50 px-3 py-1.5 rounded-lg">
                            <i class="fa-solid fa-hourglass-half mr-1"></i>Menunggu verifikasi Manager
                        </div>
                    @endif
                </div>
            </div>

            <div class="info-row">
                <div class="info-item">
                    <label>Nama Penumpang</label>
                    <span>{{ $booking->nama_penumpang }}</span>
                </div>
                <div class="info-item">
                    <label>Jumlah Penumpang</label>
                    <span>{{ $booking->jumlah_penumpang }} orang</span>
                </div>
                <div class="info-item">
                    <label>Status Pembayaran</label>
                    <span>
                        @if($booking->payment)
                            @if($booking->status === 'confirmed')
                                ✅ Lunas
                            @else
                                ⏳ Menunggu
                            @endif
                        @else
                            ❓ Belum Bayar
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@else
    <div class="glass p-12 text-center">
        <div style="font-size: 5rem; margin-bottom: 1rem;">🎫</div>
        <h3 class="font-black text-gray-700 text-xl">Belum Ada Pesanan</h3>
        <p class="text-gray-500 mt-2">Yuk, pesan tiket pertama kamu dan mulai petualangan!</p>
        <a href="{{ route('flights.index') }}" class="btn-ticket inline-flex mt-5" style="font-size: 0.95rem; padding: 0.75rem 2rem;">
            <i class="fa-solid fa-plane"></i> Cari Tiket Sekarang
        </a>
    </div>
@endif

@endsection