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
        return redirect()->route('bookings.checkout', ['bookingId' => 1]);
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
                'category'   => 'train',
                'nama_penumpang' => $request->passenger_name,  // GANTI 'nama_penumpang' jadi nama kolom DB kamu
                'nomor_ktp'      => $request->id_number,       // GANTI 'nomor_ktp' jadi nama kolom DB kamu
                'email'          => $request->email,
                'no_telp'        => $request->phone,           // GANTI 'no_telp' jadi nama kolom DB kamu
                'jumlah_penumpang'=> $request->passenger_count, // GANTI 'jumlah_penumpang' jadi nama kolom DB kamu
                'total_price'    => 370000 * $request->passenger_count,
                'status'         => 'pending',
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

    public function pay(Request $request) {}
    public function success($bookingId) {}
    public function downloadTicket($bookingId) {}
}