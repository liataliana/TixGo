<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HotelController extends Controller
{
    // Tampilkan Form Pencarian Hotel
    public function index()
    {
        return view('hotels.index');
    }

    // Proses Pencarian & Tampilkan Hasil (Data Dummy)
    public function search(Request $request)
    {
        // Data dummy hotel untuk tampilan
        $hotels = [
            (object) [
                'id' => 1, 'name' => 'Grand Seminyak Lifestyle Boutique Bali', 'stars' => 5, 'rating' => 4.4, 
                'reviews' => 169, 'location' => 'Seminyak, Badung', 'price' => 1500000, 'old_price' => 2500000,
                'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=400&q=80',
                'rooms_left' => 1
            ],
            (object) [
                'id' => 2, 'name' => 'Quest Vibe Dewi Sri Bali', 'stars' => 3, 'rating' => 4.7, 
                'reviews' => 121, 'location' => 'Kuta, Badung', 'price' => 850000, 'old_price' => 1200000,
                'image' => 'https://images.unsplash.com/photo-1542314831-c6e2ba6e7616?auto=format&fit=crop&w=400&q=80',
                'rooms_left' => 1
            ],
            (object) [
                'id' => 3, 'name' => 'THE SAND Suites & Villas', 'stars' => 4, 'rating' => 4.9, 
                'reviews' => 88, 'location' => 'Jimbaran, Badung', 'price' => 2100000, 'old_price' => 3000000,
                'image' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=400&q=80',
                'rooms_left' => 1
            ],
        ];

        return view('hotels.search', compact('hotels'));
    }
}