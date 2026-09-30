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
    'category',
    'nama_penumpang', // Ganti ini jika nama kolom DB aslinya beda
    'nomor_ktp',      // Ganti ini jika nama kolom DB aslinya beda
    'email',
    'no_telp',        // Ganti ini jika nama kolom DB aslinya beda
    'jumlah_penumpang',// Ganti ini jika nama kolom DB aslinya beda
    'total_price',
    'status'
];
}