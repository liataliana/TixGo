<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use App\Models\Flight;
use App\Models\Booking;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $totalRevenue = Booking::sum('total_price') ?? 0;
        $totalTickets = Booking::count() ?? 0;
        $users = User::all();
        $payments = Payment::where('status', 'pending')->count();
        $flights = Flight::count();

        return view('superadmin.dashboard', compact(
            'totalRevenue', 
            'totalTickets', 
            'users', 
            'payments', 
            'flights'
        ));
    }

    public function users()
    {
        $users = User::all();
        return view('superadmin.users', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('superadmin.users-edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('superadmin.users.index')->with('success', 'User berhasil diupdate!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }
        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();
        return redirect()->back()->with('success', 'Role user berhasil diubah!');
    }

    public function payments()
    {
        $payments = Payment::with('booking')->orderBy('created_at', 'desc')->get();
        return view('superadmin.payments', compact('payments'));
    }

    public function flights()
    {
        $flights = Flight::all();
        return view('superadmin.flights', compact('flights'));
    }

    public function reports()
    {
        return view('superadmin.reports');
    }
}