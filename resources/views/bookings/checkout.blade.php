@extends('layouts.app')

@section('content')
<style>
    .page-header { display:flex; align-items:center; gap:16px; margin-bottom:24px; }
    .page-header h1 { font-size:26px; font-weight:900; color:#0f172a; margin:0; }
    .back-btn { color:#94a3b8; font-size:20px; text-decoration:none; transition:0.2s; }
    .back-btn:hover { color:#1e3a5f; }

    .checkout-container { max-width: 700px; margin: 0 auto; }
    .checkout-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        margin-bottom: 20px;
    }
    .checkout-card h2 {
        font-size: 18px;
        font-weight: 700;
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
    .summary-row .label { color: #64748b; }
    .summary-row .value { font-weight: 600; color: #0f172a; }
    .summary-total {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-top: 2px solid #e2e8f0;
        margin-top: 8px;
        font-size: 20px;
        font-weight: 900;
        color: #1e3a5f;
    }

    .payment-options {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin: 16px 0;
    }
    .payment-option {
        padding: 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        cursor: pointer;
        transition: 0.2s;
        text-align: center;
        background: white;
    }
    .payment-option:hover {
        border-color: #1e3a5f;
    }
    .payment-option.selected {
        border-color: #1e3a5f;
        background: #1e3a5f10;
    }
    .payment-option i { font-size: 24px; display: block; margin-bottom: 4px; }
    .payment-option .name { font-weight: 600; font-size: 13px; }

    .btn-pay {
        width: 100%;
        padding: 14px;
        background: #1e3a5f;
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
    }
    .btn-pay:hover {
        background: #2d5a87;
        box-shadow: 0 4px 16px rgba(30,58,95,0.3);
    }

    @media (max-width: 640px) { .payment-options { grid-template-columns: 1fr 1fr; } }
</style>

<div class="max-w-7xl mx-auto px-4 py-4">
    <div class="page-header">
        <a href="#" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
        <h1>💳 Checkout</h1>
    </div>

    <div class="checkout-container">
        {{-- RINGKASAN --}}
        <div class="checkout-card">
            <h2>Ringkasan Pemesanan</h2>
            <div class="summary-row"><span class="label">Kereta</span><span class="value">Harina 96</span></div>
            <div class="summary-row"><span class="label">Rute</span><span class="value">Bandung → Surabaya</span></div>
            <div class="summary-row"><span class="label">Tanggal</span><span class="value">02 Agt 2026, 21:35</span></div>
            <div class="summary-row"><span class="label">Kelas</span><span class="value">Ekonomi (CC)</span></div>
            <div class="summary-row"><span class="label">Penumpang</span><span class="value">1 orang</span></div>
            <div class="summary-total"><span>Total</span><span>Rp 370.000</span></div>
        </div>

        {{-- PILIH PEMBAYARAN --}}
        <div class="checkout-card">
            <h2>Pilih Metode Pembayaran</h2>
            <form action="{{ route('bookings.pay') }}" method="POST">
                @csrf
                <div class="payment-options">
                    <div class="payment-option selected" onclick="selectPayment(this)">
                        <i class="fa-solid fa-building-columns" style="color:#1e3a5f;"></i>
                        <span class="name">Transfer Bank</span>
                    </div>
                    <div class="payment-option" onclick="selectPayment(this)">
                        <i class="fa-regular fa-credit-card" style="color:#22c55e;"></i>
                        <span class="name">Kartu Kredit</span>
                    </div>
                    <div class="payment-option" onclick="selectPayment(this)">
                        <i class="fa-solid fa-wallet" style="color:#f97316;"></i>
                        <span class="name">E-Wallet</span>
                    </div>
                    <div class="payment-option" onclick="selectPayment(this)">
                        <i class="fa-regular fa-credit-card" style="color:#a855f7;"></i>
                        <span class="name">Virtual Account</span>
                    </div>
                </div>
                <input type="hidden" name="payment_method" id="payment_method" value="transfer">
                <button type="submit" class="btn-pay">
                    <i class="fa-regular fa-circle-check"></i> Bayar Sekarang
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function selectPayment(el) {
        document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
        el.classList.add('selected');
        const name = el.querySelector('.name').textContent;
        document.getElementById('payment_method').value = name.toLowerCase().replace(' ', '_');
    }
</script>
@endsection