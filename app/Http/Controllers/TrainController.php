<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrainController extends Controller
{
    public function index()
    {
        return view('trains.index');
    }

    public function show($id)
    {
        return view('trains.show', compact('id'));
    }

    public function search(Request $request)
    {
        // Data dummy kereta api
        $trains = [
            (object) [
                'id' => 1,
                'name' => 'Argo Parahyangan',
                'route' => 'Jakarta → Bandung',
                'departure' => '06:30',
                'arrival' => '09:30',
                'duration' => '3 jam',
                'class' => 'Eksekutif',
                'price' => 370000,
                'seats_left' => 20,
            ],
            (object) [
                'id' => 2,
                'name' => 'Argo Wilis',
                'route' => 'Jakarta → Surabaya',
                'departure' => '08:00',
                'arrival' => '17:30',
                'duration' => '9 jam 30m',
                'class' => 'Eksekutif',
                'price' => 480000,
                'seats_left' => 15,
            ],
            (object) [
                'id' => 3,
                'name' => 'Taksaka',
                'route' => 'Jakarta → Yogyakarta',
                'departure' => '07:30',
                'arrival' => '14:45',
                'duration' => '7 jam 15m',
                'class' => 'Bisnis',
                'price' => 320000,
                'seats_left' => 35,
            ],
            (object) [
                'id' => 4,
                'name' => 'Gajayana',
                'route' => 'Jakarta → Malang',
                'departure' => '18:00',
                'arrival' => '05:30',
                'duration' => '11 jam 30m',
                'class' => 'Eksekutif',
                'price' => 520000,
                'seats_left' => 8,
            ],
        ];

        return view('trains.search', compact('trains'));
    }
}