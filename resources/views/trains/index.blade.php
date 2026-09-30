@extends('layouts.app')

@section('content')
<style>
    /* ===== HEADER ===== */
    .page-header { display:flex; align-items:center; gap:16px; margin-bottom:24px; }
    .page-header h1 { font-size:26px; font-weight:900; color:#0f172a; margin:0; }
    .back-btn { color:#94a3b8; font-size:20px; text-decoration:none; transition:0.2s; }
    .back-btn:hover { color:#a855f7; }

    /* ===== MAIN CONTAINER ===== */
    .train-container {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 24px;
    }

    /* ===== FORM SEARCH ===== */
    .search-box {
        background: white;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        position: sticky;
        top: 20px;
    }
    .search-box .form-group {
        margin-bottom: 16px;
    }
    .search-box label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
        margin-bottom: 4px;
    }
    .search-box .station-input {
        display: flex;
        align-items: center;
        gap: 8px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        cursor: pointer;
        transition: 0.2s;
        background: white;
    }
    .search-box .station-input:hover {
        border-color: #a855f7;
    }
    .search-box .station-input input {
        border: none;
        outline: none;
        flex: 1;
        font-size: 14px;
        background: transparent;
    }
    .search-box .station-input input::placeholder {
        color: #94a3b8;
    }
    .search-box .station-input .icon {
        color: #94a3b8;
        font-size: 16px;
    }

    .search-box .date-row {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        gap: 8px;
        align-items: center;
    }
    .search-box .date-row input {
        padding: 10px 12px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        width: 100%;
        transition: 0.2s;
    }
    .search-box .date-row input:focus {
        outline: none;
        border-color: #a855f7;
        box-shadow: 0 0 0 3px rgba(168,85,247,0.12);
    }
    .search-box .date-row .toggle-label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        white-space: nowrap;
        cursor: pointer;
    }
    .search-box .date-row .toggle-label input {
        width: auto;
        margin-right: 4px;
    }

    .passenger-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        cursor: pointer;
        transition: 0.2s;
        background: white;
        width: 100%;
        font-size: 14px;
        color: #0f172a;
    }
    .passenger-btn:hover {
        border-color: #a855f7;
    }
    .passenger-btn .icon {
        color: #94a3b8;
        font-size: 16px;
    }
    .passenger-btn .text {
        flex: 1;
        text-align: left;
    }
    .passenger-btn .badge {
        background: #a855f710;
        color: #a855f7;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .btn-cari {
        width: 100%;
        padding: 14px;
        background: #a855f7;
        color: white;
        font-weight: 700;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 4px;
    }
    .btn-cari:hover {
        background: #9333ea;
        box-shadow: 0 4px 16px rgba(168,85,247,0.3);
    }

    /* ===== HASIL ===== */
    .result-area {
        background: white;
        border-radius: 16px;
        padding: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        max-height: 700px;
        overflow-y: auto;
    }
    .result-area::-webkit-scrollbar { width: 4px; }
    .result-area::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

    .result-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 12px;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 12px;
    }
    .result-header .count {
        font-size: 14px;
        color: #64748b;
        font-weight: 600;
    }
    .result-header .filters {
        display: flex;
        gap: 8px;
    }
    .result-header .filters button {
        padding: 4px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        background: white;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        transition: 0.2s;
    }
    .result-header .filters button:hover,
    .result-header .filters button.active {
        border-color: #a855f7;
        color: #a855f7;
        background: #a855f710;
    }

    .train-card {
        background: white;
        border-radius: 12px;
        padding: 16px 20px;
        border: 1px solid #e2e8f0;
        margin-bottom: 12px;
        transition: 0.2s;
        cursor: pointer;
        display: flex;
        gap: 16px;
        align-items: stretch;
    }
    .train-card:hover {
        border-color: #a855f7;
        box-shadow: 0 4px 16px rgba(168,85,247,0.1);
    }
    .train-card .train-icon {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding-right: 16px;
        border-right: 2px dashed #e2e8f0;
        min-width: 60px;
    }
    .train-card .train-icon i {
        font-size: 28px;
        color: #a855f7;
    }
    .train-card .train-icon .class-label {
        font-size: 10px;
        font-weight: 700;
        color: #94a3b8;
        margin-top: 4px;
    }

    .train-card .train-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .train-card .train-info .name {
        font-weight: 700;
        font-size: 16px;
        color: #0f172a;
        margin: 0 0 2px;
    }
    .train-card .train-info .route {
        font-size: 14px;
        color: #475569;
        margin: 0 0 2px;
    }
    .train-card .train-info .time-detail {
        font-size: 13px;
        color: #64748b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .train-card .train-info .time-detail .duration {
        background: #f1f5f9;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }

    .train-card .train-price {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: center;
        min-width: 120px;
    }
    .train-card .train-price .price {
        font-size: 20px;
        font-weight: 900;
        color: #a855f7;
        margin: 0 0 4px;
    }
    .train-card .train-price .seats {
        font-size: 11px;
        color: #94a3b8;
        margin: 0 0 6px;
    }
    .btn-pilih {
        display: inline-block;
        padding: 4px 18px;
        background: #a855f7;
        color: white;
        font-weight: 700;
        font-size: 13px;
        border-radius: 8px;
        text-decoration: none;
        transition: 0.2s;
        border: none;
        cursor: pointer;
    }
    .btn-pilih:hover {
        background: #9333ea;
    }

    .hot-badge {
        background: #ef4444;
        color: white;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 10px;
        border-radius: 12px;
        display: inline-block;
        margin-left: 8px;
    }
    .best-badge {
        background: #22c55e;
        color: white;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 10px;
        border-radius: 12px;
        display: inline-block;
        margin-left: 8px;
    }

    .empty-state {
        text-align: center;
        padding: 40px 0;
    }
    .empty-state i {
        font-size: 40px;
        color: #cbd5e1;
        margin-bottom: 12px;
        display: block;
    }
    .empty-state p {
        color: #94a3b8;
        font-size: 15px;
        margin: 0;
    }

    @media (max-width: 992px) {
        .train-container { grid-template-columns: 1fr; }
        .search-box { position: static; }
        .result-area { max-height: none; }
    }
    @media (max-width: 640px) {
        .search-box .date-row { grid-template-columns: 1fr; }
        .train-card { flex-wrap: wrap; }
        .train-card .train-icon { border-right: none; border-bottom: 2px dashed #e2e8f0; padding-bottom: 12px; flex-direction: row; gap: 12px; width: 100%; }
        .train-card .train-price { width: 100%; flex-direction: row; justify-content: space-between; align-items: center; }
    }
</style>

<div class="max-w-7xl mx-auto px-4 py-4">

    {{-- HEADER --}}
    <div class="page-header">
        <a href="{{ route('home') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
        <h1>🚆 Kereta Api</h1>
    </div>

    {{-- MAIN --}}
    <div class="train-container">

        {{-- FORM SEARCH --}}
        <div class="search-box">
            <form action="#" method="GET" id="trainSearchForm">

                {{-- Stasiun Asal --}}
                <div class="form-group">
                    <label>Dari</label>
                    <div class="station-input" onclick="openStationModal('from')">
                        <span class="icon"><i class="fa-solid fa-location-dot"></i></span>
                        <input type="text" id="from_station" placeholder="Pilih kota atau stasiun" readonly>
                        <span class="icon"><i class="fa-solid fa-chevron-down"></i></span>
                    </div>
                </div>

                {{-- Stasiun Tujuan --}}
                <div class="form-group">
                    <label>Ke</label>
                    <div class="station-input" onclick="openStationModal('to')">
                        <span class="icon"><i class="fa-solid fa-location-dot"></i></span>
                        <input type="text" id="to_station" placeholder="Mau ke mana?" readonly>
                        <span class="icon"><i class="fa-solid fa-chevron-down"></i></span>
                    </div>
                </div>

                {{-- Tanggal + Pulang Pergi --}}
                <div class="form-group">
                    <div class="date-row">
                        <input type="date" id="departure_date" value="{{ date('Y-m-d') }}">
                        <label class="toggle-label">
                            <input type="checkbox" id="is_return" onchange="toggleReturn()"> Pulang pergi?
                        </label>
                        <input type="date" id="return_date" value="{{ date('Y-m-d', strtotime('+1 day')) }}" style="display:none;">
                    </div>
                </div>

                {{-- Penumpang --}}
                <div class="form-group">
                    <label>Penumpang</label>
                    <div class="passenger-btn" onclick="openPassengerModal()">
                        <span class="icon"><i class="fa-solid fa-user"></i></span>
                        <span class="text" id="passenger_display">1 Penumpang</span>
                        <span class="badge" id="passenger_badge">Atur</span>
                    </div>
                </div>

                {{-- Tombol Cari --}}
                <button type="submit" class="btn-cari" onclick="searchTrains(event)">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari Kereta
                </button>
            </form>
        </div>

        {{-- HASIL --}}
        <div class="result-area" id="resultArea">
            <div class="result-header">
                <span class="count" id="resultCount">0 hasil ditemukan</span>
                <div class="filters">
                    <button class="active" onclick="filterResults('all')">Semua</button>
                    <button onclick="filterResults('ekonomi')">Ekonomi</button>
                    <button onclick="filterResults('bisnis')">Bisnis</button>
                    <button onclick="filterResults('executive')">Executive</button>
                </div>
            </div>

            <div id="trainResults">
                {{-- Hasil akan di-render oleh JavaScript --}}
                <div class="empty-state">
                    <i class="fa-regular fa-train"></i>
                    <p>Silakan cari kereta terlebih dahulu</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== MODAL PILIH STASIUN ===== --}}
