<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use App\Models\Flight;
use App\Models\Booking;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;

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

    // ==========================================
    // KELOLA USERS — Super Admin lihat SEMUA
    // ==========================================
    public function users()
    {
        $users = User::orderBy('role')->orderBy('name')->get();
        return view('superadmin.users', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return redirect()->route('superadmin.users.index')->with('info', 'Gunakan tombol ubah role di halaman daftar user.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email']));
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
        $oldRole = $user->role;
        $user->role = $request->role;
        $user->save();

        // Log aktivitas
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'role'        => 'super_admin',
            'action'      => 'update_role',
            'description' => "Mengubah role user '{$user->name}' dari {$oldRole} → {$request->role}",
            'target_type' => 'User',
            'target_id'   => $user->id,
        ]);

        return redirect()->back()->with('success', "Role {$user->name} berhasil diubah menjadi {$request->role}!");
    }

    // ==========================================
    // TAMBAH AKUN MANAGER
    // ==========================================
    public function createManager()
    {
        return view('superadmin.create-manager');
    }

    public function storeManager(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:manager,super_admin,user',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // Log aktivitas
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'role'        => 'super_admin',
            'action'      => 'create_user',
            'description' => "Membuat akun baru: {$user->name} ({$user->email}) dengan role {$user->role}",
            'target_type' => 'User',
            'target_id'   => $user->id,
        ]);

        return redirect()->route('superadmin.users.index')
            ->with('success', "Akun {$user->role} '{$user->name}' berhasil dibuat!");
    }

    // ==========================================
    // ACTIVITY LOG
    // ==========================================
    public function activityLog()
    {
        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->paginate(30);
        return view('superadmin.activity-log', compact('logs'));
    }

    // ==========================================
    // PEMBAYARAN, PENERBANGAN, LAPORAN
    // ==========================================
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
        $adminCount   = User::where('role', 'super_admin')->count();
        $managerCount = User::where('role', 'manager')->count();
        $userCount    = User::where('role', 'user')->count();
        $totalRevenue = Booking::where('status', 'confirmed')->sum('total_price');
        $confirmedRate = Booking::count() > 0
            ? round((Booking::where('status', 'confirmed')->count() / Booking::count()) * 100)
            : 0;
        $users = User::latest()->get();

        return view('superadmin.reports', compact('adminCount', 'managerCount', 'userCount', 'totalRevenue', 'confirmedRate', 'users'));
    }
}