@extends('layouts.app')

@section('content')
<style>
    .success-container { max-width: 600px; margin: 0 auto; text-align: center; }
    .success-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #22c55e;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        margin: 0 auto 16px;
    }
    .ticket-code {
        background: #f1f5f9;
        padding: 12px 24px;
        border-radius: 12px;
        font-family: monospace;
        font-size: 20px;
        font-weight: 700;
        color: #1e3a5f;
        display: inline-block;
        margin: 12px 0;
    }
    .ticket-info {
        background: white;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        text-align: left;
        margin: 20px 0;
    }
    .ticket-info .row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9; }
    .ticket-info .row:last-child { border-bottom: none; }
    .ticket-info .label { color: #64748b; font-size: 14px; }
    .ticket-info .value { font-weight: 600; color: #0f172a; }

    .btn-download {
        display: inline-block;
        padding: 12px 32px;
        background: #1e3a5f;
        color: white;
        font-weight: 700;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.2s;
        text-decoration: none;
    }
    .btn-download:hover {
        background: #2d5a87;
        box-shadow: 0 4px 16px rgba(30,58,95,0.3);
    }
    .btn-home {
        display: inline-block;
        padding: 12px 32px;
        background: white;
        color: #1e3a5f;
        font-weight: 700;
        border: 2px solid #1e3a5f;
        border-radius: 12px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.2s;
        text-decoration: none;
        margin-left: 8px;
    }
    .btn-home:hover { background: #f1f5f9; }
</style>

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="success-container">
        <div class="success-icon"><i class="fa-solid fa-check"></i></div>
        <h1 class="text-2xl font-black text-gray-900">Pembayaran Berhasil! 🎉</h1>
        <p class="text-gray-500">E-ticket Anda telah terbit. Silakan simpan sebagai bukti.</p>

        <div class="ticket-code">TIX-{{ strtoupper(Str::random(8)) }}</div>

        <div class="ticket-info">
            <div class="row"><span class="label">Kereta</span><span class="value">Harina 96</span></div>
            <div class="row"><span class="label">Rute</span><span class="value">Bandung → Surabaya</span></div>
            <div class="row"><span class="label">Tanggal</span><span class="value">02 Agt 2026, 21:35</span></div>
            <div class="row"><span class="label">Kelas</span><span class="value">Ekonomi (CC)</span></div>
            <div class="row"><span class="label">Penumpang</span><span class="value">John Doe</span></div>
            <div class="row"><span class="label">Total</span><span class="value" style="color:#1e3a5f; font-size:18px;">Rp 370.000</span></div>
        </div>

        <div>
            <a href="{{ route('bookings.download', 1) }}" class="btn-download">
                <i class="fa-regular fa-download"></i> Download E-Ticket
            </a>
            <a href="{{ route('home') }}" class="btn-home">
                <i class="fa-regular fa-house"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection