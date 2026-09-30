<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    // Show form to fill passenger data for flight booking
    public function create($flightId)
    {
        $flight = \App\Models\Flight::findOrFail($flightId);
        return view('bookings.create', compact('flightId', 'flight'));
    }

    // Store flight booking
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
            'user_id'         => Auth::id(),
            'flight_id'       => $flightId,
            'booking_code'    => 'TIX-' . strtoupper(Str::random(6)),
            'category'        => 'flight',
            'nama_penumpang'  => $request->passenger_name,
            'email'           => $request->email,
            'no_telp'         => $request->phone,
            'jumlah_penumpang'=> $request->passenger_count,
            'nomor_ktp'       => $request->id_number,
            'total_price'     => $flight->price * $request->passenger_count,
            'status'          => 'pending',
        ]);

        return redirect()->route('bookings.checkout', ['bookingId' => $booking->id])
                         ->with('success', 'Data penumpang berhasil disimpan!');
    }

    // Show generic booking form for hotel/villa/train/bus
    public function createGeneric(Request $request)
    {
        $category  = $request->query('category', 'train');
        $itemName  = $request->query('name', 'Tiket Perjalanan');
        $itemRoute = $request->query('route', '-');
        $itemPrice = $request->query('price', 0);

        return view('bookings.create-generic', compact('category', 'itemName', 'itemRoute', 'itemPrice'));
    }

    // Store generic booking (hotel/villa/train/bus)
    public function storeGeneric(Request $request)
    {
        $request->validate([
            'passenger_name'  => 'required|string|max:255',
            'id_number'       => 'required|string|max:50',
            'email'           => 'required|email|max:255',
            'phone'           => 'required|string|max:20',
            'passenger_count' => 'required|integer|min:1',
            'category'        => 'required|string',
            'item_price'      => 'required|numeric|min:0',
        ]);

        try {
            $booking = Booking::create([
                'user_id'         => Auth::id(),
                'booking_code'    => 'TIX-' . strtoupper(Str::random(6)),
                'category'        => $request->category,
                'nama_penumpang'  => $request->passenger_name,
                'nomor_ktp'       => $request->id_number,
                'email'           => $request->email,
                'no_telp'         => $request->phone,
                'jumlah_penumpang'=> $request->passenger_count,
                'total_price'     => $request->item_price * $request->passenger_count,
                'status'          => 'pending',
            ]);

            return redirect()->route('bookings.checkout', ['bookingId' => $booking->id])
                             ->with('success', 'Data pemesan berhasil disimpan!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Show checkout page
    public function checkout($bookingId)
    {
        $booking = Booking::with('flight')->findOrFail($bookingId);
        // Only let the owner see their checkout
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        return view('bookings.checkout', compact('booking'));
    }

    // Process payment (user clicks Bayar Sekarang)
    public function pay(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'bookingId'      => 'required|exists:bookings,id'
        ]);

        $booking = Booking::findOrFail($request->bookingId);

        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Create a payment record (pending, waiting Manager confirmation)
        Payment::create([
            'booking_id' => $booking->id,
            'method'     => $request->payment_method,
            'status'     => 'pending',
        ]);

        // Keep booking status as pending until Manager confirms
        $booking->update(['status' => 'pending']);

        return redirect()->route('bookings.success', ['bookingId' => $booking->id]);
    }

    // Booking success page
    public function success($bookingId)
    {
        $booking = Booking::with(['flight', 'payment'])->findOrFail($bookingId);
        return view('bookings.success', compact('booking'));
    }

    // Download / View E-Ticket
    public function downloadTicket($bookingId)
    {
        $booking = Booking::with(['flight', 'user'])->findOrFail($bookingId);
        return view('bookings.eticket', compact('booking'));
    }
}