<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Tentukan nama tabel persis seperti di database
    protected $table = 'bookings';
    
    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'booking_code', 'user_id', 'flight_id', 'total_price', 'status'
    ];

    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel Flight
    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    // Relasi ke tabel Payment (1 booking punya 1 payment)
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}