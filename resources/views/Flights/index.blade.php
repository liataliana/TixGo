@extends('layouts.user')
@section('title', 'Cari Tiket Penerbangan')

@push('styles')
<style>
/* ========== HERO ========== */
.flights-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 40%, #064e3b 100%);
    border-radius: 28px;
    padding: 3rem 2.5rem 4rem;
    position: relative;
    overflow: hidden;
    margin-bottom: -2.5rem;
}
.flights-hero::before {
    content: '';
    position: absolute;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(52,211,153,0.12) 0%, transparent 70%);
    top: -100px; right: -100px;
    border-radius: 50%;
}
.flights-hero::after {
    content: '✈';
    position: absolute;
    font-size: 16rem;
    right: 2rem; bottom: -2rem;
    opacity: 0.04;
    transform: rotate(-25deg);
    line-height: 1;
}
.flights-hero h1 {
    color: white;
    font-weight: 900;
    font-size: 2.25rem;
    margin: 0 0 0.5rem;
    line-height: 1.15;
}
.flights-hero p {
    color: rgba(255,255,255,0.55);
    font-size: 1rem;
    margin: 0 0 2rem;
}

/* ========== SEARCH CARD (floating on hero) ========== */
.search-float {
    background: white;
    border-radius: 24px;
    box-shadow: 0 20px 80px rgba(0,0,0,0.15);
    padding: 2rem;
    position: relative;
    z-index: 10;
}

.trip-tabs { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; }
.trip-tab {
    padding: 0.45rem 1.25rem;
    border-radius: 100px;
    font-size: 0.8rem;
    font-weight: 700;
    cursor: pointer;
    border: 2px solid #e2e8f0;
    background: white;
    color: #64748b;
    transition: all 0.2s;
}
.trip-tab.active { background: #059669; border-color: #059669; color: white; }

.search-grid {
    display: grid;
    grid-template-columns: 1fr 50px 1fr 1fr 1fr;
    gap: 0.75rem;
    align-items: end;
}
.swap-btn {
    width: 42px; height: 42px;
    border-radius: 50%;
    background: #ecfdf5;
    border: 2px solid #a7f3d0;
    color: #059669;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    font-size: 1rem;
    transition: all 0.2s;
    margin-bottom: 2px;
}
.swap-btn:hover { background: #059669; color: white; transform: rotate(180deg); }

.sf-label {
    display: block;
    font-size: 0.65rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: #94a3b8;
    margin-bottom: 0.4rem;
}
.sf-input {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 14px;
    font-size: 0.9rem;
    font-weight: 600;
    color: #0f172a;
    font-family: 'Poppins', sans-serif;
    transition: all 0.2s;
    outline: none;
    background: white;
}
.sf-input:focus { border-color: #059669; box-shadow: 0 0 0 4px rgba(5,150,105,0.08); }

.btn-search {
    padding: 0.875rem 1.5rem;
    background: linear-gradient(135deg, #059669, #0ea5e9);
    color: white;
    font-weight: 800;
    font-size: 0.9rem;
    border: none;
    border-radius: 14px;
    cursor: pointer;
    width: 100%;
    display: flex; align-items: center; justify-content: center; gap: 0.5rem;
    transition: all 0.3s;
    box-shadow: 0 6px 20px rgba(5,150,105,0.3);
    font-family: 'Poppins', sans-serif;
}
.btn-search:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(5,150,105,0.4); }

/* ========== POPULAR ROUTES ========== */
.route-card {
    background: white;
    border-radius: 18px;
    border: 1px solid #e2e8f0;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    color: inherit;
}
.route-card:hover { border-color: #6ee7b7; box-shadow: 0 8px 30px rgba(5,150,105,0.1); transform: translateY(-3px); }
.route-icon { font-size: 2rem; width: 50px; text-align: center; }
.route-name { font-weight: 800; font-size: 0.95rem; color: #0f172a; }
.route-from { font-size: 0.75rem; color: #64748b; margin-top: 0.1rem; }
.route-price { margin-left: auto; text-align: right; }
.route-price .price { font-weight: 900; color: #059669; font-size: 0.95rem; }
.route-price .from-text { font-size: 0.65rem; color: #94a3b8; }

/* ========== PROMO BANNER ========== */
.promo-banner {
    background: linear-gradient(135deg, #d97706 0%, #ef4444 100%);
    border-radius: 20px;
    padding: 1.5rem 2rem;
    color: white;
    position: relative;
    overflow: hidden;
}
.promo-banner::after {
    content: '🎉';
    position: absolute;
    right: 1.5rem; top: 50%;
    transform: translateY(-50%);
    font-size: 3rem;
    opacity: 0.2;
}

/* ========== LIVE FLIGHTS TABLE ========== */
.flight-row-item {
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
.flight-row-item:hover { border-color: #a7f3d0; box-shadow: 0 8px 30px rgba(5,150,105,0.08); }
.airline-logo {
    width: 52px; height: 52px;
    border-radius: 14px;
    background: linear-gradient(135deg, #ecfdf5, #dbeafe);
    display: flex; align-items: center; justify-content: center;
    font-weight: 900; font-size: 0.9rem; color: #059669;
    flex-shrink: 0;
    border: 1px solid #d1fae5;
}
.flight-route { flex: 1; }
.flight-route .route-text { font-weight: 800; font-size: 1rem; color: #0f172a; }
.flight-route .meta { font-size: 0.75rem; color: #64748b; margin-top: 0.2rem; }
.flight-time { text-align: center; }
.flight-time .time { font-weight: 800; font-size: 1.1rem; }
.flight-time .code { font-size: 0.7rem; color: #64748b; }
.flight-arrow { color: #d1fae5; font-size: 1.25rem; }
.flight-price { text-align: right; }
.flight-price .price { font-weight: 900; font-size: 1.1rem; color: #059669; }
.flight-price .per { font-size: 0.7rem; color: #94a3b8; }
.btn-pilih {
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
    display: inline-block;
}
.btn-pilih:hover { transform: translateY(-2px); color: white; box-shadow: 0 6px 20px rgba(5,150,105,0.35); }

@media (max-width: 768px) {
    .search-grid { grid-template-columns: 1fr 1fr; }
    .swap-btn { display: none; }
    .flights-hero h1 { font-size: 1.5rem; }
    .flight-row-item { flex-wrap: wrap; gap: 0.75rem; }
}
@media (max-width: 480px) {
    .search-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')

{{-- ====== HERO ====== --}}
<div class="flights-hero">
    <h1>✈️ Temukan Tiket<br>Terbaik Untukmu</h1>
    <p>Bandingkan harga dari ratusan penerbangan. Hemat lebih banyak, terbang lebih jauh!</p>

    {{-- TRIP TABS --}}
    <div class="trip-tabs">
        <button class="trip-tab active" onclick="setTrip(this)">Sekali Jalan</button>
        <button class="trip-tab" onclick="setTrip(this)">Pulang Pergi</button>
    </div>
</div>

{{-- ====== SEARCH CARD ====== --}}
<div class="search-float mb-8">
    <form action="{{ route('flight.search') }}" method="GET">
        <div class="search-grid">
            {{-- DARI --}}
            <div>
                <label class="sf-label"><i class="fa-solid fa-plane-departure" style="color:#059669;"></i> Dari</label>
                <input type="text" name="origin" class="sf-input" placeholder="Kota atau bandara asal..." value="{{ request('origin') }}">
            </div>

            {{-- SWAP BUTTON --}}
            <div class="flex items-end pb-0.5">
                <button type="button" class="swap-btn" onclick="swapCities()">
                    <i class="fa-solid fa-arrows-left-right"></i>
                </button>
            </div>

            {{-- KE --}}
            <div>
                <label class="sf-label"><i class="fa-solid fa-plane-arrival" style="color:#0ea5e9;"></i> Ke</label>
                <input type="text" name="destination" id="destInput" class="sf-input" placeholder="Kota atau bandara tujuan..." value="{{ request('destination') }}">
            </div>

            {{-- TANGGAL --}}
            <div>
                <label class="sf-label"><i class="fa-regular fa-calendar" style="color:#d97706;"></i> Tanggal Pergi</label>
                <input type="date" name="departure_date" class="sf-input" value="{{ request('departure_date', date('Y-m-d')) }}">
            </div>

            {{-- TOMBOL CARI --}}
            <div>
                <label class="sf-label">&nbsp;</label>
                <button type="submit" class="btn-search">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari Tiket
                </button>
            </div>
        </div>
    </form>
</div>

{{-- ====== PROMO BANNER ====== --}}
<div class="promo-banner mb-8">
    <div style="font-size:0.7rem; font-weight:800; text-transform:uppercase; letter-spacing:0.1em; opacity:0.7;">Promo Terbatas</div>
    <div style="font-size:1.3rem; font-weight:900; margin:0.3rem 0;">Diskon hingga 50% untuk penerbangan Dalam Negeri!</div>
    <div style="font-size:0.85rem; opacity:0.75;">Gunakan kode <strong>TIXGO50</strong> saat checkout. Berlaku s.d 31 Des 2026.</div>
</div>

{{-- ====== PENERBANGAN TERSEDIA ====== --}}
<div class="glass p-6 mb-8">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-xl font-black text-gray-900">🛫 Jadwal Penerbangan Tersedia</h2>
            <p class="text-sm text-gray-500 mt-0.5">Semua jadwal aktif — klik "Pilih" untuk langsung pesan!</p>
        </div>
    </div>

    @php
        $allFlights = \App\Models\Flight::where('status','active')->orWhereNull('status')->orderBy('departure_time')->get();
    @endphp

    @if($allFlights->count() > 0)
        @foreach($allFlights as $flight)
        <div class="flight-row-item">
            <div class="airline-logo">{{ strtoupper(substr($flight->airline, 0, 2)) }}</div>

            <div class="flight-route">
                <div class="route-text">
                    {{ $flight->airline }}
                </div>
                <div class="meta">
                    ✈ {{ $flight->origin }} → {{ $flight->destination }}
                    &bull; {{ \Carbon\Carbon::parse($flight->departure_time)->format('D, d M Y') }}
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="flight-time">
                    <div class="time">{{ \Carbon\Carbon::parse($flight->departure_time)->format('H:i') }}</div>
                    <div class="code">{{ strtoupper(substr($flight->origin, 0, 3)) }}</div>
                </div>
                <div class="flight-arrow">
                    <i class="fa-solid fa-arrow-right"></i>
                </div>
                <div class="flight-time">
                    <div class="time">{{ \Carbon\Carbon::parse($flight->arrival_time)->format('H:i') }}</div>
                    <div class="code">{{ strtoupper(substr($flight->destination, 0, 3)) }}</div>
                </div>
            </div>

            <div class="flight-price ml-4">
                <div class="price">Rp {{ number_format($flight->price, 0, ',', '.') }}</div>
                <div class="per">per penumpang</div>
            </div>

            @auth
                <a href="{{ route('bookings.create', $flight->id) }}" class="btn-pilih">
                    Pilih <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-pilih" style="background: linear-gradient(135deg, #64748b, #94a3b8);">
                    Login dulu
                </a>
            @endauth
        </div>
        @endforeach
    @else
        <div class="text-center py-16">
            <div style="font-size:5rem; margin-bottom:1rem; opacity:0.3;">✈️</div>
            <h3 class="font-black text-gray-500 text-xl">Belum Ada Jadwal Penerbangan</h3>
            <p class="text-gray-400 mt-1">Manager sedang menambahkan jadwal. Cek lagi nanti!</p>
        </div>
    @endif
</div>

{{-- ====== RUTE POPULER ====== --}}
<div class="mb-8">
    <h2 class="text-xl font-black text-gray-900 mb-4">🔥 Rute Populer</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @php
        $popularRoutes = [
            ['icon'=>'🗼', 'from'=>'Jakarta', 'to'=>'Bali', 'price'=>'750.000'],
            ['icon'=>'🌋', 'from'=>'Jakarta', 'to'=>'Yogyakarta', 'price'=>'450.000'],
            ['icon'=>'🏙️', 'from'=>'Jakarta', 'to'=>'Surabaya', 'price'=>'550.000'],
            ['icon'=>'🌴', 'from'=>'Surabaya', 'to'=>'Makassar', 'price'=>'850.000'],
            ['icon'=>'✈️', 'from'=>'Bali', 'to'=>'Singapore', 'price'=>'1.200.000'],
            ['icon'=>'🏔️', 'from'=>'Medan', 'to'=>'Jakarta', 'price'=>'650.000'],
        ];
        @endphp
        @foreach($popularRoutes as $r)
        <a href="{{ route('flight.search') }}?origin={{ $r['from'] }}&destination={{ $r['to'] }}" class="route-card">
            <div class="route-icon">{{ $r['icon'] }}</div>
            <div>
                <div class="route-name">{{ $r['from'] }} → {{ $r['to'] }}</div>
                <div class="route-from">Penerbangan Langsung</div>
            </div>
            <div class="route-price">
                <div class="from-text">Mulai dari</div>
                <div class="price">Rp {{ $r['price'] }}</div>
            </div>
        </a>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    function setTrip(el) {
        document.querySelectorAll('.trip-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
    }
    function swapCities() {
        const origin = document.querySelector('input[name="origin"]');
        const dest = document.getElementById('destInput');
        [origin.value, dest.value] = [dest.value, origin.value];
    }
</script>
@endpush

@endsection