@extends('layouts.user')
@section('title', 'Checkout Pembayaran')

@push('styles')
<style>
    .checkout-hero {
        background: linear-gradient(135deg, #064e3b 0%, #0f172a 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .checkout-hero::after {
        content: '💳';
        position: absolute; right: 2rem; top: 50%;
        transform: translateY(-50%);
        font-size: 5rem; opacity: 0.08;
    }
    .checkout-hero h1 { color: white; font-weight: 900; font-size: 1.4rem; margin: 0; }
    .checkout-hero p { color: rgba(255,255,255,0.5); font-size: 0.85rem; margin-top: 0.3rem; }

    /* TICKET CARD */
    .ticket-card {
        background: linear-gradient(135deg, #059669 0%, #0ea5e9 100%);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .ticket-card::before {
        content: '✈';
        position: absolute;
        right: -1rem; bottom: -1rem;
        font-size: 8rem;
        opacity: 0.1;
        transform: rotate(-20deg);
    }
    .ticket-card .tc-code { font-family: monospace; font-size: 1.1rem; font-weight: 900; background: rgba(255,255,255,0.15); display: inline-block; padding: 0.25rem 1rem; border-radius: 8px; margin-bottom: 1rem; }
    .ticket-card .tc-route { font-size: 1.5rem; font-weight: 900; }
    .ticket-card .tc-meta { font-size: 0.8rem; opacity: 0.7; margin-top: 0.3rem; }
    .ticket-card .tc-price { font-size: 1.75rem; font-weight: 900; margin-top: 1rem; }
    .ticket-card .tc-pax { font-size: 0.8rem; opacity: 0.65; }

    /* NOTCH: dashed separator */
    .ticket-notch {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 1.5rem 0;
    }
    .ticket-notch .line { flex: 1; border-top: 2px dashed #e2e8f0; }
    .ticket-notch .circle { width: 10px; height: 10px; border-radius: 50%; background: #e2e8f0; flex-shrink: 0; }

    /* PAYMENT OPTIONS */
    .payment-option {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 0.75rem;
    }
    .payment-option:hover { border-color: #059669; background: #ecfdf5; }
    .payment-option.selected { border-color: #059669; background: #ecfdf5; }
    .payment-option .pm-icon { font-size: 1.5rem; width: 40px; text-align: center; }
    .payment-option .pm-name { font-weight: 700; color: #0f172a; font-size: 0.9rem; }
    .payment-option .pm-desc { font-size: 0.75rem; color: #64748b; }
    .payment-option .check-circle {
        margin-left: auto;
        width: 22px; height: 22px;
        border-radius: 50%;
        border: 2px solid #cbd5e1;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.2s;
    }
    .payment-option.selected .check-circle {
        background: #059669; border-color: #059669; color: white;
    }

    .btn-pay {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #059669, #0ea5e9);
        color: white;
        font-weight: 800;
        font-size: 1rem;
        border: none;
        border-radius: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        transition: all 0.3s;
        box-shadow: 0 6px 24px rgba(5,150,105,0.3);
        font-family: 'Poppins', sans-serif;
        margin-top: 1.5rem;
    }
    .btn-pay:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 35px rgba(5,150,105,0.4);
    }
</style>
@endpush

@section('content')

<div class="max-w-xl mx-auto">
    <div class="checkout-hero">
        <h1>💳 Checkout & Pembayaran</h1>
        <p>Pilih metode pembayaran dan selesaikan pemesanan kamu</p>
    </div>

    {{-- TICKET SUMMARY CARD --}}
    <div class="ticket-card">
        <div class="tc-code">{{ $booking->booking_code }}</div>
        <div class="tc-route">
            @if($booking->flight)
                {{ $booking->flight->origin }} ✈ {{ $booking->flight->destination }}
            @else
                {{ ucfirst($booking->category) }} Journey
            @endif
        </div>
        <div class="tc-meta">
            Penumpang: {{ $booking->nama_penumpang }} &bull; {{ $booking->jumlah_penumpang }} orang
            @if($booking->flight)
                <br>🕐 {{ \Carbon\Carbon::parse($booking->flight->departure_time)->format('D, d M Y H:i') }}
                &bull; {{ $booking->flight->airline }}
            @endif
        </div>
        <div class="tc-price">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
        <div class="tc-pax">Total Tagihan ({{ $booking->jumlah_penumpang }} penumpang)</div>
    </div>

    {{-- PAYMENT FORM --}}
    <div class="glass p-6">
        <h2 class="font-black text-gray-900 text-lg mb-4">Pilih Metode Pembayaran</h2>

        <form action="{{ route('bookings.pay') }}" method="POST">
            @csrf
            <input type="hidden" name="bookingId" value="{{ $booking->id }}">
            <input type="hidden" name="payment_method" id="payment_method" value="transfer_bank">

            <div class="payment-option selected" onclick="selectPayment(this, 'transfer_bank')">
                <div class="pm-icon">🏦</div>
                <div>
                    <div class="pm-name">Transfer Bank</div>
                    <div class="pm-desc">BCA, Mandiri, BNI, BRI</div>
                </div>
                <div class="check-circle"><i class="fa-solid fa-check text-xs"></i></div>
            </div>

            <div class="payment-option" onclick="selectPayment(this, 'e_wallet')">
                <div class="pm-icon">📱</div>
                <div>
                    <div class="pm-name">E-Wallet</div>
                    <div class="pm-desc">GoPay, OVO, Dana, ShopeePay</div>
                </div>
                <div class="check-circle"><i class="fa-solid fa-check text-xs"></i></div>
            </div>

            <div class="payment-option" onclick="selectPayment(this, 'virtual_account')">
                <div class="pm-icon">💳</div>
                <div>
                    <div class="pm-name">Virtual Account</div>
                    <div class="pm-desc">Bayar melalui ATM atau m-banking</div>
                </div>
                <div class="check-circle"><i class="fa-solid fa-check text-xs"></i></div>
            </div>

            <div class="payment-option" onclick="selectPayment(this, 'kartu_kredit')">
                <div class="pm-icon">🪙</div>
                <div>
                    <div class="pm-name">Kartu Kredit / Debit</div>
                    <div class="pm-desc">Visa, Mastercard, JCB</div>
                </div>
                <div class="check-circle"><i class="fa-solid fa-check text-xs"></i></div>
            </div>

            <div class="ticket-notch">
                <div class="circle"></div>
                <div class="line"></div>
                <div class="circle"></div>
            </div>

            <div style="background:#f8fafc; border-radius:14px; padding:1rem 1.25rem; margin-bottom:0.5rem;">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold text-gray-500">Total Pembayaran</span>
                    <span class="text-xl font-black text-emerald-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <p style="font-size:0.75rem; color:#94a3b8; text-align:center; margin-bottom: 0.5rem;">
                <i class="fa-solid fa-shield-halved mr-1"></i>
                Pembayaran dijamin aman. Tiket aktif setelah Manager memverifikasi.
            </p>

            <button type="submit" class="btn-pay">
                <i class="fa-solid fa-circle-check"></i>
                Bayar Sekarang – Rp {{ number_format($booking->total_price, 0, ',', '.') }}
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function selectPayment(el, method) {
        document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
        el.classList.add('selected');
        document.getElementById('payment_method').value = method;
    }
</script>
@endpush

@endsection