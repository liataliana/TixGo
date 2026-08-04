@extends('layouts.app')

@section('content')
<style>
    .page-header { display:flex; align-items:center; gap:16px; margin-bottom:24px; }
    .page-header h1 { font-size:26px; font-weight:900; color:#0f172a; margin:0; }
    .back-btn { color:#94a3b8; font-size:20px; text-decoration:none; transition:0.2s; }
    .back-btn:hover { color:#a855f7; }

    .detail-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }

    .detail-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }
    .detail-card .train-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 16px;
        margin-bottom: 16px;
    }
    .detail-card .train-header h2 {
        font-size: 24px;
        font-weight: 900;
        color: #0f172a;
        margin: 0;
    }
    .detail-card .train-header .price-tag {
        font-size: 28px;
        font-weight: 900;
        color: #a855f7;
        background: #a855f710;
        padding: 4px 20px;
        border-radius: 40px;
    }
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px 40px;
        margin-bottom: 24px;
    }
    .detail-item .label {
        font-size: 12px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .detail-item .value {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-top: 2px;
    }
    .detail-item .value .duration {
        font-size: 14px;
        font-weight: 400;
        color: #64748b;
        margin-left: 8px;
    }
    .detail-item .value .subclass {
        font-size: 14px;
        font-weight: 400;
        color: #94a3b8;
    }

    .btn-book {
        display: inline-block;
        padding: 14px 40px;
        background: #a855f7;
        color: white;
        font-weight: 700;
        font-size: 16px;
        border-radius: 12px;
        text-decoration: none;
        transition: 0.2s;
        text-align: center;
        width: 100%;
        border: none;
        cursor: pointer;
    }
    .btn-book:hover {
        background: #9333ea;
        box-shadow: 0 4px 16px rgba(168,85,247,0.3);
    }

    .refund-banner {
        background: #fef3c7;
        border: 1px solid #fcd34d;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 20px;
    }
    .refund-banner p {
        margin: 0;
        font-size: 14px;
        color: #92400e;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .refund-banner p i {
        font-size: 18px;
    }

    .summary-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        height: fit-content;
        position: sticky;
        top: 20px;
    }
    .summary-card h3 {
        font-weight: 700;
        font-size: 18px;
        color: #0f172a;
        margin: 0 0 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e2e8f0;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        font-size: 14px;
    }
    .summary-row .label {
        color: #64748b;
    }
    .summary-row .value {
        font-weight: 600;
        color: #0f172a;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-top: 2px solid #e2e8f0;
        margin-top: 8px;
        font-size: 18px;
        font-weight: 900;
        color: #a855f7;
    }

    @media (max-width: 992px) {
        .detail-container { grid-template-columns: 1fr; }
        .summary-card { position: static; }
    }
    @media (max-width: 640px) {
        .detail-grid { grid-template-columns: 1fr; }
        .detail-card .train-header { flex-direction: column; align-items: flex-start; gap: 12px; }
    }
</style>

<div class="max-w-7xl mx-auto px-4 py-4">
    <div class="page-header">
        <a href="{{ route('trains.index') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
        <h1>Detail Tiket Kereta</h1>
    </div>

    <div class="detail-container">
        {{-- DETAIL --}}
        <div class="detail-card">
            <div class="train-header">
                <h2>🚆 Harina 96</h2>
                <span class="price-tag">Rp 370.000</span>
            </div>

            <div class="refund-banner">
                <p><i class="fa-regular fa-clock"></i> Cepat habis! Terlaris #1 di kelas ini</p>
            </div>

            <div class="detail-grid">
                <div class="detail-item">
                    <span class="label">Rute</span>
                    <span class="value">Bandung (BD) → Surabaya Pasarturi (SBI)</span>
                </div>
                <div class="detail-item">
                    <span class="label">Kelas</span>
                    <span class="value">Ekonomi <span class="subclass">(Subclass CC)</span></span>
                </div>
                <div class="detail-item">
                    <span class="label">Keberangkatan</span>
                    <span class="value">02 Agt 2026, 21:35</span>
                </div>
                <div class="detail-item">
                    <span class="label">Kedatangan</span>
                    <span class="value">03 Agt 2026, 08:25 <span class="duration">(10j 50m)</span></span>
                </div>
                <div class="detail-item">
                    <span class="label">Kursi Tersedia</span>
                    <span class="value" style="color:#22c55e;">12 kursi</span>
                </div>
                <div class="detail-item">
                    <span class="label">Operator</span>
                    <span class="value">PT Kereta Api Indonesia</span>
                </div>
            </div>

            <a href="{{ route('bookings.create.train') }}" class="btn-book">
                <i class="fa-regular fa-pen-to-square"></i> Lanjutkan Pemesanan
            </a>
        </div>

        {{-- SUMMARY --}}
        <div class="summary-card">
            <h3>Ringkasan</h3>
            <div class="summary-row">
                <span class="label">Kereta</span>
                <span class="value">Harina 96</span>
            </div>
            <div class="summary-row">
                <span class="label">Rute</span>
                <span class="value">BD → SBI</span>
            </div>
            <div class="summary-row">
                <span class="label">Tanggal</span>
                <span class="value">02 Agt 2026</span>
            </div>
            <div class="summary-row">
                <span class="label">Kelas</span>
                <span class="value">Ekonomi (CC)</span>
            </div>
            <div class="summary-row">
                <span class="label">Jumlah Penumpang</span>
                <span class="value">1</span>
            </div>
            <div class="summary-total">
                <span>Total</span>
                <span>Rp 370.000</span>
            </div>
            <div style="margin-top:12px; font-size:12px; color:#94a3b8; text-align:center;">
                <i class="fa-regular fa-circle-check" style="color:#22c55e;"></i> Harga sudah termasuk pajak
            </div>
        </div>
    </div>
</div>
@endsection