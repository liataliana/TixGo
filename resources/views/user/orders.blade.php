@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('user.dashboard') }}" class="text-gray-400 hover:text-primary">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-2xl font-black text-gray-900">📋 Pesanan Saya</h1>
    </div>

    <div class="card">
        @if(auth()->user()->bookings->count() > 0)
            <div class="space-y-4">
                @foreach(auth()->user()->bookings as $booking)
                <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-sm font-bold text-primary">{{ $booking->booking_code }}</span>
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $booking->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $booking->payment_status == 'paid' ? 'Lunas' : 'Menunggu Pembayaran' }}
                                </span>
                            </div>
                            <p class="font-bold">{{ $booking->flight->airline }}</p>
                            <p class="text-sm">{{ $booking->flight->origin }} → {{ $booking->flight->destination }}</p>
                            <p class="text-sm text-gray-500">{{ $booking->flight->departure_time->format('d M Y, H:i') }}</p>
                            <p class="text-sm">Penumpang: {{ $booking->passenger_name }} ({{ $booking->passenger_count }} org)</p>
                            <p class="text-sm font-bold text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            @if($booking->payment_status == 'paid')
                                <a href="{{ route('bookings.download', $booking->id) }}" class="btn-primary text-sm py-2 px-4 rounded-lg text-center">
                                    <i class="fa-regular fa-download"></i> E-Ticket
                                </a>
                            @else
                                <a href="{{ route('user.payment.form', $booking->id) }}" class="btn-primary text-sm py-2 px-4 rounded-lg text-center bg-yellow-500 hover:bg-yellow-600">
                                    <i class="fa-regular fa-credit-card"></i> Bayar Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i class="fa-regular fa-face-smile text-5xl text-gray-300 mb-3"></i>
                <p class="text-gray-400 text-lg">Belum ada pesanan</p>
                <a href="{{ route('flights.index') }}" class="btn-primary mt-4 inline-block">Cari Tiket</a>
            </div>
        @endif
    </div>
</div>
@endsection