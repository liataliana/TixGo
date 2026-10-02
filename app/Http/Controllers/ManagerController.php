<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Payment;
use App\Models\User;
use App\Models\ActivityLog;

class ManagerController extends Controller
{
    // ==========================================
    // DASHBOARD MANAGER
    // ==========================================
    public function dashboard()
    {
        $flightsCount  = Flight::count();
        $pendingCount  = Payment::where('status', 'pending')->count();
        $usersCount    = User::where('role', 'user')->count(); // hanya user biasa
        $bookingsCount = \App\Models\Booking::count();

        return view('manager.dashboard', compact('flightsCount', 'pendingCount', 'usersCount', 'bookingsCount'));
    }

    // ==========================================
    // FLIGHTS — Manager bisa tambah jadwal
    // ==========================================
    public function flightsIndex()
    {
        $flights = Flight::all();
        return view('manager.flights', compact('flights'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'origin'         => 'required|string',
            'destination'    => 'required|string',
            'departure_time' => 'required|date',
            'price'          => 'required|numeric|min:0',
        ]);

        $data = $request->all();
        $data['airline']         = $data['airline'] ?? 'TixGo Airlines';
        $data['arrival_time']    = $data['arrival_time'] ?? \Carbon\Carbon::parse($request->departure_time)->addHours(2);
        $data['capacity']        = $data['capacity'] ?? 100;
        $data['available_seats'] = $data['available_seats'] ?? 100;

        $flight = Flight::create($data);

        // Log aktivitas
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'role'        => 'manager',
            'action'      => 'add_flight',
            'description' => "Menambahkan jadwal penerbangan: {$flight->origin} → {$flight->destination} pada " . \Carbon\Carbon::parse($flight->departure_time)->format('d M Y H:i'),
            'target_type' => 'Flight',
            'target_id'   => $flight->id,
        ]);

        return redirect()->back()->with('success', 'Penerbangan berhasil ditambahkan!');
    }

    // ==========================================
    // PAYMENTS — Manager konfirmasi pembayaran
    // ==========================================
    public function paymentsIndex()
    {
        $payments = Payment::with('booking.user')->where('status', 'pending')->get();
        return view('manager.payments', compact('payments'));
    }

    public function confirmPayment($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 'confirmed']);

        if ($payment->booking) {
            $payment->booking->update(['status' => 'confirmed']);
        }

        // Log aktivitas
        $bookingCode = optional($payment->booking)->booking_code ?? "ID#{$id}";
        $userName    = optional(optional($payment->booking)->user)->name ?? 'Unknown';
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'role'        => 'manager',
            'action'      => 'confirm_payment',
            'description' => "Mengkonfirmasi pembayaran booking {$bookingCode} atas nama {$userName}",
            'target_type' => 'Payment',
            'target_id'   => $payment->id,
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi! Tiket user telah diaktifkan.');
    }

    // ==========================================
    // USERS — Manager HANYA lihat role=user
    // (Tidak bisa lihat super_admin / sesama manager)
    // ==========================================
    public function usersIndex()
    {
        $users = User::where('role', 'user')->orderBy('name')->get();
        return view('manager.users', compact('users'));
    }
}