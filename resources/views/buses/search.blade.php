@extends('layouts.app')

@section('content')
<style>
    .bus-result-wrapper { max-width: 900px; margin: 30px auto; padding: 0 16px; }
    
    /* Header Ringkasan Pencarian (Persis Tiket.com) */
    .summary-bar {
        background: #fff;
        padding: 12px 20px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    .summary-item { display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 600; color: #0f172a; }
    .summary-item i { color: #94a3b8; }
    .summary-divider { width: 1px; height: 24px; background: #e2e8f0; }

    /* Filter Bar (Tombol-tombol kecil di atas) */
    .filter-bar { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; }
    .filter-tag {
        padding: 8px 16px;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        background: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
        color: #0f172a;
    }
    .filter-tag:hover { border-color: #1e3a5f; color: #1e3a5f; }

    /* Kartu Bus Premium */
    .bus-list { display: flex; flex-direction: column; gap: 12px; }
    .bus-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        transition: 0.2s;
    }
    .bus-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        border-color: #cbd5e1;
    }

    /* KOLOM KIRI: Info PO */
    .bus-left { flex: 0 0 220px; display: flex; align-items: center; gap: 14px; }
    .bus-logo {
        width: 48px; height: 48px;
        background: #fff7ed;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; color: #f97316;
    }
    .bus-info h4 {
        font-size: 16px; font-weight: 700;
        margin: 0 0 2px 0; color: #0f172a;
    }
    .bus-info p {
        font-size: 13px; color: #64748b;
        margin: 0;
    }

    /* KOLOM TENGAH: Timeline Keberangkatan */
    .bus-middle {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        padding: 0 20px;
        min-width: 200px;
    }
    .time-group { text-align: center; }
    .time-group .time { font-size: 20px; font-weight: 700; color: #0f172a; display: block; }
    .time-group .station { font-size: 13px; color: #64748b; margin-top: 2px; }
    
    /* Garis Waktu (Timeline) */
    .timeline-wrap {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        padding: 0 10px;
    }
    .timeline-durasi {
        font-size: 12px;
        color: #94a3b8;
        background: #f8fafc;
        padding: 0 8px;
        margin-bottom: 4px;
    }
    .timeline-line {
        width: 100%;
        height: 2px;
        background: #e2e8f0;
        position: relative;
        display: flex;
        justify-content: space-between;
    }
    .timeline-line::before {
        content: '';
        width: 8px; height: 8px;
        background: #cbd5e1; border-radius: 50%;
        position: absolute; top: -3px; left: 0;
    }
    .timeline-line::after {
        content: '';
        width: 8px; height: 8px;
        background: #cbd5e1; border-radius: 50%;
        position: absolute; top: -3px; right: 0;
    }
    .timeline-label {
        font-size: 12px; color: #94a3b8;
        margin-top: 4px;
    }

    /* KOLOM KANAN: Harga & Tombol */
    .bus-right { text-align: right; min-width: 140px; }
    .bus-price { font-size: 22px; font-weight: 700; color: #dc2626; display: block; line-height: 1.2; }
    .bus-seats { font-size: 12px; color: #64748b; display: block; margin: 4px 0 10px 0; }
    
    .btn-booking {
        display: inline-block;
        background: #f97316;
        color: white;
        font-weight: 700;
        font-size: 14px;
        padding: 8px 24px;
        border-radius: 8px;
        text-decoration: none;
        transition: 0.2s;
        border: none;
        cursor: pointer;
    }
    .btn-booking:hover {
        background: #ea580c;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(249, 115, 22, 0.3);
    }

    /* Responsive Mobile */
    @media (max-width: 768px) {
        .bus-card { flex-direction: column; align-items: stretch; text-align: left; padding: 16px; }
        .bus-left { flex: unset; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px; }
        .bus-middle { padding: 12px 0; justify-content: space-between; flex-wrap: nowrap; border-bottom: 1px solid #f1f5f9; }
        .bus-right { text-align: left; padding-top: 12px; display: flex; justify-content: space-between; align-items: center; }
        .summary-divider { display: none; }
        .summary-bar { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="bus-result-wrapper">
    <!-- Header Ringkasan Pencarian (Persis Tiket) -->
    <div class="summary-bar">
        <div class="summary-item">
            <i class="fa-solid fa-location-dot"></i> Jakarta
            <i class="fa-solid fa-arrow-right-arrow-left" style="font-size:12px; margin: 0 4px;"></i>
            <span style="font-weight:400;">Bandung</span>
        </div>
        <div class="summary-divider"></div>
        <div class="summary-item">
            <i class="fa-regular fa-calendar"></i> Sel, 02 Agt 2026
        </div>
        <div class="summary-divider"></div>
        <div class="summary-item">
            1 Kursi, Ekonomi
        </div>
        <button class="btn-booking" style="padding:6px 20px; font-size:13px; margin-left:auto;">
            <i class="fa-solid fa-rotate-right"></i> Cari Ulang
        </button>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <button class="filter-tag"><i class="fa-solid fa-sliders"></i> Filter & Urutkan</button>
        <button class="filter-tag">Keberangkatan Terawal</button>
        <button class="filter-tag">Harga Termurah</button>
        <button class="filter-tag">Kelas Eksekutif</button>
    </div>

    <!-- List Kartu Bus Premium -->
    <div class="bus-list">
        @foreach($buses as $bus)
        <div class="bus-card">
            <!-- Kiri: Logo & Info PO -->
            <div class="bus-left">
                <div class="bus-logo">{{ $bus->logo }}</div>
                <div class="bus-info">
                    <h4>{{ $bus->name }}</h4>
                    <p>{{ $bus->route }}</p>
                </div>
            </div>

            <!-- Tengah: Timeline Jam Berangkat & Tiba -->
            <div class="bus-middle">
                <div class="time-group">
                    <span class="time">08:00</span>
                    <span class="station">Jakarta</span>
                </div>
                
                <div class="timeline-wrap">
                    <span class="timeline-durasi">4j 0m</span>
                    <div class="timeline-line"></div>
                    <span class="timeline-label">Langsung</span>
                </div>

                <div class="time-group">
                    <span class="time">12:00</span>
                    <span class="station">Bandung</span>
                </div>
            </div>

            <!-- Kanan: Harga & Tombol -->
            <div class="bus-right">
                <span class="bus-price">Rp {{ number_format($bus->price, 0, ',', '.') }}</span>
                <span class="bus-seats">{{ $bus->seats_left }} kursi tersisa</span>
                
                <a href="{{ route('bookings.create.train') }}" class="btn-booking">
                    Pilih
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection