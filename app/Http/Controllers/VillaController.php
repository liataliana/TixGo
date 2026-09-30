<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VillaController extends Controller
{
    // Tampilkan Form Pencarian Villa
    public function index()
    {
        return view('villas.index');
    }

    // Proses Pencarian & Tampilkan Hasil (Data Dummy)
    public function search(Request $request)
    {
        // Data dummy mirip persis screenshot kamu
        $villas = [
            (object) [
                'id' => 1,
                'name' => 'Titanium Express Homtel',
                'sub_title' => 'Apartemen',
                'stars' => 3,
                'rating' => 4.2,
                'reviews' => 569,
                'review_desc' => '"Akses mudah"',
                'location' => 'Jakarta Pusat',
                'rooms' => 2, 
                'guests' => 5, 
                'area' => '37.0m²',
                'facilities' => ['Kolam Renang', 'Parkir', 'WiFi Gratis'],
                'cashback' => 2416,
                'price' => 263817,
                'old_price' => 310489,
                'discount' => '-16%',
                'tax_price' => 319726,
                'image' => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=600&q=80',
                'badge' => 'Special Deal'
            ],
            (object) [
                'id' => 2,
                'name' => 'Ascott Sudirman',
                'sub_title' => 'Apartemen',
                'stars' => 5,
                'rating' => 4.8,
                'reviews' => 121,
                'review_desc' => '"Lokasi strategis"',
                'location' => 'Jakarta Selatan',
                'rooms' => 1, 
                'guests' => 2, 
                'area' => '25.0m²',
                'facilities' => ['AC', 'Parkir', 'WiFi Gratis', 'Dapur'],
                'cashback' => 3200,
                'price' => 495000,
                'old_price' => 550000,
                'discount' => '-10%',
                'tax_price' => 530000,
                'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80',
                'badge' => 'Top Stay'
            ],
        ];

        return view('villas.search', compact('villas'));
    }
}