<!DOCTYPE html>
<html>
<head>
    <title>E-Ticket {{ $booking->booking_code }}</title>
    <style>
        body { font-family: 'Figtree', sans-serif; background: white; padding: 2rem; }
        .ticket { max-width: 600px; margin: auto; border: 2px solid #1e3a5f; border-radius: 12px; padding: 2rem; }
        .header { text-align: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 1rem; }
        .row { display: flex; justify-content: space-between; margin: 0.75rem 0; }
        .label { color: #64748b; font-weight: 600; }
        .value { font-weight: 700; color: #1e293b; }
        .footer { text-align: center; margin-top: 2rem; font-size: 0.8rem; color: #94a3b8; }
        .category-badge { display: inline-block; background: #ecfdf5; color: #059669; padding: 0.25rem 1rem; border-radius: 100px; font-size: 0.8rem; font-weight: 700; margin-top: 0.5rem; }
    </style>
</head>
<body>
    @php
        $icons = ['flight'=>'✈️','hotel'=>'🏨','villa'=>'🏡','train'=>'🚂','bus'=>'🚌'];
        $labels = ['flight'=>'Penerbangan','hotel'=>'Hotel','villa'=>'Villa','train'=>'Kereta Api','bus'=>'Bus & Travel'];
        $cat = $booking->category ?? 'flight';
        $icon = $icons[$cat] ?? '🎫';
        $catLabel = $labels[$cat] ?? 'Tiket';
    @endphp
    <div class="ticket">
        <div class="header">
            <h1 style="color: #1e3a5f;">{{ $icon }} TixGo</h1>
            <p style="color: #475569;">E-Ticket {{ $catLabel }}</p>
        </div>
        <div style="margin-top: 1.5rem;">
            <div class="row"><span class="label">Kode Booking</span><span class="value">{{ $booking->booking_code }}</span></div>
            <div class="row"><span class="label">Kategori</span><span class="value"><span class="category-badge">{{ $icon }} {{ $catLabel }}</span></span></div>

            @if($booking->flight)
                <div class="row"><span class="label">Maskapai</span><span class="value">{{ $booking->flight->airline }}</span></div>
                <div class="row"><span class="label">Rute</span><span class="value">{{ $booking->flight->origin }} → {{ $booking->flight->destination }}</span></div>
                <div class="row"><span class="label">Keberangkatan</span><span class="value">{{ \Carbon\Carbon::parse($booking->flight->departure_time)->format('d M Y, H:i') }}</span></div>
            @endif

            <div class="row"><span class="label">Nama Pemesan</span><span class="value">{{ $booking->nama_penumpang }}</span></div>
            <div class="row"><span class="label">Nomor KTP</span><span class="value">{{ $booking->nomor_ktp ?? '-' }}</span></div>
            <div class="row"><span class="label">Email</span><span class="value">{{ $booking->email }}</span></div>
            <div class="row"><span class="label">No. Telepon</span><span class="value">{{ $booking->no_telp ?? '-' }}</span></div>
            <div class="row"><span class="label">Jumlah</span><span class="value">{{ $booking->jumlah_penumpang }} orang</span></div>
            <div class="row" style="border-top: 2px dashed #e2e8f0; padding-top: 0.75rem; margin-top: 1rem;">
                <span class="label" style="font-size: 1.1rem;">Total Dibayar</span>
                <span class="value" style="font-size: 1.1rem; color: #059669;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="footer">Terima kasih telah menggunakan TixGo. Selamat menikmati perjalanan! 🌿</div>
    </div>
</body>
</html>