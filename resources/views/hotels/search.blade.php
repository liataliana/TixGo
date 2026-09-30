@extends('layouts.app')

@section('content')
<style>
    .hotel-result-wrapper { max-width: 1100px; margin: 20px auto; padding: 0 16px; }
    .top-search-summary { background: #fff; padding: 16px 20px; border-radius: 12px; border:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:24px;}
    
    .hotel-grid-container { display: grid; grid-template-columns: 240px 1fr; gap: 24px; }
    
    /* SIDEBAR FILTER */
    .filter-sidebar { background: #fff; border-radius: 12px; border:1px solid #e2e8f0; padding: 16px; height: fit-content; }
    .filter-title { font-weight: 700; margin-bottom: 12px; font-size: 15px; }
    .filter-chip-group { display: flex; flex-wrap: wrap; gap:8px; margin-bottom: 16px; }
    .filter-chip { padding: 6px 14px; border:1px solid #e2e8f0; border-radius: 20px; font-size: 12px; background: #fff; cursor: pointer; transition: 0.2s; }
    .filter-chip:hover { background: #f1f5f9; border-color: #1e3a5f; }

    /* PROMO BANNER */
    .promo-banner { background: linear-gradient(to right, #ffedd5, #f97316); color: white; padding: 16px; border-radius: 12px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;}
    .promo-text { font-weight: 700; font-size: 14px; }
    .promo-countdown { background: #fef08a; color: #854d0e; padding: 4px 12px; border-radius: 8px; font-weight: 700; }
    .promo-btn { background: white; color: #1e3a5f; padding: 6px 16px; border-radius: 8px; font-weight: 700; border: none; cursor: pointer; }

    /* HOTEL CARD */
    .hotel-list { display: flex; flex-direction: column; gap: 12px; }
    .hotel-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; display: flex; overflow: hidden; }
    .hotel-img { width: 220px; min-height: 160px; object-fit: cover; }
    .hotel-info { padding: 16px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; gap:10px;}
    .hotel-top { display: flex; justify-content: space-between; align-items: start; }
    .hotel-name { font-weight: 700; font-size: 16px; margin-bottom: 2px; }
    .hotel-stars { color: #f59e0b; font-size: 12px; }
    .hotel-location { font-size: 12px; color: #64748b; margin-bottom: 4px; }
    .hotel-rating { background: #1e3a5f; color: white; padding: 2px 8px; border-radius: 6px; font-weight: 700; font-size: 13px; }
    .hotel-reviews { font-size: 12px; color:#64748b; margin-left: 6px;}
    .hotel-bottom { display: flex; justify-content: space-between; align-items: end; flex-wrap: wrap; gap: 8px;}
    .badge-rooms { background: #fee2e2; color: #dc2626; font-weight: 700; font-size: 12px; padding: 2px 8px; border-radius: 6px; display: inline-block; margin-bottom: 4px;}
    .hotel-price { text-align: right; }
    .price-main { font-size: 20px; font-weight: 700; color: #1e3a5f; }
    .price-old { font-size: 14px; color: #94a3b8; text-decoration: line-through; display: block;}
    .price-per-night { font-size: 12px; color:#64748b; }
    .btn-book-hotel { background: #1e3a5f; color: white; padding: 8px 16px; border-radius: 8px; border:none; font-weight: 700; cursor: pointer; margin-top: 4px; transition:0.2s;}
    .btn-book-hotel:hover { background:#2d5a87; }

    @media (max-width: 768px) {
        .hotel-grid-container { grid-template-columns: 1fr; }
        .filter-sidebar { display: none; } /* Sembunyikan sidebar di mobile */
        .hotel-card { flex-direction: column; }
        .hotel-img { width: 100%; height: 140px; }
    }
</style>

<div class="hotel-result-wrapper">
    <!-- Header Hasil Pencarian -->
    <div class="top-search-summary">
        <div><strong id="destDisplay">Bali</strong></div>
        <div>Min, 02 Agt 2026 - Sen, 03 Agt 2026 (1 malam)</div>
        <div>1 Kamar, 1 Dewasa, 0 Anak</div>
    </div>

    <!-- Layout Grid -->
    <div class="hotel-grid-container">
        <!-- Sidebar Filter -->
        <div class="filter-sidebar">
            <div class="filter-title">Filter Populer</div>
            <div class="filter-chip-group">
                <div class="filter-chip">Resort</div>
                <div class="filter-chip">Bintang 4</div>
                <div class="filter-chip">Villa</div>
                <div class="filter-chip">Bintang 5</div>
            </div>
            
            <div class="filter-title" style="margin-top: 12px;">Harga per Malam</div>
            <div class="filter-chip-group">
                <div class="filter-chip">Rp 500.000 - 1 Juta</div>
                <div class="filter-chip">1 Juta - 2 Juta</div>
            </div>
        </div>

        <!-- List Hotel -->
        <div>
            <!-- Banner Promo -->
            <div class="promo-banner">
                <div class="promo-text">🏆 Promoted Stay</div>
                <div class="promo-countdown">03 : 01 : 35</div>
                <button class="promo-btn">Lihat deal</button>
            </div>

            <div class="hotel-list">
                @foreach($hotels as $hotel)
                <div class="hotel-card">
                    <img src="{{ $hotel->image }}" class="hotel-img" alt="Hotel">
                    <div class="hotel-info">
                        <div class="hotel-top">
                            <div>
                                <div class="hotel-name">{{ $hotel->name }}</div>
                                <div class="hotel-stars">
                                    @for($i=0; $i<$hotel->stars; $i++) ⭐ @endfor
                                </div>
                                <div class="hotel-location">{{ $hotel->location }}</div>
                                <div>
                                    <span class="hotel-rating">{{ $hotel->rating }}/5</span>
                                    <span class="hotel-reviews">({{ $hotel->reviews }})</span>
                                </div>
                            </div>
                        </div>
                        <div class="hotel-bottom">
                            <div>
                                <span class="badge-rooms">{{ $hotel->rooms_left }} kamar tersisa</span>
                            </div>
                            <div class="hotel-price">
                                <span class="price-old">Rp {{ number_format($hotel->old_price, 0, ',', '.') }}</span>
                                <span class="price-main">Rp {{ number_format($hotel->price, 0, ',', '.') }}</span>
                                <span class="price-per-night">/malam</span>
                                <br>
                                <button class="btn-book-hotel">Pilih Kamar</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    // Ambil data dari URL
    const params = new URLSearchParams(window.location.search);
    const dest = params.get('destination');
    if(dest) document.getElementById('destDisplay').innerText = dest;
</script>
@endsection