<div id="stationModal" style="display:none; position:fixed; inset:0; z-index:1000; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
    <div style="background:white; border-radius:16px; max-width:480px; width:100%; max-height:80vh; overflow-y:auto; padding:24px; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h3 style="font-weight:700; font-size:18px; margin:0;" id="stationModalTitle">Pilih Kota atau Stasiun</h3>
            <button onclick="closeStationModal()" style="background:none; border:none; font-size:24px; cursor:pointer; color:#94a3b8;">&times;</button>
        </div>
        <input type="text" id="stationSearch" placeholder="Masukin nama kota atau stasiun..." style="width:100%; padding:12px 16px; border:2px solid #e2e8f0; border-radius:10px; font-size:14px; margin-bottom:16px;">
        <div style="font-size:13px; font-weight:700; color:#64748b; text-transform:uppercase; margin-bottom:8px;">Stasiun Populer</div>
        <div id="stationList">
            <div class="station-item" onclick="selectStation('Bandung (BD)')" style="padding:10px 14px; border-radius:8px; cursor:pointer; transition:0.2s; display:flex; justify-content:space-between; align-items:center;">
                <span><strong>Bandung</strong><br><span style="font-size:12px; color:#94a3b8;">Bandung</span></span>
                <span style="font-size:12px; color:#94a3b8;">BD</span>
            </div>
            <div class="station-item" onclick="selectStation('Gambir (GMR)')" style="padding:10px 14px; border-radius:8px; cursor:pointer; transition:0.2s; display:flex; justify-content:space-between; align-items:center;">
                <span><strong>Gambir</strong><br><span style="font-size:12px; color:#94a3b8;">Jakarta</span></span>
                <span style="font-size:12px; color:#94a3b8;">GMR</span>
            </div>
            <div class="station-item" onclick="selectStation('Semarang Tawang (SMT)')" style="padding:10px 14px; border-radius:8px; cursor:pointer; transition:0.2s; display:flex; justify-content:space-between; align-items:center;">
                <span><strong>Semarang Tawang</strong><br><span style="font-size:12px; color:#94a3b8;">Semarang</span></span>
                <span style="font-size:12px; color:#94a3b8;">SMT</span>
            </div>
            <div class="station-item" onclick="selectStation('Surabaya Pasarturi (SBI)')" style="padding:10px 14px; border-radius:8px; cursor:pointer; transition:0.2s; display:flex; justify-content:space-between; align-items:center;">
                <span><strong>Surabaya Pasarturi</strong><br><span style="font-size:12px; color:#94a3b8;">Surabaya</span></span>
                <span style="font-size:12px; color:#94a3b8;">SBI</span>
            </div>
            <div class="station-item" onclick="selectStation('Yogyakarta (YK)')" style="padding:10px 14px; border-radius:8px; cursor:pointer; transition:0.2s; display:flex; justify-content:space-between; align-items:center;">
                <span><strong>Yogyakarta</strong><br><span style="font-size:12px; color:#94a3b8;">Yogyakarta</span></span>
                <span style="font-size:12px; color:#94a3b8;">YK</span>
            </div>
        </div>
    </div>
