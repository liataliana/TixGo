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
        return view('trains.index');
    }
}