@extends('layouts.app')

@section('content')
<style>
    .page-header { display:flex; align-items:center; gap:16px; margin-bottom:24px; }
    .page-header h1 { font-size:26px; font-weight:900; color:#0f172a; margin:0; }

    .stats-grid { display:grid; grid-template-columns: repeat(4,1fr); gap:16px; margin-bottom:24px; }
    .stat-card { background:white; border-radius:12px; padding:20px; border:1px solid #e2e8f0; box-shadow:0 2px 8px rgba(0,0,0,0.04); }
    .stat-card .number { font-size:28px; font-weight:900; color:#1e3a5f; }
    .stat-card .label { font-size:13px; color:#64748b; margin-top:4px; }

    .report-table { background:white; border-radius:12px; padding:20px; border:1px solid #e2e8f0; overflow-x:auto; }
    .report-table table { width:100%; border-collapse:collapse; font-size:14px; }
    .report-table th { text-align:left; padding:12px 16px; background:#f8fafc; font-weight:700; color:#0f172a; border-bottom:2px solid #e2e8f0; }
    .report-table td { padding:12px 16px; border-bottom:1px solid #f1f5f9; }
    .report-table tr:hover { background:#f8fafc; }

    .status-paid { color:#22c55e; font-weight:700; }
    .status-pending { color:#f97316; font-weight:700; }
    .status-failed { color:#ef4444; font-weight:700; }
</style>

<div class="max-w-7xl mx-auto px-4 py-4">
    <div class="page-header">
        <h1>📊 Laporan Admin</h1>
    </div>

    <div class="stats-grid">
        <div class="stat-card"><div class="number">156</div><div class="label">Total Pemesanan</div></div>
        <div class="stat-card"><div class="number">42</div><div class="label">Pemesanan Bulan Ini</div></div>
        <div class="stat-card"><div class="number" style="color:#22c55e;">Rp 48.2 Jt</div><div class="label">Total Pendapatan</div></div>
        <div class="stat-card"><div class="number" style="color:#f97316;">12</div><div class="label">Menunggu Konfirmasi</div></div>
    </div>

    <div class="report-table">
        <h3 style="font-weight:700; margin-bottom:12px;">Daftar Pemesanan</h3>
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Penumpang</th>
                    <th>Rute</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>TIX-A7B3C</strong></td>
                    <td>John Doe</td>
                    <td>BD → SBI</td>
                    <td>02 Agt 26</td>
                    <td>Rp 370.000</td>
                    <td><span class="status-paid">✔ Lunas</span></td>
                    <td><a href="#" style="color:#1e3a5f; font-weight:600; text-decoration:none;">Detail</a></td>
                </tr>
                <tr>
                    <td><strong>TIX-D9E2F</strong></td>
                    <td>Jane Smith</td>
                    <td>GMR → YK</td>
                    <td>03 Agt 26</td>
                    <td>Rp 450.000</td>
                    <td><span class="status-pending">⏳ Pending</span></td>
                    <td><a href="#" style="color:#1e3a5f; font-weight:600; text-decoration:none;">Detail</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection