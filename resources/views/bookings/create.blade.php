@extends('layouts.user')
@section('title', 'Isi Data Penumpang')

@push('styles')
<style>
    .booking-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 40%, #064e3b 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    .booking-hero::before {
        content: '✈';
        position: absolute;
        font-size: 10rem;
        right: -1rem;
        top: 50%;
        transform: translateY(-50%) rotate(-20deg);
        opacity: 0.05;
    }
    .booking-hero h1 { color: white; font-weight: 900; font-size: 1.4rem; margin: 0; }
    .booking-hero p { color: rgba(255,255,255,0.55); font-size: 0.85rem; margin: 0.4rem 0 0; }

    .flight-info-bar {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 14px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-top: 1.25rem;
        flex-wrap: wrap;
    }
    .flight-info-bar .fi-item { color: white; font-size: 0.85rem; }
    .flight-info-bar .fi-item strong { display: block; font-size: 1rem; font-weight: 800; }

    .section-label {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #059669;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .section-label::after {
        content: '';
        flex: 1;
        height: 2px;
        background: linear-gradient(to right, #d1fae5, transparent);
        border-radius: 2px;
    }

    .form-field label {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 0.5rem;
    }
    .form-field input, .form-field select {
        width: 100%;
        padding: 0.875rem 1.125rem;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        font-size: 0.9rem;
        font-weight: 600;
        color: #0f172a;
        background: white;
        transition: all 0.2s;
        outline: none;
        font-family: 'Poppins', sans-serif;
    }
    .form-field input:focus, .form-field select:focus {
        border-color: #059669;
        box-shadow: 0 0 0 4px rgba(5,150,105,0.08);
    }
    .form-field input.is-invalid, .form-field select.is-invalid {
        border-color: #f87171;
    }
    .form-field .err { color: #ef4444; font-size: 0.75rem; font-weight: 600; margin-top: 0.3rem; }

    .btn-next {
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
        box-shadow: 0 6px 24px rgba(5,150,105,0.25);
        font-family: 'Poppins', sans-serif;
    }
    .btn-next:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 35px rgba(5,150,105,0.35);
    }

    .price-preview {
        background: linear-gradient(135deg, #ecfdf5, #f0f9ff);
        border: 1px solid #a7f3d0;
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
    }
    .price-preview .price-label { font-size: 0.85rem; color: #064e3b; font-weight: 600; }
    .price-preview .price-val { font-size: 1.5rem; font-weight: 900; color: #059669; }
</style>
@endpush

@section('content')

<div class="max-w-2xl mx-auto">
    {{-- HERO --}}
    <div class="booking-hero">
        <h1>✈️ Isi Data Penumpang</h1>
        <p>Lengkapi data penumpang sesuai dengan dokumen identitas yang sah</p>
        @if(isset($flight))
        <div class="flight-info-bar">
            <div class="fi-item">
                <strong>{{ $flight->origin }}</strong>
                <span style="color: rgba(255,255,255,0.5);">Asal</span>
            </div>
            <div style="color: #34d399; font-size: 1.5rem;">✈</div>
            <div class="fi-item">
                <strong>{{ $flight->destination }}</strong>
                <span style="color: rgba(255,255,255,0.5);">Tujuan</span>
            </div>
            <div style="width: 1px; background: rgba(255,255,255,0.1); height: 40px;"></div>
            <div class="fi-item">
                <strong>{{ $flight->airline }}</strong>
                <span style="color: rgba(255,255,255,0.5);">Maskapai</span>
            </div>
            <div class="fi-item">
                <strong>Rp {{ number_format($flight->price, 0, ',', '.') }}</strong>
                <span style="color: rgba(255,255,255,0.5);">per orang</span>
            </div>
        </div>
        @endif
    </div>

    {{-- FORM --}}
    <div class="glass p-8">
        {{-- Errors --}}
        @if($errors->any())
            <div style="background:#fef2f2; border:1px solid #fca5a5; border-radius:14px; padding:1rem 1.5rem; margin-bottom:1.5rem;">
                <p class="font-bold text-red-700 mb-2"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Mohon perbaiki data berikut:</p>
                @foreach($errors->all() as $err)
                    <p class="text-red-600 text-sm">• {{ $err }}</p>
                @endforeach
            </div>
        @endif

        @if(isset($flightId))
            <form action="{{ route('bookings.store', $flightId) }}" method="POST">
        @else
            <form action="{{ route('bookings.store.train') }}" method="POST">
        @endif
            @csrf

            <div class="section-label"><i class="fa-solid fa-user"></i> Data Penumpang</div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div class="form-field">
                    <label>Nama Lengkap <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="passenger_name" value="{{ old('passenger_name') }}"
                           placeholder="Nama sesuai KTP/Paspor"
                           class="{{ $errors->has('passenger_name') ? 'is-invalid' : '' }}">
                    @error('passenger_name')<p class="err">{{ $message }}</p>@enderror
                </div>
                <div class="form-field">
                    <label>Nomor KTP / Paspor <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="id_number" value="{{ old('id_number') }}"
                           placeholder="16 digit NIK atau nomor paspor"
                           class="{{ $errors->has('id_number') ? 'is-invalid' : '' }}">
                    @error('id_number')<p class="err">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div class="form-field">
                    <label>Email <span style="color:#ef4444;">*</span></label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                           placeholder="email@contoh.com"
                           class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                    @error('email')<p class="err">{{ $message }}</p>@enderror
                </div>
                <div class="form-field">
                    <label>Nomor Telepon <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           placeholder="08xxxxxxxxxx"
                           class="{{ $errors->has('phone') ? 'is-invalid' : '' }}">
                    @error('phone')<p class="err">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="form-field mb-6">
                <label>Jumlah Penumpang <span style="color:#ef4444;">*</span></label>
                <select name="passenger_count" id="paxCount" class="{{ $errors->has('passenger_count') ? 'is-invalid' : '' }}"
                    onchange="updatePrice()">
                    @for($i = 1; $i <= 9; $i++)
                        <option value="{{ $i }}" {{ old('passenger_count') == $i ? 'selected' : ($i == 1 ? 'selected' : '') }}>{{ $i }} Penumpang</option>
                    @endfor
                </select>
                @error('passenger_count')<p class="err">{{ $message }}</p>@enderror
            </div>

            @if(isset($flight))
            <div class="price-preview" id="pricePreview">
                <div>
                    <div class="price-label">Estimasi Total Harga</div>
                    <div style="font-size: 0.75rem; color: #64748b;">{{ $flight->airline }} &bull; <span id="paxDisplay">1</span> penumpang</div>
                </div>
                <div class="price-val" id="priceDisplay">Rp {{ number_format($flight->price, 0, ',', '.') }}</div>
            </div>
            @endif

            <button type="submit" class="btn-next">
                <i class="fa-solid fa-arrow-right"></i>
                Lanjut ke Checkout
            </button>
        </form>
    </div>
</div>

@if(isset($flight))
@push('scripts')
<script>
    const pricePerPax = {{ $flight->price }};
    function updatePrice() {
        const pax = parseInt(document.getElementById('paxCount').value);
        const total = pax * pricePerPax;
        document.getElementById('priceDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('paxDisplay').textContent = pax;
    }
</script>
@endpush
@endif

@endsection