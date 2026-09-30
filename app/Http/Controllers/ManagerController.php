<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Payment;
use App\Models\User;

class ManagerController extends Controller
{
    // ==========================================
    // DASHBOARD MANAGER
    // ==========================================
    public function dashboard()
    {
        $flightsCount = Flight::count();
        $pendingCount = Payment::where('status', 'pending')->count();
        $usersCount = User::count();

        // ✅ INI YANG PENTING! Pastikan viewnya manager.dashboard
        return view('manager.dashboard', compact('flightsCount', 'pendingCount', 'usersCount'));
    }

    // ==========================================
    // FLIGHTS
    // ==========================================
    public function flightsIndex()
    {
        $flights = Flight::all();
        return view('manager.flights', compact('flights'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'origin' => 'required|string',
            'destination' => 'required|string',
            'departure_time' => 'required|date',
            'price' => 'required|numeric|min:0',
        ]);

        $data = $request->all();
        // Mengisi default value untuk field yang tidak ada di form tapi dibutuhkan oleh Database
        $data['airline'] = $data['airline'] ?? 'TixGo Airlines';
        $data['arrival_time'] = $data['arrival_time'] ?? \Carbon\Carbon::parse($request->departure_time)->addHours(2);
        $data['capacity'] = $data['capacity'] ?? 100;
        $data['available_seats'] = $data['available_seats'] ?? 100;

        Flight::create($data);

        return redirect()->back()->with('success', 'Penerbangan berhasil ditambahkan!');
    }

    // ==========================================
    // PAYMENTS
    // ==========================================
    public function paymentsIndex()
    {
        $payments = Payment::where('status', 'pending')->get();
        return view('manager.payments', compact('payments'));
    }

    public function confirmPayment($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 'confirmed']);

        // Mark the booking as CONFIRMED so user sees their ticket is active
        if ($payment->booking) {
            $payment->booking->update(['status' => 'confirmed']);
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi! Tiket user telah diaktifkan.');
    }

    // ==========================================
    // USERS
    // ==========================================
    public function usersIndex()
    {
        $users = User::all();
        return view('manager.users', compact('users'));
    }
}