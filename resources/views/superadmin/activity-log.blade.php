@extends('layouts.app')
@section('content')
<style>
    .log-hero { background: linear-gradient(135deg, #0f172a, #1e3a5f); border-radius: 20px; padding: 2rem; margin-bottom: 2rem; color: white; }
    .log-hero h1 { font-weight: 900; font-size: 1.5rem; margin: 0; }
    .log-hero p { color: rgba(255,255,255,0.6); margin: 0.4rem 0 0; font-size: 0.9rem; }

    .log-card { background: white; border-radius: 16px; border: 1px solid #e2e8f0; margin-bottom: 0.75rem; padding: 1.1rem 1.5rem; display: flex; align-items: flex-start; gap: 1rem; transition: box-shadow 0.2s; }
    .log-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.07); }

    .log-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    .icon-confirm { background: #d1fae5; color: #059669; }
    .icon-flight  { background: #dbeafe; color: #2563eb; }
    .icon-role    { background: #fce7f3; color: #be185d; }
    .icon-user    { background: #fef3c7; color: #d97706; }
    .icon-other   { background: #f1f5f9; color: #64748b; }

    .log-action { font-weight: 800; color: #0f172a; font-size: 0.9rem; }
    .log-desc   { color: #475569; font-size: 0.85rem; margin-top: 2px; }
    .log-meta   { font-size: 0.75rem; color: #94a3b8; margin-top: 4px; }
    .log-badge  { display: inline-block; padding: 2px 8px; border-radius: 100px; font-size: 0.7rem; font-weight: 700; }
    .badge-manager    { background: #dbeafe; color: #1d4ed8; }
    .badge-super_admin { background: #fce7f3; color: #be185d; }
</style>

<div class="log-hero">
    <h1><i class="fa-solid fa-clock-rotate-left" style="margin-right: 8px; color: #34d399;"></i> Log Aktivitas</h1>
    <p>Pantau semua aksi yang dilakukan oleh Manager dan Super Admin</p>
</div>

@if($logs->count() > 0)
    @foreach($logs as $log)
    @php
        $actionIcons = [
            'confirm_payment' => ['class' => 'icon-confirm', 'icon' => '✅', 'label' => 'Konfirmasi Pembayaran'],
            'add_flight'      => ['class' => 'icon-flight',  'icon' => '✈️', 'label' => 'Tambah Penerbangan'],
            'update_role'     => ['class' => 'icon-role',    'icon' => '🔄', 'label' => 'Ubah Role User'],
            'create_user'     => ['class' => 'icon-user',    'icon' => '👤', 'label' => 'Buat Akun Baru'],
        ];
        $info = $actionIcons[$log->action] ?? ['class' => 'icon-other', 'icon' => '📌', 'label' => ucfirst(str_replace('_', ' ', $log->action))];
    @endphp
    <div class="log-card">
        <div class="log-icon {{ $info['class'] }}">{{ $info['icon'] }}</div>
        <div style="flex: 1;">
            <div class="log-action">
                {{ $info['label'] }}
                <span class="log-badge badge-{{ $log->role }}" style="margin-left: 6px;">{{ $log->role }}</span>
            </div>
            <div class="log-desc">{{ $log->description }}</div>
            <div class="log-meta">
                <i class="fa-regular fa-user" style="margin-right: 4px;"></i>
                {{ optional($log->user)->name ?? 'Unknown' }}
                &bull;
                <i class="fa-regular fa-clock" style="margin: 0 4px;"></i>
                {{ $log->created_at->format('d M Y, H:i') }}
                @if($log->target_type)
                    &bull; {{ $log->target_type }} #{{ $log->target_id }}
                @endif
            </div>
        </div>
    </div>
    @endforeach

    <div style="margin-top: 1.5rem;">
        {{ $logs->links() }}
    </div>
@else
    <div style="background: white; border-radius: 20px; padding: 4rem; text-align: center;">
        <div style="font-size: 4rem; margin-bottom: 1rem;">📋</div>
        <h3 style="font-weight: 800; color: #374151;">Belum Ada Aktivitas</h3>
        <p style="color: #6b7280;">Log aktivitas Manager akan muncul di sini.</p>
    </div>
@endif
@endsection
