@extends('layouts.app')

@section('content')
<style>
    /* CSS Form Pencarian & Modal */
    .flight-search-wrapper { max-width: 900px; margin: 40px auto; padding: 0 16px; }
    .search-card { background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 8px 24px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; }
    .flight-grid { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr auto; gap: 12px; align-items: end; }
    .form-label { font-size: 12px; font-weight: 700; color: #1e293b; display: block; margin-bottom: 4px; }
    .input-group { position: relative; }
    .input-group input, .input-group button { width: 100%; padding: 12px 14px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; background: #fff; transition: 0.2s; text-align: left; cursor: pointer; }
    .input-group input:focus, .input-group button:focus { outline: none; border-color: #1e3a5f; box-shadow: 0 0 0 3px rgba(30,58,95,0.1); }
    .btn-cari { background: #1e3a5f; color: white; padding: 12px 24px; border-radius: 10px; border: none; font-weight: 700; cursor: pointer; width: 100%; transition: 0.2s; }
    .btn-cari:hover { background: #2d5a87; }
    
    /* Modal CSS */
    .modal-overlay { position: fixed; top:0; left:0; width:100vw; height:100vh; background: rgba(0,0,0,0.5); z-index: 999; display: none; align-items: center; justify-content: center; }
    .modal-box { background: #fff; width: 90%; max-width: 500px; border-radius: 16px; padding: 24px; max-height: 80vh; overflow-y: auto; position: relative; }
    .modal-close { position: absolute; top: 16px; right: 16px; background: none; border: none; font-size: 24px; cursor: pointer; }
    .modal-title { font-size: 18px; font-weight: 700; margin-bottom: 16px; }
    .city-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }
    .city-btn { padding: 10px; border: 1px solid #e2e8f0; background: #f8fafc; border-radius: 10px; cursor: pointer; transition: 0.2s; text-align: center; font-weight: 600; font-size: 13px; }
    .city-btn:hover { background: #e2e8f0; border-color: #94a3b8; }

    /* Penumpang & Kelas Modal */
    .passenger-row { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #f1f5f9; }
    .passenger-label { font-weight: 600; font-size: 14px; }
    .counter-wrap { display: flex; align-items: center; gap: 12px; }
    .counter-btn { width: 32px; height: 32px; border-radius: 50%; border: 1px solid #e2e8f0; background: #fff; cursor: pointer; font-weight: 700; }
    .counter-val { font-weight: 700; width: 20px; text-align: center; }
    .class-selector { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 16px; }
    .class-btn { padding: 10px 16px; border: 1px solid #e2e8f0; border-radius: 20px; cursor: pointer; font-size: 13px; font-weight: 600; }
    .class-btn.active { border-color: #1e3a5f; background: #eef2ff; color: #1e3a5f; }

    /* Responsive Form */
    @media (max-width: 768px) { .flight-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 480px) { .flight-grid { grid-template-columns: 1fr; } }
</style>

<div class="flight-search-wrapper">
    <div class="search-card">
        <div style="margin-bottom: 16px; font-weight: 700; font-size: 20px;">✈️ Cari Penerbangan</div>
        <form action="{{ route('flight.search') }}" method="GET" class="flight-grid">
            <!-- DARI -->
            <div class="input-group">
                <label class="form-label">DARI</label>
                <button type="button" onclick="openModal('originModal')" id="originBtn">Kota atau bandara</button>
            </div>
            <!-- KE -->
            <div class="input-group">
                <label class="form-label">KE</label>
                <button type="button" onclick="openModal('destModal')" id="destBtn">Kota atau bandara</button>
            </div>
            <!-- TANGGAL PERGI -->
            <div class="input-group">
                <label class="form-label">PERGI</label>
                <input type="date" name="departure_date" value="{{ date('Y-m-d') }}">
            </div>
            <!-- TANGGAL PULANG -->
            <div class="input-group">
                <label class="form-label">PULANG</label>
                <input type="date" name="return_date">
            </div>
            <!-- TOMBOL CARI -->
            <div>
                <button type="submit" class="btn-cari"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
            </div>
        </form>
        
        <div style="margin-top: 16px; display: flex; gap: 16px; align-items: center; flex-wrap: wrap; border-top: 1px solid #e2e8f0; padding-top: 16px;">
            <div>
                <label class="form-label">PENUMPANG & KELAS</label>
                <button type="button" onclick="openModal('passengerModal')" style="padding:8px 16px; border:1px solid #e2e8f0; border-radius:8px; background:#fff; font-weight:600; width:200px; text-align:left; display:flex; justify-content:space-between;">
                    <span id="passengerDisplay">1 Penumpang</span> <i class="fa-solid fa-chevron-down"></i>
                </button>
                <input type="hidden" name="adults" id="adultsVal" value="1">
                <input type="hidden" name="children" id="childrenVal" value="0">
                <input type="hidden" name="infants" id="infantsVal" value="0">
                <input type="hidden" name="class" id="classVal" value="economy">
            </div>
        </div>
    </div>

    <!-- MODAL 1: PILIH DARI -->
    <div id="originModal" class="modal-overlay">
        <div class="modal-box">
            <button class="modal-close" onclick="closeModal('originModal')">×</button>
            <div class="modal-title">Pilih Kota Asal</div>
            <div class="city-grid">
                <div class="city-btn" onclick="selectCity('originModal', 'Jakarta (CGK)')">Jakarta</div>
                <div class="city-btn" onclick="selectCity('originModal', 'Denpasar (DPS)')">Bali</div>
                <div class="city-btn" onclick="selectCity('originModal', 'Surabaya (SUB)')">Surabaya</div>
                <div class="city-btn" onclick="selectCity('originModal', 'Yogyakarta (YIA)')">Yogyakarta</div>
                <div class="city-btn" onclick="selectCity('originModal', 'Medan (KNO)')">Medan</div>
                <div class="city-btn" onclick="selectCity('originModal', 'Makassar (UPG)')">Makassar</div>
            </div>
        </div>
    </div>

    <!-- MODAL 2: PILIH KE -->
    <div id="destModal" class="modal-overlay">
        <div class="modal-box">
            <button class="modal-close" onclick="closeModal('destModal')">×</button>
            <div class="modal-title">Mau ke Mana?</div>
            <div class="city-grid">
                <div class="city-btn" onclick="selectCity('destModal', 'Denpasar (DPS)')">Bali</div>
                <div class="city-btn" onclick="selectCity('destModal', 'Jakarta (CGK)')">Jakarta</div>
                <div class="city-btn" onclick="selectCity('destModal', 'Surabaya (SUB)')">Surabaya</div>
                <div class="city-btn" onclick="selectCity('destModal', 'Singapore (SIN)')">Singapore</div>
                <div class="city-btn" onclick="selectCity('destModal', 'Kuala Lumpur (KUL)')">Kuala Lumpur</div>
                <div class="city-btn" onclick="selectCity('destModal', 'Makassar (UPG)')">Makassar</div>
            </div>
        </div>
    </div>

    <!-- MODAL 3: PENUMPANG & KELAS -->
    <div id="passengerModal" class="modal-overlay">
        <div class="modal-box">
            <button class="modal-close" onclick="closeModal('passengerModal')">×</button>
            <div class="modal-title">Atur Penumpang & Kelas</div>
            
            <!-- Counter Dewasa -->
            <div class="passenger-row">
                <div><div class="passenger-label">Dewasa</div><div style="font-size:12px; color:#64748b;">12 tahun ke atas</div></div>
                <div class="counter-wrap">
                    <button class="counter-btn" onclick="updatePassenger('adults', -1)">-</button>
                    <span class="counter-val" id="adultsDisplay">1</span>
                    <button class="counter-btn" onclick="updatePassenger('adults', 1)">+</button>
                </div>
            </div>
            <!-- Counter Anak -->
            <div class="passenger-row">
                <div><div class="passenger-label">Anak</div><div style="font-size:12px; color:#64748b;">2 - 11 tahun</div></div>
                <div class="counter-wrap">
                    <button class="counter-btn" onclick="updatePassenger('children', -1)">-</button>
                    <span class="counter-val" id="childrenDisplay">0</span>
                    <button class="counter-btn" onclick="updatePassenger('children', 1)">+</button>
                </div>
            </div>
            <!-- Counter Bayi -->
            <div class="passenger-row">
                <div><div class="passenger-label">Bayi</div><div style="font-size:12px; color:#64748b;">Di bawah 2 tahun</div></div>
                <div class="counter-wrap">
                    <button class="counter-btn" onclick="updatePassenger('infants', -1)">-</button>
                    <span class="counter-val" id="infantsDisplay">0</span>
                    <button class="counter-btn" onclick="updatePassenger('infants', 1)">+</button>
                </div>
            </div>

            <!-- Kelas -->
            <div style="margin-top: 20px;">
                <div class="passenger-label">Pilih Kelas</div>
                <div class="class-selector">
                    <div class="class-btn active" onclick="selectClass(this, 'economy')">Ekonomi</div>
                    <div class="class-btn" onclick="selectClass(this, 'premium')">Premium Ekonomi</div>
                    <div class="class-btn" onclick="selectClass(this, 'business')">Bisnis</div>
                    <div class="class-btn" onclick="selectClass(this, 'first')">First</div>
                </div>
            </div>

            <button onclick="closeModal('passengerModal')" style="width:100%; margin-top:20px; padding:12px; background:#1e3a5f; color:#fff; border:none; border-radius:8px; font-weight:700; cursor:pointer;">Simpan</button>
        </div>
    </div>
</div>

<script>
    // Modal Functions
    function openModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; }

    // Select City
    function selectCity(modalId, cityName) {
        let btnId = (modalId === 'originModal') ? 'originBtn' : 'destBtn';
        document.getElementById(btnId).innerText = cityName;
        closeModal(modalId);
    }

    // Passenger & Class Logic
    function updatePassenger(type, change) {
        let displayMap = { adults: 'adultsDisplay', children: 'childrenDisplay', infants: 'infantsDisplay' };
        let valMap = { adults: 'adultsVal', children: 'childrenVal', infants: 'infantsVal' };
        
        let displayEl = document.getElementById(displayMap[type]);
        let valEl = document.getElementById(valMap[type]);
        let currentVal = parseInt(displayEl.innerText);
        let newVal = currentVal + change;

        if(type === 'adults' && newVal < 1) return; // Dewasa minimal 1
        if(type !== 'adults' && newVal < 0) return; // Anak/Bayi minimal 0

        displayEl.innerText = newVal;
        valEl.value = newVal;
        updatePassengerText();
    }

    function updatePassengerText() {
        let a = parseInt(document.getElementById('adultsDisplay').innerText);
        let c = parseInt(document.getElementById('childrenDisplay').innerText);
        let i = parseInt(document.getElementById('infantsDisplay').innerText);
        let total = a + c + i;
        let text = total + ' Penumpang';
        document.getElementById('passengerDisplay').innerText = text;
    }

    function selectClass(el, className) {
        document.querySelectorAll('.class-btn').forEach(btn => btn.classList.remove('active'));
        el.classList.add('active');
        document.getElementById('classVal').value = className;
    }
</script>
@endsection