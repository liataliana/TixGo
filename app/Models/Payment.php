<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'amount',
        'status', // pending, paid, failed
        'payment_method', // transfer, credit_card, etc.
        'payment_proof',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}