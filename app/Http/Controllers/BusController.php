<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusController extends Controller
{
    // Tampilkan Form Pencarian Bus
    public function index()
    {
        return view('buses.index');
    }

    // Proses Pencarian & Tampilkan Hasil (Data Dummy)
    public function search(Request $request)
    {
        // Data Dummy Bus
        $buses = [
            (object) [
                'id' => 1,
                'name' => 'PO. Sinar Jaya',
                'route' => 'Jakarta → Bandung',
                'date' => '02 Agt 2026, 08:00 - 12:00',
                'price' => 150000,
                'seats_left' => 12,
                'logo' => '🚌'
            ],
            (object) [
                'id' => 2,
                'name' => 'PO. Haryanto',
                'route' => 'Jakarta → Yogyakarta',
                'date' => '02 Agt 2026, 07:30 - 15:30',
                'price' => 280000,
                'seats_left' => 8,
                'logo' => '🚌'
            ],
            (object) [
                'id' => 3,
                'name' => 'PO. Lorena',
                'route' => 'Jakarta → Surabaya',
                'date' => '02 Agt 2026, 06:00 - 18:00',
                'price' => 350000,
                'seats_left' => 5,
                'logo' => '🚌'
            ],
        ];

        return view('buses.search', compact('buses'));
    }
}