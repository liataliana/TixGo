<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // ⚠️ Ganti nama di dalam array ini sesuai dengan KOLOM tabel database kamu yang sebenarnya!
    protected $fillable = [
        'user_id',
        'flight_id',
        'booking_code',
        'category',
        'nama_penumpang',
        'passenger_name', // alias / double column from multiple migrations
        'passenger_email',
        'passenger_phone',
        'passenger_count',
        'nomor_ktp',
        'email',
        'no_telp',
        'jumlah_penumpang',
        'total_price',
        'status',
        'payment_status',
        'booking_date'
    ];
}