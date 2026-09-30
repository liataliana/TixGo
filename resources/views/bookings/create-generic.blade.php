{{-- [Magfi Adi Radza Putra] - Form Booking Generik (Hotel / Villa / Kereta / Bus) --}}
@extends('layouts.user')
@section('title', 'Booking ' . ucfirst($category ?? 'Tiket'))

@section('content')
<style>
    .booking-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #064e3b 100%);
        border-radius: 20px;
        padding: 2rem 2.5rem;
        color: white;
        margin-bottom: 2rem;
    }
    .booking-hero h2 { font-weight: 800; font-size: 1.8rem; }
    .booking-hero .info-bar {
        display: flex;
        gap: 2rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }
    .booking-hero .info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
        color: rgba(255,255,255,0.85);
    }
    .booking-form {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 4px 30px rgba(0,0,0,0.06);
    }
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem; font-size: 0.9rem; }
    .form-group input, .form-group select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: border-color 0.2s;
        outline: none;
    }
    .form-group input:focus, .form-group select:focus {
        border-color: #059669;
        box-shadow: 0 0 0 3px rgba(5,150,105,0.1);
    }
    .price-summary {
        background: linear-gradient(135deg, #ecfdf5, #f0f9ff);
        border: 2px solid #6ee7b7;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .price-row { display: flex; justify-content: space-between; margin-bottom: 0.5rem; }
    .price-total { font-size: 1.3rem; font-weight: 800; color: #059669; border-top: 2px dashed #6ee7b7; padding-top: 0.75rem; margin-top: 0.5rem; }
    .btn-submit {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #059669, #0ea5e9);
        color: white;
        border: none;
        border-radius: 14px;
        font-weight: 700;
        font-size: 1.05rem;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(5,150,105,0.3); }
</style>

{{-- HERO INFO --}}
<div class="booking-hero">
    <h2>
        @if($category == 'hotel') 🏨
        @elseif($category == 'villa') 🏡
        @elseif($category == 'train') 🚂
        @elseif($category == 'bus') 🚌
        @else 🎫
        @endif
        Booking {{ ucfirst($category ?? 'Tiket') }}
    </h2>
    <div class="info-bar">
        <div class="info-item">
            <i class="fa-solid fa-tag"></i>
            <span>{{ $itemName ?? 'Tiket Perjalanan' }}</span>
        </div>
        <div class="info-item">
            <i class="fa-solid fa-route"></i>
            <span>{{ $itemRoute ?? '-' }}</span>
        </div>
        <div class="info-item">
            <i class="fa-solid fa-money-bill-wave"></i>
            <span>Rp {{ number_format($itemPrice ?? 0, 0, ',', '.') }} / orang</span>
        </div>
    </div>
</div>

{{-- FORM --}}
<div class="booking-form">
    <h3 style="font-weight: 700; margin-bottom: 1.5rem; color: #0f172a;">
        <i class="fa-solid fa-user-pen" style="color: #059669; margin-right: 8px;"></i>
        Data Pemesan
    </h3>

    <form action="{{ route('bookings.store.generic') }}" method="POST">
        @csrf
        <input type="hidden" name="category" value="{{ $category }}">
        <input type="hidden" name="item_name" value="{{ $itemName ?? '' }}">
        <input type="hidden" name="item_route" value="{{ $itemRoute ?? '' }}">
        <input type="hidden" name="item_price" value="{{ $itemPrice ?? 0 }}">

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label><i class="fa-regular fa-user" style="color:#059669;margin-right:4px;"></i> Nama Lengkap</label>
                <input type="text" name="passenger_name" value="{{ old('passenger_name', auth()->user()->name ?? '') }}" required>
                @error('passenger_name') <span style="color:red; font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label><i class="fa-regular fa-id-card" style="color:#059669;margin-right:4px;"></i> Nomor KTP</label>
                <input type="text" name="id_number" value="{{ old('id_number') }}" placeholder="16 digit NIK" required>
                @error('id_number') <span style="color:red; font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label><i class="fa-regular fa-envelope" style="color:#059669;margin-right:4px;"></i> Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                @error('email') <span style="color:red; font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label><i class="fa-solid fa-phone" style="color:#059669;margin-right:4px;"></i> No. Telepon</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
                @error('phone') <span style="color:red; font-size:0.8rem;">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label><i class="fa-solid fa-users" style="color:#059669;margin-right:4px;"></i> Jumlah Orang</label>
            <select name="passenger_count" id="passengerCount" onchange="updatePrice()">
                @for($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}">{{ $i }} orang</option>
                @endfor
            </select>
        </div>

        {{-- PRICE SUMMARY --}}
        <div class="price-summary">
            <div class="price-row">
                <span style="color:#64748b;">Harga per orang</span>
                <span style="font-weight:600;">Rp <span id="pricePerPerson">{{ number_format($itemPrice ?? 0, 0, ',', '.') }}</span></span>
            </div>
            <div class="price-row">
                <span style="color:#64748b;">Jumlah</span>
                <span style="font-weight:600;"><span id="personCount">1</span> orang</span>
            </div>
            <div class="price-row price-total">
                <span>Total Bayar</span>
                <span>Rp <span id="totalPrice">{{ number_format($itemPrice ?? 0, 0, ',', '.') }}</span></span>
            </div>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fa-solid fa-lock" style="margin-right: 8px;"></i>
            Lanjut ke Pembayaran
        </button>
    </form>
</div>

<script>
    const basePrice = {{ $itemPrice ?? 0 }};
    function updatePrice() {
        const count = document.getElementById('passengerCount').value;
        const total = basePrice * count;
        document.getElementById('personCount').textContent = count;
        document.getElementById('totalPrice').textContent = total.toLocaleString('id-ID');
    }
</script>
@endsection
