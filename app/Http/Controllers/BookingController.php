<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create($flightId)
    {
        return view('bookings.create', compact('flightId'));
    }

    public function store(Request $request, $flightId)
    {
        $request->validate([
            'passenger_name'  => 'required|string|max:255',
            'id_number'       => 'required|string|max:50',
            'email'           => 'required|email|max:255',
            'phone'           => 'required|string|max:20',
            'passenger_count' => 'required|integer|min:1',
        ]);

        $flight = \App\Models\Flight::findOrFail($flightId);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'flight_id' => $flightId,
            'booking_code' => 'TIX-' . strtoupper(\Illuminate\Support\Str::random(6)),
            'category' => 'flight',
            'passenger_name' => $request->passenger_name,
            'nama_penumpang' => $request->passenger_name,
            'passenger_email' => $request->email,
            'email' => $request->email,
            'passenger_phone' => $request->phone,
            'no_telp' => $request->phone,
            'passenger_count' => $request->passenger_count,
            'jumlah_penumpang' => $request->passenger_count,
            'nomor_ktp' => $request->id_number,
            'total_price' => $flight->price * $request->passenger_count,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        return redirect()->route('bookings.checkout', ['bookingId' => $booking->id])
                         ->with('success', 'Data penumpang berhasil disimpan!');
    }

    // ==========================================
    // BOOKING KERETA (FINAL MAPPING)
    // ==========================================
    public function storeTrain(Request $request)
    {
        // 1. Validasi Input Form (JANGAN DIUBAH!)
        $request->validate([
            'passenger_name'  => 'required|string|max:255',
            'id_number'       => 'required|string|max:50',
            'email'           => 'required|email|max:255',
            'phone'           => 'required|string|max:20',
            'passenger_count' => 'required|integer|min:1',
        ]);

        try {
            // 🟢 2. MAPPING KOLOM DATABASE (CUBA GANTI BAGIAN 'passenger_name' INI!)
            // Caranya: Ganti 'passenger_name' dengan nama kolom di tabel booking database kamu.
            // Contoh: Jika di database kolomnya 'full_name', tulis 'full_name'.
            $dataToSave = [
                'user_id'    => Auth::id(),
                'booking_code' => 'TIX-' . strtoupper(\Illuminate\Support\Str::random(6)),
                'category'   => 'train',
                'nama_penumpang' => $request->passenger_name,
                'passenger_name' => $request->passenger_name,
                'nomor_ktp'      => $request->id_number,
                'email'          => $request->email,
                'passenger_email'=> $request->email,
                'no_telp'        => $request->phone,
                'passenger_phone'=> $request->phone,
                'jumlah_penumpang'=> $request->passenger_count,
                'passenger_count'=> $request->passenger_count,
                'total_price'    => 370000 * $request->passenger_count,
                'status'         => 'pending',
                'payment_status' => 'pending',
            ];
            
            // 3. Simpan ke Database
            $booking = Booking::create($dataToSave);

            // 4. Redirect ke Checkout
            return redirect()->route('bookings.checkout', ['bookingId' => $booking->id])
                             ->with('success', 'Data penumpang berhasil disimpan!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function checkout($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        return view('bookings.checkout', compact('booking'));
    }

    public function pay(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'bookingId' => 'required|exists:bookings,id'
        ]);

        $booking = Booking::findOrFail($request->bookingId);
        $booking->update(['status' => 'pending']);

        // Create a mock payment record for Manager to confirm
        \App\Models\Payment::create([
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
            'amount' => $booking->total_price,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'payment_date' => now(),
        ]);

        return redirect()->route('bookings.success', ['bookingId' => $booking->id]);
    }

    public function success($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        return view('bookings.success', compact('booking'));
    }

    public function downloadTicket($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        // This is a mockup for ticket download (just shows a view that looks like a PDF)
        return view('bookings.ticket', compact('booking'));
    }
}