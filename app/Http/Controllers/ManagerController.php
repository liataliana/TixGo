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

        Flight::create($request->all());

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

        if ($payment->booking) {
            $payment->booking->update(['status' => 'confirmed']);
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
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