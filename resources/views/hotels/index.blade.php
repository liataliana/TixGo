@extends('layouts.app')

@section('content')
<style>
    .hotel-search-wrapper { max-width: 800px; margin: 40px auto; padding: 0 16px; }
    .search-card { background: #fff; border-radius: 16px; padding: 28px; box-shadow: 0 8px 24px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; }
    .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; align-items: end; margin-bottom: 16px; }
    .form-label { font-size: 12px; font-weight: 700; color: #1e293b; display: block; margin-bottom: 4px; }
    
    .input-group { position: relative; }
    .input-group button, .input-group input { 
        width: 100%; padding: 12px 14px; border: 2px solid #e2e8f0; border-radius: 10px; 
        font-size: 14px; background: #fff; transition: 0.2s; text-align: left; cursor: pointer; 
    }
    .input-group button:focus, .input-group input:focus { border-color: #1e3a5f; box-shadow: 0 0 0 3px rgba(30,58,95,0.1); outline: none; }
    
    .btn-cari-hotel { width: 100%; background: #1e3a5f; color: white; padding: 12px 24px; border-radius: 10px; border: none; font-weight: 700; cursor: pointer; transition: 0.2s; font-size: 16px;}
    .btn-cari-hotel:hover { background: #2d5a87; }

    /* Modal - Sama kaya sebelumnya */
    .modal-overlay { position: fixed; top:0; left:0; width:100vw; height:100vh; background: rgba(0,0,0,0.5); z-index: 999; display: none; align-items: center; justify-content: center; }
    .modal-box { background: #fff; width: 90%; max-width: 550px; border-radius: 16px; padding: 24px; max-height: 80vh; overflow-y: auto; position: relative; }
    .modal-close { position: absolute; top: 16px; right: 16px; background: none; border: none; font-size: 24px; cursor: pointer; }
    .modal-title { font-size: 18px; font-weight: 700; margin-bottom: 16px; }
    
    .city-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }
    .city-btn { padding: 10px; border: 1px solid #e2e8f0; background: #f8fafc; border-radius: 10px; cursor: pointer; transition: 0.2s; text-align: center; font-weight: 600; font-size: 13px; }
    .city-btn:hover { background: #e2e8f0; }
    
    /* Guest & Room Modal */
    .guest-row { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #f1f5f9; }
    .guest-label { font-weight: 600; font-size: 14px; }
    .counter-wrap { display: flex; align-items: center; gap: 12px; }
    .counter-btn { width: 32px; height: 32px; border-radius: 50%; border: 1px solid #e2e8f0; background: #fff; cursor: pointer; font-weight: 700; }
    
    @media (max-width: 768px) { .grid-3 { grid-template-columns: 1fr 1fr; } }
</style>

<div class="hotel-search-wrapper">
    <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
        <a href="/" class="back-btn"><i class="fa-solid fa-arrow-left" style="color:#94a3b8; font-size:20px;"></i></a>
        <h1 style="font-size:24px; font-weight:700; margin:0;">🏨 Cari Hotel</h1>
    </div>

    <div class="search-card">
        <form action="{{ route('hotels.search') }}" method="GET">
            
            <!-- Baris 1: Destinasi -->
            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label">MAU NGINEP DI MANA?</label>
                <button type="button" class="input-group" onclick="openHotelModal('destinasiModal')" id="destBtn" style="text-align:left; color:#64748b;">
                    Kota, destinasi, atau nama hotel
                </button>
                <input type="hidden" name="destination" id="destVal">
            </div>

            <!-- Baris 2: Tanggal Check-in / Check-out -->
            <div class="grid-3">
                <div class="form-group">
                    <label class="form-label">CHECK-IN</label>
                    <input type="date" name="check_in" value="{{ date('Y-m-d') }}" style="width:100%; padding:12px 14px; border:2px solid #e2e8f0; border-radius:10px;">
                </div>
                <div class="form-group">
                    <label class="form-label">CHECK-OUT</label>
                    <input type="date" name="check_out" value="{{ date('Y-m-d', strtotime('+1 day')) }}" style="width:100%; padding:12px 14px; border:2px solid #e2e8f0; border-radius:10px;">
                </div>
                <div class="form-group">
                    <label class="form-label">KAMAR & TAMU</label>
                    <button type="button" class="input-group" onclick="openHotelModal('guestModal')" id="guestBtn" style="color:#1e293b; font-weight:600;">
                        1 Kamar, 1 Dewasa
                    </button>
                    <input type="hidden" name="rooms" id="roomsVal" value="1">
                    <input type="hidden" name="adults" id="adultsValH" value="1">
                    <input type="hidden" name="children" id="childrenValH" value="0">
                </div>
            </div>

            <!-- Tombol Cari -->
            <button type="submit" class="btn-cari-hotel"><i class="fa-solid fa-magnifying-glass"></i> Cari Hotel</button>
        </form>
    </div>
</div>

<!-- MODAL DESTINASI -->
<div id="destinasiModal" class="modal-overlay">
    <div class="modal-box">
        <button class="modal-close" onclick="closeHotelModal('destinasiModal')">×</button>
        <div class="modal-title">Mau nginep di mana?</div>
        <div style="margin-bottom:12px;">Destinasi Populer</div>
        <div class="city-grid">
            <div class="city-btn" onclick="selectHotelCity('Bali')">Bali</div>
            <div class="city-btn" onclick="selectHotelCity('Jakarta')">Jakarta</div>
            <div class="city-btn" onclick="selectHotelCity('Yogyakarta')">Yogyakarta</div>
            <div class="city-btn" onclick="selectHotelCity('Bandung')">Bandung</div>
            <div class="city-btn" onclick="selectHotelCity('Surabaya')">Surabaya</div>
            <div class="city-btn" onclick="selectHotelCity('Lombok')">Lombok</div>
        </div>
    </div>
</div>

<!-- MODAL KAMAR & TAMU -->
<div id="guestModal" class="modal-overlay">
    <div class="modal-box">
        <button class="modal-close" onclick="closeHotelModal('guestModal')">×</button>
        <div class="modal-title">Atur Kamar & Tamu</div>
        
        <div class="guest-row">
            <div><div class="guest-label">Kamar</div></div>
            <div class="counter-wrap">
                <button class="counter-btn" onclick="updateHotelGuests('rooms', -1)">-</button>
                <span class="counter-val" id="roomsDisplay">1</span>
                <button class="counter-btn" onclick="updateHotelGuests('rooms', 1)">+</button>
            </div>
        </div>
        <div class="guest-row">
            <div><div class="guest-label">Dewasa</div><div style="font-size:12px; color:#64748b;">12+ tahun</div></div>
            <div class="counter-wrap">
                <button class="counter-btn" onclick="updateHotelGuests('adults', -1)">-</button>
                <span class="counter-val" id="adultsDisplayH">1</span>
                <button class="counter-btn" onclick="updateHotelGuests('adults', 1)">+</button>
            </div>
        </div>
        <div class="guest-row">
            <div><div class="guest-label">Anak</div><div style="font-size:12px; color:#64748b;">2-11 tahun</div></div>
            <div class="counter-wrap">
                <button class="counter-btn" onclick="updateHotelGuests('children', -1)">-</button>
                <span class="counter-val" id="childrenDisplayH">0</span>
                <button class="counter-btn" onclick="updateHotelGuests('children', 1)">+</button>
            </div>
        </div>

        <button onclick="closeHotelModal('guestModal')" style="width:100%; margin-top:20px; padding:12px; background:#1e3a5f; color:#fff; border:none; border-radius:8px; font-weight:700; cursor:pointer;">Simpan</button>
    </div>
</div>

<script>
    function openHotelModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeHotelModal(id) { document.getElementById(id).style.display = 'none'; }

    // Pilih Destinasi
    function selectHotelCity(city) {
        document.getElementById('destBtn').innerText = city;
        document.getElementById('destBtn').style.color = '#1e293b';
        document.getElementById('destVal').value = city;
        closeHotelModal('destinasiModal');
    }

    // Counter Kamar & Tamu
    function updateHotelGuests(type, change) {
        let displayMap = { rooms: 'roomsDisplay', adults: 'adultsDisplayH', children: 'childrenDisplayH' };
        let valMap = { rooms: 'roomsVal', adults: 'adultsValH', children: 'childrenValH' };
        
        let el = document.getElementById(displayMap[type]);
        let valEl = document.getElementById(valMap[type]);
        let current = parseInt(el.innerText);
        let newVal = current + change;

        if(type === 'rooms' && newVal < 1) return; // Kamar min 1
        if(type === 'adults' && newVal < 1) return; // Dewasa min 1
        if(type === 'children' && newVal < 0) return; // Anak min 0

        el.innerText = newVal;
        valEl.value = newVal;
        
        // Update text di tombol
        let rooms = parseInt(document.getElementById('roomsDisplay').innerText);
        let adults = parseInt(document.getElementById('adultsDisplayH').innerText);
        let children = parseInt(document.getElementById('childrenDisplayH').innerText);
        
        let text = rooms + ' Kamar, ' + adults + ' Dewasa';
        if(children > 0) text += ', ' + children + ' Anak';
        document.getElementById('guestBtn').innerText = text;
    }
</script>
@endsection