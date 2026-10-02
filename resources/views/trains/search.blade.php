@extends('layouts.user')
@section('title', 'Hasil Pencarian Kereta Api')

@push('styles')
<style>
    .train-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    .train-hero::after {
        content: '🚂';
        position: absolute; right: 2rem; top: 50%;
        transform: translateY(-50%);
        font-size: 5rem; opacity: 0.08;
    }
    .train-hero h1 { color: white; font-weight: 900; font-size: 1.5rem; margin: 0; }
    .train-hero p { color: rgba(255,255,255,0.5); margin: 0.3rem 0 0; font-size: 0.85rem; }

    .train-card {
        background: white;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        transition: all 0.3s;
        margin-bottom: 0.75rem;
    }
    .train-card:hover { border-color: #a7f3d0; box-shadow: 0 8px 30px rgba(5,150,105,0.1); }

    .train-logo {
        width: 52px; height: 52px;
        border-radius: 14px;
        background: linear-gradient(135deg, #ecfdf5, #dbeafe);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
        border: 1px solid #d1fae5;
    }
    .train-info { flex: 1; }
    .train-name { font-weight: 800; color: #0f172a; font-size: 1rem; }
    .train-meta { font-size: 0.8rem; color: #64748b; margin-top: 0.2rem; }
    .train-time { font-weight: 800; font-size: 1.1rem; color: #0f172a; }
    .train-price { font-weight: 900; font-size: 1.1rem; color: #059669; }
    .train-seats { font-size: 0.75rem; color: #94a3b8; }

    .btn-pesan {
        background: linear-gradient(135deg, #059669, #0ea5e9);
        color: white;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.6rem 1.25rem;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
        box-shadow: 0 4px 14px rgba(5,150,105,0.25);
    }
    .btn-pesan:hover { transform: translateY(-2px); color: white; }
</style>
@endpush

@section('content')

<div class="train-hero">
    <h1>🚂 Hasil Pencarian Kereta Api</h1>
    <p>Pilih jadwal kereta favoritmu dan pesan sekarang</p>
</div>

@if(isset($trains) && count($trains) > 0)
    @foreach($trains as $train)
    <div class="train-card">
        <div class="train-logo">🚂</div>
        <div class="train-info">
            <div class="train-name">{{ $train->name }}</div>
            <div class="train-meta">{{ $train->route }} &bull; {{ $train->class }} &bull; {{ $train->duration }}</div>
        </div>
        <div class="text-center">
            <div class="train-time">{{ $train->departure }} → {{ $train->arrival }}</div>
            <div class="train-seats">{{ $train->seats_left }} kursi tersisa</div>
        </div>
        <div class="text-right">
            <div class="train-price">Rp {{ number_format($train->price, 0, ',', '.') }}</div>
            <div class="train-seats">per orang</div>
        </div>
        <a href="{{ route('bookings.create.generic', ['category' => 'train', 'name' => $train->name, 'route' => $train->route, 'price' => $train->price]) }}" class="btn-pesan">
            Pesan <i class="fa-solid fa-arrow-right ml-1"></i>
        </a>
    </div>
    @endforeach
@else
    <div class="glass p-12 text-center">
        <div style="font-size:4rem; margin-bottom:1rem;">🚂</div>
        <h3 class="font-black text-gray-600 text-lg">Jadwal Kereta Tidak Ditemukan</h3>
        <p class="text-gray-400 mt-1">Coba ganti rute atau tanggal pencarian.</p>
    </div>
@endif

@endsection