</div>

{{-- ===== MODAL ATUR PENUMPANG ===== --}}
<div id="passengerModal" style="display:none; position:fixed; inset:0; z-index:1000; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
    <div style="background:white; border-radius:16px; max-width:400px; width:100%; padding:24px; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h3 style="font-weight:700; font-size:18px; margin:0;">Atur Jumlah Penumpang</h3>
            <button onclick="closePassengerModal()" style="background:none; border:none; font-size:24px; cursor:pointer; color:#94a3b8;">&times;</button>
        </div>
        <div class="passenger-row" style="display:flex; justify-content:space-between; align-items:center; padding:12px 0; border-bottom:1px solid #f1f5f9;">
            <div>
                <div style="font-weight:600; font-size:15px;">Dewasa</div>
                <div style="font-size:12px; color:#94a3b8;">3 tahun ke atas</div>
            </div>
            <div style="display:flex; align-items:center; gap:16px;">
                <button onclick="changePassenger('adult', -1)" style="width:32px; height:32px; border-radius:50%; border:2px solid #e2e8f0; background:white; font-size:18px; cursor:pointer;">−</button>
                <span id="adult_count" style="font-size:18px; font-weight:700; min-width:24px; text-align:center;">1</span>
                <button onclick="changePassenger('adult', 1)" style="width:32px; height:32px; border-radius:50%; border:2px solid #e2e8f0; background:white; font-size:18px; cursor:pointer;">+</button>
            </div>
        </div>
        <div class="passenger-row" style="display:flex; justify-content:space-between; align-items:center; padding:12px 0;">
            <div>
                <div style="font-weight:600; font-size:15px;">Bayi</div>
                <div style="font-size:12px; color:#94a3b8;">di bawah 3 tahun</div>
            </div>
            <div style="display:flex; align-items:center; gap:16px;">
                <button onclick="changePassenger('infant', -1)" style="width:32px; height:32px; border-radius:50%; border:2px solid #e2e8f0; background:white; font-size:18px; cursor:pointer;">−</button>
                <span id="infant_count" style="font-size:18px; font-weight:700; min-width:24px; text-align:center;">0</span>
                <button onclick="changePassenger('infant', 1)" style="width:32px; height:32px; border-radius:50%; border:2px solid #e2e8f0; background:white; font-size:18px; cursor:pointer;">+</button>
            </div>
        </div>
        <div style="font-size:12px; color:#94a3b8; margin:8px 0 16px;">
            <i class="fa-regular fa-info-circle"></i> Penumpang bayi nggak dapat kursi.
        </div>
        <button onclick="savePassenger()" style="width:100%; padding:12px; background:#a855f7; color:white; font-weight:700; border:none; border-radius:10px; font-size:16px; cursor:pointer;">Simpan</button>
    </div>
