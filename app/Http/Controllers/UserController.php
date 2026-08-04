<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Booking;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('user.dashboard');
    }

    public function search()
    {
        return view('user.search-flight');
    }

    public function orders()
    {
        return view('user.orders');
    }

    public function store(Request $request)
    {
        // ... kode booking ...
    }

    public function paymentForm($id)
    {
        return view('user.payment');
    }

    public function uploadPayment(Request $request, $id)
    {
        // ... kode upload payment ...
        return redirect()->route('user.dashboard')->with('success', 'Bukti pembayaran berhasil diupload. Tunggu konfirmasi dari Manager!');
    }
}