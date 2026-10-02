<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrainController extends Controller
{
    public function index()
    {
        return view('trains.index');
    }

    private function getTrains()
    {
        return [
            1 => (object)['id'=>1,'name'=>'Argo Parahyangan','route'=>'Jakarta → Bandung','departure'=>'06:30','arrival'=>'09:30','duration'=>'3 jam','class'=>'Eksekutif','price'=>370000,'seats_left'=>20],
            2 => (object)['id'=>2,'name'=>'Argo Wilis','route'=>'Jakarta → Surabaya','departure'=>'08:00','arrival'=>'17:30','duration'=>'9 jam 30m','class'=>'Eksekutif','price'=>480000,'seats_left'=>15],
            3 => (object)['id'=>3,'name'=>'Taksaka','route'=>'Jakarta → Yogyakarta','departure'=>'07:30','arrival'=>'14:45','duration'=>'7 jam 15m','class'=>'Bisnis','price'=>320000,'seats_left'=>35],
            4 => (object)['id'=>4,'name'=>'Gajayana','route'=>'Jakarta → Malang','departure'=>'18:00','arrival'=>'05:30','duration'=>'11 jam 30m','class'=>'Eksekutif','price'=>520000,'seats_left'=>8],
        ];
    }

    public function show($id)
    {
        $trains = $this->getTrains();
        $train  = $trains[$id] ?? $trains[1]; // fallback ke kereta pertama
        return view('trains.show', compact('id', 'train'));
    }

    public function search(Request $request)
    {
        $trains = array_values($this->getTrains());
        return view('trains.search', compact('trains'));
    }
}