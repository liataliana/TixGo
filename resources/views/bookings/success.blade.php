@extends('layouts.user')
@section('title', 'Pemesanan Berhasil!')

@section('content')
<div class="max-w-xl mx-auto text-center py-12">
    {{-- SUCCESS ANIMATION --}}
    <div style="width:120px; height:120px; background:linear-gradient(135deg,#059669,#0ea5e9); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 2rem; box-shadow:0 20px 60px rgba(5,150,105,0.3); animation: pulse-success 2s infinite;">
        <i class="fa-solid fa-circle-check text-white" style="font-size: 3.5rem;"></i>
    </div>
    <style>
        @keyframes pulse-success {
            0%, 100% { box-shadow: 0 20px 60px rgba(5,150,105,0.3); transform: scale(1); }
            50% { box-shadow: 0 25px 80px rgba(5,150,105,0.5); transform: scale(1.03); }
        }
    </style>

    <h1 class="font-black text-3xl text-gray-900 mb-3">Pemesanan Berhasil! 🎉</h1>
    <p class="text-gray-500 text-base mb-6">Tiket kamu sudah kami terima. Sekarang tinggal tunggu verifikasi dari Manager kami!</p>

    {{-- BOOKING CARD --}}
    <div class="glass p-6 mb-8 text-left">
        <div style="background:linear-gradient(135deg,#059669,#0ea5e9); border-radius:14px; padding:1.25rem; color:white; margin-bottom:1.25rem; position:relative; overflow:hidden;">
            <div style="position:absolute; right:-0.5rem; bottom:-0.5rem; font-size:4rem; opacity:0.1;">✈</div>
            <div style="font-family:monospace; font-size:1.1rem; font-weight:900; margin-bottom:0.5rem;">{{ $booking->booking_code }}</div>
            <div style="font-size:1.25rem; font-weight:800;">
                @if($booking->flight)
                    {{ $booking->flight->origin }} ✈ {{ $booking->flight->destination }}
                @else
                    {{ ucfirst($booking->category) }} Booking
                @endif
            </div>
            <div style="font-size:0.8rem; opacity:0.7; margin-top:0.3rem;">{{ $booking->nama_penumpang }} &bull; {{ $booking->jumlah_penumpang }} penumpang</div>
            <div style="font-size:1.5rem; font-weight:900; margin-top:0.75rem;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
        </div>

        <div class="space-y-3">
            <div class="flex items-center gap-3">
                <div style="width:36px; height:36px; background:#fef3c7; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1rem; flex-shrink:0;">1️⃣</div>
                <div>
                    <p class="font-bold text-sm text-gray-800">Pembayaran Kamu Diterima</p>
                    <p class="text-xs text-gray-500">Sistem kami telah merekam pilihan pembayaran kamu</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div style="width:36px; height:36px; background:#dbeafe; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1rem; flex-shrink:0;">2️⃣</div>
                <div>
                    <p class="font-bold text-sm text-gray-800">Verifikasi oleh Manager</p>
                    <p class="text-xs text-gray-500">Manager kami akan memverifikasi pembayaran kamu (biasanya 1x24 jam)</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div style="width:36px; height:36px; background:#d1fae5; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1rem; flex-shrink:0;">3️⃣</div>
                <div>
                    <p class="font-bold text-sm text-gray-800">E-Ticket Siap Diunduh</p>
                    <p class="text-xs text-gray-500">Setelah terverifikasi, E-Ticket bisa kamu unduh di halaman "Pesanan Saya"</p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <a href="{{ route('user.orders') }}" style="background:linear-gradient(135deg,#059669,#0ea5e9); color:white; font-weight:800; padding:0.875rem 2rem; border-radius:14px; text-decoration:none; display:inline-flex; align-items:center; gap:0.5rem; box-shadow:0 6px 24px rgba(5,150,105,0.3); transition:all 0.3s;">
            <i class="fa-regular fa-receipt"></i> Lihat Pesanan Saya
        </a>
        <a href="{{ route('home') }}" style="background:white; border:2px solid #e2e8f0; color:#0f172a; font-weight:700; padding:0.875rem 2rem; border-radius:14px; text-decoration:none; display:inline-flex; align-items:center; gap:0.5rem; transition:all 0.3s;">
            <i class="fa-solid fa-house"></i> Kembali ke Home
        </a>
    </div>
</div>
@endsection