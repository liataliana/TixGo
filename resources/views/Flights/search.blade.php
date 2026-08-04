@extends('layouts.app')

@section('content')
<style>
    /* CSS Hasil Penerbangan */
    .result-wrapper { max-width: 1000px; margin: 20px auto; padding: 0 16px; }
    .result-header { background:#fff; padding: 16px 20px; border-radius: 12px; border:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom: 16px;}
    .filter-bar { display: flex; gap: 10px; flex-wrap:wrap; margin-bottom:20px; }
    .filter-btn { padding: 8px 16px; border: 1px solid #e2e8f0; background:#fff; border-radius: 20px; cursor: pointer; font-weight: 600; font-size: 13px; transition:0.2s; display:flex; align-items:center; gap:6px;}
    .filter-btn:hover { border-color:#1e3a5f; }
    
    .flight-card { background:#fff; border-radius: 12px; border:1px solid #e2e8f0; margin-bottom:12px; padding: 20px; display:flex; flex-direction:column; gap:16px; transition:0.2s;}
    .flight-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .flight-row { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; }
    
    .airline { display:flex; align-items:center; gap:12px; width:200px; }
    .airline-logo { width:40px; height:40px; background:#f1f5f9; border-radius:50%; display:flex; justify-content:center; align-items:center; font-size:20px; color:#1e3a5f; font-weight:700; }
    .airline-name { font-weight:700; font-size:14px; }
    
    .schedule { display:flex; align-items:center; gap:12px; flex:1; justify-content:center; text-align:center; }
    .time { font-size:20px; font-weight:700; }
    .airport { font-size:12px; color:#64748b; }
    .duration { display:flex; flex-direction:column; align-items:center; font-size:12px; color:#64748b; }
    .duration-line { width:80px; height:2px; background:#cbd5e1; position:relative; margin:4px 0; }
    .duration-line::before { content:''; position:absolute; top:-4px; left:0; width:8px; height:8px; background:#cbd5e1; border-radius:50%; }
    .duration-line::after { content:''; position:absolute; top:-4px; right:0; width:8px; height:8px; background:#cbd5e1; border-radius:50%; }

    .price-box { text-align:right; min-width:120px; }
    .price { font-size:22px; font-weight:700; color:#dc2626; }
    .sub-price { font-size:12px; color:#64748b; text-decoration:line-through; }
    .btn-select { margin-top:8px; background:#1e3a5f; color:#fff; padding:8px 16px; border:none; border-radius:8px; font-weight:600; cursor:pointer; width:100%; }
    
    .flight-detail { display:flex; gap:16px; font-size:12px; color:#475569; border-top:1px solid #e2e8f0; padding-top:12px; }
    .flight-detail i { margin-right:4px; }

    @media (max-width: 768px) { 
        .flight-row { flex-direction: column; align-items: start; }
        .schedule { width:100%; justify-content:space-between; }
        .price-box { width:100%; text-align:left; }
    }
</style>

<div class="result-wrapper">
    <!-- Header Rute -->
    <div class="result-header">
        <div><strong>Jakarta (CGK)</strong> → <strong>Makassar (UPG)</strong></div>
        <div>Sel, 04 Agu 2026 - Rab, 05 Agu 2026 (Pulang Pergi)</div>
        <div>4 Penumpang, Ekonomi</div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <button class="filter-btn"><i class="fa-solid fa-sliders"></i> Filter</button>
        <button class="filter-btn">Urutkan <i class="fa-solid fa-chevron-down"></i></button>
        <button class="filter-btn">Transit <i class="fa-solid fa-chevron-down"></i></button>
        <button class="filter-btn" onclick="toggleFilterMenu('maskapai')">Maskapai <i class="fa-solid fa-chevron-down"></i></button>
        <button class="filter-btn" onclick="toggleFilterMenu('waktu')">Waktu <i class="fa-solid fa-chevron-down"></i></button>
        <button class="filter-btn">100% Refund</button>
    </div>

    <!-- List Penerbangan -->
    <div id="flightList">
        <!-- Card 1 -->
        <div class="flight-card">
            <div class="flight-row">
                <div class="airline">
                    <div class="airline-logo">SW</div>
                    <div>
                        <div class="airline-name">Sriwijaya Air</div>
                        <div style="font-size:12px; color:#64748b;">Boeing 737-800</div>
                    </div>
                </div>
                <div class="schedule">
                    <div><div class="time">22:15</div><div class="airport">CGK</div></div>
                    <div class="duration">
                        <div>2j 25m</div>
                        <div class="duration-line"></div>
                        <div>Langsung</div>
                    </div>
                    <div><div class="time">01:40<div style="display:inline-block; font-size:12px; color:#dc2626;">+1</div></div><div class="airport">UPG</div></div>
                </div>
                <div class="price-box">
                    <div class="price">Rp 1.852.197</div>
                    <div class="sub-price">Rp 1.886.129</div>
                    <button class="btn-select">Pilih</button>
                </div>
            </div>
            <div class="flight-detail">
                <span><i class="fa-solid fa-suitcase"></i> Bagasi 15 kg</span>
                <span><i class="fa-solid fa-clock"></i> Last Minute Deal</span>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="flight-card">
            <div class="flight-row">
                <div class="airline">
                    <div class="airline-logo">NA</div>
                    <div>
                        <div class="airline-name">NAM Air</div>
                        <div style="font-size:12px; color:#64748b;">Boeing 737-500</div>
                    </div>
                </div>
                <div class="schedule">
                    <div><div class="time">21:15</div><div class="airport">CGK</div></div>
                    <div class="duration">
                        <div>2j 25m</div>
                        <div class="duration-line"></div>
                        <div>Langsung</div>
                    </div>
                    <div><div class="time">00:40<div style="display:inline-block; font-size:12px; color:#dc2626;">+1</div></div><div class="airport">UPG</div></div>
                </div>
                <div class="price-box">
                    <div class="price">Rp 1.694.668</div>
                    <div class="sub-price">Rp 1.886.129</div>
                    <button class="btn-select">Pilih</button>
                </div>
            </div>
            <div class="flight-detail">
                <span><i class="fa-solid fa-suitcase"></i> Bagasi 15 kg</span>
            </div>
        </div>
    </div>
</div>

<script>
    // Simple Toggle untuk Filter Maskapai & Waktu (Bisa ditambahkan modal sama seperti search)
    function toggleFilterMenu(type) {
        alert('Fitur Filter ' + type + ' akan membuka popup pemilihan. Silakan integrasikan dengan modal sendiri sesuai kebutuhan anda!');
    }
</script>
@endsection