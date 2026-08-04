@extends('layouts.app')

@section('content')
<style>
    .bus-search-wrapper { max-width: 1000px; margin: 40px auto; padding: 0 16px; }
    .search-card { background: #fff; border-radius: 16px; padding: 28px; box-shadow: 0 8px 24px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; }
    
    .form-label { font-size: 12px; font-weight: 700; color: #1e293b; display: block; margin-bottom: 4px; }
    .bus-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; align-items: end; margin-bottom: 16px; }
    
    .input-group button, .input-group input { 
        width: 100%; padding: 12px 14px; border: 2px solid #e2e8f0; border-radius: 10px; 
        font-size: 14px; background: #fff; transition: 0.2s; text-align: left; cursor: pointer; 
        color: #1e293b; font-weight: 600;
    }
    .input-group button:focus, .input-group input:focus { border-color: #f97316; box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1); outline: none; }
    
    .bus-bottom-grid { display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 12px; align-items: end; }
    
    .btn-cari-bus { width: 100%; background: #f97316; color: white; padding: 12px 24px; border-radius: 10px; border: none; font-weight: 700; cursor: pointer; transition: 0.2s; font-size: 16px;}
    .btn-cari-bus:hover { background: #ea580c; }

    /* Modal Destinasi */
    .modal-overlay { position: fixed; top:0; left:0; width:100vw; height:100vh; background: rgba(0,0,0,0.4); z-index: 999; display: none; align-items: center; justify-content: center; }
    .modal-box { background: #fff; width: 90%; max-width: 500px; border-radius: 20px; padding: 24px; position: relative; max-height: 80vh; overflow-y: auto; }
    .modal-close { position: absolute; top: 16px; right: 16px; background: none; border: none; font-size: 24px; cursor: pointer; }
    .modal-title { font-size: 20px; font-weight: 700; margin-bottom: 16px; }
    .modal-input { width: 100%; padding: 12px 16px; border-radius: 30px; border: none; background: #f1f5f9; font-size: 15px; outline: none; margin-bottom: 16px;}
    .city-pill-group { display: flex; flex-wrap: wrap; gap: 10px; }
    .city-pill { padding: 8px 16px; border: 1px solid #e2e8f0; border-radius: 20px; cursor: pointer; font-weight: 600; font-size: 14px; transition:0.2s; }
    .city-pill:hover { background: #f1f5f9; border-color: #f97316; }

    /* Modal Tanggal */
    .date-option { display: flex; gap: 10px; margin-bottom: 16px; }
    .date-tab { flex:1; padding: 10px; text-align: center; border: 1px solid #e2e8f0; border-radius: 10px; cursor: pointer; transition:0.2s; font-weight: 600;}
    .date-tab.active { border-color: #f97316; background: #fff7ed; color: #f97316; }

    /* Modal Kursi */
    .passenger-row { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; }
    .counter-wrap { display: flex; align-items: center; gap: 12px; }
    .counter-btn { width: 32px; height: 32px; border-radius: 50%; border: 1px solid #e2e8f0; background: #fff; cursor: pointer; font-weight: 700; }
    .save-btn { width: 100%; background: #f97316; color: white; padding: 12px; border: none; border-radius: 10px; font-weight: 700; font-size: 16px; cursor: pointer; margin-top: 16px; }
    .save-btn:hover { background: #ea580c; }
    
    @media (max-width: 768px) { .bus-grid { grid-template-columns: 1fr; } .bus-bottom-grid { grid-template-columns: 1fr 1fr; } }
</style>

<div class="bus-search-wrapper">
    <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
        <a href="/" style="color:#94a3b8; font-size:20px;"><i class="fa-solid fa-arrow-left"></i></a>
        <h1 style="font-size:24px; font-weight:700; margin:0;">🚌 Cari Bus & Travel</h1>
    </div>

    <div class="search-card">
        <form action="{{ route('buses.search') }}" method="GET">
            <div class="bus-grid">
                <!-- TITIK NAIK -->
                <div class="form-group">
                    <label class="form-label">TITIK NAIK</label>
                    <button type="button" class="input-group" onclick="openBusModal('naikModal')" id="naikBtn" style="color:#64748b; font-weight:400;">Kota atau terminal</button>
                    <input type="hidden" name="origin" id="naikVal">
                </div>
                <!-- TITIK TURUN -->
                <div class="form-group">
                    <label class="form-label">TITIK TURUN</label>
                    <button type="button" class="input-group" onclick="openBusModal('turunModal')" id="turunBtn" style="color:#64748b; font-weight:400;">Kota atau terminal</button>
                    <input type="hidden" name="destination" id="turunVal">
                </div>
            </div>

            <div class="bus-bottom-grid">
                <!-- TANGGAL BERANGKAT -->
                <div class="form-group">
                    <label class="form-label">TANGGAL BERANGKAT</label>
                    <button type="button" class="input-group" onclick="openBusModal('tanggalModal')" id="dateBtn">Pilih Tanggal</button>
                    <input type="hidden" name="date" id="dateVal">
                </div>
                <!-- TANGGAL PULANG -->
                <div class="form-group">
                    <label class="form-label">TANGGAL PULANG</label>
                    <input type="date" name="return_date" style="width:100%; padding:12px 14px; border:2px solid #e2e8f0; border-radius:10px; color:#1e293b; font-weight:600;">
                </div>
                <!-- KURSI -->
                <div class="form-group">
                    <label class="form-label">KURSI</label>
                    <button type="button" class="input-group" onclick="openBusModal('kursiModal')" id="kursiBtn">1 Kursi</button>
                    <input type="hidden" name="seats" id="kursiVal" value="1">
                </div>
                <!-- BUTTON CARI -->
                <div>
                    <button type="submit" class="btn-cari-bus"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 1: PILIH KOTA (NAIK) -->
<div id="naikModal" class="modal-overlay">
    <div class="modal-box">
        <button class="modal-close" onclick="closeBusModal('naikModal')">×</button>
        <div class="modal-title">Kota Keberangkatan</div>
        <input type="text" class="modal-input" placeholder="Cari titik naik...">
        <div class="city-pill-group">
            <div class="city-pill" onclick="selectBusCity('naik', 'Jakarta')">Jakarta</div>
            <div class="city-pill" onclick="selectBusCity('naik', 'Bandung')">Bandung</div>
            <div class="city-pill" onclick="selectBusCity('naik', 'Surabaya')">Surabaya</div>
            <div class="city-pill" onclick="selectBusCity('naik', 'Yogyakarta')">Yogyakarta</div>
        </div>
    </div>
</div>

<!-- MODAL 2: PILIH KOTA (TURUN) -->
<div id="turunModal" class="modal-overlay">
    <div class="modal-box">
        <button class="modal-close" onclick="closeBusModal('turunModal')">×</button>
        <div class="modal-title">Kota Kedatangan</div>
        <input type="text" class="modal-input" placeholder="Cari titik turun...">
        <div class="city-pill-group">
            <div class="city-pill" onclick="selectBusCity('turun', 'Bandung')">Bandung</div>
            <div class="city-pill" onclick="selectBusCity('turun', 'Jakarta')">Jakarta</div>
            <div class="city-pill" onclick="selectBusCity('turun', 'Surabaya')">Surabaya</div>
            <div class="city-pill" onclick="selectBusCity('turun', 'Malang')">Malang</div>
        </div>
    </div>
</div>

<!-- MODAL 3: ATUR TANGGAL -->
<div id="tanggalModal" class="modal-overlay">
    <div class="modal-box">
        <button class="modal-close" onclick="closeBusModal('tanggalModal')">×</button>
        <div class="modal-title">Atur Tanggal</div>
        <div class="date-option">
            <div class="date-tab active" onclick="selectBusDate('Sekali jalan')">Sekali jalan</div>
            <div class="date-tab" onclick="selectBusDate('Pulang pergi')">Pulang pergi</div>
        </div>
        <div style="text-align:center; padding:20px; color:#64748b;">
            <p>📅 Pilih tanggal di kalender (Simulasi)</p>
            <div class="city-pill-group" style="justify-content:center;">
                <div class="city-pill" onclick="selectBusDate('02 Agt 2026')">Hari Ini (2 Agt)</div>
                <div class="city-pill" onclick="selectBusDate('03 Agt 2026')">Besok (3 Agt)</div>
            </div>
        </div>
        <button class="save-btn" onclick="closeBusModal('tanggalModal')">Simpan Tanggal</button>
    </div>
</div>

<!-- MODAL 4: ATUR KURSI -->
<div id="kursiModal" class="modal-overlay">
    <div class="modal-box">
        <button class="modal-close" onclick="closeBusModal('kursiModal')">×</button>
        <div class="modal-title">Atur Jumlah Kursi</div>
        <div style="font-size:13px; color:#64748b; margin-bottom:16px;">Anak di atas 2 tahun harus memiliki tiket.</div>
        <div class="passenger-row">
            <div class="passenger-label" style="font-weight:600;">Kursi</div>
            <div class="counter-wrap">
                <button class="counter-btn" onclick="updateBusSeats(-1)">-</button>
                <span class="counter-val" id="kursiDisplay" style="font-weight:700; width:20px; text-align:center;">1</span>
                <button class="counter-btn" onclick="updateBusSeats(1)">+</button>
            </div>
        </div>
        <button class="save-btn" onclick="closeBusModal('kursiModal')">Simpan</button>
    </div>
</div>

<script>
    // Buka/Tutup Modal
    function openBusModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeBusModal(id) { document.getElementById(id).style.display = 'none'; }

    // Pilih Kota Naik/Turun
    function selectBusCity(type, city) {
        let btnId = (type === 'naik') ? 'naikBtn' : 'turunBtn';
        let valId = (type === 'naik') ? 'naikVal' : 'turunVal';
        document.getElementById(btnId).innerText = city;
        document.getElementById(btnId).style.color = '#1e293b';
        document.getElementById(valId).value = city;
        closeBusModal((type === 'naik') ? 'naikModal' : 'turunModal');
    }

    // Pilih Tanggal
    function selectBusDate(date) {
        document.getElementById('dateBtn').innerText = date;
        document.getElementById('dateVal').value = date;
        closeBusModal('tanggalModal');
    }

    // Atur Kursi
    function updateBusSeats(change) {
        let el = document.getElementById('kursiDisplay');
        let valEl = document.getElementById('kursiVal');
        let current = parseInt(el.innerText);
        let newVal = current + change;
        if(newVal < 1) return;
        el.innerText = newVal;
        valEl.value = newVal;
        document.getElementById('kursiBtn').innerText = newVal + ' Kursi';
    }
</script>
@endsection