</div>

<script>
    // ===== VARIABEL =====
    let selectedStationType = 'from';
    let adults = 1;
    let infants = 0;

    // ===== STATION =====
    function openStationModal(type) {
        selectedStationType = type;
        document.getElementById('stationModalTitle').textContent = type === 'from' ? 'Pilih Kota atau Stasiun' : 'Mau ke Mana?';
        document.getElementById('stationModal').style.display = 'flex';
    }

    function closeStationModal() {
        document.getElementById('stationModal').style.display = 'none';
    }

    function selectStation(name) {
        if (selectedStationType === 'from') {
            document.getElementById('from_station').value = name;
        } else {
            document.getElementById('to_station').value = name;
        }
        closeStationModal();
    }

    // Filter stasiun
    document.getElementById('stationSearch')?.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.station-item').forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(query) ? 'flex' : 'none';
        });
    });

    // ===== PASSENGER =====
    function openPassengerModal() {
        document.getElementById('passengerModal').style.display = 'flex';
        document.getElementById('adult_count').textContent = adults;
        document.getElementById('infant_count').textContent = infants;
    }

    function closePassengerModal() {
        document.getElementById('passengerModal').style.display = 'none';
    }

    function changePassenger(type, delta) {
        if (type === 'adult') {
            adults = Math.max(1, Math.min(10, adults + delta));
            document.getElementById('adult_count').textContent = adults;
        } else {
            infants = Math.max(0, Math.min(5, infants + delta));
            document.getElementById('infant_count').textContent = infants;
        }
    }

    function savePassenger() {
        const total = adults + infants;
        document.getElementById('passenger_display').textContent = total + ' Penumpang';
        document.getElementById('passenger_badge').textContent = total > 1 ? total + ' org' : 'Atur';
        closePassengerModal();
    }

    // ===== TOGGLE RETURN =====
    function toggleReturn() {
        const isChecked = document.getElementById('is_return').checked;
        document.getElementById('return_date').style.display = isChecked ? 'block' : 'none';
        if (!isChecked) {
            document.getElementById('return_date').value = '';
        }
    }

    // ===== SEARCH =====
    function searchTrains(e) {
        e.preventDefault();

        const from = document.getElementById('from_station').value;
        const to = document.getElementById('to_station').value;
        const date = document.getElementById('departure_date').value;
        const isReturn = document.getElementById('is_return').checked;
        const returnDate = document.getElementById('return_date').value;

        if (!from || !to) {
            alert('Silakan pilih stasiun asal dan tujuan!');
            return;
        }

        // Simulasi hasil pencarian
        const results = [
            {
                name: 'Harina 96',
                route: from + ' → ' + to,
                departure: date + ' 21:35',
                arrival: date + ' 08:25+1',
                duration: '10j 50m',
                price: 370000,
                seats: 12,
                class: 'Ekonomi',
                subclass: 'CC',
                hot: true,
                best: true
            },
            {
                name: 'Argo Bromo',
                route: from + ' → ' + to,
                departure: date + ' 07:00',
                arrival: date + ' 12:30',
                duration: '5j 30m',
                price: 450000,
                seats: 8,
                class: 'Bisnis',
                subclass: 'BB',
                hot: false,
                best: false
            },
            {
                name: 'Sembrani',
                route: from + ' → ' + to,
                departure: date + ' 08:00',
                arrival: date + ' 16:30',
                duration: '8j 30m',
                price: 520000,
                seats: 5,
                class: 'Executive',
                subclass: 'AA',
                hot: false,
                best: false
            }
        ];

        renderResults(results);
    }

    function renderResults(results) {
        const container = document.getElementById('trainResults');
        const countEl = document.getElementById('resultCount');

        if (!results || results.length === 0) {
            container.innerHTML = `
                <div class="empty-state">
                    <i class="fa-regular fa-train"></i>
                    <p>Tidak ada kereta ditemukan</p>
                </div>
            `;
            countEl.textContent = '0 hasil ditemukan';
            return;
        }

        countEl.textContent = results.length + ' hasil ditemukan';

        let html = '';
        results.forEach((train, index) => {
            html += `
                <div class="train-card" onclick="window.location.href='/trains/${index}'">
                    <div class="train-icon">
                        <i class="fa-solid fa-train"></i>
                        <span class="class-label">${train.class}</span>
                    </div>
                    <div class="train-info">
                        <div class="name">
                            ${train.name}
                            ${train.hot ? '<span class="hot-badge">Cepat habis!</span>' : ''}
                            ${train.best ? '<span class="best-badge">Terlaris #1</span>' : ''}
                            ${train.subclass ? `<span style="font-size:12px; color:#94a3b8; font-weight:400;"> (${train.subclass})</span>` : ''}
                        </div>
                        <div class="route">${train.route}</div>
                        <div class="time-detail">
                            <span>${train.departure}</span>
                            <span class="duration">${train.duration}</span>
                            <span>${train.arrival}</span>
                        </div>
                    </div>
                    <div class="train-price">
                        <div class="price">Rp ${train.price.toLocaleString('id-ID')}</div>
                        <div class="seats">${train.seats} kursi tersisa</div>
                       <a href="/trains/${index}" class="btn-pilih" onclick="event.stopPropagation();">Lihat Detail</a>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
    }

    // ===== FILTER =====
    function filterResults(type) {
        document.querySelectorAll('.filters button').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        // Filter logic...
    }
</script>
@endsection