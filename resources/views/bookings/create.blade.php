@extends('layouts.app')

@section('content')
<style>
    /* Reset & Layout Utama CSS Manual */
    .main-wrapper {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px 16px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .page-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
    }
    .page-header h1 {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }
    .back-btn {
        color: #94a3b8;
        font-size: 20px;
        text-decoration: none;
        transition: color 0.2s;
    }
    .back-btn:hover {
        color: #1e3a5f;
    }
    .form-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 28px 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 6px;
    }
    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px 14px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        background: #ffffff;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }
    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #1e3a5f;
        box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.12);
    }
    .text-danger {
        display: block;
        margin-top: 4px;
        font-size: 12px;
        color: #dc2626;
        font-weight: 500;
    }
    .is-invalid {
        border-color: #dc2626 !important;
    }
    .is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15) !important;
    }
    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 20px;
    }
    .btn-submit {
        width: 100%;
        padding: 14px;
        background: #1e3a5f;
        color: #ffffff;
        font-weight: 700;
        font-size: 16px;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: background 0.2s, box-shadow 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 4px;
    }
    .btn-submit:hover {
        background: #2d5a87;
        box-shadow: 0 4px 14px rgba(30, 58, 95, 0.3);
    }
    @media (max-width: 600px) {
        .form-row { grid-template-columns: 1fr; gap: 0; }
        .page-header h1 { font-size: 20px; }
        .form-card { padding: 20px 16px; }
    }
</style>

<div class="main-wrapper">
    <div class="page-header">
        <a href="{{ route('trains.index') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1>✏️ Isi Data Penumpang</h1>
    </div>

    <div class="form-card">
        {{-- TAMPILKAN ERROR JIKA GAGAL SIMPAN DATABASE --}}
        @if(session('error'))
            <div class="alert-danger">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('bookings.store.train') }}" method="POST">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="passenger_name">Nama Lengkap</label>
                    <input type="text" id="passenger_name" name="passenger_name" 
                           value="{{ old('passenger_name') }}" 
                           class="{{ $errors->has('passenger_name') ? 'is-invalid' : '' }}" 
                           placeholder="Nama sesuai KTP">
                    @error('passenger_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="id_number">Nomor KTP/Paspor</label>
                    <input type="text" id="id_number" name="id_number" 
                           value="{{ old('id_number') }}" 
                           class="{{ $errors->has('id_number') ? 'is-invalid' : '' }}" 
                           placeholder="Nomor identitas">
                    @error('id_number')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" 
                           value="{{ old('email') }}" 
                           class="{{ $errors->has('email') ? 'is-invalid' : '' }}" 
                           placeholder="email@example.com">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="text" id="phone" name="phone" 
                           value="{{ old('phone') }}" 
                           class="{{ $errors->has('phone') ? 'is-invalid' : '' }}" 
                           placeholder="08xxxxxxxxxx">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="passenger_count">Jumlah Penumpang</label>
                <select name="passenger_count" id="passenger_count" class="{{ $errors->has('passenger_count') ? 'is-invalid' : '' }}">
                    <option value="1" {{ old('passenger_count') == '1' ? 'selected' : '' }}>1 Penumpang</option>
                    <option value="2" {{ old('passenger_count') == '2' ? 'selected' : '' }}>2 Penumpang</option>
                    <option value="3" {{ old('passenger_count') == '3' ? 'selected' : '' }}>3 Penumpang</option>
                    <option value="4" {{ old('passenger_count') == '4' ? 'selected' : '' }}>4 Penumpang</option>
                    <option value="5" {{ old('passenger_count') == '5' ? 'selected' : '' }}>5 Penumpang</option>
                </select>
                @error('passenger_count')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-regular fa-circle-check"></i> Lanjut ke Checkout
            </button>
        </form>
    </div>
</div>
@endsection