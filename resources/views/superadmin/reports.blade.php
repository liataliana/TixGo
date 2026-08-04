@extends('layouts.app')

@section('content')
<style>
    .page-header { display:flex; align-items:center; gap:16px; margin-bottom:24px; }
    .page-header h1 { font-size:26px; font-weight:900; color:#0f172a; margin:0; }

    .stats-grid { display:grid; grid-template-columns: repeat(5,1fr); gap:16px; margin-bottom:24px; }
    .stat-card { background:white; border-radius:12px; padding:20px; border:1px solid #e2e8f0; box-shadow:0 2px 8px rgba(0,0,0,0.04); }
    .stat-card .number { font-size:28px; font-weight:900; color:#1e3a5f; }
    .stat-card .label { font-size:13px; color:#64748b; margin-top:4px; }

    .report-table { background:white; border-radius:12px; padding:20px; border:1px solid #e2e8f0; overflow-x:auto; margin-bottom:24px; }
    .report-table table { width:100%; border-collapse:collapse; font-size:14px; }
    .report-table th { text-align:left; padding:12px 16px; background:#f8fafc; font-weight:700; color:#0f172a; border-bottom:2px solid #e2e8f0; }
    .report-table td { padding:12px 16px; border-bottom:1px solid #f1f5f9; }

    .chart-placeholder {
        background: white;
        border-radius:12px;
        padding:40px;
        border:1px solid #e2e8f0;
        text-align:center;
        color:#94a3b8;
    }
    .chart-placeholder i { font-size:48px; display:block; margin-bottom:12px; }
</style>

<div class="max-w-7xl mx-auto px-4 py-4">
    <div class="page-header">
        <h1>📊 Laporan Super Admin</h1>
    </div>

    <div class="stats-grid">
        <div class="stat-card"><div class="number">3</div><div class="label">Total Admin</div></div>
        <div class="stat-card"><div class="number">12</div><div class="label">Total Manager</div></div>
        <div class="stat-card"><div class="number">1,234</div><div class="label">Total User</div></div>
        <div class="stat-card"><div class="number">Rp 185 Jt</div><div class="label">Total Pendapatan</div></div>
        <div class="stat-card"><div class="number" style="color:#22c55e;">98%</div><div class="label">Tingkat Konfirmasi</div></div>
    </div>

    <div class="report-table">
        <h3 style="font-weight:700; margin-bottom:12px;">User Terdaftar</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Pemesanan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>John Doe</td><td>john@email.com</td><td>User</td><td>12</td><td><span style="color:#22c55e;">Aktif</span></td></tr>
                <tr><td>Admin TixGo</td><td>admin@tixgo.com</td><td>Admin</td><td>-</td><td><span style="color:#22c55e;">Aktif</span></td></tr>
                <tr><td>Manager 1</td><td>manager1@tixgo.com</td><td>Manager</td><td>-</td><td><span style="color:#22c55e;">Aktif</span></td></tr>
            </tbody>
        </table>
    </div>

    <div class="chart-placeholder">
        <i class="fa-regular fa-chart-bar"></i>
        <p>Grafik pendapatan per bulan</p>
        <div style="display:flex; gap:8px; justify-content:center; align-items:end; height:120px;">
            <div style="width:30px; background:#1e3a5f; height:40px; border-radius:4px;"></div>
            <div style="width:30px; background:#2d5a87; height:70px; border-radius:4px;"></div>
            <div style="width:30px; background:#1e3a5f; height:55px; border-radius:4px;"></div>
            <div style="width:30px; background:#2d5a87; height:100px; border-radius:4px;"></div>
            <div style="width:30px; background:#1e3a5f; height:80px; border-radius:4px;"></div>
            <div style="width:30px; background:#2d5a87; height:120px; border-radius:4px;"></div>
        </div>
    </div>
</div>
@endsection