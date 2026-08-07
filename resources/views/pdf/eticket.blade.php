<!DOCTYPE html>
<html>
<head>
    <title>E-Ticket {{ $booking->booking_code }}</title>
    <style>
        body { font-family: sans-serif; padding: 30px; border: 2px solid #456882; }
        h1 { color: #456882; text-align: center; }
        .ticket-box { margin-top: 20px; }
        .row { margin-bottom: 10px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <h1>✈️ E-TICKET PENERBANGAN</h1>
    <p style="text-align: center; font-size: 14px; color: #555;">Tiket ini sah digunakan sesuai dengan data pemesan</p>
    
    <div class="ticket-box">
        <div class="row"><span class="label">Kode Booking :</span> {{ $booking->booking_code }}</div>
        <div class="row"><span class="label">Nama Pemesan :</span> {{ $booking->user->name }}</div>
        <div class="row"><span class="label">Rute Tujuan :</span> {{ $booking->flight->origin }} → {{ $booking->flight->destination }}</div>
        <div class="row"><span class="label">Keberangkatan :</span> {{ $booking->flight->departure_time }}</div>
        <div class="row"><span class="label">Total Harga :</span> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
    </div>
    
    <hr style="border: 1px dashed #456882; margin: 20px 0;">
    <p style="text-align: center; color: #456882; font-weight: bold;">Status Pembayaran: LUNAS ✅</p>
</body>
</html>