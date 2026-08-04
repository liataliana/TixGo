@extends('layouts.app')

@section('content')
<style>
    .page-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }
    .page-header h1 {
        font-size: 26px;
        font-weight: 900;
        color: #0f172a;
        margin: 0;
    }
    .back-btn {
        color: #94a3b8;
        font-size: 20px;
        text-decoration: none;
        transition: 0.2s;
    }
    .back-btn:hover { color: #1e3a5f; }

    .detail-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }
    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }
    .detail-header h2 {
        font-size: 24px;
        font-weight: 900;
        color: #0f172a;
        margin: 0;
    }
    .detail-header .price-tag {
        font-size: 28px;
        font-weight: 900;
        color: #1e3a5f;
        background: #1e3a5f10;
        padding: 4px 20px;
        border-radius: 40px;
    }
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px 40px;
        margin-bottom: 24px;
    }
    .detail-item {
        display: flex;
        flex-direction: column;
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
    .detail-item .value small {
        font-size: 14px;
        font-weight: 400;
        color: #64748b;
        margin-left: 8px;
    }
    .btn-book {
        display: inline-block;
        padding: 14px 40px;
        background: #1e3a5f;
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
        background: #2d5a87;
        box-shadow: 0 4px 16px rgba(30, 58, 95, 0.3);
    }

    @media (max-width: 640px) {
        .detail-grid { grid-template-columns: 1fr; }
        .detail-header { flex-direction: column; gap: 12px; }
        .detail-header .price-tag { align-self: flex-start; }
    }
</style>

<div class="max-w-4xl mx-auto px-4 py-4">
    <div class="page-header">
        <a href="{{ route('flights.index') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
        <h1>Detail Penerbangan</h1>
    </div>

    <div class="detail-card">
        <div class="detail-header">
            <h2>{{ $flight->airline }}</h2>
            <span class="price-tag">Rp {{ number_format($flight->price, 0, ',', '.') }}</span>
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <span class="label">Rute</span>
                <span class="value">{{ $flight->origin }} → {{ $flight->destination }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Maskapai</span>
                <span class="value">{{ $flight->airline }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Keberangkatan</span>
                <span class="value">{{ $flight->departure_time->format('d M Y, H:i') }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Kedatangan</span>
                <span class="value">{{ $flight->arrival_time->format('d M Y, H:i') }}</span>
            </div>
            <div class="detail-item">
                <span class="label">Kursi Tersedia</span>
                <span class="value">{{ $flight->available_seats }} <small>dari {{ $flight->capacity }}</small></span>
            </div>
            <div class="detail-item">
                <span class="label">Status</span>
                <span class="value" style="color:#22c55e;">{{ ucfirst($flight->status) }}</span>
            </div>
        </div>

        <a href="{{ route('bookings.create', $flight->id) }}" class="btn-book">
            <i class="fa-regular fa-pen-to-square"></i> Lanjutkan Pemesanan
        </a>
    </div>
</div>
@endsection