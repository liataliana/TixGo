<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    // 1. METHOD UNTUK MENAMPILKAN HALAMAN FORM PENCARIAN
    public function index(Request $request)
    {
        // Tampilkan halaman form pencarian (view flights.index yang udah kita buat sebelumnya)
        return view('flights.index');
    }

    // 2. METHOD UNTUK PROSES PENCARIAN DAN MENAMPILKAN HASILNYA
    public function search(Request $request)
    {
        // Mulai query dengan status active
        $query = Flight::where('status', 'active');

        // Filter berdasarkan Asal (origin)
        if ($request->filled('origin')) {
            $query->where('origin', 'LIKE', '%' . $request->origin . '%');
        }

        // Filter berdasarkan Tujuan (destination)
        if ($request->filled('destination')) {
            $query->where('destination', 'LIKE', '%' . $request->destination . '%');
        }

        // Filter berdasarkan Tanggal (departure_time)
        if ($request->filled('departure_date')) { // Ganti 'date' jadi 'departure_date' sesuai name input di form tadi
            $query->whereDate('departure_time', $request->departure_date);
        }

        // Ambil data dan urutkan
        $flights = $query->orderBy('departure_time')->get();

        // Kembalikan ke view flights.search (Halaman hasil pencarian yang kita buat sebelumnya)
        return view('flights.search', compact('flights'));
    }

    // 3. METHOD UNTUK DETAIL PENERBANGAN
    public function show($id)
    {
        $flight = Flight::findOrFail($id);

        return view('flights.show', compact('flight'));
    }
}