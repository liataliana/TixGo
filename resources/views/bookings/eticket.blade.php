<!DOCTYPE html>
<html>
<head>
    <title>E-Ticket</title>
    <style>
        body { font-family: 'Figtree', sans-serif; background: white; padding: 2rem; }
        .ticket { max-width: 600px; margin: auto; border: 2px solid #1e3a5f; border-radius: 12px; padding: 2rem; }
        .header { text-align: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 1rem; }
        .row { display: flex; justify-content: space-between; margin: 0.75rem 0; }
        .label { color: #64748b; font-weight: 600; }
        .value { font-weight: 700; color: #1e293b; }
        .footer { text-align: center; margin-top: 2rem; font-size: 0.8rem; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1 style="color: #1e3a5f;">✈️ TixGo</h1>
            <p style="color: #475569;">E-Ticket Penerbangan</p>
        </div>
        <div style="margin-top: 1.5rem;">
            <div class="row"><span class="label">Kode Booking</span><span class="value">{{ $booking->booking_code }}</span></div>
            <div class="row"><span class="label">Maskapai</span><span class="value">{{ $booking->flight->airline }}</span></div>
            <div class="row"><span class="label">Rute</span><span class="value">{{ $booking->flight->origin }} → {{ $booking->flight->destination }}</span></div>
            <div class="row"><span class="label">Keberangkatan</span><span class="value">{{ $booking->flight->departure_time->format('d M Y, H:i') }}</span></div>
            <div class="row"><span class="label">Penumpang</span><span class="value">{{ $booking->passenger_name }}</span></div>
            <div class="row"><span class="label">Jumlah</span><span class="value">{{ $booking->passenger_count }} orang</span></div>
            <div class="row"><span class="label">Total Dibayar</span><span class="value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span></div>
        </div>
        <div class="footer">Terima kasih telah menggunakan TixGo. Selamat terbang!</div>
    </div>
</body>
</html>