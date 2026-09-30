@extends('layouts.app')

@section('content')
<style>
    .villa-search-wrapper { max-width: 850px; margin: 40px auto; padding: 0 16px; }
    .search-card { background: #fff; border-radius: 16px; padding: 28px; box-shadow: 0 8px 24px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; }
    .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; align-items: end; margin-bottom: 16px; }
    .form-label { font-size: 12px; font-weight: 700; color: #1e293b; display: block; margin-bottom: 4px; }
    
    /* Styling tombol destinasi */
    .input-group button, .input-group input { 
        width: 100%; padding: 12px 14px; border: 2px solid #e2e8f0; border-radius: 10px; 
        font-size: 14px; background: #fff; transition: 0.2s; text-align: left; cursor: pointer; 
        color: #1e293b;
    }
    .input-group button:focus, .input-group input:focus { border-color: #1e3a5f; box-shadow: 0 0 0 3px rgba(30,58,95,0.1); outline: none; }
    
    .btn-cari-villa { width: 100%; background: #1e3a5f; color: white; padding: 12px 24px; border-radius: 10px; border: none; font-weight: 700; cursor: pointer; transition: 0.2s; font-size: 16px;}
    .btn-cari-villa:hover { background: #2d5a87; }

    /* MODAL POPUP DESTINASI (Persis Screenshot) */
    .modal-overlay { position: fixed; top:0; left:0; width:100vw; height:100vh; background: rgba(0,0,0,0.4); z-index: 999; display: none; align-items: flex-start; justify-content: center; padding-top: 40px; }
    .modal-box { background: #fff; width: 90%; max-width: 480px; border-radius: 20px; padding: 20px; position: relative; box-shadow: 0 10px 40px rgba(0,0,0,0.15); max-height: 80vh; overflow-y: auto;}
    .modal-close { position: absolute; top: 16px; right: 16px; background: #f1f5f9; border: none; border-radius: 50%; width: 32px; height: 32px; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.2s; }
    .modal-close:hover { background: #e2e8f0; }
    .modal-title { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 16px; }
    
    .search-input-wrap { position: relative; margin-bottom: 16px; }
    .search-input-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 16px; }
    .search-input-wrap input { width: 100%; padding: 12px 12px 12px 44px; border-radius: 12px; border: none; background: #f1f5f9; font-size: 15px; outline: none; transition: 0.2s; }
    .search-input-wrap input:focus { background: #e2e8f0; }
    
    .nearby-btn { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border: none; background: transparent; cursor: pointer; border-radius: 10px; font-weight: 600; font-size: 14px; width: 100%; transition: 0.2s; }
    .nearby-btn:hover { background: #f1f5f9; }
    .nearby-btn i { color: #1e3a5f; font-size: 18px; }

    .divider { border-top: 1px solid #e2e8f0; margin: 16px 0; }
    
    .history-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
    .history-title { font-weight: 700; font-size: 14px; color: #0f172a; }
    .history-clear { background: none; border: none; color: #2563eb; font-weight: 600; font-size: 13px; cursor: pointer; }
    
    .history-list { display: flex; flex-direction: column; gap: 8px; }
    .history-item { display: flex; justify-content: space-between; align-items: center; padding: 8px 10px; cursor: pointer; border-radius: 10px; transition: 0.2s; }
    .history-item:hover { background: #f8fafc; }
    .history-left { display: flex; align-items: center; gap: 12px; }
    .history-icon { width: 32px; height: 32px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #1e293b; }
    .history-text { display: flex; flex-direction: column; line-height: 1.3; }
    .city-name { font-weight: 600; font-size: 14px; color: #0f172a; }
    .city-region { font-size: 12px; color: #64748b; }
    .city-tag { background: #f1f5f9; padding: 2px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; color: #475569; }
    
    @media (max-width: 768px) { .grid-3 { grid-template-columns: 1fr 1fr; } }
</style>

<div class="villa-search-wrapper">
    <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
        <a href="/" style="color:#94a3b8; font-size:20px;"><i class="fa-solid fa-arrow-left"></i></a>
        <h1 style="font-size:24px; font-weight:700; margin:0;">🏡 Cari Villa & Apartemen</h1>
    </div>

    <div class="search-card">
        <form action="{{ route('villas.search') }}" method="GET">
            
            <!-- DESTINASI INPUT (SEKARANG BERUPA TOMBOL) -->
            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label">MAU NGINEP DI MANA?</label>
                <div class="input-group">
                    <button type="button" id="villaDestBtn" onclick="openVillaDestModal()">
                        Kota, destinasi, atau nama villa
                    </button>
                    <!-- HIDDEN INPUT UNTUK MENGIRIM DATA -->
                    <input type="hidden" name="destination" id="villaDestHidden" value="">
                </div>
            </div>

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
                    <select name="guests" style="width:100%; padding:12px 14px; border:2px solid #e2e8f0; border-radius:10px; background:white;">
                        <option value="1">1 Kamar, 1 Dewasa</option>
                        <option value="2">1 Kamar, 2 Dewasa</option>
                        <option value="3">2 Kamar, 3 Dewasa</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn-cari-villa"><i class="fa-solid fa-magnifying-glass"></i> Cari Villa</button>
        </form>
    </div>
</div>

<!-- MODAL DESTINASI -->
<div id="villaDestModal" class="modal-overlay">
    <div class="modal-box">
        <button class="modal-close" onclick="closeVillaDestModal()">×</button>
        <div class="modal-title">Mau nginep di mana?</div>
        
        <!-- Kolom Pencarian -->
        <div class="search-input-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Masukkan nama akomodasi, destinasi, ...">
        </div>

        <!-- Lokasi Terdekat -->
        <button class="nearby-btn">
            <i class="fa-solid fa-location-dot"></i> Di dekat kamu
        </button>

        <div class="divider"></div>

        <!-- Pencarian Terakhir -->
        <div class="history-header">
            <span class="history-title">Pencarian Terakhir</span>
            <button class="history-clear">Hapus semua</button>
        </div>

        <div class="history-list">
            <div class="history-item" onclick="selectVillaDest('Jakarta')">
                <div class="history-left">
                    <div class="history-icon"><i class="fa-solid fa-globe"></i></div>
                    <div class="history-text">
                        <span class="city-name">Jakarta</span>
                        <span class="city-region">Indonesia</span>
                    </div>
                </div>
                <span class="city-tag">Region</span>
            </div>
            <div class="history-item" onclick="selectVillaDest('Bali')">
                <div class="history-left">
                    <div class="history-icon"><i class="fa-solid fa-globe"></i></div>
                    <div class="history-text">
                        <span class="city-name">Bali</span>
                        <span class="city-region">Indonesia</span>
                    </div>
                </div>
                <span class="city-tag">Region</span>
            </div>
            <div class="history-item" onclick="selectVillaDest('Bandung')">
                <div class="history-left">
                    <div class="history-icon"><i class="fa-solid fa-globe"></i></div>
                    <div class="history-text">
                        <span class="city-name">Bandung</span>
                        <span class="city-region">Indonesia</span>
                    </div>
                </div>
                <span class="city-tag">Region</span>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi Membuka dan Menutup Modal
    function openVillaDestModal() { document.getElementById('villaDestModal').style.display = 'flex'; }
    function closeVillaDestModal() { document.getElementById('villaDestModal').style.display = 'none'; }

    // Saat user mengklik salah satu kota di list
    function selectVillaDest(city) {
        // Ubah text di tombol utama form
        document.getElementById('villaDestBtn').innerText = city;
        document.getElementById('villaDestBtn').style.color = '#0f172a';
        document.getElementById('villaDestBtn').style.fontWeight = '600';
        
        // Set nilai hidden input agar terbaca oleh Laravel saat disubmit
        document.getElementById('villaDestHidden').value = city;
        
        // Tutup modal
        closeVillaDestModal();
    }

    // Tutup modal jika user mengklik area luar modal
    window.onclick = function(event) {
        let modal = document.getElementById('villaDestModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endsection