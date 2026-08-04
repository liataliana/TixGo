@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-black text-gray-900">Dashboard User</h1>
        <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-semibold">
            {{ auth()->user()->name }}
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card">
            <p class="text-sm text-gray-500">Total Pemesanan</p>
            <p class="text-2xl font-bold">{{ auth()->user()->bookings->count() }}</p>
        </div>
        <div class="card">
            <p class="text-sm text-gray-500">Pembayaran Lunas</p>
            <p class="text-2xl font-bold">{{ auth()->user()->bookings->where('payment_status', 'paid')->count() }}</p>
        </div>
        <div class="card">
            <p class="text-sm text-gray-500">Menunggu Pembayaran</p>
            <p class="text-2xl font-bold">{{ auth()->user()->bookings->where('payment_status', 'pending')->count() }}</p>
        </div>
    </div>

    <div class="mt-8 card">
        <h2 class="text-lg font-bold mb-4">Pemesanan Terbaru</h2>
        @if(auth()->user()->bookings->count() > 0)
            <ul>
                @foreach(auth()->user()->bookings->take(5) as $booking)
                <li class="border-b py-2 flex justify-between">
                    <span>{{ $booking->booking_code }}</span>
                    <span>{{ $booking->flight->origin }} → {{ $booking->flight->destination }}</span>
                    <span class="text-sm {{ $booking->payment_status == 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                        {{ $booking->payment_status }}
                    </span>
                </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-400">Belum ada pemesanan. <a href="{{ route('flights.index') }}" class="text-primary hover:underline">Cari tiket</a></p>
        @endif
    </div>
</div>
@endsection