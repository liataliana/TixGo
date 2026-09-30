@extends('layouts.app')
@section('content')
<style>
    .form-card { background: white; border-radius: 20px; padding: 2.5rem; box-shadow: 0 4px 30px rgba(0,0,0,0.06); max-width: 600px; margin: 0 auto; }
    .form-group { margin-bottom: 1.25rem; }
    .form-group label { display: block; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem; font-size: 0.9rem; }
    .form-group input, .form-group select {
        width: 100%; padding: 0.75rem 1rem; border: 2px solid #e2e8f0;
        border-radius: 12px; font-size: 0.95rem; transition: border-color 0.2s; outline: none;
    }
    .form-group input:focus, .form-group select:focus { border-color: #059669; box-shadow: 0 0 0 3px rgba(5,150,105,0.1); }
    .btn-submit { width: 100%; padding: 0.9rem; background: linear-gradient(135deg, #059669, #0ea5e9); color: white; border: none; border-radius: 14px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: all 0.3s; }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(5,150,105,0.3); }
    .role-badge { display: inline-block; padding: 2px 10px; border-radius: 100px; font-size: 0.75rem; font-weight: 700; }
    .badge-manager { background: #dbeafe; color: #1d4ed8; }
    .badge-super { background: #fce7f3; color: #be185d; }
    .badge-user { background: #d1fae5; color: #065f46; }
</style>

<div style="max-width: 600px; margin: 0 auto;">
    <div style="background: linear-gradient(135deg, #0f172a, #1e3a5f, #064e3b); border-radius: 20px; padding: 2rem; margin-bottom: 2rem; color: white;">
        <h2 style="font-weight: 900; font-size: 1.5rem; margin: 0;">
            <i class="fa-solid fa-user-plus" style="color: #34d399; margin-right: 8px;"></i>
            Tambah Akun Baru
        </h2>
        <p style="color: rgba(255,255,255,0.6); margin: 0.5rem 0 0; font-size: 0.9rem;">
            Buat akun Manager atau role lain untuk sistem TixGo
        </p>
    </div>

    @if($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1rem;">
            <ul style="margin: 0; padding-left: 1.25rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('superadmin.managers.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label><i class="fa-regular fa-user" style="color:#059669; margin-right:4px;"></i> Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Manager" required>
            </div>
            <div class="form-group">
                <label><i class="fa-regular fa-envelope" style="color:#059669; margin-right:4px;"></i> Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="manager@tixgo.com" required>
            </div>
            <div class="form-group">
                <label><i class="fa-solid fa-shield-halved" style="color:#059669; margin-right:4px;"></i> Role</label>
                <select name="role" required>
                    <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>👔 Manager</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>👤 User</option>
                    <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>🛡️ Super Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label><i class="fa-solid fa-lock" style="color:#059669; margin-right:4px;"></i> Password</label>
                <input type="password" name="password" placeholder="Minimal 8 karakter" required>
            </div>
            <div class="form-group">
                <label><i class="fa-solid fa-lock" style="color:#059669; margin-right:4px;"></i> Konfirmasi Password</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
            </div>

            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 1rem; margin-bottom: 1.25rem; font-size: 0.85rem; color: #065f46;">
                <i class="fa-solid fa-circle-info" style="margin-right: 6px;"></i>
                Akun yang dibuat akan langsung bisa login. Pastikan email dan password diberitahukan kepada yang bersangkutan.
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-user-plus" style="margin-right: 8px;"></i>
                Buat Akun Sekarang
            </button>
        </form>
    </div>

    <div style="text-align: center; margin-top: 1rem;">
        <a href="{{ route('superadmin.users.index') }}" style="color: #64748b; font-size: 0.85rem; text-decoration: none;">
            <i class="fa-solid fa-arrow-left" style="margin-right: 4px;"></i> Kembali ke Daftar User
        </a>
    </div>
</div>
@endsection
