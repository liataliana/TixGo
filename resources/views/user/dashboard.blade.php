@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        {{-- SIDEBAR KIRI --}}
        <div class="md:col-span-1">
            <div class="card text-center">
                <div class="w-20 h-20 rounded-full bg-primary text-white flex items-center justify-center text-3xl font-black mx-auto mb-3">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <h3 class="font-bold text-lg">{{ auth()->user()->name }}</h3>
                <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                <div class="mt-2 inline-block px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                    {{ auth()->user()->role ?? 'User' }}
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-400">Member sejak {{ auth()->user()->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <div class="card mt-4 p-3">
                <nav class="space-y-1">
                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold text-sm {{ request()->routeIs('user.dashboard') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fa-regular fa-user w-5"></i> Profil Saya
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold text-sm text-gray-600 hover:bg-gray-100">
                        <i class="fa-regular fa-heart w-5"></i> Wishlist
                    </a>
                    <a href="{{ route('user.orders') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold text-sm text-gray-600 hover:bg-gray-100">
                        <i class="fa-regular fa-receipt w-5"></i> Pesanan Saya
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold text-sm text-gray-600 hover:bg-gray-100">
                        <i class="fa-regular fa-user w-5"></i> Data Penumpang
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold text-sm text-gray-600 hover:bg-gray-100">
                        <i class="fa-regular fa-ticket w-5"></i> Voucher Box
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold text-sm text-gray-600 hover:bg-gray-100">
                        <i class="fa-regular fa-credit-card w-5"></i> Metode Pembayaran
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold text-sm text-gray-600 hover:bg-gray-100">
                        <i class="fa-regular fa-clock w-5"></i> Daftar Refund
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold text-sm text-gray-600 hover:bg-gray-100">
                        <i class="fa-regular fa-star w-5"></i> My Review
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold text-sm text-gray-600 hover:bg-gray-100">
                        <i class="fa-regular fa-gear w-5"></i> Pengaturan
                    </a>
                    <div class="border-t border-gray-200 my-2"></div>
                    <a href="/force-logout" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-semibold text-sm text-red-500 hover:bg-red-50">
                        <i class="fa-regular fa-right-from-bracket w-5"></i> Keluar
                    </a>
                </nav>
            </div>
        </div>

        {{-- KONTEN UTAMA --}}
        <div class="md:col-span-3">
            <div class="card">
                <h2 class="text-xl font-black text-gray-900 mb-6">👋 Selamat Datang, {{ auth()->user()->name }}!</h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div class="bg-primary/5 rounded-xl p-4 border border-primary/10">
                        <p class="text-sm text-gray-500">Total Pesanan</p>
                        <p class="text-2xl font-black text-primary">{{ auth()->user()->bookings->count() }}</p>
                    </div>
                    <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                        <p class="text-sm text-gray-500">Selesai</p>
                        <p class="text-2xl font-black text-green-600">{{ auth()->user()->bookings->where('payment_status', 'paid')->count() }}</p>
                    </div>
                    <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-100">
                        <p class="text-sm text-gray-500">Menunggu</p>
                        <p class="text-2xl font-black text-yellow-600">{{ auth()->user()->bookings->where('payment_status', 'pending')->count() }}</p>
                    </div>
                </div>

                <h3 class="font-bold text-gray-800 mb-3">📋 Pesanan Terbaru</h3>
                @if(auth()->user()->bookings->count() > 0)
                    <div class="space-y-3">
                        @foreach(auth()->user()->bookings->take(5) as $booking)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:shadow-md transition">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary">
                                    <i class="fa-solid fa-plane"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-sm">{{ $booking->flight->origin }} → {{ $booking->flight->destination }}</p>
                                    <p class="text-xs text-gray-500">{{ $booking->flight->departure_time->format('d M Y, H:i') }}</p>
                                    <p class="text-xs font-mono text-primary">{{ $booking->booking_code }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold {{ $booking->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $booking->payment_status == 'paid' ? '✔ Lunas' : '⏳ Pending' }}
                                </span>
                                <div class="mt-1 flex gap-2">
                                    <a href="{{ route('bookings.download', $booking->id) }}" class="text-xs text-primary font-bold hover:underline">
                                        <i class="fa-regular fa-download"></i> E-Ticket
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fa-regular fa-face-smile text-4xl text-gray-300 mb-2"></i>
                        <p class="text-gray-400">Belum ada pesanan. <a href="{{ route('flights.index') }}" class="text-primary font-bold hover:underline">Cari tiket sekarang</a></p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection