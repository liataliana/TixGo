@extends('layouts.guest')

@section('content')
<div style="margin-bottom: 24px; text-align: center;">
    <h2 style="font-size: 22px; font-weight: 700; margin: 0; color: #0f172a;">Selamat Datang!</h2>
    <p style="font-size: 14px; color: #64748b; margin-top: 4px;">Masuk untuk mengakses semua tiket</p>
</div>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email -->
    <div style="margin-bottom: 16px;">
        <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Alamat Email</label>
        <div style="position: relative;">
            <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                <i class="fa-regular fa-envelope"></i>
            </div>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                   placeholder="contoh@email.com"
                   style="width: 100%; padding: 12px 12px 12px 40px; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 14px; box-sizing: border-box; outline: none; transition: 0.2s;">
        </div>
        @error('email')
            <span style="font-size: 12px; color: #dc2626; margin-top: 4px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <!-- Password -->
    <div style="margin-bottom: 16px;">
        <label style="display: block; font-size: 12px; font-weight: 700; color: #334155; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Kata Sandi</label>
        <div style="position: relative;">
            <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8;">
                <i class="fa-solid fa-lock"></i>
            </div>
            <input id="password" type="password" name="password" required 
                   placeholder="Masukkan kata sandi"
                   style="width: 100%; padding: 12px 12px 12px 40px; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 14px; box-sizing: border-box; outline: none; transition: 0.2s;">
        </div>
        @error('password')
            <span style="font-size: 12px; color: #dc2626; margin-top: 4px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <!-- Remember Me -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <label style="display: flex; align-items: center; font-size: 13px; color: #475569; cursor: pointer;">
            <input type="checkbox" name="remember" style="margin-right: 8px; accent-color: #0066ff; width: 16px; height: 16px; cursor: pointer;">
            Ingat saya
        </label>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" style="font-size: 13px; font-weight: 600; color: #0066ff; text-decoration: none;">Lupa kata sandi?</a>
        @endif
    </div>

    <!-- Submit Button -->
    <button type="submit" style="width: 100%; padding: 14px; background-color: #0066ff; color: white; font-weight: 700; font-size: 14px; border: none; border-radius: 12px; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 14px rgba(0, 102, 255, 0.3);">
        <i class="fa-solid fa-arrow-right-to-bracket"></i> MASUK SEKARANG
    </button>

    <!-- Footer Link -->
    <div style="margin-top: 16px; text-align: center; font-size: 14px; color: #64748b;">
        Belum punya akun? 
        <a href="{{ route('register') }}" style="font-weight: 700; color: #0066ff; text-decoration: none;">Daftar gratis</a>
    </div>
</form>
@endsection